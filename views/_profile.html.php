<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _profile($content) {
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
                <div class="span4">
                  <ul class="thumbnails">
                    <li class="span3">
                      <div class="thumbnail">
                        <img src="http://placehold.it/260x180" alt="">
                      </div>
                    </li>
                  </ul>
                </div><!--/span-->
                <div class="span5">
                  <div class="well-small">
                    <h3>Club Name: <?php echo $content['club_name']; ?></h3>
                    <h4>Type: <?php echo $content['club_type']; ?></h4>
                    <p><strong>Description:</strong> <?php echo $content['club_description']; ?></p>
                  </div>
                </div><!--/span-->
                <!--/content-pane-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
							<?php
                if ( ( strcmp($content['club_type'],"private") == 0 ) &&
                    ( !is_club_member($_SESSION['username'], $content['club_id']) ) ) {
                  ?>
                	<h4>Club Membership</h4>
                  <p>You are currently not a member of this club.</p>
                  <p>
									<form class="well form-inline" id="join_a_club" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <strong>Interested in becoming a member?</strong><br/>
                    <input type="text" placeholder="Subject: Membership" name="subject">
                    <input type="hidden" name="sender" value="sender_id">
                    <input type="hidden" name="recipient" value="club_moderator">
                    <input type="text" name="message" placeholder="Message: I would like to join!">
                    <button type="submit" class="btn btn-info">Send membership request</button>
                  </form>
                  </p>                      
									<?php
                }
                ?>
                <h4><?php echo $content['club_name']; ?> Forums</h4>
                <div class="well">
                <?php
								$result = get_club_forums($content['club_id']);
								if ( $result ) {
									while ( $row = $result->fetch_assoc() ) {
										echo "<li><strong>".$row['name']."</strong> - ".$row['description']."</li>";
									}
								} else {
									echo "No active forums are available at this time.";
								}
								?>
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