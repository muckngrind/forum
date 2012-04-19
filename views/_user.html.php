<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _user($content) {
?>
    <!--container-->
    <div class="container-fluid">
      <div class="row-fluid">
				<div class="span12">
        	<div class="row-fluid">  
						<?php _nav_left(); ?>
            <!--/home-content-->
            <div class="span9">
            	<div class="row-fluid">
              	<!--content-description-->
               		<h2><?php echo $content['heading']; ?></h2>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
                  <div class="well">
                    <h3><?php echo $content['username']; ?></h3>
                    <p><?php echo $content['full_name']; ?></p>
                    <hr />
                    <h4>Manage Password</h4>
                    <form name="reset_password" id="resetPassword" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <input type="password" class="span2"><span class="help-inline admin-label">old password</span><br/>
                      <input type="password" class="span2"><span class="help-inline admin-label">new password</span><br/>
                      <input type="password" class="span2"><span class="help-inline admin-label">confirm password</span><br/>
                      <button type="submit" class="btn btn-warning">Change Password</button>
                    </form>
                    <hr />
                    <h4>Manage Club Membership</h4>
                  </div>               
                  <!--/content-pane-->
              </div><!--/row-->
            </div><!--/span-->
            <!--/home-content-->
          </div><!--/row-->
        </div><!--/span12-->
      </div><!--/row-->
<?php
	}
?>