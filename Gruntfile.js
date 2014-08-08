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
                dir: ['*.php']
          },
            options: {
                bin: 'vendor/bin/phpmd',
                rulesets: 'codesize'
               }
           },

        phpcs: {
          application: {
                dir: ['*.php']
          },
            options: {
               bin: 'vendor/bin/phpcs',
               standard: 'Zend'
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
                directory : '*.php',
                target : 'docs'
            }
        }
    }
        
    });

    // Load required modules
      grunt.loadNpmTasks('grunt-phpmd');
      grunt.loadNpmTasks('grunt-phpcs');
      grunt.loadNpmTasks('grunt-phpcpd');
      grunt.loadNpmTasks('grunt-phpdocumentor');
      
    // Task definitions
    grunt.registerTask('default', ['phpmd','phpcs','phpcpd']);
};
