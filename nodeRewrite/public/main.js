var $ = require('jquery');
var Quiz = require('./quiz');

var how_to_use_browserify = new Quiz("How to use browserify");
console.log("ARE WE IN THIS Main.js file??");

$('body').append('<h2>' + how_to_use_browserify.title + '</h2>');