<?php
/**
 * User Password changes
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/
?>

<script>
// Define the date picker function
$(document).ready(function(){
 
$("#dob").datepicker({dateFormat: $.datepicker.W3C });
$("#form").validate();
});
</script>





<?php // Change password inputs?>

<form name="form" id="form" method="post" action="<?php echo $this->docroot;?>users/settings" onsubmit="return valid_create()">
<table cellpadding="5" cellspacing="5" border="0">

<tr>
<td align="right"><label>Old Password:</label></td>
<td><input type="password" size="40" maxlength="20" name="old_password" id="old_password" title="<br>Enter the old password" class="title required"  ></td>

</tr>
<tr>

<td align="right"><label>New Password:</label></td>
<td><input type="password" name="new_password" size="40" maxlength="20" id="new_password" title="<br>Enter the new password" class="title required" minlength="5" ></td>

</tr>
<tr>

<td class="right"><label>Confirm Password:</label></td>
<td><input type="password" name="confirm_password" size="40" maxlength="20" id="confirm_password" title="<br>Enter the confirm password" class="title required"  equalTo="#new_password" ></td>

</tr>
<tr>
<td></td>
<td> 
<?php  echo UI::btn_("Submit", "invite", "Change", "", "","form","form");?>&nbsp;
<?php  echo UI::btn_("Button", "cancel", "Cancel", "", "window.location='".$this->docroot."profile'","form","form");?>
<!--input type="submit" value="Change">&nbsp;<input type="button" value="Cancel" onClick="javascript:window.location='<?php echo $this->docroot;?>profile'">-->
</td>
</tr>
</table>
</form>



