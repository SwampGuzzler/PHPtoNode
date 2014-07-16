'use strict';
/*global casper*/

casper.test.begin('home page', 3, function suite(test) {

  casper.start('http://localhost:3000/', function() {
    test.assertHttpStatus(200);
  });

  casper.then(function(){
    test.assertTitle('Hello World Express', 'title is Hello World Express');
  });

  casper.then(function() {
    test.assertSelectorHasText('h1','Many Testings!!');
  });


  casper.waitForResource("happy-cat-wallpaper-thumbnail.jpg", function() {
    this.echo('happy-cat-wallpaper-thumbnail.jpg has been loaded.');
  });
  casper.waitForResource("http://www.lifesize-models.co.uk/custom/images/products/DSCF5034.JPG", function() {
    this.echo('http://www.lifesize-models.co.uk/custom/images/products/DSCF5034.JPG has been loaded.');
  });

  casper.run(function(){
    test.done();
  });

});

