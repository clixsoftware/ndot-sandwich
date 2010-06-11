			<div class=" span-5 suggestion borderf p2">
			<h3 class="sub-heading">Invite Friends </h3>
            <div class="">
			<a href="<?php echo $this->docroot;?>profile/invite_friends">&nbsp;&nbsp;Invite friends from your networks
			<img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/invite_icons.jpg" /> 
            </a>
			</div>
            </div>
<?php 
if(!empty($this->template->profile_info))
{
	if($this->template->profile_info["mysql_fetch_array"]->id==$this->userid)
	{
	        $i = 1;
		?>
			<div class=" span-5 suggestion borderf p2">
			<h3 class="sub-heading">Friend Suggestions  <span class="fr mr-5"><?php if(count($this->template->suggest_friends) > 2){ ?><a href="<?php echo $this->docroot;?>profile/friend_suggestion/<?php echo $this->user_id; ?>">View all</a><?php } ?></span></h3>
            <div class="fri_rcon">
			<?php
		if(!empty($this->template->suggest_friends) && $this->template->suggest_friends->count()>0)
		{ 
			
			foreach($this->template->suggest_friends as $suggest)
				{ if($i <= 2){?>
					
					<div class="span-5">
					<div class="span-1a mr_fl_l text-align m0 mr-10">
                    <?php echo Nauth::getPhoto($suggest->id,$suggest->name);?>
                    </div>
					<div class="span-3 last   overflowh"  > 
					<?php Nauth::print_name($suggest->id, $suggest->name); ?>
					<br/>
					<a id="friend<?php echo $suggest->id;?>" href="<?php echo $this->docroot;?>profile/add_as_friend/?uid=<?php echo $suggest->id;?>"  class="less_link">Add as friend!</a>
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
						<td><input type="submit"  value="Send" id="send<?php echo $suggest->id;?>" ></td>
					
					</tr>
					  <input type="hidden" name="friends_id" id="friends_id" value="<?php echo $suggest->id;?>">
					</table>
					</form>
					</div>
		 <?php } ?>
			 
		<?php
		$i++;
		}	
	}else{
		?>
        No Friends Suggested. 
        <form method="get" action="/profile/commonsearch">
        <table  cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
        <td valign="top">
        <input id="search_value" type="text" value="" name="search_value" size="17"/>
        </td>
        <td>
        <input type="image" value="Search" title="search" alt="search" src="<?php echo $this->docroot;?>public/themes/default/images/search.jpg"/>
        </td>
        </tr>
        <tr><td colspan="2" class="quiet">Search Friends by Name,City</td></tr>
        </tbody>
        </table>
        </form>

        <?php
	}
	?>
		</div>
   </div>
    <?php 	 
	
	}	
}

?>
