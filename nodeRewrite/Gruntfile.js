module.exports = function(grunt) {
  
  grunt.initConfig({
    clean: ['dist'],
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
    browserify: {
      all: {
        src: 'lib/*.js',
        dest: 'dist/app.js'
      },
      options: {
        transform: ['debowerify'],
        debug: true
      }
    },
    copy: {
      all: {
        expand: true,
        cwd: 'src/',
        src: ['*.css', '*.html', '/images/**/*', '!Gruntfile.js'],
        dest: 'dist/',
        flatten: true,
        filter: 'isFile'
      },
    },
    jshint: {
      all: ['Gruntfile.js', 'server.js', 'test/../*.js', 'lib/quiz.js']
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

  /*grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-simple-mocha');
  grunt.loadNpmTasks('grunt-express-server');
  grunt.loadNpmTasks('grunt-casper');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-contrib-copy');*/
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks); //This allows us to skip the above 8 lines!


  grunt.registerTask('server', [ 'jshint', 'express:dev', 'watch' ]);
  grunt.registerTask('default', ['jshint','clean','browserify','copy']);
  grunt.registerTask('test', ['simplemocha','express:dev','casper']);

};
