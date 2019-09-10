<?php
ob_start();

 /**
   * This  function use for Add new Agencies 
   *
   * call this function under add_new_agencies();
   */
	function add_agency_admin($username,$name,$password,$email,$contact_num='',$reg_code,$action='',$note='') 
	{
		           
		// Create the new user
		$user_id = wp_create_user( $username, $password, $email );

		// Get current user object
		$user = get_user_by( 'id', $user_id );
		
		// add Name in user meta
		update_user_meta( $user_id, 'first_name', $name );
		// add contact number in user meta
		update_user_meta( $user_id, 'contact_number', $contact_num );
		// add contact number in user meta
		update_user_meta( $user_id, 'reg_code', $reg_code );
		// add action in user meta
		update_user_meta( $user_id, 'action', $action );
		// add action in user meta
		update_user_meta( $user_id, 'note', $note );
        // conditional check if user already exist or not
		if($user){
			echo $username.' created successfully.';
			echo '<br>';
			/**
			* wp_create_user function set default subscriber role 
			*
			* remove_role() function remove subscriber role of new create user;
			*/
			$user->remove_role( 'subscriber' );
			// add_role() function Add administrator role of new create user;
			$user->add_role( 'agencyadmin' );

		}else{
			echo $username.' already exist.';
			echo '<br>';
		}

	 }
   /**
   * This callback function use for Add new Agencies
   *
   * function call in main.php add menu section 
   */

   function add_new_agencies()
   {
		
	    if(isset($_GET['agency_id']))
	    {
			/**
			* 	Update user agency data
			*/
	    	$user_id=$_GET['agency_id'];
	    	$user_info = get_userdata($user_id);
	    	//print_r($user_info);
	    	// Fetch name of agency from user meta
	    	$name=get_user_meta( $user_id, 'first_name');
	    	// Fetch contact_number of agency from user meta
	    	$contact_num=get_user_meta( $user_id, 'contact_number' );
	    	// Fetch reg_code of agency from user meta
	    	$reg_code=get_user_meta( $user_id, 'reg_code' );
	    	// Fetch action of agency from user meta
	    	$action=get_user_meta( $user_id, 'action' );
	    	// Fetch note of agency from user meta
	    	$note=get_user_meta( $user_id, 'note' );

	    	if(isset($_POST['agency_update'])){

	    		$name_up=$_POST['ageny_name'];
	    		$contact_up=$_POST['contact_number'];
	    		$registration_up=$_POST['registration_number'];
	    		$action_up=$_POST['agency_action'];
	    		$note_up=$_POST['ageny_note'];

				update_user_meta( $user_id, 'first_name', $name_up );
				// Update contact number in user meta
				update_user_meta( $user_id, 'contact_number', $contact_up );
				// Update registration _code in user meta
				update_user_meta( $user_id, 'reg_code', $registration_up );
				// Update action in user meta
				update_user_meta( $user_id, 'action', $action_up );
				// Update note in user meta
				update_user_meta( $user_id, 'note', $note_up );
				

				wp_redirect( get_bloginfo('url')."/wp-admin/admin.php?page=add_new_agency&agency_id=".$user_id, 301 );
				exit();

	
	    	}

	    	?>
	    	<div class="wrap" id="profile-page">
				<h1 class="wp-heading-inline">
				Agency</h1>
				<a href="<?echo get_bloginfo('url')?>/wp-admin/admin.php?page=add_new_agency" class="page-title-action">Add New</a>
				<hr class="wp-header-end">
				<form id="your-profile" action="" method="post" >
				<h2>Name</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-user-login-wrap">
				<th><label for="user_login">Username<span class="description">(required)</span></label></th>
				<td><input type="text" name="user_login" id="user_login" value="<?echo $user_info->data->user_login?>" class="regular-text"  disabled="disabled" > <span class="description">Usernames cannot be changed.</span></td>
				</tr>
				<tr class="user-first-name-wrap">
				<th><label for="first_name">Name<span class="description">(required)</span></label></th>
				<td><input type="text" name="ageny_name" id="first_name" value="<?echo $name[0]?>" class="regular-text" required></td>
				</tr>

				</tbody>
				</table>
				<h2>Contact Info</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-email-wrap">
				<th><label for="email">Email <span class="description">(required)</span></label></th>
				<td>
				<input type="email" name="ageny_email" id="email" aria-describedby="email-description" value="<?echo $user_info->data->user_email?>" class="regular-text ltr" email required>
				</td>
				</tr>
				<tr class="user-url-wrap">
				<th><label for="contact no">Contact Number</label></th>
				<td><input type="number" name="contact_number" id="number" value="<?echo $contact_num[0]?>" class="regular-text code"></td>
				</tr>
				<tr class="user-email-wrap">
				<th><label for="Registration field">Registration Number <span class="description">(required)</span></label></th>
				<td>
				<input type="text" name="registration_number" id="registration_number"  value="<?echo $reg_code[0]?>" class="regular-text ltr" required>
				</td>
				</tr>
				<tr class="user-email-wrap">
				<th><label for="Actions field">Actions<span class="Actions"></span></label></th>
				<td>
				<input type="radio" name="agency_action" value="block" <?if($action[0]=='block'){echo "checked";}?>> Block
				<input type="radio" name="agency_action" value="release" <?if($action[0]=='release'){echo "checked";}?>> Release<br>
				</td>
				</tr>
				</tbody>
				</table>
				<h2>About Yourself</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-description-wrap">
				<th><label for="Note">Note</label></th>
				<td>
				<textarea name="ageny_note" id="description" rows="3" cols="30"><?echo $note[0] ?></textarea>

				</td>
				</tr>

				</tbody>
				</table>

				<p class="submit"><input type="submit" name="agency_update" id="submit" class="button button-primary" value="Update"></p>
				</form>
			</div>
	    	<?

	    }else
	    {

			/**
			* Create user in wordpress Wp_users by add ageny
			*/
	    	if(isset($_POST['agency_submit'])){
	   		//print_r($_POST);
			/* 
			* Create an admin user silently
			*/ 
				$username = strtolower($_POST['user_login']);
				$password = wp_generate_password();
				$name = $_POST['ageny_name'];
				$email = $_POST['ageny_email'];  
				$contact_num = $_POST['contact_number']; 
				$reg_code = $_POST['registration_number']; 
				$action = $_POST['agency_action'];
				$note = $_POST['ageny_note'];   

			add_action('init', 'add_agency_admin');
			
			add_agency_admin($username,$name,$password,$email,$contact_num,$reg_code,$action,$note);
	   		}
	        ?>
			<div class="wrap" id="profile-page">
				<h1 class="wp-heading-inline">
				Agency</h1>
				<a href="<?echo get_bloginfo('url')?>/wp-admin/admin.php?page=add_new_agency" class="page-title-action">Add New</a>
				<hr class="wp-header-end">
				<form id="your-profile" action="" method="post" >
				<h2>Name</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-user-login-wrap">
				<th><label for="user_login">Username</label></th>
				<td><input type="text" name="user_login" id="user_login" value="" class="regular-text" required > <span class="description">Usernames cannot be changed.</span></td>
				</tr>
				<tr class="user-first-name-wrap">
				<th><label for="first_name">Name</label></th>
				<td><input type="text" name="ageny_name" id="first_name" value="" class="regular-text" required></td>
				</tr>

				</tbody>
				</table>
				<h2>Contact Info</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-email-wrap">
				<th><label for="email">Email <span class="description">(required)</span></label></th>
				<td>
				<input type="email" name="ageny_email" id="email" aria-describedby="email-description" value="" class="regular-text ltr" email required>
				</td>
				</tr>
				<tr class="user-url-wrap">
				<th><label for="contact no">Contact Number</label></th>
				<td><input type="number" name="contact_number" id="number" value="" class="regular-text code"></td>
				</tr>
				<tr class="user-email-wrap">
				<th><label for="Registration field">Registration Number <span class="description">(required)</span></label></th>
				<td>
				<input type="text" name="registration_number" id="registration_number"  value="" class="regular-text ltr" required>
				</td>
				</tr>
				<tr class="user-email-wrap">
				<th><label for="Actions field">Actions<span class="Actions"></span></label></th>
				<td>
				<input type="radio" name="agency_action" value="block"> Block
				<input type="radio" name="agency_action" value="release"> Release<br>
				</td>
				</tr>
				</tbody>
				</table>
				<h2>About Yourself</h2>
				<table class="form-table">
				<tbody>
				<tr class="user-description-wrap">
				<th><label for="Note">Note</label></th>
				<td>
				<textarea name="ageny_note" id="description" rows="3" cols="30"></textarea>

				</td>
				</tr>

				</tbody>
				</table>

				<p class="submit"><input type="submit" name="agency_submit" id="submit" class="button button-primary" value="Submit"></p>
				</form>
			</div>
			<?
	    }  	
	}
  /**
   * This callback function use for display list of Agencies
   *
   * function call in main.php All Agencies menu section 
   */
	function show_all_agencies_list()
	{
		ob_start();
		require get_template_directory() . '/fellow_admin/views/agencies_view.php';
		$template=ob_get_contents();
		ob_end_clean();
		echo $template;
	}  

  /**
   * This callback function use for modify users profile page 
   *
   * function call in main.php with "edit_user_profile" wordpress hook.
   *
   * creating  Contact Number field and Action field in users profile page
   */


	function add_custom_user_profile_fields( $user )
	{
		
		// get user id of selected user
		$user_id=$user->data->ID;

		// get contact number from user meta by user id
		$contact_num=get_user_meta( $user_id, 'contact_number' );

		// Fetch action of agency from user meta
	    $action=get_user_meta( $user_id, 'action' );
	    ?>
	    <table class="form-table">
	    <!-- input field for add contact field -->
			<tr class="user-contact">
			<th><label for="contact no">Contact Number</label></th>
			<td><input type="number" name="contact_number" id="number" value="<?echo $contact_num[0]?>" class="regular-text code"></td>
			</tr>
		<!-- input field for Action  field -->
			<tr class="user-action-wrap">
			<th><label for="Actions field">Actions<span class="Actions"></span></label></th>
			<td>
			<input type="radio" name="agency_action" value="block" <?if($action[0]=='block'){echo "checked";}?>> Block
			<input type="radio" name="agency_action" value="release" <?if($action[0]=='release'){echo "checked";}?>> Release<br>
			</td>
			</tr>
	    </table>
	    
	    <?php
	 } 
	/**
   * This callback function use for Update users Contact number and action from user update page
   *
   * function call in main.php with "edit_user_profile_update" wordpress hook.
   *
   */
	function update_custom_user_profile_fields( $user_id )
	{
		// Update contact number in user meta	
		$contact_number = $_POST['contact_number'];
		update_user_meta( $user_id, 'contact_number', $contact_number );
		// Update action in user meta
		$action = $_POST['agency_action'];
		update_user_meta( $user_id, 'action', $action );
	}

	/*this will add column in user list table
	*
	* function call in main.php with "manage_users_columns" wordpress hook.
	*/

	function add_column_agency( $column ) {
	    $column['name_agency'] = 'Agency';
	    return $column;
	}
	
	/* 
	* this will add column value in user list table
	* function call in main.php with "manage_users_custom_column" wordpress hook.
	*/
	function add_column_value_agency( $val, $column_name, $user_id ) {

	// Fetch agencyid of user from user meta
	$agency_id=get_user_meta( $user_id, 'agencyid' );
	$agency_name=get_userdata( $agency_id[0] );

	    switch($column_name) {
	        case 'name_agency' :
	            return '<a href="http://localhost/fellowadmin/wp-admin/user-edit.php?user_id='.$agency_id[0].'">'.$agency_name->data->user_login.'</a>';
	            break;
	           default:
	    }
	}

	/* 
	* callback function for add hidden input field for set agency id
	* function call in main.php with "user_new_form" wordpress hook.
	*/
	function agencyid_add_field() {
		$current_user = wp_get_current_user();
	      ?>
		    <table class="form-table">
		    <!-- input field for add Agency id field -->
				<tr>
				<th><label for="contact no"></label></th>
				<td><input type="hidden" name="agency_userid" id="number" value="<?echo $current_user->data->ID?>" class="regular-text code"></td>
				</tr>
			<!-- input field for Action  field -->
				<tr class="user-action-wrap">
					<th><label for="Actions field">Actions<span class="Actions"></span></label></th>
					<td>
					<input type="radio" name="agency_action" value="block"> Block
					<input type="radio" name="agency_action" value="release"> Release<br>
					</td>
				</tr>
		    </table>
		<?php
	}

	/* 
	* callback function for add agency id in meta field of current register user
	* function call in main.php with "user_register" wordpress hook.
	*/
	function agencyid_save_inregistered_usermeta( $user_id)  {
		$current_user = wp_get_current_user();
		// add agencyid in user meta
		$agencyid=$_POST['agency_userid'];
		update_user_meta( $user_id, 'agencyid', $agencyid );

        // add action in user meta
		$action = $_POST['agency_action'];
		update_user_meta( $user_id, 'action', $action );
	}



    /* 
	* callback function for filter all users list on the bases of perticular agencies 
	* function call in main.php with "pre_get_users" wordpress hook.
	*/

	function filter_users_by_agencies($query)
	{
		$current_user = wp_get_current_user();
	

		global $pagenow;
		if (is_admin() && 'users.php' == $pagenow) {
			$meta_query = array (				
				array (
					'key' => 'agencyid',
					'value' => $current_user->data->ID,
					'compare' => '='
				)
			);
			$query->set('meta_query', $meta_query);
		}
	}

	/*
	* This callback function use to redirect url after login 
	* agencies list page of administrator and user page of agencyadmin 
	*/

	function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check if login user is agencyadmin
       		if (in_array('agencyadmin', $user->roles)) {
	            // redirect them to their user list of perticular agency 
	            $redirect_to =  get_bloginfo('url')."/wp-admin/users.php";

	        }
	          //check for administrator
	        if (in_array('administrator', $user->roles)) {
	            // redirect them to list of all agencies if login user is administrator 
	            $redirect_to =  get_bloginfo('url')."/wp-admin/admin.php?page=agencies";
	        }
    	}
    return $redirect_to;
	}


	/*
	* callback function for redirect url when any user will access any other page by url
	* agencies list page of administrator and user page of agencyadmin 
	*/
	function custome_url_redirect() {
		global $current_user;
		$current_user = wp_get_current_user();
		$userrole=$current_user->roles[0];

		if (!is_user_logged_in())
		{
			wp_redirect( wp_login_url());
		}
		elseif(is_user_logged_in() && $userrole == "administrator")
		{			
			wp_redirect(admin_url("admin.php?page=agencies"));
			exit();
		}
		elseif( is_user_logged_in() && $userrole == "agencyadmin")
		{
			wp_redirect(admin_url("users.php"));
			exit();
		}
		else {
			wp_redirect(admin_url());
			exit();
		}
	}