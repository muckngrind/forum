<?php
	function _mailbox($type) {
		?>
                 <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="new-mail">
                        <td class="address">…</td>
                        <td class="subject">…</td>
                        <td class="date">…</td>
                      </tr>
                      <tr class="new-mail">
                        <td class="address">…</td>
                        <td class="subject">…</td>
                        <td class="date">…</td>
                      </tr>        
                      <tr class="read-mail">
                        <td class="address">…</td>
                        <td class="subject">…</td>
                        <td class="date">…</td>
                      </tr>
                      <tr class="new-mail">
                        <td class="address">…</td>
                        <td class="subject">…</td>
                        <td class="date">…</td>
                      </tr>                                            
                    </tbody>
                  </table>                
		<?php
	}
?>