<div class="notice">
Invite your friends to here!
</div>

<script src="<?php echo $this->docroot;?>public/js/editor_script.js"></script>
<script>
	
	$(document).ready(function()
	{
		//for  form validation 
		$("#send_email").validate();
	});
</script>
<!-- common validations -->
    <div style="width:760px;margin-left:9px;"    >
    <h3>Invite friends with Email address</h3>
    <form name="send_email" method="post" action="<?php echo $this->docroot;?>users/general_invite"  id="send_email">
    <input type="hidden" name="invite_type" value="normal">
    <table border="0" cellpadding="10" cellspacing="10" width="629">
    <tr><td valign="top">To</td><td><textarea name="to" class="required span-13" title="Enter the Email Ids"></textarea>*separate using comma(,)&nbsp;e.g:example@example.com,example@example.com</td></tr>
    <tr><td valign="top">Subject</td><td><input type="text" name="subject" class="required span-13" title="Enter the Subject"></td></tr>
    <tr><td valign="top">Message</td><td><textarea name="message"class="required span-13 " title="Enter the Message"></textarea></td></tr>
    <tr><td>&nbsp;</td><td>
    <?php  echo UI::btn_("Submit", "invite", "Invite My Friends!", "", "","send_email","send_email");?></td></tr>
    </table>
    </form>
    </div>
