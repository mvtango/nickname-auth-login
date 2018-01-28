<?php
/*
 * Plugin Name: Nickname Auth Login
 * Version: 1.1
 * Plugin URI: https://github.com/mvtango/nickname-auth-login
 * Description: Try to authenticate using wordpress nickname + password. Prevents duplicate nicknames from being created.
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



function authenticate_nickname_password($user,$username,$password) {

 global $wpdb;

 /* find id for nickname $username */
 /* https://wordpress.stackexchange.com/a/124966/135725 */

 $query = $wpdb->get_results("SELECT * FROM $wpdb->users as users, $wpdb->usermeta as meta WHERE users.ID = meta.user_id AND meta.meta_key = 'nickname' and meta.meta_value = '" . esc_sql( $username ) . "'");

 if ((count($query) > 1) or (count($query) == 0) ) {
    error_log("Nickname '" . esc_sql($username) . "' yielded " . count($query) . " users.");
    return null;
 }


 /* https://developer.wordpress.org/reference/functions/get_user_by/ */

 $user = get_user_by('id',$query[0]->ID);


 /* https://developer.wordpress.org/reference/functions/wp_authenticate_username_password/ */

 if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
    error_log("Password check for user " . $user->login . " failed");
    return null;
  }

 return $user;

} // End authenticate_nickname_password ()



function check_nickname($user_id) {
        global $wpdb;
        // Getting user data and user meta data
        $err['nick'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM $wpdb->users as users, $wpdb->usermeta as meta WHERE users.ID = meta.user_id AND meta.meta_key = 'nickname' AND meta.meta_value = %s AND users.ID <> %d", $_POST['nickname'], $_POST['user_id']));
        foreach($err as $key => $e) {
            // If display name or nickname already exists
            if($e >= 1) {
                $err[$key] = $_POST['username'];
                // Adding filter to corresponding error
                add_filter('user_profile_update_errors', "check_{$key}_field", 10, 3);
            }
        }
    }
    /*
     * Filter function for nickname error
     */
    function check_nick_field($errors, $update, $user) {
            $errors->add('display_nick_error',('Sorry, Nickname is already in use. It needs to be unique.'));
            return false;
    }



/* https://wordpress.stackexchange.com/a/124966/135725 */

function init_nickname_login () {
    add_action('personal_options_update', 'check_nickname');
    add_action('edit_user_profile_update', 'check_nickname');
    add_filter( 'authenticate', 'authenticate_nickname_password',  30, 3 );
}

init_nickname_login();


