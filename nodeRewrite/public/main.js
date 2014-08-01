var $ = require('jquery-browserify');
var Quiz = require('./quiz');

var how_to_use_browserify = new Quiz("How to use browserify");
console.log("ARE WE IN THIS Main.js file??");

$('body').append('<h2>' + how_to_use_browserify.title + '</h2>');
$(document).ready(function() {
    $("#overlay").show();
});
$(document).ready(function() {
    $(".overly").show();
});
$('#main').click(function() {
	$("#overlay").show();
});
L.Main = {
    compute: function () { return 2; }
}