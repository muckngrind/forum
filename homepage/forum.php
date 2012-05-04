<?php
require_once(dirname(__FILE__).'/../config/before.php');
require_once(dirname(__FILE__).'/../views/_forum.html.php');
require_once(dirname(__FILE__).'/../config/after.php');
session_start();
if ( is_signed_in() ) {
	if ( isset($_GET['request']) || isset($_POST['request']) ) {
		try {
			
			if ( isset($_POST['subject'],$_POST['content']) ) {
				$content['forum_id'] = trim($_GET['request']);
				# Submit post and prepare to output content
				$params['forum_id'] = $content['forum_id'];
				$params['subject'] = trim($_POST['subject']);
				$params['content'] = trim($_POST['content']);
				$params['user_id'] = get_user_id($_SESSION['username']);																				
				create_thread($params);
				
			} else {
				$content['forum_id'] = trim($_GET['request']);
			}			
			# Retrieve forum details
			$result = get_forum($content['forum_id']);
			$forum = $result->fetch_assoc();
			$content['heading'] = $forum['club_name'];
			$content['name'] = $forum['forum_name'];
			$content['type'] = $forum['forum_type'];
			$content['description'] = $forum['forum_description'];
			$content['is_open'] = $forum['is_open'];
			if ( isset($_POST['action']) || isset($_GET['action']) ) {
				# Should we output form or button?
				if ( (strcmp($_GET['action'],'add') == 0) || (strcmp($_POST['action'],'add') == 0) ) {
					$content['show_reply_form'] = true;
				} else {
					$content['show_reply_form'] = false;
				}
				if ( (strcmp($_GET['action'],'close') == 0) || (strcmp($_POST['action'],'close') == 0) ) {
					# Close this forum
					close_forum($content['forum_id']);
				}
			}
			
			# Should we show the moderator view?
			if ( is_moderator($content['forum_id'], get_user_id($_SESSION['username'])) ) {
				$content['moderator'] = true;
			}
			_header();
			_nav_bar_top();
			_forum($content);
			_footer();
		} catch (Exception $e) {
			$content['error'] = $e->getMessage();
			_header();
			_nav_bar_top();
			_error($content);
			_footer();
		}
	} else {
		# No forum selected
		header("location: home.php?request=Inbox");	
	}
} else {
	header("location: index.php");	
}


?>
