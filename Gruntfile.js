module.exports = function(grunt) {
	grunt.initConfig({
		copy: {
			build: {
				expand: true,
				files: [
					{
						src: [
							'app/**', 'public/**', '!public/css/sass/**', '!public/js/**', 
							'vendor/**', 'bootstrap/**', 'server.php', '.htaccess', 'artisan'
						], 
						dest: 'build/', dot: true
					}
				]
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
					'build/public/css/main<%= grunt.template.today("yyyy-mm-dd")%>.css': 'public/css/*.css'
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
				dest: 'build/public/js/main<%= grunt.template.today("yyyy-mm-dd")%>.min.js'
			}
		},

		clean: {
			target: {
				src: ['public/js/site.js']
			},

			build: {
				src: 'build/**'
			}
		},

		watch: {
			stylesheets: {
				files: ['public/css/**/*.scss'],
				tasks: ['sass'],
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

	grunt.registerTask('build', ['copy', 'cssmin', 'imagemin', 'concat', 'uglify', 'clean:target']);

	grunt.registerTask('default', 'Watches the project for changes', ['watch']);
};