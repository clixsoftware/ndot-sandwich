<script>
	$(document).ready(function()
	{ 
		$("#block_user").validate();
	});
</script>
<form name="block_user" id="block_user" action="/users/block" method="post">
<table cellpadding="5" cellspacing="5" border="0" >
<tr>
<td colspan="4"><h2><font color="red">Your Email has been Blocked by Administrator. Please Contact Administrator</font></h2></td>
</tr>
<tr>
<td align="right">Username : </td>
<td><input type="text" value="<?php echo $this->input->post('username'); ?>" name="username" id="username" title="Username Required." class="span-10 required" /><font color="red" style="margin-left:5px;">*</font></td>
</tr>
<tr>
<td align="right">Email : </td>
<td><input type="text" value="<?php echo $this->input->post('email'); ?>" name="email" id="email" class="span-10 required"  /><font color="red" style="margin-left:5px;">*</font></td>
</tr>
<tr>
<td valign="top" align="right">Message : </td>
<td valign="top"><textarea name="message" id="message" class="span-10 required" title="Message Required."><?php echo $this->input->post('message'); ?></textarea><font color="red" style="margin-left:5px;verticle-align:top;">*</font></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Submit" /></td>
</tr>
</table>
</form>
