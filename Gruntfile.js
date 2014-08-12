module.exports = function(grunt) {
    var directoriesConfig = {
        composer: 'vendor',
        composerBin: 'vendor/bin',
        reports: 'logs',
        php: 'app'
    };
    // Project configuration.
     grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        directories: directoriesConfig,

        phpmd: {
          application: {
                dir: './'
          },
            options: {
                bin: 'vendor/bin/phpmd',
                suffixes: 'php',
                rulesets: 'naming',
                exclude:'vendor,phpmd,node_modules,docs'

               }
           }, 

        phpcs: {
          application: {
                dir: ['*.php']
          },
            options: {
               bin: 'vendor/bin/phpcs',
               standard: 'PSR1'
            }
        },

        phpcpd: {
            application: {
            dir: '*.php'
            },
            options: {
            bin: 'vendor/bin/phpcpd',
            quiet: 'true'
            }
        },

        phpdocumentor: {
        dist: {
            options: {
                directory : ['./'],
				exclude:'vendor,phpmd,node_modules,forphpmd,docs',
                target : 'docs'
            }
        }	
    },
	    shell: {                                
        listFolders: {                     
          options: {                     
            stderr: false
          },
            command: 'php phpdcd.phar *.php'  
          }
        },
		
		phpdcd: {
  		application: {
     		 dir: ['*.php']
    		},
    options: {
      namesExclude: 'config.php,settings.php',
	  bin: 'vendor/bin/phpdcd'
    }
}


    });

    // Load required modules
      grunt.loadNpmTasks('grunt-phpmd');
      grunt.loadNpmTasks('grunt-phpcs');
      grunt.loadNpmTasks('grunt-phpcpd');
      grunt.loadNpmTasks('grunt-phpdocumentor');
      grunt.loadNpmTasks('grunt-shell');
	  grunt.loadNpmTasks('grunt-phpdcd');
      
    // Task definitions
    grunt.registerTask('default', ['phpmd','phpdcd','phpcpd','phpdocumentor','shell','phpcs']);
};
