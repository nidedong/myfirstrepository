// 路由模块
var url = require('url');
var handler = require('./handler');
module.exports = function( req, res ) {
  if( req.url == '/index.html' || req.url == '/') {
    handler.indexHandler( req, res );
  }else if (url.parse(req.url).pathname == '/details') {
    console.log('ahahha');
    handler.detailsHandler( req, res );
  }else if( req.url == '/submit' ) {
    handler.submitHandler( req, res );
  }else if( req.url.indexOf('/resources') == 0 ) {
    handler.resourcesHandler( req, res );
  }else if( url.parse(req.url).pathname == '/add') {
    handler.addHandler( req, res );
  }else {
    handler.notFoundHandler( req, res );
  }
}