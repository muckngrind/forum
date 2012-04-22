<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _admin($content) {
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
               		<h2>Administrative Panel</h2>
                  <p><?php echo $content['message']; ?></p>
                  <hr>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
                <h3>Administrator Tasks</h3>
                <div class="well">
                  <h4>Create new clubs</h4>
                  <hr />
                  <form name="create_club_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="create_club" />
                    <label class="admin-label">Official Club Name</label>
                    <input type="text" class="span5" placeholder="Name goes here" name="club_name" id="clubName"><br/>
                    <label class="admin-label">Club Description</label>
                    <textarea class="span5" name="club_description" id="clubDescription"></textarea><br/>
                    <label class="admin-label">Club Administrator</label>
                    <input type="text" class="span5" placeholder="Administratror" name="club_administrator" id="clubAdministator"><br/>
                    <label class="admin-label">Club Type</label>
                    <input type="radio" name="club_type" value="public"><span class="help-inline">Public</span> &nbsp; 
                    <input type="radio" name="club_type" value="private"><span class="help-inline">Private</span> &nbsp;
                    <input type="radio" name="club_type" value="closed"><span class="help-inline">Closed</span><br/><br/>
                    <button type="submit" class="btn btn-info">Create Club</button>
                  </form>  
                </div>
                <div class="well">
                  <h4>Appoint club administrator</h4>
                  <hr />
                  <form name="administer_club_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="appoint_club_administrator" />
                    <label class="admin-label">Club Name</label>
                    <input type="text" class="span5" placeholder="Enter name of club" name="club_name" id="clubName"><br/>
                    <label class="admin-label">Club Administrator</label>
                    <input type="text" class="span5" placeholder="Administratror" name="club_administrator" id="clubAdministator"><br/><br/>
                    <button type="submit" class="btn btn-info">Update Club Administrator</button>
                  </form>                  
                </div>
                <div class="well">
                  <h4>Ban user</h4>
                  <hr />
                  <form name="remove_user_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="ban_user" />
                    <label class="admin-label">User name</label>
                    <input type="text" class="span5" placeholder="Enter username" name="username" id="username"><br/><br/>
                    <button type="submit" class="btn btn-info">Ban User</button>
                  </form>                     
                </div>
                <h3>Club administrators</h3>
                <div class="well">
                 <h4>Edit club profile</h4>
                 <hr />
                  <form name="update_club_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="edit_club_profile" />
                    <label class="admin-label">Name of club you wish to edit.</label>
                    <input type="text" class="span5" placeholder="Enter club name" name="club_name" id="clubName"><hr /><h5>Enter new information below:</h5>
                    <label class="admin-label">Club Description</label>
                    <textarea class="span5" name="club_description" id="clubDescription"></textarea><br/>
                    <label class="admin-label">Club Type</label>
                    <input type="radio" name="club_type" value="public"><span class="help-inline">Public</span> &nbsp; 
                    <input type="radio" name="club_type" value="private"><span class="help-inline">Private</span> &nbsp;
                    <input type="radio" name="club_type" value="closed"><span class="help-inline">Closed</span><br/><br/>
                    <button type="submit" class="btn btn-info">Edit Club Profile</button>
                  </form>                      
                </div>
                <div class="well">
                  <h4>Create/close forums</h4>
                  <hr />
                  <h5>Add forum:</h5>
                  <form name="add_forum_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="add_forum" />
                    <label class="admin-label">Select club to add forum:</label>
                    <select name="club_name">
  										<?php
                      	$clubs = get_club_list($_SESSION['username']);
												if ( $clubs ) {
													echo "here";
													while ( $row = $clubs->fetch_assoc() ) {
														echo "<option>".$row['name']."</option>";
													}
												} else {
													echo "<option>Error occurred</option>";
												}
											?>
										</select>
                    <label class="admin-label">Forum Name</label>
                    <input type="text" class="span5" placeholder="Enter name of forum" name="forum_name" id="forumName"><br/>
                    <label class="admin-label">Forum Description</label>
                    <textarea class="span5" name="forum_description" id="forumDescription"></textarea>                    
										<br/><br/>
                    <button type="submit" class="btn btn-info">Create new forum</button>
                  </form>
                  <hr />
                  <h5>Close forum:</h5>
                   <form name="close_forum_frm" action="admin.php" method="post">
                  	<input type="hidden" name="form_type" value="close_forum" />
                    <label class="admin-label">Name of club you wish to edit.</label>
                    <input type="text" class="span5" placeholder="Enter club name" name="club_name" id="clubName">
                    <label class="admin-label">Select forum to close:</label>
                    <select name="club_name">
  										<?php
                      	$clubs = get_club_list($_SESSION['username']);
												if ( $clubs ) {
													echo "here";
													while ( $row = $clubs->fetch_assoc() ) {
														echo "<option>".$row['name']."</option>";
													}
												} else {
													echo "<option>Error occurred</option>";
												}
											?>
										</select>
										<br/><br/>
                    <button type="submit" class="btn btn-info">Create new forum</button>
                  </form>                           
                </div>
                <div class="well">
                  <h4>Assign forum moderators</h4>
                </div>
                <div class="well">
                  <h4>Approve/remove club members</h4>
                </div>
                <div class="well">
                  <h4>Send messages to all club members</h4>
                </div>
               	<h3>Forum moderators</h3>
                <div class="well">
                  <h4>Close threads (via forum_view.php)</h4>
                </div>
                <div class="well">
                  <h4>Remove posts (via forum_view.php)</h4>
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
