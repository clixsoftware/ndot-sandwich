<script>

function char_count(Object,event)
{ 
        var val=event.which;

        if(Object.value.length<100)
        {
                document.getElementById('message').innerHTML = 99-Object.value.length + " Characters left";
                return true;
        }
        else
        {
                
                if(val<30)
                {
                return true;
                }
                else
                {
                //alert("max 140 char");
                return false;
                }
        }

}
 
</script>

<form name="add_form" id="add_form" method="post" action="/profile/send_request" >
<input type="hidden" value="<?php echo $this->input->get('uid'); ?>" name="friends_id" id="friends_id" />
<table cellpadding="8" cellspacing="8" width="742" class="span-10">
<tr>
<td><input type="hidden" name="fri_message" id="fri_message" value=" Hi <?php if($this->template->friend_name){echo $this->template->friend_name['mysql_fetch_array']->name; }?> Add me as friend" /></td>
<td><label>Message:</label> Please provide any details to help <label><?php if($this->template->friend_name){echo $this->template->friend_name['mysql_fetch_array']->name; } ?></label> know who you are
(enter at most 100 characters with no HTML tags)</td>
</tr>
<tr>
<td valign="top"><?php if($this->template->friend_name){ echo Nauth::getPhotoName($this->template->friend_name['mysql_fetch_array']->id,$this->template->friend_name['mysql_fetch_array']->name); }?></td>
 
<td><textarea name="friend_comment" id="friend_comment" class="span-10 required" onkeypress="return char_count(this,event) "></textarea><br />
<span id="message">100 characters left</span>
</td>
</tr>
<tr>
<td></td>
<td align="right">
<?php  echo UI::btn_("Submit", "Add", "Add", "", "", "Add","Add");?>
<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."' ", "cancel","");?> 
<!-- <input type="submit" value="Add" />&nbsp;<input type="button" value="Cancel" /></td>-->
</tr>
</table>
</form>
