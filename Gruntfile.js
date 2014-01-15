module.exports = function(grunt) {
	grunt.initConfig({
		copy: {
			build: {
				expand: true,
				src: ['app/**', 'public/**', '!public/css/sass/**', '!public/js/site.js', 'vendor/**', 'bootstrap/**', 'server.php'],
				dest: 'build/'
			}
		},

		sass: {
			dist: {
				files: {
					'public/css/main.css': 'public/css/sass/main.scss'
				}
			}	
		},

		cssmin: {
			minifyCSS: {
				files: {
					'build/public/css/main.css': 'public/css/*.css'
				}
			}
		},

		imagemin: {
			minifyImg: {
				files: [{
					expand: true,
					cwd: 'src',
					src: ['public/img/*.{png,jpg,gif}'],
					dest: 'build/public/img'
				}]
			}
		},

		jshint: {
			all: {
				src: ['public/js/**.js']
			}
		},

		concat: {
			dist: {
				src: ['public/js/main.js', 'public/js/vendor/momentjs.js'],
				dest: 'public/js/site.js'
			}
		},

		uglify: {
			dist: {
				src: ['public/js/site.js'],
				dest: 'build/public/js/main.min.js'
			}
		},

		clean: {
			target: {
				src: ['public/js/site.js', 'build/public/js/main.js']
			}
		},

		watch: {
			stylesheets: {
				files: ['public/css/**/*.scss'],
				tasks: ['compileSass'],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-clean');

	grunt.registerTask('build', ['copy', 'cssmin', 'imagemin', 'concat', 'uglify', 'clean']);

	grunt.registerTask('default', 'Watches the project for changes', ['watch']);
};