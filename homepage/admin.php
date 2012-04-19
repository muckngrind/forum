<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_admin.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
$content['heading'] = "Administrative Panel";
$content['type'] = "get_user_rights";
_header();
_nav_bar_top();
_admin($content);
_footer();
?>
