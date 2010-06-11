<script>
jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox()
}) ;

function setvalue(a,b)
{
	document.getElementById('user_name').value = a+b;
}
</script>
<table cellpadding="5" cellspacing="5" border="0">
<?php
if(!empty($this->template->profile_info) && $this->template->profile_info->count()>0)
{
	foreach($this->template->profile_info as $row)
	{
	?>
       <!-- <tr>
        <td align="center" height="75">
        <?php Nauth::getPhoto($row->id,$row->name,$row->user_photo); //get the user photo?>	</td>
        <td width="202" colspan="2" ><?php echo $row->name.'&nbsp;'.$row->last_name; ?></td>
        </tr>-->
        <?php 
		 if($row->email!='')
		 {
		 
		 ?>
			<tr>
            <td width="179" class="title_pl">Email:</td>
            <td colspan="2"><?php echo $row->email; ?></td>
            </tr>
		<?php }
        ?>
        <?php if($row->street!="")
        {?>
            <tr>
            <td class="title_pl">Street:</td>
            <td colspan="2"><?php echo $row->street; ?></td>
            </tr>
        <?php } ?>
        <?php if($row->city!="")
        {?>
            <tr>
            <td class="title_pl">City:</td>
            <td colspan="2"><?php echo $row->city; ?></td>
            </tr>
        <?php } ?>
        <?php if($row->country!="")
        {?>
            <tr>
            <td class="title_pl">Country:</td>
            <td colspan="2"><?php echo $row->cdesc; ?></td>
            </tr>
        <?php } ?>
        <?php  if($row->post_code!="" && $row->post_code != 0)
        {?>
            <tr>
            <td class="title_pl">Postal:</td>
            <td colspan="2"><?php echo $row->post_code;?></td>
            </tr>
        <?php } ?>
        <?php if($row->phone!="" && $row->phone != 0)
        {?>
            <tr>
            <td class="title_pl">Phone:</td>
            <td colspan="2"><?php echo $row->phone; ?></td>
            </tr>
        <?php } ?>
        <?php if($row->mobile!="" && $row->mobile != 0)
        {?>
            <tr>
            <td class="title_pl">Mobile:</td>
            <td colspan="2"><?php echo $row->mobile; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><a href="<?php echo $this->docroot; ?>profile/wall/?id=<?php echo $row->id; ?>">Show Wall</a></td>
            </tr>
        <?php
        if($this->userid==$row->id)
        {
        ?>
            <tr>
            <td class="title_pl"><a href="<?php echo $this->docroot; ?>users/invite_friends">Invite friends</a></td>
            <td class="title_pl" colspan="2"></td>
            </tr>
            <tr>
            <td><a href="<?php echo $this->docroot; ?>profile/list_friends">View Friends List</a></td>
            <td colspan="2"><a href="<?php echo $this->docroot; ?>profile/updateprofile">Edit Profile</a></td>
            </tr>
	<?php } ?>
    <?php
        if($this->userid!=$row->id)
        {
        ?>
    		<tr>
            <?php 
			if($this->template->check_friends==0)
			{ ?>
            <td><a href="#friend" rel="facebox" onmouseover="setvalue('<?php echo $row->name; ?>','<?php echo $row->last_name; ?>');">Add as Friend</a></td>
            <?php }
			else
			{?>
             <td></td>
             <?php } ?>
			
            <td colspan="2"></td>
            </tr>
            
    <?php } ?> 
    <tr>
    <td colspan="3">
    <div id="friend" style="display:none;">
    <form name="send_request" id="send_request" action="<?php echo $this->docroot;?>profile/send_request_profile" method="post">
    <table cellspacing="5" cellpadding="5" border="0">
    <tr><td><h3 id="name">Dear <?php echo $row->name.'&nbsp;'.$row->last_name; ?>,</h3></td></tr>
    <tr>
    <td><textarea name="friend_comment" cols="40">Added me as your friend</textarea></td>
    </tr>
    <tr>
    <td><input type="hidden" name="friends_id" value="<?php echo $row->id; ?>" ><input type="hidden" name="user_name" value="<?php echo $row->name.'&nbsp;'.$row->last_name; ?>" ><input type="submit" value="Send" ></td>
    </tr>
    </table>
    </form>
    </div>
    </td>
    </tr>       
	<?php
	}
	
}
?>
</table>
