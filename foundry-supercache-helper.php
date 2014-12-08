<?php
/**
 * Plugin Name: Foundry Supercache Helper
 * Plugin URI: http://performancefoundry.com
 * Description: Stops WP Supercache from sending preload emails to the site admin, while still checking up on preloading
 * Version: 1.0
 * Author: Craig Martin, Performance Foundry
 * Author URI: http://performancefoundry.com
 **/

/****************************************************
  * HERE WE GO!
*****************************************************/
remove_action( 'init', 'check_up_on_preloading', '1' ); // stops WP Super Cache from firing off admin emails

function pf_check_up_on_preloading() {
	$value = get_option( 'preload_cache_counter' );
	if ( $value[ 'c' ] > 0 && ( time() - $value[ 't' ] ) > 3600 && false == wp_next_scheduled( 'wp_cache_preload_hook' ) ) {
		if ( is_admin() )
			wp_schedule_single_event( time() + 30, 'wp_cache_preload_hook' );
	}
}
add_action( 'init', 'pf_check_up_on_preloading' ); // sometimes preloading stops working. Kickstart it without emails.

 /* No code below here, please */
 ?>
