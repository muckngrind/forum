<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _about($content) {
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
									<h3>CPSC 431 - Final Project</h3>
                  <h4>Spring 2012</h4>
                  <h5>Contributors: Tina Nguy & Ryan Lewis</h5>
                  <p>&copy;This is a project created by Dr. Shawn X. Wang together with students in the Databases and Applications class in Spring 2012 at California State University, Fullerton.
                  <h5>Functional Requirements</h5>
                  <ol>
                  	<li>Administrator</li>
										<ul>
                    	<li>Create new clubs</li>
											<li>Appoint club administrators</li>
											<li>Ban users</li>
                    </ul>
										<li>Club administrators</li>
										<ul>
                   		<li>Edit club profile</li>
											<li>Create/close forums</li>
											<li>Assign forum moderators</li>
											<li>Approve/remove club members</li>
											<li>Send messages to all club members</li>
										</ul>
                    <li>Forum moderators</li>
										<ul>
                    	<li>Close threads</li>
                      <li>Remove posts</li>
                     </ul>
                    <li>Club members</li>
                    <ul>  
                      <li>Create threads</li>
                      <li>Invite users to join a club</li>
                    </ul>
                    <li>Registered users</li>
                    <ul>
                      <li>Login with a registered username and password</li>
                      <li>Change password</li>
                      <li>Post to the forums</li>
                      <li>Send internal messages</li>
                      <li>Join a club</li>
                    </ul>
                    <li>The public</li>
                   	<ul>
                    	<li>View clubs and forums</li>
                      <li>Register to become a user</li>
                    </ul>
                  </p>
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