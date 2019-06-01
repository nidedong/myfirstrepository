// 页面处理模块
var fs = require('fs');
var storage = require('./storage');
var path = require('path');
var mime = require('mime');
var DATAPATH = path.join(__dirname, 'data.json');

module.exports = {
  indexHandler: function( req, res ) {
    storage.getAllNews(function(news) {
      fs.readFile(path.join(__dirname, 'views', 'index.html'), 'utf8', function(err, data) {
        res.render(data, {list: news});
      })
    })
  },
  detailsHandler: function( req, res ) {
    storage.getNewById(req.obj.query.id, function( news ) {
      fs.readFile(path.join(__dirname, 'views', 'details.html'), 'utf8', function(err, data) {
        res.render(data, {item: news});
      })
    })
  },
  resourcesHandler: function( req, res ) {
    fs.readFile(path.join(__dirname, req.url), 'utf8', function(err, data) {
      res.setHeader('content-type', mime.getType( req.url ));
      res.end( data );
    })
  },
  submitHandler: function( req, res ) {
    fs.readFile(path.join(__dirname, 'views', 'submit.html'), 'utf8', function(err, data) {
      res.render( data );
    })
  },
  addHandler: function( req, res ) {
    storage.addNew(req.obj.query, function( data ) {
      fs.writeFile(DATAPATH, JSON.stringify(data), 'utf8', function(err) {
        res.statusCode = 302;
        res.statusMessage = 'Found';
        res.setHeader('location', '/');
        res.end();
      })
    });
  },
  notFoundHandler: function( req, res ) {
    res.statusCode = 404;
    res.statusMessage = 'Not Found';
    res.end('cuowu');
  }
}