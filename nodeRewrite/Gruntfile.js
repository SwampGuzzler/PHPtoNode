module.exports = function(grunt) {
  
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
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
    copy: {
      all: {
        expand: true,
        cwd: 'public/',
        src: ['*.css', '*.html', '/images/**/*', '!Gruntfile.js'],
        dest: 'dist/',
        flatten: true,
        filter: 'isFile'
      },
    },
    browserify: {
      all: {
        src: 'public/*.js',
        //maybe src should be ALL of public; not just the js files??
        // I need to make more code available in the Browser! Why isn't the main.js jquery working?
        dest: 'dist/app.js'
      },
      options: {
        transform: ['debowerify'],
        debug: true
      }
    },
    jshint: {
      all: ['Gruntfile.js', '!bundle.js', 'server.js', 'test/../*.js', 'public/quiz.js']
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
    /*qunit: {
      all: ['test/browser/*.html']
    },*/
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
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-qunit');*/
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks); //This allows us to skip the above 8 lines!

  //grunt.registerTask('q', ['qunit']);
  grunt.registerTask('server', [ 'jshint', 'express:dev', 'watch' ]);
  grunt.registerTask('default', ['jshint','clean','browserify','copy']);
  grunt.registerTask('test', ['simplemocha','express:dev','casper']);


};
