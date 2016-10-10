# portdb.js

## About

portdb.js is a small Node.js + MongoDB API that can be useful as a backend for
CRUX's portdb.

## Quickstart

### Requirements

 * Node.js
 * MongoDB. Daemon should be well configured and running

### Initialize MongoDB database

Start MongoDB daemon and run ___pdbcacher___. It will create a database
automatically named portdb32.

```
$ npm run pdbcacher

Connecting to database
Truncate collections
Update collections (#repos: 55). Please wait...
Number of ports: 4875
```

By default mongodb URI is ___mongodb://localhost:27017/portdb32___. To change
this behaviour you can use ___MONGODB_URI___ environment variable.

### Run the application

Run this command:

```
$ npm run portdb

Listening on 8000
```

By default TCP port 8000 is used.  You can use ___APP_PORT__ environment
variable to change it.

