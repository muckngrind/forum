<?php
	require_once(dirname(__FILE__).'/../views/_page_elements.html.php');
	function _directory($content) {
?>
    <!--container-->
    <div class="container-fluid">
      <div class="row-fluid">
				<div class="span12">
        	<div class="row-fluid">  
						<?php if ( is_signed_in() ) { _nav_left(); } ?>
            <!--/home-content-->
            <div class="span9">
            	<div class="row-fluid">
              	<!--content-description-->
               		<h2><?php echo $content['heading']; ?></h2>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
                  <div class="well"><strong>Private clubs</strong> - Request to join must first be approved by club administrator<br/>
                  <strong>Closed clubs</strong> - Not accepting new members<br />
                  <strong>Public clubs</strong> - Request to join automatically processed</div>
									<?php render_directory(); ?>
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
