<?php
/*
 * Plugin Name: nickname-login
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Martin Virtel
 * Author URI: https://twitter.com/mvtango
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: nickname-login
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Martin Virtel
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-nickname-login.php' );
// require_once( 'includes/class-nickname-login-settings.php' );

// Load plugin libraries
// require_once( 'includes/lib/class-nickname-login-admin-api.php' );
// require_once( 'includes/lib/class-nickname-login-post-type.php' );
// require_once( 'includes/lib/class-nickname-login-taxonomy.php' );

/**
 * Returns the main instance of nickname-login to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object nickname-login
 */
function nickname_login () {
	$instance = nickname_login::instance( __FILE__, '1.0.0' );

	/*
    if ( is_null( $instance->settings ) ) {
		$instance->settings = nickname_login_Settings::instance( $instance );
	}
    */

	return $instance;
}

nickname_login();


