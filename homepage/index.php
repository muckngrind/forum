<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_index.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
	session_start();
	if ( is_signed_in() ) {
		# If user is signed in, send to user home page
		header("location: home.php?request=Inbox");
	} else {
		# Log in attempt made
		if ( isset( $_POST['username'], $_POST['password'] ) ) {
		
			# Make log in credentials safe for db
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			
			try {
				
				# New user sign up
				if ( isset($_POST['full_name']) ) {
					
					# Make user's name safe for db
					$full_name = trim($_POST['full_name']);								 
					
					# Create user account
					if ( is_user_available($username) ) {
						new_user($username, $full_name, $password);
					}
				}
				
				# Sign in user
				if ( sign_in($username, $password) ) {
					# Register user for session
					$_SESSION['username'] = $username;
					header("location: home.php?request=Inbox");
				}
			} catch (Exception $e) {
				$content['error'] = $e;
				_header();
				_nav_bar_top();
				_index($content);
				_footer();				
			}
		} else {
	
			# Display index page
			_header();
			_nav_bar_top();
			_index();
			_footer();
		}
	}
	
?>
