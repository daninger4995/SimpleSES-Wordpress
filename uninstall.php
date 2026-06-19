<?php
/**
 * Uninstall handler for SimpleSES.
 *
 * Removes the plugin's only stored option. Runs when the user deletes the
 * plugin from the WordPress admin.
 *
 * @package SimpleSES
 */

// Exit if accessed directly or not during an uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'simple_ses' );
delete_transient( 'simple_ses_notice' );

// Multisite: clean up on every site.
if ( is_multisite() ) {
	$site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);

	foreach ( $site_ids as $site_id ) {
		switch_to_blog( $site_id );
		delete_option( 'simple_ses' );
		delete_transient( 'simple_ses_notice' );
		restore_current_blog();
	}
}
