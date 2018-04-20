<?php
/**
 * Automate the setup of the freshest version of WordPress and Gutenberg
 */

/* Fetch the latest version of WordPress */
ds_cli_exec( "wp core download" );

/* Install WordPress
 *
 * You can change the title, admin_user, admin_password, admin_email
 */
ds_cli_exec( "wp core install --url=$siteName --title='Gutenberg Blueprint' --admin_user=testadmin --admin_password=password --admin_email=pleaseupdate@$siteName" );

//** Download & Activate Theme from Git
ds_cli_exec( "git clone https://github.com/WordPress/gutenberg-starter-theme.git  wp-content/themes/gutenberg-starter-theme-master/");
ds_cli_exec( "wp theme activate gutenberg-starter-theme-master" );

/** Download plugin from repository, unzip Gutenberg, activate */
ds_cli_exec( "wp plugin install gutenberg" );
ds_cli_exec( "wp plugin activate gutenberg" );

//** Download & Activate Plugin from Git
/* How to create your first blockf for Gutenberg -- https://neliosoftware.com/blog/how-to-create-your-first-block-for-gutenberg/ */
ds_cli_exec( "git clone https://github.com/avillegasn/nelio-testimonial-block.git wp-content/plugins/nelio-testimonial-block/" );
ds_cli_exec( "wp plugin activate nelio-testimonial-block" );

//** Change Permalink structure
ds_cli_exec( "wp rewrite structure '/%postname%' --quiet" );

//** Discourage search engines from indexing this site
ds_cli_exec( "wp option update blog_public 'on'" );

ds_cli_exec( "wp rewrite flush --quiet" );

/** Check if index.php unpacked okay */
if ( is_file( "index.php" ) ) {

	/** Cleanup the empty folder, download, and this script. */
	ds_cli_exec( "rm -rf wordpress && rm index.htm && rm latest.zip && rm blueprint.php" );	
}
