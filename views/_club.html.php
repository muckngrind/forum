<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _club($content) {
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
								if ( $content['club_admin'] == true ) {
									if ( isset($content['message']) ) {
										echo "<div class=\"alert alert-success\">".$content['message']."</div>";
									}?>
                <h4><?php echo $content['club_name']; ?> Forums</h4>
                <div class="well">
                <?php
								$result = $content['forums'];
								if ( $result ) {
									while ( $row = $result->fetch_assoc() ) {
										echo "<li><a href=\"forum.php?request=".$row['id']."\"><strong>".$row['name']."</strong> - ".$row['description']."</a></li>";
									}
								} else {
									echo "No active forums are available at this time.";
								}
								?>
                </div>                  
									<h3>Club Administrator Tasks</h3>
                <div class="alert">
                 <h4>Edit club profile</h4>
                 <hr />
                  <form name="update_club_frm" action="club.php" method="post">
                  	<input type="hidden" name="form_type" value="edit_club_profile" />
                    <input type="hidden" name="request" value="<?php echo $content['club_id']; ?>" />
                    <input type="hidden" name="club_name" value="<?php echo $content['club_name'];?>" />
<h5>Enter new information below:</h5>
                    <label class="admin-label">Club Description</label>
                    <textarea class="span5" name="club_description" id="clubDescription"></textarea><br/>
                    <label class="admin-label">Club Type</label>
                    <input type="radio" name="club_type" value="public"><span class="help-inline">Public</span> &nbsp; 
                    <input type="radio" name="club_type" value="private"><span class="help-inline">Private</span> &nbsp;
                    <input type="radio" name="club_type" value="closed"><span class="help-inline">Closed</span><br/><br/>
                    <button type="submit" class="btn btn-info">Edit Club Profile</button>
                  </form>                      
                </div>
                <div class="alert">
                  <h4>Create forums</h4>
                  <hr />
                  <h5>Add forum:</h5>
                  <form name="add_forum_frm" action="club.php" method="post">
                  	<input type="hidden" name="form_type" value="add_forum" />
										<input type="hidden" name="request" value="<?php echo $content['club_id']; ?>" />                <input type="hidden" name="club_name" value="<?php echo $content['club_name']; ?>" />
                    <label class="admin-label">Forum Name</label>
                    <input type="text" class="span5" placeholder="Enter name of forum" name="forum_name" id="forumName"><br/>
                    <label class="admin-label">Forum Description</label>
                    <textarea class="span5" name="forum_description" id="forumDescription"></textarea>                    
										<br/><br/>
                    <button type="submit" class="btn btn-info">Create new forum</button>
                  </form>
                </div>
                <div class="alert">
                  <h4>Assign forum moderator</h4>
                  <hr />
                  <form name="moderator_frm" action="club.php" method="post">
                  	<input type="hidden" name="form_type" value="assign_forum_moderator" />
                    <label class="admin-label">Forum Name</label>
                    <input type="text" class="span5" placeholder="Enter name of forum" name="forum_name" id="forumName"><br/>
                    <label class="admin-label">Forum Moderator</label>
                    <input type="text" class="span5" placeholder="Moderator" name="forum_moderator" id="forumModerator"><br/><br/>
                    <button type="submit" class="btn btn-info">Update Forum Moderator</button>
                  </form>                         
                </div>
                <div class="alert">
                  <h4>Approve/remove club members</h4>
                </div>
                <div class="alert">
                  <h4>Send messages to all club members</h4>
                </div>                
                
                  <?php
								}
                ?>

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