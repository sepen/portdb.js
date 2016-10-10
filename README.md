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


## Examples


### Show Repositories

**URL**: http://localhost:8000/repos
```
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
   },
   
   ...
]
```


### Search ports by name

**URL**: http://localhost:8000/ports?search=vim
```
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


### Find duplicates

**URL**: http://localhost:8000/ports?dups=true
```
[
   {
      "count" : 9,
      "_id" : {
         "name" : "yajl"
      },
      "items" : [
         "57fae8a32c5b4d07a1b7d88d",
         "57fae8a22c5b4d07a1b7d50f",
         "57fae8a22c5b4d07a1b7d415",
         "57fae8a22c5b4d07a1b7cf88",
         "57fae8a22c5b4d07a1b7d4f9",
         "57fae8a22c5b4d07a1b7ca96",
         "57fae8a32c5b4d07a1b7d9ed",
         "57fae8a32c5b4d07a1b7d545",
         "57fae8a22c5b4d07a1b7c9f8"
      ]
   },
   {
      "count" : 6,
      "_id" : {
         "name" : "python3"
      },
      "items" : [
         "57fae8a32c5b4d07a1b7dae3",
         "57fae8a32c5b4d07a1b7d53a",
         "57fae8a32c5b4d07a1b7d9b4",
         "57fae8a22c5b4d07a1b7cfd6",
         "57fae8a22c5b4d07a1b7cf79",
         "57fae8a22c5b4d07a1b7ccd5"
      ]
   }
]
```


