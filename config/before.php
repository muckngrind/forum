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
		$result = $conn->query("select username from users where username='".$username."' and password_digest='".sha1($password)."'");
		if ( !$result ) {
			$conn->close();
			throw new Exception("Error while attempting to log in.  Please try again later.");	
		}
		
		# If name is available, num_rows should equal zero
		if ( $result->num_rows > 0 ) {
			return true;
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
			return true;
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
	
	##################################
	#     Mail Message Functions     #
	##################################
	
	# Request email results from db
	function get_mail($mailbox) {
		
		# Select requested mailbox
		switch ($mailbox) {
			case 'Inbox':
				$query = "select id, sender_id, subject, created_at, recipient_read from messages where recipient_id=(select id from users where username='".$_SESSION['username']."');";
				break;
			case 'Sent':
				$query = "select id, recipient_id, subject, created_at, recipient_read from messages where sender_id=(select id from users where username='".$_SESSION['username']."') and sender_sent=1;";
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
	
	# Check to see if user is admin
	function is_admin() {
		
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
		$query = "select id from clubs where name='$name'";
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("Could not identify club.");
		} else {
			$conn->close();
			return true;
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
		$query = "insert into forums values (null, '".$params['club_id']."', '".$params['forum_name']."', '".$params['forum_description']."', 0)";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not create a new forum at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}	
	
	function close_forum($params) {
		$query = "update forums set type=1 where name='".$params['forum_name']."'";
		$conn = db_conn();
		$result = $conn->query($query);
		if ( !$result ) {
			$conn->close();
			throw new Exception("We can not close forum at this time. Please try again later.");
		}
		$conn->close();
		return true;
	}		
	
	
#Should auto include all required files but I have not gotten it to work correctly yet
#echo $conn->host_info . " from before.php<br/>";
#$test_val = "TEST";
# Require all of our classes
#foreach ($cnf['requires'] as $glob_me)
#  foreach (glob($glob_me) as $path)
#    require_once($path);
?>
