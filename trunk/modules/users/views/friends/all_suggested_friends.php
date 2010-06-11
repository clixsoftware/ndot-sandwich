 
			<?php
			foreach($this->template->suggest_friends as $suggest)
				{  ?>
					
					<div class="span-5">
					<div class="span-1a mr_fl_l text-align m0 mr-10">
                    <?php echo Nauth::getPhoto($suggest->id,$suggest->name);?>
                    </div>
					<div class="span-3 last   overflowh"  > 
					<?php Nauth::print_name($suggest->id, $suggest->name); ?>
					<br/>
					<a id="friend<?php echo $suggest->id;?>" href="/profile/add_as_friend/?uid=<?php echo $suggest->id;?>"  class="less_link">Add as friend!</a>
					<!--<div id="" style="cursor:pointer;">Add As Friend</div>-->
					</div>
					</div>

					<div id="friend_form<?php echo $suggest->id;?>" class="hide">
                    <strong>Send Friend Request</strong>
					<form action="<?php echo $this->docroot;?>profile/send_request" method="post">
					<table  border="0">
					<tr>
						<td>
						<textarea class="span-8" id="description3"  name="friend_comment" rows="5" >Hi <?php echo $suggest->name;?> ,Add Me as your friend</textarea>
						</td>
					</tr>
					<tr>
						<td><input type="submit"  value="Send" id="send<?php echo $suggest->id;?>" >
						<!--<input type="button"  class="convey" value="cancel" onclick="javascript:facebox.close;" id="cancel<?php //echo $suggest->id;?>"></td>-->
					</tr>
					  <input type="hidden" name="friends_id" id="friends_id" value="<?php echo $suggest->id;?>">
					</table>
					</form>
					</div>
 <?php  } ?>
