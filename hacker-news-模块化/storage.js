// 功能方法模块
var fs = require('fs');
var path = require('path');
var DATAPATH = path.join(__dirname, 'data.json');
module.exports = {

  getAllNews: function( callback ) {
    fs.readFile(DATAPATH, 'utf8', function(err, data) {
      var data = JSON.parse( data || '[]');
      callback( data );
    })
  },
  getNewById: function(id, callback) {
    this.getAllNews(function( news ) {
      var current = news.find(function(v, i) {
        return v.id == id;
      })
      callback( current );
    })
  },
  addNew: function(data, callback) {
    this.getAllNews(function(news) {
      data.id = news.length == 0 ? 1 : news[news.length - 1].id + 1;
      news.push( data );
      callback( news );
    })
  }
}