
var express = require('express');
var http    = require('http');

var app = express();

app.use(express.static(__dirname + '/public'));
//app.use(express.static(__dirname + '/dist'));
// So above, if we use dist, we can reference the browserified 'app.js' file easily, but we 
// no longer get what's in the public folder (which is all that logic I built in), we just get 
// some lame static html and our other files alongside it. -Basically, we'd have to re-build 
// the logic there using the app.js bundle rather than explicit stand-alone js files alongside 
// our index.html file

var server = http.createServer(app);
server.listen(3000, function() {
  console.log('the server is listening on port 3000');
});