<?php
if(count($this->template->get_mod_permission)>0)
{
	foreach($this->template->get_mod_permission as $modperm)
	{
		$modperm->wall;
		$modperm->updates;
		$modperm->profile;
		$modperm->video;
		$modperm->photo;		
	}
}
?>
<?php
$this->session = Session::instance();
$userid = $this->session->get('userid');
?>
<form name="form" id="form" method="post" action="<?php echo $this->docroot ;?>profile/privacy_setting">
<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>" />
<table cellpadding="8" cellspacing="8" border="0" width="50%">
<tr>
<td align="right"><label>Show your wall :</label></td>
<td ></td>
<td>
<select id="wall" name="wall">
<option value="0" <?php if($modperm->wall==0) { echo 'selected="selected"'; } ?>>Myself</option>
<option value="-1"  <?php if($modperm->wall==-1) { echo 'selected="selected"'; } ?>>Only my friends</option>
<option value="1"  <?php if($modperm->wall==1) { echo 'selected="selected"'; } ?>>Everyone</option>
</select></td>
</tr>

<tr>
<td align="right"><label>Show your updates:</label></td>
<td ></td>
<td>
<select id="updates" name="updates">
<option value="0" <?php if($modperm->updates==0) { echo 'selected="selected"'; } ?>>Myself</option>
<option value="-1"  <?php if($modperm->updates==-1) { echo 'selected="selected"'; } ?>>Only my friends</option>
<option value="1"  <?php if($modperm->updates==1) { echo 'selected="selected"'; } ?>>Everyone</option>
</select></td>
</tr>
<tr>
<td align="right"><labeL>Show your profile:</labeL></td>
<td ></td>
<td>
<select id="profile" name="profile">
<option value="0" <?php if($modperm->profile==0) { echo 'selected="selected"'; } ?>>Myself</option>
<option value="-1"  <?php if($modperm->profile==-1) { echo 'selected="selected"'; } ?>>Only my friends</option>
<option value="1"  <?php if($modperm->profile==1) { echo 'selected="selected"'; } ?>>Everyone</option>
</select></td>
</tr>
<tr>
<td align="right"><labeL>Show your Videos:</labeL></td>
<td ></td>
<td>
<select id="video" name="video">
<option value="0" <?php if($modperm->video==0) { echo 'selected="selected"'; } ?>>Myself</option>
<option value="-1"  <?php if($modperm->video==-1) { echo 'selected="selected"'; } ?>>Only my friends</option>
<option value="1"  <?php if($modperm->video==1) { echo 'selected="selected"'; } ?>>Everyone</option>
</select></td>
</tr>

<tr>
<td align="right"><labeL>Show your Photos:</labeL></td>
<td ></td>
<td>
<select id="photo" name="photo">
<option value="0" <?php if($modperm->photo==0) { echo 'selected="selected"'; } ?>>Myself</option>
<option value="-1"  <?php if($modperm->photo==-1) { echo 'selected="selected"'; } ?>>Only my friends</option>
<option value="1"  <?php if($modperm->photo==1) { echo 'selected="selected"'; } ?>>Everyone</option>
</select></td>
</tr>

<tr>
<td></td>
<td></td>
<td>
<?php echo UI::btn_("Submit", "save", "Save", "", "","form","form");?>&nbsp;&nbsp;
<?php echo UI::btn_("Click", "canl", "Cancel", "", "window.location='".$this->docroot."profile'","form","form");?>
<!--input type="submit" value="Save" />&nbsp;<input type="button" value="Cancel" onclick="javascript:window.location='<?php echo $this->docroot;?>users/'" /-->
</td>
</tr>
</table>
</form>


