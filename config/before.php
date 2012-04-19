<?php
#	Ryan Lewis, CPSC 431, CSUF
#	Professor Shawn Wang
#	Database connection and query functions

require_once('config.php');

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
	function is_logged_in() {
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

#Should auto include all required files but I have not gotten it to work correctly yet
#echo $conn->host_info . " from before.php<br/>";
#$test_val = "TEST";
# Require all of our classes
#foreach ($cnf['requires'] as $glob_me)
#  foreach (glob($glob_me) as $path)
#    require_once($path);
?>
