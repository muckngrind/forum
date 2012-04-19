<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_profile.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
$content['heading'] = "Inbox";
$content['type'] = "inbox";
$content['club_name'] = "Flower Club";
$content['club_description'] = "Flowers smell nice.  We like to plant flowers.";
_header();
_nav_bar_top();
_profile($content);
_footer();
?>
