module.exports = function(grunt) {
  
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    clean: {
      options: {
        force: true,
      },
      contents: ['../../dist/images/*', '../../dist/functions/*', '../../dist/acf-json/*', '../../dist/template-parts/*', '../../dist/template/*'],
    },
    copy: {
      main: {
        files: [
          {expand: true, src: ['../images/**'], dest: '../../dist/images/'},
          {expand: true, src: ['../functions/**'], dest: '../../dist/functions/'},
          {expand: true, src: ['../acf-json/**'], dest: '../../dist/acf-json/'},
          {expand: true, src: ['../template-parts/**'], dest: '../../dist/template-parts/'},
          {expand: true, src: ['../template/**'], dest: '../../dist/template/'},
        ],
      },
    },
    sass: {
      dist: {
        options: {
          sourcemap: 'none',
          compress: false,
          yuicompress: false,
          style: 'compressed',
        },
        files: [{
          expand: true,
          cwd: '../scss',
          src: ['**/*.scss'],
          dest: '../../dist/css/',
          ext: '.min.css'
        }]
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      build: {
        files: [
          {
            src: '../js/*.js',  // source files mask
            dest: '../../dist/js/',    // destination folder
            expand: true,    // allow dynamic building
            flatten: true,   // remove all unnecessary nesting
            ext: '.min.js'   // replace .js to .min.js
          },
          {
            '../../dist/js/vendors.min.js': [ '../vendor/bootstrap-5.2.2/dist/js/bootstrap.js', '../vendor/gsap-shockingly-green/minified/gsap.min.js', '../vendor/gsap-shockingly-green/minified/ScrollTrigger.min.js', '../js/slick.js' ],
          }
        ]
      }
    },
    watch: {
      css: {
        files: ['../scss/**/*.scss'],
        tasks: ['sass']
      },
      js: {
        files: ['../js/*.js'],
        tasks: ['uglify']
      },
      copy: {
        files: ['../images/**/*', '../functions/**/*', '../acf-json/**/*', '../template-parts/**/*', '../template/**/*'],
        tasks: ['clean', 'copy']
      },
    }
  });
  grunt.loadNpmTasks('grunt-contrib-sass');
  // grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-uglify-es');
  // grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default',['watch']);
}