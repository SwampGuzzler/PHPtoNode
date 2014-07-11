module.exports = function(grunt) {
  
  grunt.initConfig({
    express: {
      options: {
        // Override defaults here
      },
      dev: {
        options: {
          script: 'server.js'
        }
      },
      prod: {
        options: {
          script: 'server.js',
          node_env: 'production'
        }
      },
      test: {
        options: {
          script: 'server.js'
        }
      }
    },
    jshint: {
      all: ['Gruntfile.js', 'server.js']
    },
    simplemocha: {
	  options: { timeout: 3000 },
	    all: { src: ['test/*.js'] }
	  },
    casper: {
      acceptance : {
        options : {
          test : true,
        },
        files : {
          'test/acceptance/casper-results.xml' : ['test/acceptance/*_test.js']
        }
      }
    },
    watch: {
      options: {
        livereload: true
      },
      js: {
        files: ["server.js"],
        tasks: ["jshint", "concat:js"],
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-simple-mocha');
  grunt.loadNpmTasks('grunt-express-server');
  grunt.loadNpmTasks('grunt-casper');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('server', [ 'jshint', 'express:dev', 'watch' ]);
  grunt.registerTask('default','jshint');
  grunt.registerTask('test', ['simplemocha','express:dev','casper']);

};
