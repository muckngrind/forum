<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_directory.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
# If user is signed in

	# Gather parameters and display requested resources
	$content['request'] = trim($_GET['request']);
	$content['heading'] = $content['request'];
	try {
		_header();
		_nav_bar_top();
		_directory($content);
		_footer();
	} catch (Exception $e) {
		$content['error'] = $e;
		_header();
		_nav_bar_top();
		_error($content);
		_footer();		
	}
?>
