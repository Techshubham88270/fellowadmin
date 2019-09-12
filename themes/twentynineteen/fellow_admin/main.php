<?php

/**
 * Add fellow all callback fuctions 
*/
require get_template_directory() . '/fellow_admin/custom_functions.php';

/**
 * Add external css in admin fuctions main_style.css 
 */
function fellow_main_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/fellow_admin/assets/main_style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
        wp_enqueue_script( 'custome_jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", array(), '1.1', true );
}
add_action( 'admin_enqueue_scripts', 'fellow_main_admin_style' );

global $current_user;
$current_user = wp_get_current_user();
// check current user role 
$check_userrole=$current_user->roles[0];
/**
* This function use for register a Agencies menu and sub menus in admin dashboard
*/


function agencies_menu_function(){
  add_menu_page('Agencies', 'Agencies', 'manage_options', 'agencies', 'show_all_agencies_list');
  add_submenu_page( 'agencies', 'All Agencies', 'All Agencies', 'manage_options', 'agencies');
  add_submenu_page( 'agencies', 'Add New', 'Add New', 'manage_options', 'add_new_agency', 'add_new_agencies');
}
add_action('admin_menu', 'agencies_menu_function');


/**
* edit_user_profile hook for add contact number field and Action field in user profile page
* 
*  Callback function defined in custom_functions.php
*/
add_action( 'edit_user_profile', 'add_custom_user_profile_fields' );
add_action( 'show_user_profile', 'add_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'update_custom_user_profile_fields' );


/*add_filter hook for add column in all users list table
*/

add_filter( 'manage_users_columns', 'add_column_agency' );

/*this will add column value in user list table
*
*
*/
add_filter( 'manage_users_custom_column', 'add_column_value_agency', 10, 3 );

/*
* this will add hidden input field for set agency id of his subscribers
* field will add only if agency admin will add users
*/

//field will add only if agency admin will add users
if($check_userrole == "agencyadmin"){

	/*user_new_form hook for add hidden input field for set agency id
	*/
	add_action('user_new_form','agencyid_add_field');

	/*user_register hook for add agency id in meta field of current register user
	*/
	add_action( 'user_register', 'agencyid_save_inregistered_usermeta', 100 );
}

/* 
* this filter "pre_get_users" for display list of all users for perticular agency
*/
add_filter('pre_get_users', 'filter_users_by_agencies');


/*
* This hook will use to redirect url after login 
* agencies list page of administrator and user page of agencyadmin 
*/	

add_filter( 'login_redirect', 'fellow_login_redirect', 10, 3 );

/*
* This hook will use to redirect url when any user will access any other page by url 
* agencies list page of administrator and user page of agencyadmin 
*/
add_action('template_redirect', 'fellow_custome_url_redirect');

/*
* This hook will use to style of login page of wordpress/fellow admin
*  
*/
add_action( 'login_enqueue_scripts', 'fellow_login_page_style' );

/*
* This hook will use to add logo and custome text on login page of wordpress/fellow admin
*  
*/
add_filter( 'login_form', 'fellow_login_logo_title' );

/*
* This hook will use  for block users 
* 
*/
add_filter( 'authenticate', 'fellow_block_user', 30, 3 );

?>


