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
                    <h2><?php echo $content['heading']; ?></h2>
                    <h3><?php echo $content['forum']; ?></h3><!--Forum Title-->
                    <p><?php echo $content['description']; ?><p>
                  </div>
                <!--/content-description-->
              </div><!--/row-->
              <div class="row-fluid">
              	<!--content-pane-->
 
 								<!--thread-->
 									<div class="well thread-head">
                  	<h4>When is the best time to plant roses?</h4>
                    <p>Posted by: Ryan on May 12, 2012</p>
                  </div>
                  <p class="thread">Some interesting info goes here.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque dolor tellus, faucibus at ultricies ac, fringilla eu mi. Integer et mauris lorem. Nullam vulputate velit quis tortor eleifend quis mattis dolor blandit. Morbi pharetra pulvinar magna, vel rhoncus nisi volutpat vel. Donec lacinia dignissim dolor, quis semper tellus malesuada et. Fusce a neque a dolor convallis fermentum. Integer scelerisque, dolor nec convallis dignissim, lectus lorem tincidunt massa, sit amet placerat velit ipsum et urna. Vestibulum nec dui est, at mattis erat. Donec consequat luctus orci quis hendrerit. Donec nec rhoncus dui. Mauris risus lacus, lacinia et scelerisque ac, pretium ut sapien. Ut vel nisi nibh. Sed id metus tortor, eu sollicitudin tellus. Nunc tellus nunc, volutpat in facilisis sed, suscipit eu velit. Vestibulum tincidunt mi vel nisi convallis vel tempus nisi rhoncus.

Integer nisi mi, gravida eget sagittis in, imperdiet ut mi. Fusce at mi ac mi dapibus ullamcorper. Mauris eget leo auctor elit tempus convallis sed mattis nulla. Nulla eu sem vel urna fringilla tincidunt. Donec laoreet rutrum dignissim. Mauris id adipiscing mi. In varius tincidunt placerat. Integer in mi at massa lobortis pellentesque. Donec at facilisis mauris.</p>               
                <!--/thread-->
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