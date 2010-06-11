<?php
/**
 * Defines the user profile photo.
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/

?>
<script>
	$(document).ready(function()
	{
		//for create form validation
		$("#form1").validate();
		

	});
</script>


 <?php  $session=Session::instance();
       $userid = $session->get('userid') ?>
<table width="100%" cellpadding="10" >

<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="" onsubmit="return validate_photo();">


  <tr>
    <td width="15%" valign="top" align="right">
	<label>Upload the Photo:</label>
	</td>	
    <td width="75%" valign="bottom" class="quiet">
	
	<input name="user_image" type="file" id="user_image"  class="title required" title="<br>Browse the profile photo" /><br/>
	Please upload photos with Max 1MB Size of .jpg, .gif, .png!</td>
	<tr><td class="quiet"></td><td>
	<?php  echo UI::btn_("Submit", "Submit2", "Upload", "", "","form1","form1");?>&nbsp;&nbsp;
	<?php // echo UI::btn_("Click", "button", "Cancel", "", "window.location='<?php echo $this->docroot;users/settings'","form","form");?>
	</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td></tr>
</form>

</table>







