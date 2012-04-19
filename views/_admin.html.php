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
                  <hr>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
                <h3>Administrator Tasks</h3>
                <div class="well">
                  <h4>Create new clubs</h4>
                  <hr>
                  <form>
                    <label class="admin-label">Official Club Name</label>
                    <input type="text" class="span5" placeholder="Name goes here" name="club_name" id="clubName"><br/>
                    <label class="admin-label">Club Description</label>
                    <textarea class="span5" name="club_description" id="clubDescription"></textarea><br/>
                    <label class="admin-label">Club Administrator</label>
                    <input type="text" class="span5" placeholder="Administratror" name="club_administrator" id="clubAdministator"><br/>
                    <label class="admin-label">Club Type</label>
                    <input type="radio" name="clubType" value="public"><span class="help-inline">Public</span> &nbsp; 
                    <input type="radio" name="clubType" value="private"><span class="help-inline">Private</span> &nbsp;
                    <input type="radio" name="clubType" value="closed"><span class="help-inline">Closed</span><br/><br/>
                    <button type="submit" class="btn btn-info">Create Club</button>
                  </form>  
                </div>
                <div class="well">
                  <h4>Appoint club administrators</h4>
                </div>
                <div class="well">
                  <h4>Ban users</h4>
                </div>
                <h3>Club administrators</h3>
                <div class="well">
                  <h4>Edit club profile</h4>
                </div>
                <div class="well">
                  <h4>Create/close forums</h4>
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
