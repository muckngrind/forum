<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_home.html.php');
require_once(dirname(__FILE__).'/../config/after.php');

session_start();
$content['heading'] = "Inbox";
$content['type'] = "inbox";
_header();
_nav_bar_top();
_home($content);
_footer();
?>
