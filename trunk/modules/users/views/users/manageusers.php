 
<script>
function deleteusers(a)
{
	var agree=confirm("Are you sure you wish to continue?");
	if(agree)
	{
		window.location='<?php echo $this->docroot;?>users/deleteuser/?userid='+a;
	}
}
function set_value(email)
{
	document.sendemail.email.value = email
}
</script>
<script>
jQuery(document).ready(
function($) 
{
  	$('a[rel*=facebox]').facebox()
});
</script>
 <table cellpadding="5" cellspacing="5" width="100%">
 <tr><th align="right" colspan="5"><a href="<?php echo $this->docroot ;?>users/adduser">Add User</a></th></tr>
 <tr>
 <th align="left">S.No</th>
 <th align="left">Name</th>
 <th align="left">Edit</th>
 <th align="left">Delete</th>
 <th align="left">Mail</th>
 </tr>
 <?php 
 if(count($this->template->get_users)>0)
 {
 	$i = 1;
 	foreach($this->template->get_users as $row)
	{
 	?>
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->first_name; ?></td>
		<td><a href="<?php echo $this->docroot;?>users/edituser/?user_id=<?php echo $row->user_id; ?>">Edit</a></td>
		<td><a href="javascript:deleteusers('<?php echo $row->user_id; ?>')">Delete</a></td>
		<td><a href="#send_email" rel="facebox" id="sendmail" onmouseover="javascript:set_value('<?php echo $row->email; ?>');" style="cursor:pointer;">Mail</a></td>
		</tr>
<?php $i++; } }?>
 </table>
<div id="send_email" style="display:none;">
<div name="email" id="email">
	<form name="sendemail" action="<?php echo $this->docroot;?>users/sendmail" method="post">
	<table cellspadding="10" cellspacing="10" border="0" style="line-height:30px;" >
	<tr>
	<td colspan="2" style="text-align:center;"><h1 style="font-size:14px;font-weight:bold;">Send Mail</h1></td>
	</tr>
	<tr>
	<td>Email:</td>
	<td><input type="text" name="email" id="email" value="" style="width:300px;" readonly /></td>
	</tr>
	<tr>
	<td valign="top" style="padding:3px;"  >Description:</td>
	<td><textarea name="message" id="message" cols="60" rows="5" ></textarea></td>
	</tr>
	<tr >
	<td>&nbsp;</td>
	<td align="right" style="text-align:left;"><input type="submit" value="send"/></td>
	</tr>
	</table>
	</form>
</div>
</div>
