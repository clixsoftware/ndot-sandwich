<?php
/**
 * It forgot password form with captcha  code
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/

?>
<script>
	$(document).ready(function()
	{ 
		$("#forget_pass").validate();
	});
</script>
<form name="forget_pass" id="forget_pass" method="post" action="">

<table cellpadding="5" cellspacing="5" border="0">
<tr>
<td>Enter your Email Id:</td>
<td><input type="text" value="<?php echo $this->input->post('email_id'); ?>" name="email_id" size="40" class="required email"  ></td>
</tr>
<tr><td>&nbsp;</td><td><?php echo $this->captcha->render(true);?></td></tr>

<td>Enter above code in text</td><td><input type="text" name="captcha_code" class="required"/>
<?php
//captcha validation message to user
if (Captcha::valid($this->input->post('captcha_code')))
{
	echo '<span style="color:green">Good answer!</span>';
}
else
{
	//echo '<span style="color:red">Wrong answer!</span>';
}
?>
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="Send" name="send" id="send"> &nbsp;<input type="button" value="Cancel" onClick="javascript:window.location='<?php echo $this->docroot;?>'"></td>
</tr>



</table>

</form>
