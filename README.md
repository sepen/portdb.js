# portdb.js

## About

portdb.js is a small API that can be useful as a backend for CRUX's portdb.


## Quickstart


### Requirements

 * Node.js
 * MongoDB
 * NPM (Node Package Manager)


### Initialize MongoDB database

Start MongoDB daemon and run _pdbcacher_. It will create the database:
```
$ npm run pdbcacher

Connecting to database
Truncate collections
Update collections (#repos: 55). Please wait...
Number of ports: 4875
```

By default mongodb URI is _mongodb://localhost:27017/portdb32_. To change
this behaviour you can use _MONGODB_URI_ environment variable.


### Run the application

Start the application with this command:
```
$ npm run portdb

Listening on 8000
```

By default TCP port 8000 is used.  You can use _APP_PORT_ environment
variable to change it.


### Update MongoDB database

Add a crontab line to run periodically _pdbcacher_ command. 
 
To register a new repository you should edit _pdbcacher/config.json_ and insert
a line with all the fields required for the new repository: 
 * name
 * type
 * url
 * owner

Every time _pdbcacher_ is launched it will re-create the database.


### Examples


#### Search ports by name

**URL**: http://localhost:8000/ports?search=vim
```json
[
   {
      "repo" : "df",
      "_id" : "57fae8a22c5b4d07a1b7caba",
      "name" : "qt5"
   },
   {
      "repo" : "opt",
      "_id" : "57fae8a32c5b4d07a1b7d688",
      "name" : "qt5"
   }
]
```


#### Show Repositories

**URL**: http://localhost:8000/repos
```json
[
   {
      "owner" : "kori at openmailbox dot org",
      "_id" : "57fae8a12c5b4d07a1b7c8da",
      "url" : "https://raw.githubusercontent.com/6c37/crux-ports/3.2/",
      "name" : "6c37",
      "pubkey" : null,
      "type" : "httpup"
   },
   {
      "owner" : "kori at openmailbox dot org",
      "_id" : "57fae8a12c5b4d07a1b7c8db",
      "url" : "https://raw.githubusercontent.com/6c37/crux-ports-git/3.2/",
      "name" : "6c37-git",
      "pubkey" : null,
      "type" : "httpup"
   },
   {
      "owner" : "alan+crux at mizrahi dot com dot ve",
      "_id" : "57fae8a12c5b4d07a1b7c8dc",
      "url" : "http://www.mizrahi.com.ve/crux/pkgs/",
      "name" : "alan",
      "pubkey" : null,
      "type" : "httpup"
   }
]
```


