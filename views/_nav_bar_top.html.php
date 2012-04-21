<?php
	function _nav_bar_top() {
		?>
		<!--nav-bar-top-->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Discussion</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
            <p class="navbar-text pull-right">
						<?php 
							if ( is_signed_in() ) {
								echo "Signed in as <a href=\"home.php\">".$_SESSION['username']."</a> ";
								echo "| <a href=\"log_out.php\">sign out</a>";
              } else {
              	echo "<a href=\"index.php\">Sign in</a>";
              }
            ?>
            </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
		<!--/nav-bar-top-->
		<?php
	}
?>