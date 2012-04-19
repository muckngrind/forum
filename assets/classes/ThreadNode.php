<?php
# ThreadNode class for threads
# This file contains functions for loading, constructing and displaying thread messages

class ThreadNode {
	# ThreadNode contains instance variables for thread post
	public $id; # self
	public $forum_id;
	public $parent_id;
	public $subject;
	public $content;
	public $created_at; # Date/time of post
	public $user;
	public $has_children; # Boolean to flag if contains child node(s)
	public $child_list; # Array of children nodes
	public $depth; # Used to determine level of indenting we will display
	
	public function __construct($post_id, $post_forum_id, $post_parent_id, $post_subject, 
															$post_content, $post_created_at, $post_user, $post_has_children, $post_depth) {
		
		# Initialize instance variables
		$this->$id = $post_id;
		$this->$forum_id = $post_forum_id;
		$this->$parent_id = $post_parent_id;
		$this->$subject = $post_subject;
		$this->$content = $post_content;
		$this->$created_at = $post_created_at;
		$this->$user = $post_user;
		$this->$has_children = $post_has_children;
		$this->$depth = $post_depth;
		$this->$child_list = array();
		
		# Look for children nodes only if they exist
		if ( $this->$has_children ) {
			# Select $this->$id children from db	
			# Assign result
			# Get row count
			$r_count = $result->num_rows;
						
			# Populate children nodes
			for ( $i = 0; $i < $r_count; $i++ ) {
				$row = $result->fetch_assoc();
				$this->$child_list[$i] = new ThreadNode($row['id'], $row['subject'], $row['content'], $row['created_at'], $row['has_children'], $depth+1);
			}
		}
	} # /__construct
	
	# Display thread.  We will use css/js to collapse or expand
	function show_thread_row() {
		
		# Indent to current depth
		for ( $i = 0; $i < $this->$depth; $i++ ) {
			echo "&nbsp;&nbsp;";
		}
		
		if ( $this->$has_children ) {
			echo "<a href=\"#\" id=\"collapse\">-</a>\n";
		}
		
		echo "<strong>$this->$subject</strong> | Author: <strong>$this->$user</strong> | Posted: <strong>$this->$created_on</strong><br />\n";
		echo "$this->$content\n";
		
	} # /show_thread
} # /ThreadNode

?>