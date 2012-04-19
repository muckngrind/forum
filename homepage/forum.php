<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_forum.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
$content['heading'] = "Flower Club";
$content['type'] = "public";
$content['lookup'] = "some_club_id or forum_id";
$content['forum'] = "How to plant perennials";
$conent['description'] = "This forum is dedicated to all things related to perennial flowers.";
_header();
_nav_bar_top();
_forum($content);
_footer();
?>
