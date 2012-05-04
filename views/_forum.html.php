<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _forum($content) {
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
               		<div class="well">
                  <?php if ( $content['moderator'] == true ) {
										if ( $content['is_open'] == true ) {										
										echo "<a class=\"btn btn-warning\" style=\"float:right;\" href=\"".$_SERVER['PHP_SELF']."?request=".$content['forum_id']."&action=close\">Close this Forum</a>";
										} else {
										echo "<div class=\"alert alert-error\">Forum is Closed</div>";											
										}
									}
									?>
                    <h2><?php echo $content['heading']; ?></h2>
                    <h3><?php echo $content['name']; ?></h3><!--Forum Title-->
                    <p><?php echo $content['description'];
										if ( $content['is_open'] ) {
											if ( $content['show_reply_form'] ) {
											?>
                      </p>
                      <hr />
                      <h4>Create a new post</h4>
                      <form name="create_thread_frm" action="forum.php?request=<?php echo $content['forum_id']; ?>" method="post">
                        <input type="hidden" name="forum_id" value="<?php echo $content['forum_id']; ?>" />
                        <label class="admin-label">Subject</label>
                        <input type="text" class="span5" placeholder="Enter post title" name="subject" id="subject"><br />
                        <label class="admin-label">Content</label>
                        <textarea class="span5" name="content" id="content"></textarea><br/>
                        <br/>
                        <button type="submit" class="btn btn-info">Post Thread</button>
                      </form>              
                      <?php
											} else {
											echo "<a class=\"btn btn-primary\" style=\"float:right;\" href=\"".$_SERVER['PHP_SELF']."?request=".$content['forum_id']."&action=add\">Add a Thread</a></p>";	
											}
										}
										?>
                  </div>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
                <?php
                $result = get_threads($content['forum_id']);
 								if ( $result->num_rows > 0 ) {
									while ( $row = $result->fetch_assoc() ) {
										?>
                	<!--thread-->
										<div class="well thread-head">
                  	<h4><?php echo $row['subject'];?></h4>
                    <p>Posted by: <strong><?php echo $row['username']; ?></strong> on <?php echo $row['created_at']; ?></p>
                    <p class="thread"><?php echo $row['content']; ?></p>               
                		</div>
                <!--/thread-->								
									<?php
  								}
								} else { ?>
									<div class="well thread-head">
                  	<h4>No threads have been posted to this forum</h4>
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