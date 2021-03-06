<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_home.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
# If user is signed in
#$club=$_POST['request'];
if ( is_signed_in() ) {
	# Gather parameters and display requested resources
	$content['request'] = trim($_GET['request']);
	$content['heading'] = $content['request'];
	try {
		echo $content;
		# Retrieve email for requested mailbox or compose form
		#if ( !strcmp($content['request'], "Compose") == 0 ) {
		#	$content['mail'] = get_mail($content['request']);
		#}
		_header();
		_nav_bar_top();
		_home($content);
		_footer();
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
