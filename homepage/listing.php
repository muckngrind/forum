<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_listing.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
$content['heading'] = "Some club's forums";
$content['type'] = "club";
$content['lookup'] = "some_club_id or forum_id";
_header();
_nav_bar_top();
_listing($content);
_footer();
?>
