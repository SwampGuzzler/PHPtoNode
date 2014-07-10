
var express = require('express');
var http    = require('http');

var app = express();

app.use(express.static(__dirname + '/public'));

var server = http.createServer(app);
server.listen(3000, function() {
  console.log('the server is listening on port 3000');
});