<script src="<?php echo $this->docroot;?>public/js/validation.js" type="text/javascript"></script>

<?php
if(!empty($this->template->profile_info))
{
	if($this->template->profile_info["mysql_fetch_array"]->id==$this->userid)
	{ 
	?>
		      
        <form name="user_status" id="user_status" method="post" class="clear mt-10 mb-10">
        <table cellpadding="2" cellspacing="2" >
        <input type="hidden" name="form_type" value="user_message" > 
        <tr><td colspan="2"> <textarea name="user_message" id="user_message" rows="2"  class="span-10" onfocus="text_clear(this)"  onkeypress="return MaxLength(this,event);" style="height:25px;">Share your status with your friends</textarea></td>
		<td valign="middle">
		<?php  echo UI::btn_("Click", "share", "Update ","","valid_check('user_message','user_status')","user_status","user_status");?> <span id="limits_count" class="quiet">140 characters</span>
		</td>
		</tr>
        </table>
        </form>
    <?php
	}
}
?>	
