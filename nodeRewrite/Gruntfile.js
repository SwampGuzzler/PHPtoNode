module.exports = function(grunt) {
  
  grunt.loadNpmTasks('grunt-contrib-jshint');
  
  grunt.initConfig({
    jshint: {
      all: ['Gruntfile.js', 'server.js']
    },
    simplemocha: {
	  options: { timeout: 3000 },
	    all: { src: ['test/*.js'] }
	}
  });

  grunt.loadNpmTasks('grunt-simple-mocha');

  grunt.registerTask('default','jshint');
  grunt.registerTask('test','simplemocha');
};
