<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_home.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();

$club=$_POST['search'];

# If user is signed in
if ( is_signed_in() ) {
	# Gather parameters and display requested resources
	$content['request'] = trim($_GET['request']);
	$content['heading'] = $content['request'];
	try {
		$get=mysql_query("SELECT name from clubs where name = '$club'");
		}
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
