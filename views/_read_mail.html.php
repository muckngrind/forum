<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _read_mail($content) {
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
									<?php
									$row = $content['message']->fetch_assoc();
									?>
                  <div class="well span8">
                  	<div class="row-fluid">
                    	<span class="read-title">From:</span><span class="read"> &nbsp;<?php echo get_username($row['sender_id']); ?> </span>
                      <span style="float:right; color:#666">Date: <?php echo $row['created_at']; ?> </span><br/>
                      <span class="read-title">To:</span><span class="read"> &nbsp;<?php echo get_username($row['recipient_id']); ?> </span>  
                    </div>
                    <div class="row-fluid">
                    	<span class="read-title">Subject:</span><span class="read"> &nbsp;<?php echo $row['subject']; ?></span>
                    </div>
                    <div class="row-fluid">
                    	<span class="read"><?php echo $row['content']; ?></span>
                    </div>
                    <div class="row-fluid">
                    	<br/>
											<?php 
												if ( strcmp($content['request'],'Inbox') == 0 ) { 
													echo "<a class=\"btn btn-warning\" href=\"read_mail.php?action=delete&id=".$row['id']."&request=".$content['request']."\">Delete Message</a> &nbsp;";
											  }
												?>
                        <a class="btn btn-info" href="home.php?request=Inbox">Return to Inbox</a>
                    </div>
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
