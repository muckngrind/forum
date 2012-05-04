<?php
#	Ryan Lewis, CPSC 431, CSUF
#	Professor Shawn Wang
#	Database connection and query functions

require_once('config.php');

	##################################
	#         User Functions         #
	##################################
	
	# Create new database object
	function db_conn() {
		$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
		if ( !$conn ) {
			throw new Exception("Could not connect to database server. Error No: ", mysqli_connect_errno);
		} else {
			return $conn;
		}
	}
	
	# Create new user
	function new_user($username, $userFullName, $password) {
		$conn = db_conn();
		$result = $conn->query("insert into users (username, password_digest, full_name) values ('".$username."', sha1('".$password."'), '".$userFullName."')");
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not register you at this time, please try again later.");
		}
		$conn->close();
		return true;
	}
	
	# Check to see if user name is available
	function is_user_available($username) {
		$conn = db_conn();
		$result = $conn->query("select username from users where username='".$username."'");
		if ( !$result ) {
			$conn->close();
			throw new Exception("Error while checking user name availability");	
		}
		
		# If name is available, num_rows should equal zero
		if ( $result->num_rows > 0 ) {
			return false;
		} else {
			return true;
		}
	}

	# Sign user in
	function sign_in($username, $password) {
		$conn = db_conn();
		$result = $conn->query("select username, banned from users where username='".$username."' and password_digest='".sha1($password)."'");
		if ( !$result ) {
			$conn->close();
			throw new Exception("Error while attempting to log in.  Please try again later.");	
		}
		
		# Evaluate result
		if ( $result->num_rows > 0 ) {
			$row = $result->fetch_assoc();
			if ( $row['banned'] == true) {
				throw new Exception("Your account has been closed.");	
			} else {
				return true;
			}
		} else {
			throw new Exception("User name or password mismatch.");
		}		
	}

	# Is user logged in?
	function is_signed_in() {
		if ( $_SESSION['username'] ) {
			return true;
		} else {
			return false;
		}
	}
	
	# User forgot password, reset it for them
	function reset_password($username) {
		$conn = db_conn();
		$temp = get_temp_password();
		$result = $conn->query("update users set password='".$temp."' where username='".$username."'");
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not reset password.  Please try again later.");	
		} else {
			return true;
		}
	}
	
	# Get user id
	function get_user_id($username) {
		$conn = db_conn();
		$query = "select id from users where username='$username'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not identify user.");
		} else {
			$row = $result->fetch_assoc();
			return $row['id'];
		}
	}
	
	# Get user name
	function get_user_name($username) {
		$conn = db_conn();
		$query = "select full_name from users where username='$username'";
		$result = $conn->query($query);
		if ( !$result ) {
				$conn->close();
				throw new Exception("Could not identify user.");
		} else {
			$row = $result->fetch_assoc();
			return $row['full_name'];
		}
	}
	
	# Select a new random temporary password
	function get_temp_password() {
		$dictionary = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()_+";
		str_shuffle($dictionary);
		return substr(0,8);
	}
	
	# Sterilize sign up / in credentials
	function steril_credentials($username, $password, $full_name = "empty") {
		$message = "";
		# Required patterns for matching
		$pattern_username = "/^[a-zA-Z0-9._-]{5,25}$/";
		
		# Match patterns
		if (!preg_match($pattern_username, $username)) {
			$message = "Invalid user name: May contain a-zA-Z0-9._- and must be between 5 and 25 characters length.";
		}
	}
	
	# Check to see if this user is an administrator of some kind
	function is_an_admin() {
		$conn = db_conn();
		$username = $_SESSION['username'];
		$query = "select admin from users where username='$username'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve admin credentials.");
		} else {
			$row = $result->fetch_assoc();
			if ( $row['admin'] == true ) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	# Get list of clubs for which user is a member
	function user_clubs() {
		$conn = db_conn();
		$username = $_SESSION['username'];
		$query = "select id, name from clubs a inner join clubs_users b on a.id = b.club_id where b.user_id = (select users.id from users where users.username = '$username');";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve club listing.");
		} else {
			$conn->close();
			if ( $result->num_rows == 0 ) {
				return false;
			} else {
				return $result;
			}
		}
	}
	
	##################################
	#     Mail Message Functions     #
	##################################
	
	# Request email results from db
	function get_mail($mailbox) {
		
		# Select requested mailbox
		switch ($mailbox) {
			case 'Inbox':
				$query = "select a.id, a.sender_id, a.subject, a.created_at, a.recipient_read, b.username as sender_name from messages a inner join users b on a.sender_id = b.id where recipient_id=(select id from users where username='".$_SESSION['username']."');";
				break;
			case 'Sent':
				$query = "select a.id, a.recipient_id, a.subject, a.created_at, a.recipient_read, b.username as recipient_name from messages where sender_id=(select id from users where username='".$_SESSION['username']."') and sender_sent=1;";
				break;
			case 'Trash':
				$query = "select id, recipient_id, sender_id, subject, created_at, recipient_read from messages where sender_id=(select id from users where username='".$_SESSION['username']."') and sender_deleted=1;";
				break;
		}
		
		# Query database for mail
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Problem retrieving mail. Please try again later.");	
		}
		
		if ( $result->num_rows < 1 ) {
			$conn->close();
			return false;
		} else {
			$conn->close();
			return $result;
		}
	}

	# Send mail
	function send_message($message) {
		# Gather user id's
		$conn = db_conn();
		$query = "select id from users where username='".$message['from']."';";
		$from_result = $conn->query($query);
		$row = $from_result->fetch_assoc();
		$from = $row['id'];
		$query = "select id from users where username='".$message['to']."';";
		$to_result = $conn->query($query);
		$row = $to_result->fetch_assoc();
		$to = $row['id'];
		
		$query = "insert into messages (sender_id, recipient_id, subject, content, sender_sent) values ('".$from."', '".$to."', '".$message['subject']."', '".$message['content']."', 1);";

		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Problem sending mail. Please try again later.");	
		}
		
		if ( $result->affected_rows < 1 ) {
			$conn->close();
			return false;
		} else {
			$conn->close();
			return true;
		}
	}
	
	# Retrieve message
	function get_message($id) {
		# Request message from db
		$query = "select id, sender_id, recipient_id, subject, content, created_at from messages where id=$id";
		$conn = db_conn();
		$result = $conn->query($query);
		
		if ( !$result ) {
			$conn->close();
			throw new Exception("Problem retrieving message. Please try again later.");	
		}
		if ( $result->num_rows < 1 ) {
			$conn->close();
			return false;
		} else {
			$conn->close();
			return $result;
		}
	}
	
	# Delete message from db
	function delete_message($id) {
		$query = "delete from messages where id=$id";
		$conn = db_conn();
		$result = $conn->query($query);
		
		if ( !$result ) {
			$conn-close();
			throw new Exeception("Problem deleting message.  Please try again later.");
		}
		
		if ( $result->affected_rows > 0 ) {
			return true;
		} else {
			return false;
		}		
	}
	
	
	##################################
	#    Administrator Functions     #
	##################################

	function is_admin() {
		$conn = db_conn();
		$username = $_SESSION['username'];
		$query = "select admin from users where username='$username'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve admin credentials.");
		} else {
			$row = $result->fetch_assoc();
			if ( $row['admin'] == true ) {
				return true;
			} else {
				return false;
			}
		}		
	}
	
	function create_club($params) {
		# Get id for administrator
		$id = get_user_id($params['club_administrator']);
		$query = "insert into clubs values (null, '".$params['club_name']."', '".$params['club_description']."', '".$params['club_type']."', '".$id."');";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not create a new club at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}
	
	function appoint_club_administrator($params) {
		# Get id for administrator
		$id = get_user_id($params['club_administrator']);
		$query = "update clubs set admin='$id' where name='".$params['club_name']."'";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not update club admin at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}
	
	function ban_user($params) {
		$query = "update users set banned='1' where username='".$params['username']."'";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not ban user at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}	
	
	function edit_club_profile($params) {
		$query = "update clubs set description='".$params['club_description']."', type='".$params['club_type']."' where name='".$params['club_name']."';";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not update the club profile at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}	

	# Get club id
	function get_club_id($name) {
		$conn = db_conn();
		$query = "select id from clubs where name='".$name."'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not identify club.");
		} else {
			$conn->close();
			$row = $result->fetch_assoc();
			return $row['id'];
		}
	}

	function get_club_list($username) {
		# Get user id to search for clubs for which user is admin
		$id = get_user_id($username);
		echo "$id";
		$conn = db_conn();
		$query = "select id, name from clubs where admin='$id'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We retrieve club list at this time. Please try again later.");
		}
		$conn->close();
		if ( $result->num_rows > 0 ) {
			return $result;
		} else {
			return false;
		}
	}
	
	function add_forum($params) {
		$query = "insert into forums (club_id, name, description) values ('".$params['club_id']."', '".$params['forum_name']."', '".$params['forum_description']."')";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not create a new forum at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}	
	

	##################################
	#        Helper Functions        #
	##################################
	
	# Retrive club info
	function get_club_info($id) {
		$conn = db_conn();
		$query = "select * from clubs where id=$id";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve club info.");
		} else {
			$conn->close();
			$row = $result->fetch_assoc();
			return $row;
		}
	}
	
	# Is user a club member?
	function is_club_member($username, $id) {
		$conn = db_conn();
		$query = "select user_id from clubs_users where user_id=(select id from users where username='$username') and club_id=$id";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could determine if user is a member of club.");
		} else {
			$conn->close();
			if ( $result->num_rows != 1 ) {
				return false;
			} else {
				return true;
			}
		}		
	}
	
	# Is user a forum moderator?
	function is_moderator($forum_id, $user_id) {
		$conn = db_conn();
		$query = "select * from forums_moderators where forum_id='".$forum_id."' and user_id='".$user_id."'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could determine if user is a forum moderator.");
		} else {
			$conn->close();
			if ( $result->num_rows != 1 ) {
				return false;
			} else {
				return true;
			}
		}		
	}	
	
	# Is user a club administrator?
	function is_club_admin($club_id, $user_id) {
		$conn = db_conn();
		$query = "select a.admin, b.id from clubs a inner join users b on a.admin=b.id where b.id=$user_id and a.id=$club_id";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could determine if user is a club administrator.");
		} else {
			$conn->close();
			if ( $result->num_rows != 1 ) {
				return false;
			} else {
				return true;
			}
		}		
	}		
	
	# Get a club's forums
	function get_club_forums($id) {
		$conn = db_conn();
		$query = "select id, name, description, type from forums where club_id = $id";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve forum info.");
		} else {
			$conn->close();
			if ( $result->num_rows == 0 )
				return false;
			else
				return $result;
		}		
	}

# Get a forum's info
	function get_forum($id) {
		$conn = db_conn();
		$query = "select a.name as club_name, b.name as forum_name, b.description as forum_description, b.type as forum_type, b.is_open as is_open from clubs a inner join forums b on a.id=b.club_id where b.id=$id";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve forum info.");
		} else {
			$conn->close();
			if ( $result->num_rows == 0 )
				return false;
			else
				return $result;
		}		
	}	
	
# Get threads
	function get_threads($forum_id) {
		$conn = db_conn();
		$query = "select a.id, a.subject, a.content, a.created_at, b.username from threads a inner join users b on a.user_id = b.id where a.forum_id = $forum_id order by a.created_at desc";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not retrieve thread info.");
		} else {
			$conn->close();
			if ( $result->num_rows == 0 )
				return false;
			else
				return $result;
		}		
	}

# Create threads
	function create_thread($params) {
		$conn = db_conn();
		$query = "insert into threads (forum_id, subject, content, user_id) values ('".$params['forum_id']."', '".$params['subject']."', '".$params['content']."', '".$params['user_id']."')";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Error: Could not save your thread at this time.");
		} else {
			return true;
		}
	}

# Close forum
	function close_forum($forum_id) {
		$conn = db_conn();
		$query = "update forums set is_open='0' where id='$forum_id'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not close forum at this time.");
		} else {
			$conn->close();
			if ( $result->affected_rows != 0 )
				return false;
			else
				return true;
		}				
	}
	
	function assign_forum_moderator($params) {
		# Get id for moderator
		$user_id = get_user_id($params['forum_moderator']);
		$forum_id = get_forum_id($params['forum_name']);
		$query = "insert into forums_moderators (forum_id, user_id) values (forum_id='$forum_id', user_id='$user_id')";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not update club admin at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}	
	
	# Get forum id
	function get_forum_id($name) {
		$conn = db_conn();
		$query = "select id from forums where name='".$name."'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not identify club.");
		} else {
			$conn->close();
			$row = $result->fetch_assoc();
			return $row['id'];
		}
	}	
?>
