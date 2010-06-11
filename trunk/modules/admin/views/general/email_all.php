<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function()
	{ 
		//for create form validation
		$("#news_letter").validate();

	});
	
 
</script>

<div id="cont_pb" style="margin-top:0px;">
<form name="news_letter" id="news_letter" action="" method="post" enctype="multipart/form-data" onsubmit="return news_valid();">	
<table border="0" cellpadding="5" cellspacing="5" align="center" style="margin-bottom:10px; margin-top:10px;">
<tr><td align="right"><label>From:</label></td><td><input type="text"  name="from" value="<?php echo $this->username;?>" class="required span-8">
</td>
<input type="hidden" name="to" value="<?php
foreach($this->template->email_all as $row)
{
if($row->email!='')
{
echo $row->email;
echo ',';
}
}
?>">


<tr><td valign="top" align="right"><label>Subject:</label></td><td><input type="text"  name="subject" class="required span-8" title="Enter the Subject"></td></tr>
<tr><td valign="top" align="right"><label>Message:</label></td><td><textarea name="message" class="mceEditor required  " title="Enter the Message" style="width:300px;"></textarea></td></tr>

<tr><td>&nbsp;</td><td><?php   echo UI::btn_("Submit", "news_letter", "Send", "", "","news_letter","news_letter");?></td></tr>
</table>
</form>
</div>
	 
	
