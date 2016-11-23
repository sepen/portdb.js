#portdb.js

##About

This project is intended to create an HTTP API for CRUX's portdb.  
  
One difference with the current portdb is the separation in _frontend_ and
_backend._ Another difference is the database, which changes from _SQLite_ to
_MongoDB_ and thus to a _NoSQL_ database.  
The _backend_, written in _NodeJS_, starts a server which listens for HTTP requests,
queries the database, and returns the result in JSON format. This favors the use
of portdb for CLI tools and applications.  
The _frontend_ maintains the original design and style of the current portdb but
the _PHP_ code has been adapted to make requests to the backend instead of querying
the database directly. In the future, the frontend could be written in _Javascript_
for browsers that support it. This would remove workload from the server.


##Quickstart


### Requirements

 * Node.js
 * MongoDB
 * NPM (Node Package Manager)


###Initialize MongoDB database

Start MongoDB daemon and run ``pdbcacher``. It will create the database:
```
$ npm run pdbcacher

Connecting to database
Truncate collections
Update collections (#repos: 55). Please wait...
Number of ports: 4875
```

By default mongodb URI is _mongodb://localhost:27017/portdb32_. To change
this behaviour you can use _MONGODB_URI_ environment variable.


###Run the application

Start the application with this command:
```
$ npm run portdb &

Listening on 8000
```

By default TCP port 8000 is used.  You can use ``APP_PORT`` environment
variable to change it.


###Update MongoDB database

Add a crontab line to run periodically ``pdbcacher`` command. 
  
To register a new repository you should edit ``pdbcacher/config.json`` and insert
a line with all the fields required for the new repository: 
 * name
 * type
 * url
 * owner

Every time ``pdbcacher`` is launched it will re-create the database.



##Output examples

###Show Repositories

 * http://API_URL/repos
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


###Search ports by name

 * http:/:/API_URL/ports?search=vim
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


###Find duplicates

 * http://API_URL/ports?dups=true
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

##Website

I modified the original portdb website written in PHP to use backend calls. 
  
To start the website:
```
$ npm run website &
```
By default TCP port 8080 is used. 
Note that this command runs a PHP built-in webserver which is used for
development purposes only.  
  
If you want to use the values in ``website/config.php`` you need to add a line to
``/etc/hosts`` like this:
```
127.0.0.1 portdb.crux.nu
```

