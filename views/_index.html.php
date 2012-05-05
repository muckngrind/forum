<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _index($content="") {
?>
    <!--container-->
    <div class="container-fluid">
      <div class="row-fluid">

        <div class="span12">
          <div class="hero-unit">
            <h1>Welcome.  Join the discussion!</h1>
            <p>Discussion is a simple web forum that allows users to create clubs, forums, and threads in order to communicate and share ideas.  This site also contains a simple internal messaging system for intra-user communication.  Enjoy!</p>
					</div>
          <div class="alert">
          	<h2>Account Credentials for Testing</h2>
            <ul>
            	<li>Administrator:</li>
              <ul>
              	<li>User name - webmaster</li>
                <li>Password - testing</li>
              </ul>
            	<li>Club Administrator:</li>
              <ul>
              	<li>User name - clubsandwich</li>
                <li>Password - testing</li>
              </ul>
            	<li>Forum Moderator:</li>
              <ul>
              	<li>User name - modulus</li>
                <li>Password - testing</li>
              </ul>              
            	<li>Registered User:</li>
              <ul>
              	<li>User name - everyman</li>
                <li>Password - testing</li>
              </ul>                            
            </ul>
          </div>
          
          <div class="row-fluid">
          	<div class="span6">
             	<h2>Want to Join? <strong>Sign up</strong></h2>
              <p>
                <form class="well form-inline" id="user_sign_up" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="text" class="input-small" placeholder="Full Name" name="full_name">
                  <input type="text" class="input-small" placeholder="User Name" name="username">
                  <input type="password" class="input-small" placeholder="Password" name="password">
                  <button type="submit" class="btn btn-success">Create Account</button>
                </form>
              </p>
            </div><!--/span-->
          	<div class="span6">            
              <h2>Existing Member? <strong>Sign in</strong></h2>            
              <p>
                <form class="well form-inline" id="user_sign_in" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="text" class="input-small" placeholder="User Name" name="username">
                  <input type="password" class="input-small" placeholder="Password" name="password">
                  <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
              </p>
            </div><!--/span-->
        	</div><!--/row-->   

          <div class="row-fluid">
          	<div class="span6">
            	<h3>Not ready to sign up yet?</h3> 
              <div class="well">
                Check out some of discussions in our public clubs.  <a href="directory.php?request=Directory" class="btn btn-info">Public Clubs</a>
              </div>            
            </div><!--/span-->
        	</div><!--/row-->   
          
        </div><!--/span-->
      </div><!--/row-->

<?php
	}
?>
