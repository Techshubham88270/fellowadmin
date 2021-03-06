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
			//call this function for display suceess message if any aggency will created.
			add_agency_message($user_id,$u_action='add',$message_type='success');

			$msg = "Your agency has been created successfully. Your password is: ".$password;
			wp_mail($user->user_email, "Agency created", $msg);
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
			//call this function for display error message if any aggency will already exist.
			add_agency_message($user_id,$u_action='add',$message_type='error');
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

				add_agency_message($user_id,$u_action='update',$message_type='success');

				// wp_redirect( admin_url('/admin.php?page=add_new_agency&agency_id=').$user_id, 301 );
				// exit();

                   ?>
                <div class="wrap" id="profile-page">
					<h1 class="wp-heading-inline">
					Agency</h1>
					<a href="<?echo admin_url('admin.php?page=add_new_agency')?>" class="page-title-action">Add New</a>
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
								<td><input type="text" name="ageny_name" id="first_name" value="<?echo $name_up?>" class="regular-text" required></td>
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
								<td><input type="number" name="contact_number" id="number" value="<?echo $contact_up?>" class="regular-text code"></td>
								</tr>
								<tr class="user-email-wrap">
								<th><label for="Registration field">Registration Number <span class="description">(required)</span></label></th>
								<td>
								<input type="text" name="registration_number" id="registration_number"  value="<?echo $registration_up?>" class="regular-text ltr" required>
								</td>
								</tr>
								<tr class="user-email-wrap">
								<th><label for="Actions field">Actions<span class="Actions"></span></label></th>
								<td>
								<input type="radio" name="agency_action" value="block" <?if($action_up=='block'){echo "checked";}?>> Block
								<input type="radio" name="agency_action" value="release" <?if($action_up=='release'){echo "checked";}?>> Release<br>
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
								<textarea name="ageny_note" id="description" rows="3" cols="30"><?echo $note_up ?></textarea>
								</td>
								</tr>
							</tbody>
						</table>
						<p class="submit"><input type="submit" name="agency_update" id="submit" class="button button-primary" value="Update"></p>
					</form>
				</div>
                   <?
	
	    	}else{

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
	    	}

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
   * Update custome table user data 
   */
	function update_custom_user_profile_fields( $user_id )
	{
		// Update contact number in user meta	
		$contact_number = $_POST['contact_number'];
		update_user_meta( $user_id, 'contact_number', $contact_number );
		// Update action in user meta
		$action = $_POST['agency_action'];
		update_user_meta( $user_id, 'action', $action );

		$user=get_userdata( $user_id);
		$user_role=$user->roles[0];
        // insert register user data in custome "user" table  if register role is 'subscriber'
			if($user_role="subscriber"){
				$custome_uid=get_user_meta( $user_id, 'custome_uid' );
				$email = $_POST['email'];
				$first_name = $_POST['first_name'];
				global $wpdb;
				$table ='user';
				$data = [ 'email' =>$email,'firstName' =>$first_name]; // NULL value.
				$where = [ 'id' =>$custome_uid[0] ]; // NULL value in WHERE clause.
				$wpdb->update(  $table, $data, $where);
			} 
	}

	/* 
	* callback function for add agency id in meta field of current register user
	* 
	* function call in main.php with "user_register" wordpress hook.
	*
	* Insert new user row in custome table 'user'
	*/
	function agencyid_save_inregistered_usermeta( $user_id)  
	{
		$current_user = wp_get_current_user();
		// add agencyid in user meta
		$agencyid=$_POST['agency_userid'];
		update_user_meta( $user_id, 'agencyid', $agencyid );

        // add action in user meta
		$action = $_POST['agency_action'];
		update_user_meta( $user_id, 'action', $action );
            //fetch user all data by user id
			$user=get_userdata( $user_id);
			//print_r($user);
			$user_role=$user->roles[0];
            // insert register user data in custome "user" table  if register role is 'subscriber'
			if($user_role="subscriber"){
				global $wpdb;
				$table ='user';
				$data = array('firstName' => $user->display_name,'lastName' => 'test','email'=>$user->user_email);
				$format = array('%s','%d');
				$wpdb->insert($table,$data,$format);
				$cus_user_id = $wpdb->insert_id;


                // add user id of custome table in user meta 
				update_user_meta( $user_id, 'custome_uid', $cus_user_id);
				echo $cus_user_id;
		} 
	}
    
    /* 
	* callback function for delete custome user row after delete user from wordpress table 
	* 
	* function call in main.php with "delete_user" wordpress hook.
	*/
	function fellow_custome_delete_user( $user_id ) 
	{
		$user=get_userdata( $user_id);
		$user_role=$user->roles[0];
        // Delete register user data in custome "user" table  if register role is 'subscriber'
			if($user_role="subscriber"){
				global $wpdb;
				$table ='user';
				$custome_uid=get_user_meta( $user_id, 'custome_uid' );
				$wpdb->delete( $table, array( 'id' =>$custome_uid[0] ) );
			} 
	}

	/*this will add column in user list table
	*
	* function call in main.php with "manage_users_columns" wordpress hook.
	*/

	function add_column_agency( $column ) 
	{
	    $column['name_agency'] = 'Agency';
	    return $column;
	}
	
	/* 
	* this will add column value in user list table
	* function call in main.php with "manage_users_custom_column" wordpress hook.
	*/
	function add_column_value_agency( $val, $column_name, $user_id ) 
	{

		// Fetch agencyid of user from user meta http://localhost/fellowadmin/wp-admin/user-edit.php?user_id='.$agency_id[0]
		$agency_id=get_user_meta( $user_id, 'agencyid' );
		$agency_name=get_userdata( $agency_id[0] );

		    switch($column_name) {
		        case 'name_agency' :
		            return '<a href="'.admin_url('user-edit.php?user_id='.$agency_id[0]).'">'.$agency_name->data->user_login.'</a>';
		            break;
		           default:
		    }
	}

	/* 
	* callback function for add hidden input field for set agency id
	*
	* function call in main.php with "user_new_form" wordpress hook.
	*/
	function agencyid_add_field()
	{
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
	* callback function for filter all users list on the bases of perticular agencies 
	* function call in main.php with "pre_get_users" wordpress hook.
	*/

	function filter_users_by_agencies($query)
	{
		$current_user = wp_get_current_user();
		$user_role=$current_user->roles[0];
		global $pagenow;
		if (is_admin() && 'users.php' == $pagenow) {
			/*
			* display list of user on the base of user roles
			* if agencyadmin login only list of their users will show
			*/

			if($user_role=="agencyadmin"){
				$meta_query = array (				
				array (
					'key' => 'agencyid',
					'value' => $current_user->data->ID,
					'compare' => '='
				)
			);
			$query->set('meta_query', $meta_query);

			}
			// if administrator login and will access user by "Show User" users will show on the base of agency
			elseif(isset($_GET['user_agencyid']) && $user_role == "administrator"){
				$meta_query = array (				
				array (
					'key' => 'agencyid',
					'value' => $_GET['user_agencyid'],
					'compare' => '='
				)
			);
			$query->set('meta_query', $meta_query);
			
			}
		}
	}

	/*
	* This callback function use to redirect url after login 
	* agencies list page of administrator and user page of agencyadmin 
	*/

	function fellow_login_redirect( $redirect_to, $request, $user ) 
	{
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
	function fellow_custome_url_redirect() 
	{
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

	/*
	* This hook will use to style of login page of wordpress/fellow admin
	*  
	*/
	function fellow_login_page_style() 
	{ ?>
		<style type="text/css">
		/* css of login page */
		#login h1 a, .login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
			height:65px;
			width:320px;
			background-size: 320px 65px;
			background-repeat: no-repeat;
			padding-bottom: 30px;

	    }
		.login-action-login{
			background-color: #3a90b3;
		}
		.login-action-login .fellow_logo{
			position: absolute;
			top: 22%;
			left: 41%;
			color: #0f0f0f;
			text-transform: uppercase;
			font-size: 36px;

		}
		.login .button-primary {
			float: none!important;
			margin-top: 10px!important;
			width: 100%;
		}
		.login-action-login #login {
			width: 500px;
			padding: 8% 0 0;
			margin: auto;
		}
		.login-action-login #backtoblog{
			display:none;
		}
		.login-action-login .button.button-large {
			height: 45px!important;

		}
		.login-action-login .forgetmenot{
			margin-top: 20px;

		}
		.fellow_logo{
			color:#fff!important;
		}
		.login-action-login #nav{
			float: right;
			position: absolute;
			right: 0;
			bottom: 10px;
		}
		.login-action-login #login{
			position: relative!important;
		}
	    .cus_text{
	    	position: absolute;
			bottom: 10px;
	    }  
	    .cus_logo{
			position: absolute;
			top: 20px;
			text-align: center;
			left: 36%;

	    }
	    .cus_logo p{
			padding-top:15px;
			color: #444;
			font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
			font-size: 14px;
	    }
	    .login-action-login form#loginform{
			position: relative!important;
			margin-top: -100px!important;
			padding: 100px 24px 46px!important;
			background: #f5f3f3!important;
	    }
	    .block_msg{
		    background: #dc3232cf;
		    color: #fff;
		    padding: 20px!important;
		    font-size: 18px;
		    position: absolute;
		    top: 17%;
		    left: 34.5%;
		    width: 453px;
	    }

		</style>
	<?php }

	/*
	* This hook will use to add logo and custome text on login page of wordpress/fellow admin
	*  
	*/
	function fellow_login_logo_title()
	{?>
		<div class="cus_logo">
			<?if(isset($_GET['userlogin'])&& $_GET['userlogin']=='agency'){
				echo '<h2>Agency Admin</h2>';
			}else{
				echo '<h2>Fellow Admin</h2>';
			}?>
			<p class="">Who's knocking ?</p>
		</div>
	    <p class="cus_text">Don't have an account</p>
	<?}

    /*
	* callback function for block users  
	* this function will call with wp_authenticate 
	*/
	function fellow_block_user( $user, $username, $password ) 
	{
		if (!empty($username) && !empty($password)) {
			$action= get_user_meta($user->ID,"action");
			// echo $action[0];
			if($action[0]=="block"){
				echo "<h4 class='block_msg'>Your account is blocked</h4></br>";
			}else{
					return $user;
			}
		}
	}

	/**
   * This callback function use display message if any new agency will  Add 
   *
   * this function use with hook "admin_notices";
   */
	function add_agency_message($user_id,$u_action='',$message_type='') {
			if($user_id){
				if($u_action=='add'){
					if($message_type=='success'){
						?>
						<div class="notice notice-success is-dismissible">
						<p><?php _e( 'Agency added successfully!');?></p>
						</div>
						<?php
					}elseif($message_type=='error'){
                         ?>
						<div class="notice notice-error is-dismissible">
						<p><?php _e( 'Agency already exist');?></p>
						</div>
						<?php
					}
				}elseif($u_action=='update'){
					if($message_type=='success'){
						?>
						<div class="notice notice-success is-dismissible">
						<p><?php _e( 'Agency updated!');?></p>
						</div>
						<?php
					}elseif($message_type=='error'){
                         ?>
						<div class="notice notice-error is-dismissible">
						<p><?php _e( 'Agency already exist');?></p>
						</div>
						<?php
					}

				}
		
			}
		}