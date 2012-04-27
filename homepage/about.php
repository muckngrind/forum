<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_about.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
session_start();
$content['heading'] = "About";
_header();
_nav_bar_top();
_about($content);
_footer();
?>
