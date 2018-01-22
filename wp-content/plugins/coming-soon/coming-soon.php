<?php
/*
 * Plugin Name:       Coming Soon Page & Maintenance Mode by SeedProd
 * Plugin URI:        http://www.seedprod.com
 * Description:       The #1 Coming Soon Page, Under Construction & Maintenance Mode plugin for WordPress.
 * Version:           5.0.17
 * Author:            SeedProd
 * Author URI:        http://www.seedprod.com
 * Text Domain:       coming-soon
 * Domain Path:		  /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * Copyright 2012  John Turner (email : john@seedprod.com, twitter : @johnturner)
 */

/**
 * Default Constants
 */
define( 'SEED_CSP4_SHORTNAME', 'seed_csp4' ); // Used to reference namespace functions.
define( 'SEED_CSP4_SLUG', 'coming-soon/coming-soon.php' ); // Used for settings link.
define( 'SEED_CSP4_TEXTDOMAIN', 'coming-soon' ); // Your textdomain
define( 'SEED_CSP4_PLUGIN_NAME', __( 'Coming Soon Page & Maintenance Mode by SeedProd', 'coming-soon' ) ); // Plugin Name shows up on the admin settings screen.
define( 'SEED_CSP4_VERSION', '5.0.17'); // Plugin Version Number. Recommend you use Semantic Versioning http://semver.org/
define( 'SEED_CSP4_PLUGIN_PATH', plugin_dir_path( __FILE__ ) ); // Example output: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/seed_csp4/
define( 'SEED_CSP4_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // Example output: http://localhost:8888/wordpress/wp-content/plugins/seed_csp4/
define( 'SEED_CSP4_TABLENAME', 'seed_csp4_subscribers' );


/**
 * Load Translation
 */
function seed_csp4_load_textdomain() {
    load_plugin_textdomain( 'coming-soon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'seed_csp4_load_textdomain');


/**
 * Upon activation of the plugin, see if we are running the required version and deploy theme in defined.
 *
 * @since 0.1.0
 */
function seed_csp4_activation(){
	require_once( 'inc/default-settings.php' );
	add_option('seed_csp4_settings_content',unserialize($seed_csp4_settings_deafults['seed_csp4_settings_content']));
	add_option('seed_csp4_settings_design',unserialize($seed_csp4_settings_deafults['seed_csp4_settings_design']));
	add_option('seed_csp4_settings_advanced',unserialize($seed_csp4_settings_deafults['seed_csp4_settings_advanced']));
}
register_activation_hook( __FILE__, 'seed_csp4_activation' );



// Welcome Page

register_activation_hook( __FILE__, 'seed_csp4_welcome_screen_activate' );
function seed_csp4_welcome_screen_activate() {
  set_transient( '_seed_csp4_welcome_screen_activation_redirect', true, 30 );
}


add_action( 'admin_init', 'seed_csp4_welcome_screen_do_activation_redirect' );
function seed_csp4_welcome_screen_do_activation_redirect() {
  // Bail if no activation redirect
    if ( ! get_transient( '_seed_csp4_welcome_screen_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_seed_csp4_welcome_screen_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to bbPress about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'seed_csp4' ), admin_url( 'options-general.php' ) ) );
}


/***************************************************************************
 * Load Required Files
 ***************************************************************************/

// Global
global $seed_csp4_settings;

require_once( SEED_CSP4_PLUGIN_PATH.'framework/get-settings.php' );
$seed_csp4_settings = seed_csp4_get_settings();

require_once( SEED_CSP4_PLUGIN_PATH.'inc/class-seed-csp4.php' );
add_action( 'plugins_loaded', array( 'SEED_CSP4', 'get_instance' ) );

if( is_admin() ) {
// Admin Only
	  require_once( SEED_CSP4_PLUGIN_PATH.'inc/config-settings.php' );
    require_once( SEED_CSP4_PLUGIN_PATH.'framework/framework.php' );
    add_action( 'plugins_loaded', array( 'SEED_CSP4_ADMIN', 'get_instance' ) );
    require_once( SEED_CSP4_PLUGIN_PATH.'framework/review.php' );
} else {
// Public only

}





