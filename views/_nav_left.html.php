<?php
	function _nav_left() {
		?>
            <!--nav-left-->
            <div class="span3">
              <div class="well sidebar-nav">
                <ul class="nav nav-list">
                  <li class="nav-header">Mailbox</li>
                  <li><a href="home.php?request=Compose">Compose</a></li>
                  <li class="active"><a href="home.php?request=Inbox">Inbox</a></li>
                  <li><a href="home.php?request=Sent">Sent</a></li>
                  <li><a href="home.php?request=Trash">Trash</a></li>
                  <li class="nav-header">My Clubs</li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
                  <li class="nav-header">Public Forums</li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
                  <li><a href="#">Link</a></li>
                </ul>
                <hr>
                <h2 class="club-search">Search for Clubs</h2>
                <form class="form-search" style="padding-left:15px;">
  								<input type="text" class="input-medium search-query">
  								<button type="submit" class="btn">Search</button>
								</form>
              </div><!--/.well -->
            </div><!--/span-->
            <!--/nav-left-->
		<?php
	}
?>