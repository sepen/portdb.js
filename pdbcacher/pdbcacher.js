const httpreq = require('request')
const exec = require('child_process').exec
const mongodb = require('mongodb')
const MongoClient = mongodb.MongoClient
const MONGODB_URI = process.env.MONGODB_URI || 'mongodb://localhost:27017/portdb32'
const config = require('./config.json')
const repos = config.repos

var db
var pnum = 0

console.log('Connecting to database')
MongoClient.connect(MONGODB_URI, function(err, database) {
  if (err) return console.log('Unable to connect to the mongoDB server. Error:', err)

  console.log('Truncate collections')
  database.collection('repos').drop()
  database.collection('ports').drop()

  db = database

  console.log('Update collections (#repos: ' + repos.length + '). Please wait...')
  repos.forEach(function(repo) {

    db.collection('repos').insert({
      "name"  : repo.name,
      "owner" : repo.owner,
      "type"  : repo.type,
      "url"   : repo.url,
      "pubkey": repo.pubkey
    })

    if (repo.type == 'httpup') {
      httpreq.get(repo.url + 'REPO', function(error, response, body) {
        if (!error && response.statusCode == 200) {
          body.split('\n').forEach(function(line) {
            if (line.substr(0,2) == 'd:') {
              var portname = line.substr(2).trim()
              pnum++
              db.collection('ports').insert({
                "name": portname,
                "repo": repo.name
              })
              //console.log(' > ' + repo.name + '/' + portname)
            }
          })
        }
      })
    } else if (repo.type == 'rsync') {
      exec('rsync --list-only ' + repo.url, function(error, stdout, stderr) {
        stdout.split('\n').forEach(function(line) {
          if (line[0] == 'd') {
            var sp = line.split(' ')
            var portname = sp[sp.length-1]
            if (portname != '.') {
              pnum ++
              db.collection('ports').insert({
                "name": portname,
                "repo": repo.name
              })
              //console.log(' > ' + repo.name + '/' + portname)
            }
          }
        })
      })
    } else {
      console.log('repo.type not found: ' + repo.type)
    }
  })

  setTimeout(function() {
    console.log('Number of ports: ' + pnum)
    db.close()
  }, 10000)
})
