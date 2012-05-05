<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_send_mail.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
# If user is signed in
if ( is_signed_in() ) {
	# Gather parameters and display requested resources
	$content['heading'] = "Mail Sent";
	$content['to'] = trim($_POST['to']);
	$content['from'] = trim($_POST['from']);
	$content['subject'] = trim($_POST['subject']);
	$content['content'] = trim($_POST['content']);
	if ( isset($_POST['club_id']) ) {
		$content['club_id'] = trim($_POST['club_id']);
	}
	
	try {
		# Send mail
		if ( strcmp($content['to'],'all') == 0 ) {
			send_message_club($content); 
		} else {
			send_message($content);
		}
		_header();
		_nav_bar_top();
		_send_mail($content);
		_footer();
	} catch (Exception $e) {
		$content['error'] = $e;
		_header();
		_nav_bar_top();
		_error($content);
		_footer();		
	}
} else {
	# User is not signed in so redirect back to root
	header("location: index.php");
}
?>
