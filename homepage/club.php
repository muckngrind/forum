<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_club.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
session_start();
if ( is_signed_in() || is_public($_GET['request']) ) {
	if ( isset($_GET['request']) || isset($_POST['request']) ) {
		try {
			if ( isset($_GET['request']) ) {
				$content['club_id'] = $_GET['request'];
				if ( isset($_GET['action']) && strcmp(trim($_GET['action']),'join') == 0 ) {
					join_club($_SESSION['username'], $content['club_id']);
				}
			} else {
				$content['club_id'] = trim($_POST['request']);
	
				# Identify which form we need to respond to
				$type = trim($_POST['form_type']);
				switch ($type) {
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
						$params['forum_name'] = trim($_POST['forum_name']);
						$params['forum_moderator'] = trim($_POST['forum_moderator']);
						assign_forum_moderator($params);
						$content['message'] = "Moderator set to ".$params['forum_moderator']." for ".$params['forum_name'];				
						break;
						
					case "remove_club_members":
						$params['club_id'] = trim($_POST['request']);
						$params['users'] = $_POST['users'];
						remove_members($params);
						$content['message'] = "Members removed.";					
						break;
						
					case "membership_request":
						$params['club_id'] = trim($_POST['request']);
						$params['subject'] = $_POST['subject'];
						$params['sender'] = $_POST['sender'];
						$params['recipient'] = $_POST['recipient'];
						$params['message'] = $_POST['message'];
						request_membership($params);
						$content['message'] = "Membership request successfully sent.";					
						break;
						
					case "member_invitation":
						$params['club_id'] = trim($_POST['request']);
						$params['subject'] = $_POST['subject'];
						$params['sender'] = $_POST['sender'];
						$params['recipient'] = $_POST['recipient'];
						$params['message'] = $_POST['message'];
						invite_member($params);
						$content['message'] = "Membership request successfully sent.";					
						break;
						
					case "approve_club_members":
						$params['club_id'] = trim($_POST['request']);
						$params['sender_ids'] = $_POST['sender_ids'];
						$params['message_ids'] = $_POST['message_ids'];
						add_member($params);
						$content['message'] = "Users added to club roster.";					
						break;						
				}
			}
	
			$content['heading'] = "Club Profile";
			# Retrieve club details
			$club = get_club_info($content['club_id']);
			$forums = get_club_forums($content['club_id']);
			$content['forums'] = $forums;
			$content['club_name'] = $club['name'];
			$content['club_type'] = $club['type'];
			$content['club_description'] = $club['description'];
			$content['club_admin'] = is_club_admin($content['club_id'], get_user_id($_SESSION['username']));
			_header();
			_nav_bar_top();
			_club($content);
			_footer();
		} catch (Exception $e) {
			$content['error'] = $e->error_list; //->getMessage();
			_header();
			_nav_bar_top();
			_error($content);
			_footer();
		}
	} else {
		# No clube selected
		header("location: home.php?request=Inbox");	
	}
} else {
	header("location: index.php");	
}
?>
