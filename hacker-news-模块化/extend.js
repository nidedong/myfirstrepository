// res的扩展功能
var fs = require('fs');
var path = require('path');
var template = require('art-template');
var url = require('url');
module.exports = function( req, res ) {
  res.render = function(file, data) {
    if( data ) {
      var renderFn = template.compile( file );
      var result = renderFn(data);
    }else {
      result = file;
    }
    res.end( result );
  }

  req.obj = url.parse( req.url, true );


}