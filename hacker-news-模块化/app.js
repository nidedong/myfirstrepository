// 主模块

var http = require('http');
var router = require('./router');
var extend = require('./extend');
var server = http.createServer();

server.on('request', function( req, res ) {
  extend( req, res );
  router( req, res );
})

server.listen(8000, function() {
  console.log("http://localhost:8000");
})