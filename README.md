# portdb.js

## About

portdb.js is a small Node.js + MongoDB API that can be useful as a backend for
CRUX's portdb.


## Quickstart


### Requirements

 * Node.js
 * MongoDB. Daemon should be well configured and running
 * NPM (Node Package Manager)


### Initialize MongoDB database

Start MongoDB daemon and run _pdbcacher_. It will create a database
automatically named portdb32.

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

