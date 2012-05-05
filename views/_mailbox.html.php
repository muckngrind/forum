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
													if ( $row['recipient_read'] == 0 )
														$class = "new-mail";
													else
														$class = "read-mail";
														
													echo "<tr class=\"$class\">\n";
														echo "\t<td class=\"address\"><a href=\"read_mail.php?request=Inbox&id=".$row['id']."&set=recipient_read\">".$row['sender']."</a></td>\n";
														echo "\t<td class=\"subject\"><a href=\"read_mail.php?request=Inbox&id=".$row['id']."&set=recipient_read\">".$row['subject']."</a></td>\n";
														echo "\t<td class=\"date\"><a href=\"read_mail.php?request=Inbox&id=".$row['id']."&set=recipient_read\">".$row['created_at']."</a></td>\n";
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
													$class = "read-mail";
														
													echo "<tr class=\"$class\">\n";
														echo "\t<td class=\"address\"><a href=read_mail.php?request=Sent&id=".$row['id'].">".$row['recipient']."</a></td>\n";
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
													<th>Subject</th>
                          <th>Date</th>
												</tr>
											</thead>
											<tbody>	
											<?php														
												while ( $row = $mail->fetch_assoc() ) {
													$class = "read-mail";
													echo "<tr>";
														echo "<td class=\"address\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['sender_id']."</a></td>";
														echo "<td class=\"subject\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['subject']."</a></td>";
														echo "<td class=\"date\"><a href=read_mail.php?request=Trash&id=".$row['id'].">".$row['created_at']."</a></td>";
													echo "</tr>";
												}
												echo "</tbody>\n</table>\n";          
											} else {
												echo "<div class=\"well\">";
												render_compose_mail();
												echo "</div><br/>";
											}
										?>
      
		<?php
		}
	}
?>