<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_log_out.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
$content['heading'] = "Sign Out";
$content['old_user'] = $_SESSION['username'];

# Test if user *was* logged in
unset($_SESSION['username']);
$content['destroy_session_result'] = session_destroy();
_header();
_nav_bar_top();
_log_out($content);
_footer();
?>