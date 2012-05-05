<?php
	function _nav_left() {
		?>
            <!--nav-left-->
            <div class="span3">
              <div class="well sidebar-nav">
                <ul class="nav nav-list">
                  <li class="nav-header">Mailbox</li>
                  <li><a href="home.php?request=Compose">Compose</a></li>
                  <li><a href="home.php?request=Inbox">Inbox</a></li>
                  <li><a href="home.php?request=Sent">Sent</a></li>
                  <!--<li><a href="home.php?request=Trash">Trash</a></li>-->
                  <li class="nav-header">My Clubs</li>
                  <?php
										$results = user_clubs();
										if ( !$results ) {
											echo "<li>Join a club!</li>";
										} else {
											while ( $row = $results->fetch_assoc() ) {
												echo "<li><a href=\"club.php?request=".$row['id']."\">".$row['name']."</a></li>";
											}
										}
									?>
                  <li class="nav-header">Club Directory</li>
                  <li><a href="directory.php?request=Directory">View all clubs</a></li>
                </ul>
                <hr>
                <h2 class="club-search">Search for Clubs</h2>
                <form method= "post" class="form-search" style="padding-left:15px;">
  								<input type="text" class="input-medium search-query" name= 'Search'>
  								<button type="submit" class="btn">Search</button>
								</form>
		<?php
		#	$club= $_POST['Search'];
		#	$results = search_club($club);




		#?>

              </div><!--/.well -->
            </div><!--/span-->
            <!--/nav-left-->
		<?php
	}
?>