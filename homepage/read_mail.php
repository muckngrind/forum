<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_read_mail.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
# If user is signed in
if ( is_signed_in() ) {
	# Get id for request message
	$id = (int) trim($_GET['id']);
	$content['request'] = trim($_GET['request']);
	if ( isset($_GET['action']) ) {
		$action = trim($_GET['action']);
	}
	$content['heading'] = $content['request'];
	try {
		# Has user requested to delete message?
		if ( strcmp($action, 'delete') == 0 ) {
			delete_message($id);	
			_header();
			_nav_bar_top();
			$content['mail'] = get_mail($content['request']);
			_home($content);
			_footer();
		} else {
			# Else retrieve message
			$content['message'] = get_message($id);
			_header();
			_nav_bar_top();
			_read_mail($content);
			_footer();
		}
	} catch (Exception $e) {
		$content['error'] = $e;
		_header();
		_nav_bar_top();
		_home($content);
		_footer();		
	}
} else {
	# User is not signed in so redirect back to root
	header("location: index.php");
}
?>
