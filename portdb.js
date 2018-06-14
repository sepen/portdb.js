// portdb.js
const express = require('express')
const app = express()
const bodyParser = require('body-parser')
const MongoClient = require('mongodb').MongoClient
const APP_PORT = process.env.APP_PORT || 8000
const MONGODB_URI = process.env.MONGODB_URI || 'mongodb://localhost:27017/portdb32'

var db

MongoClient.connect(MONGODB_URI, (err, database) => {
  if (err) return console.log(err)
  db = database
  app.listen(APP_PORT, () => {
    console.log('Listening on ' + APP_PORT)
  })
})

app.use(bodyParser.urlencoded({extended: true}))
app.use(bodyParser.json())
app.use(express.static('public'))

app.get('/ports', (req, res) => {
  var name = req.query.name
  var repo = req.query.repo
  var search = req.query.search
  var dups = req.query.dups
  if (name) {
    db.collection('ports').find({"name": name}).sort({repo: 1}).toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  } else if (repo) { 
    db.collection('ports').find({"repo": repo}).sort({name: 1}).toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  } else if (search) {
    RegExp.quote = function(str) {
      return str.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
    }
    db.collection('ports').find({"name": new RegExp(RegExp.quote(search))}).sort({repo: 1}).toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  } else if (dups) {
    db.collection('ports').aggregate([
      {$group: {
        _id: {name: "$name"},
        items: {$addToSet: "$_id"},
        count: {$sum: 1}
      }},
      {$match: {
        count: {$gte: 2}
      }},
      {$sort: {count: -1}}
    ]).toArray((err,result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  } else {
    db.collection('ports').find().sort({name: 1}).toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  }
})

app.get('/repos', (req, res) => {
  var name = req.query.name
  if (name) {
    db.collection('repos').find({"name": name}).sort({name: 1}).toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  } else {
    db.collection('repos').find().toArray((err, result) => {
      if (err) return console.log(err)
      res.json(result)
    })
  }
})

app.get('/', (req, res) => {
  res.json({"status": "ok"})
})
