module.exports = function(grunt) {
  var target = grunt.option('target') || '*';

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // paths
    meta: {
      assetPath_style: '../styles/',
      assetPath_script: '../scripts/',
      assetPath_script_lib: '../scripts/lib/',
      assetPath_script_depend: '../scripts/lib/dependencies/',
      assetPath_script_vendor: '../scripts/vendor/',
      assetPath_script_custom: '../scripts/lib/custom',
      assetPath_image: '../images/',
    },


    // sass
    sass: {
      dist: {
        options: {
          style: 'compressed',
          //sourceMap: true,
          sourceMap: false
        },
        files: {
          '<%= meta.assetPath_style %>/style.css': '<%= meta.assetPath_style %>/style.scss',
          '<%= meta.assetPath_style %>/wp-admin.css': '<%= meta.assetPath_style %>/admin/wp-admin.scss',
          '<%= meta.assetPath_style %>/first-meaningful-paint.css': '<%= meta.assetPath_style %>/first-meaningful-paint.scss'
        },
      }
    },
    
    postcss: {
      options: {
        map: false,
        processors: [
          require('autoprefixer')({browsers: 'last 3 versions'}), // add vendor prefixes
          require('cssnano')() // minify the result
        ]
      },
      dist: {
        src: '<%= meta.assetPath_style %>/*.css'
      }
    },
  
    // concat js
  
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        src: '<%= meta.assetPath_script_vendor %>/*.js' ,
        dest: '<%= meta.assetPath_script %>/javascript.min.js'
      }
    },
  
    // uglify js
   
    uglify: {
      options: {
        banner: '',
        sourceMap: true
      },
      dist: {
        files: {
          '<%= meta.assetPath_script %>/javascript.min.js': ['<%= concat.dist.dest %>']
        }
      }
    },
   
    // optimize images
    /*
    imagemin: {
      png: {
        options: {
          optimizationLevel: 2
        },
        files: [
          {
            expand: true,
            cwd: '<%= meta.assetPath_image %>',
            src: ['starstar/*.png'],
            dest: '<%= meta.assetPath_image %>',
            ext: '.png'
          }
        ]
      },
      jpg: {
        options: {
          progressive: true
        },
        files: [
          {
            expand: true,
            cwd: '<%= meta.assetPath_image %>',
            src: ['starstar/*.jpg'],
            dest: '<%= meta.assetPath_image %>',
            ext: '.jpg'
          }
        ]
      }
    },*/


    // watch files
    watch: {
      scripts: {
        files: [
          '<%= meta.assetPath_script_vendor %>/*.js'
        ],
        tasks: ['concat', 'uglify'],
      },
      css: {
        files: [
          '<%= meta.assetPath_style %>/**/*.scss'
        ],
        //tasks: ['sass'],
        tasks: ['sass', 'postcss'],
      },/*
      images: {
        files: [
          '<%= meta.assetPath_image %>/starstar/*.*'
        ],
        tasks: ['imagemin'],
        options: {
          spawn: true,
        }
      }*/
    },



  });


  // plugins
  //grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  //grunt.loadNpmTasks('grunt-contrib-imagemin');
  //grunt.loadNpmTasks('grunt-browser-sync');
  //grunt.loadNpmTasks('grunt-sftp-deploy');
  //grunt.loadNpmTasks('grunt-kss');

  grunt.registerTask('default', ['watch']);
  //grunt.registerTask('styleguide', ['clean', 'kss']);
  //grunt.registerTask('deploy', ['sftp-deploy:build']);
};
