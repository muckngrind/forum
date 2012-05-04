<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_admin.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
# If user is signed in
if ( is_signed_in() && is_admin() ) {
	# Check to see which form was submitted and gather parameters
	if ( isset($_POST['form_type']) ) {
		$type = trim($_POST['form_type']);
		
		try {
			
			switch ($type) {
				case "create_club":
					$params['club_name'] = trim($_POST['club_name']);
					$params['club_description'] = trim($_POST['club_description']);
					$params['club_type'] = trim($_POST['club_type']);
					$params['club_administrator'] = trim($_POST['club_administrator']);
					create_club($params);
					$content['message'] = "Club ".$params['club_name']." created.";
					break;
				
				case "appoint_club_administrator":
					$params['club_name'] = trim($_POST['club_name']);
					$params['club_administrator'] = trim($_POST['club_administrator']);
					appoint_club_administrator($params);
					$content['message'] = "Administrator set to ".$params['club_administrator']." for ".$params['club_name'];
					break;
					
				case "ban_user":
					$params['username'] = trim($_POST['username']);
					ban_user($params);
					$content['message'] = $params['username']." has been banned.";				
					break;
					
				case "edit_club_profile":
					$params['club_name'] = trim($_POST['club_name']);
					$params['club_description'] = trim($_POST['club_description']);
					$params['club_type'] = trim($_POST['club_type']);
					edit_club_profile($params);
					$content['message'] = "Club ".$params['club_name']." modified.";				
					break;
					
				case "add_forum":
					$params['club_name'] = trim($_POST['club_name']);
					$params['club_id'] = get_club_id($params['club_name']);
					$params['forum_name'] = trim($_POST['forum_name']);
					$params['forum_description'] = trim($_POST['forum_description']);
					add_forum($params);
					$content['message'] = "Forum ".$params['forum_name']." has been added to ".$params['club_name'].".";						
					break;
					
				case "close_forum":
					$params['forum_name'] = trim($_POST['forum_name']);
					close_forum($params);
					$content['message'] = "Forum ".$params['forum_name']." has been closed to club ".$params['club_name'].".";						
					break;					
					
				case "assign_forum_moderator":
				
					break;
					
				case "manage_club_members":
				
					break;
					
				case "send_message_to_members":
				
					break;
					
				case "close_threads":
				
					break;
					
				case "remove_posts":
				
					break;			
					
			}
			
			# Render admin page
			$content['heading'] = "Administrative Panel";
			$content['type'] = "get_user_rights";
			_header();
			_nav_bar_top();
			_admin($content);
			_footer();
		} catch (Exception $e) {
			echo $e;
			$content['heading'] = "Administrative Panel";
			$content['error'] = $e;
			_header();
			_nav_bar_top();
			_admin($content);
			_footer();			
		}
	} else {
		$content['heading'] = "Administrative Panel";
		$content['type'] = "get_user_rights";
		_header();
		_nav_bar_top();
		_admin($content);
		_footer();
	}
} else {
	# User is not signed in so redirect back to root
	header("location: index.php");	
}
?>
