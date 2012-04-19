<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_user.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
$content['heading'] = "User Preferences";
$content['type'] = "user";
$content['username'] = "muckngrind";
$content['full_name'] = "Ryan Lewis";
_header();
_nav_bar_top();
_user($content);
_footer();
?>
