'use strict';

import db from '../../sqldb';
var config = require('../../config/environment'),
  session = require('express-session');
    

var sequelizeStore = require('express-sequelize-session')(session.Store);

var sessionMiddleware = session({
    resave: false,
    saveUninitialized: true,
    store: new sequelizeStore(db.sequelize),
    cookie:{maxAge:1000*3600*24*7}, //remember for 7 days
    secret: config.mysql.options.expressSessionSecret/*||'$uper$ecret$e$$ionKey'*/
});

module.exports = sessionMiddleware;