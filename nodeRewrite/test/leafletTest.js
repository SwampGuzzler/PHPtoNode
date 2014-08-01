if (typeof require == 'function') {
    var assert = require('assert'),
    L = require('leaflet/src/Leaflet');
    L.Main = require('./../main').Main;
}

// Test function call
describe('compute', function() {
  it('should be ok', function(done) {
     assert.equal(2, L.Main.compute());
     done();
  });
});