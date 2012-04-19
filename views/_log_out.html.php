<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _log_out($content) {
?>
    <!--container-->
    <div class="container-fluid">
      <div class="row-fluid">
				<div class="span12">
        	<div class="row-fluid">  
					<?php
						if ( !empty($content['old_user']) ) {
							if ( $content['destroy_session_result'] ) {
								# User was logged in and is now logged out
								?>
                	<h2>You have signed out successfully</h2>
                  <h3><a href="./index.php">Sign in again</a></h3>
                <?php
							} else {
								# Could not log out
								?>
                	<h2>There was a problem signing you out</h2>
                  <h3><a href="./index.php">Return to home</a></h3>
                <?php
							}
						} else {
							# Navigated to this page without first logging in
							?>
								<h2>You were not signed in.</h2>
								<h3><a href="./index.php">Sign in now</a></h3>
							<?php							
						}
					?>
          </div><!--/row-->
        </div><!--/span12-->
      </div><!--/row-->
<?php
	}
?>
