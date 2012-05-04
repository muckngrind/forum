<?php
	function _mailbox($mail, $type) {
		
		if ( !$mail && ($type != "Compose") ) {
				echo "<h3>No mail to display</h3>";
		} else {
		?>
                 <table class="table table-striped table-bordered table-condensed">
                    <?php
											if ( strcmp($type, "Inbox") == 0 ) {
											?>												
											<thead>
												<tr>
													<th>Sender</th>
													<th>Subject</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>	
											<?php											
												while ( $row = $mail->fetch_assoc() ) {
													if ( $row['recipient_read'] == 1 )
														$class = "new-mail";
													else
														$class = "read-mail";
														
													echo "<tr class=\"$class\">\n";
														echo "\t<td class=\"address\"><a href=read_mail.php?request=Inbox&id=".$row['id'].">".$row['sender_name']."</a></td>\n";
														echo "\t<td class=\"subject\"><a href=read_mail.php?request=Inbox&id=".$row['id'].">".$row['subject']."</a></td>\n";
														echo "\t<td class=\"date\"><a href=read_mail.php?request=Inbox&id=".$row['id'].">".$row['created_at']."</a></td>\n";
													echo "</tr>\n";
												}
												echo "</tbody>\n</table>\n";
											} elseif ( strcmp($type, "Sent") == 0 ) {
											?>												
											<thead>
												<tr>
													<th>Recipient</th>
													<th>Subject</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>	
											<?php																							
												while ( $row = $mail->fetch_assoc() ) {
													if ( $row['recipient_read'] == 1 )
														$class = "new-mail";
													else
														$class = "read-mail";
														
													echo "<tr class=\"$class\">\n";
														echo "\t<td class=\"address\"><a href=read_mail.php?request=Sent&id=".$row['id'].">".$row['recipient_name']."</a></td>\n";
														echo "\t<td class=\"subject\"><a href=read_mail.php?request=Sent&id=".$row['id'].">".$row['subject']."</a></td>\n";
														echo "\t<td class=\"date\"><a href=read_mail.php?request=Sent&id=".$row['id'].">".$row['created_at']."</a></td>\n";
													echo "</tr>\n";
												}
												echo "</tbody>\n</table>\n";
											} elseif ( strcmp($type, "Trash") == 0 ) {
											?>												
											<thead>
												<tr>
													<th>Sender</th>
													<th>Recipient</th>
													<th>Subject</th>
                          <th>Date</th>
												</tr>
											</thead>
											<tbody>	
											<?php														
												while ( $row = $mail->fetch_assoc() ) {
													if ( $row['recipient_read'] == 1 )
														$class = "new-mail";
													else
														$class = "read-mail";
														
													echo "<tr class=\"$class\">\n";
														echo "\t<td class=\"address\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['sender_id']."</a></td>\n";
														echo "\t<td class=\"address\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['recipient_id']."</a></td>\n";
														echo "\t<td class=\"subject\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['subject']."</a></td>\n";
														echo "\t<td class=\"date\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['created_at']."</a></td>\n";
													echo "</tr>\n";
												}
												echo "</tbody>\n</table>\n";          
											} else {
												?>
                        <div class="well">
												<form action="send_mail.php?request=Inbox" method="post" name="compose" id="compose">
													<label>Recipient</label>
													<input class="span7" type="text" name="to"><br/>
													<label>Subject</label>
													<input class="span7" type="text" name="subject"><br/>
                          <label>Message</label>																							
                          <textarea class="span7" name="content" id="content"></textarea><br/>
                          <input type="hidden" name="from" value="<?php echo $_SESSION['username']?>" />
                          <input class="btn btn-info" type="submit" value="Send" />
												</form>
                        </div>
                        <br />
                        <?php
											}
										?>
      
		<?php
		}
	}
?>