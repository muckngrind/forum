<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_profile.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
session_start();
if ( is_signed_in() ) {
	if ( isset($_GET['request']) ) {
		try {
			$content['heading'] = "Club Profile";
			$content['club_id'] = trim($_GET['request']);
			# Retrieve club details
			$club = get_club_info($content['club_id']);
			$content['club_name'] = $club['name'];
			$content['club_type'] = $club['type'];
			$content['club_description'] = $club['description'];
			_header();
			_nav_bar_top();
			_profile($content);
			_footer();
		} catch (Exception $e) {
			$content['error'];
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
