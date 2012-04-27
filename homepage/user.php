<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_user.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
session_start();
$content['heading'] = "User Preferences";
$content['type'] = "user";
$content['username'] = $_SESSION['username'];
$content['full_name'] = get_user_name($_SESSION['username']);
_header();
_nav_bar_top();
_user($content);
_footer();
?>
