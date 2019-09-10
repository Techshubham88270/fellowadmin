<?php
?>
<link rel="stylesheet" type="text/css" href="<? echo get_template_directory_uri()?>/fellow_admin/assets/main_style.css">
<style type="text/css">
	

		
</style>
<?

/**
 * Add fellow all callback fuctions 
 */
	require get_template_directory() . '/fellow_admin/custom_functions.php';

	global $current_user;
$current_user = wp_get_current_user();
    // check current user role 
	$check_userrole=$current_user->roles[0];
/**
* This function use for register a Agencies menu and sub menus in admin dashboard
*/
if($check_userrole=='administrator'){

function agencies_menu_function(){
  add_menu_page('Agencies', 'Agencies', 'manage_options', 'agencies', 'show_all_agencies_list');
  add_submenu_page( 'agencies', 'All Agencies', 'All Agencies', 'manage_options', 'agencies');
  add_submenu_page( 'agencies', 'Add New', 'Add New', 'manage_options', 'add_new_agency', 'add_new_agencies');
}
add_action('admin_menu', 'agencies_menu_function');
}


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

        /* 
        * this filter "pre_get_users" for display list of all users for perticular agency
		*/
		add_filter('pre_get_users', 'filter_users_by_agencies');

		/* 
        * remove default roles if agencyadmin user login it can add only agencyadmin/subscriber 
		*/
	}


	/*
	* This hook will use to redirect url after login 
	* agencies list page of administrator and user page of agencyadmin 
	*/	

	add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
    
    /*
	* This hook will use to redirect url when any user will access any other page by url 
	* agencies list page of administrator and user page of agencyadmin 
	*/
	add_action('template_redirect', 'custome_url_redirect');

    /*
	* This hook will use to Add logo on login page of wordpress
	*  
	*/
	function my_login_logo() 
	{ ?>
		<style type="text/css">
				#login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
        }
		</style>
	    <h1 class="fellow_logo">Fellow Admin</h1>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo' );