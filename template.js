/**
 * grunt-wp-boilerplate
 * https://github.com/fooExtensions/grunt-wp-boilerplate
 *
 * Copyright (c) 2014 Brad Vincent, FooExtensions LLC
 * Licensed under the MIT License
 */

'use strict';

// Basic template description
exports.description = 'Create a AnsPress Extension!';

// Template-specific notes to be displayed before question prompts.
exports.notes = 'Please answer following questions below';

// Template-specific notes to be displayed after the question prompts.
exports.after = 'Your Extension for AnsPress has been generated. Enjoy!';

// Any existing file or directory matching this wildcard will cause a warning.
exports.warnOn = '*';

// The actual init template
exports.template = function( grunt, init, done ) {
	init.process( {}, [
		// Prompt for these values.
		init.prompt( 'title', 'Extension title' ),
        init.prompt( 'slug', 'Extension slug / textdomain (no spaces)' ),
		init.prompt( 'description', 'An awesome Extension that does awesome things' ),
        {
            name: 'version',
            message: 'Extension Version',
            default: '0.0.1'
        },
		init.prompt( 'long_description', 'Long description for th Extension' ),
		init.prompt( 'homepage', 'http://wp3.in' ),
		init.prompt( 'author_name' ),
		init.prompt( 'author_email' ),
		init.prompt( 'author_url' ),
        init.prompt( 'github_repo' )
	], function( err, props ) {

        props.safe_name = props.title.replace(/[\W_]+/g, '_');
        props.constant = props.safe_name.toUpperCase();

		// Files to copy and process
		var files = init.filesToCopy( props );

        //delete a file if necessary :
        //delete files[ 'public/assets/js/public.js'];
		
		console.log( files );
		
		// Actually copy and process files
		init.copyAndProcess( files, props, {noProcess: 'assets/**' } );
		
		// Generate package.json file
		//init.writePackageJSON( 'package.json', props );
		
		// Done!
		done();
	});
};