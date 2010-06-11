<link href="<?php echo $this->docroot;?>public/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->docroot;?>public/js/ui.datepicker.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
$('#edit_form').validate();
});
$(document).ready(function()
{
	//startdate call
	$('#dob').datepicker(
	{
		showOn: "both",
		beforeShow: customRangeStart,
		
		maxDate: 365,
		dateFormat: "yy-mm-dd",
		changeYear: true,
		showButtonPanel: true,
		buttonImage: '<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/calender.jpg',
		buttonImageOnly: true
	});
	 

function customRange(input) 
{ 

return { 
	 maxDate:  new Date()
       }; 
}

function customRangeStart(input) 
{ 

return {
         maxDate:  new Date()
       }; 
}

});//End of Document Ready 
</script>
<?php
if(count($this->template->profile_info) > 0){
	foreach($this->template->profile_info as $edit)
	{
		$_POST['f_name'] = $edit->name;
		$_POST['l_name'] = $edit->last_name;
		$_POST['dob'] = $edit->dob;
		$_POST['gender'] = $edit->gender;
		$_POST['street'] = $edit->street;
		$_POST['city'] = $edit->city;
		$_POST['country'] = $edit->country;
		if($edit->post_code != 0)
		{
		        $_POST['code'] = $edit->post_code;
	        }
		$_POST['phone'] = $edit->phone;
		$_POST['mobile'] = $edit->mobile;
		$_POST['news'] = $edit->news_letter;
		$_POST['email'] = $edit->email;
		$_POST['aboutme'] = $edit->aboutme;
	}
}
else{
    $_POST['f_name'] = '';
	$_POST['l_name'] = '';
	$_POST['dob'] = '';
	$_POST['gender'] = '';
	$_POST['street'] = '';
	$_POST['city'] = '';
	$_POST['country'] = '';
	$_POST['code'] = '';
	$_POST['phone'] = '';
	$_POST['mobile'] = '';
	$_POST['news'] = '';
	$_POST['email'] = '';
	$_POST['aboutme'] = '';
}

//get the user interest
if(count($this->template->get_user_interest)>0){
	foreach($this->template->get_user_interest as $int)
	{
		$int->interest_id;
	}
}
else{
        $int->interest_id = 0;
}

//get the user privacy
if(count($this->template->get_user_privacy)>0){
	foreach($this->template->get_user_privacy as $privacy)
	{
		$privacy->email;
		$privacy->dob;
		$privacy->phone;
		$privacy->mobile;
		$privacy->videos;
		$privacy->wall;
	}
}
else{
        $privacy->email = 0;
		$privacy->dob = 0;
		$privacy->phone = 0;
		$privacy->mobile = 0;
		$privacy->videos = 0;
		$privacy->wall = 0;
}
$this->session = Session::instance();
$userid = $this->session->get('userid');
?>

<form name="edit_form" id="edit_form" method="post" action="<?php echo $this->docroot ;?>profile/updateprofile">
<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>" />
<table width="742" border="0" cellpadding="8" cellspacing="8">

<tr>
    <td width="228" align="right" valign="top" ><label>About Me:</label></td>
    <td width="276"><textarea  name="aboutme" id="aboutme" cols="35"><?php echo $this->input->post('aboutme'); ?></textarea></td>
</tr>


<tr>
<td width="228" align="right" valign="top"><label>First Name:</label></td>
<td width="276"><input type="text" name="f_name" id="f_name" tabindex="1" size="46" value="<?php echo $this->input->post('f_name'); ?>" class="required nospecialchars onlychars title" ></td>

</tr>

<tr>
<td width="228" align="right"valign="top" ><label>Last Name:</label></td>
<td width="276"><input type="text" name="l_name" id="l_name" tabindex="1" size="46" value="<?php echo $this->input->post('l_name'); ?>" class="required nospecialchars onlychars title" ></td>

</tr>

<tr>
<td  align="right" valign="top"><label>Date of Birth:</label></td>
<td><input type="text" name="dob" id="dob" value="<?php echo $this->input->post('dob'); ?>" tabindex="2" size="12" readonly  ></td>

<td>
<select id="birthdayprivacy" name="birthdayprivacy"  >
<option value="0" <?php if($privacy->dob==0) { echo 'selected="selected"'; } ?>>myself</option>
<option value="-1"  <?php if($privacy->dob==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
<option value="1"  <?php if($privacy->dob==1) { echo 'selected="selected"'; } ?>>everyone</option>
</select></td>
</tr>
<tr>
<td align="right" valign="top"><label>Gender:</label></td>
<td>
<select name="gender" id="gender" tabindex="3" class="">
<option value="">Select Gender</option>
<option <?php if($this->input->post('gender') == 'male'){ ?>selected="selected"<?php } ?> value="male" >Male</option>
<option <?php if($this->input->post('gender') == 'female'){ ?>selected="selected"<?php } ?> value="female">Female</option>
</select></td>

</tr>
<tr>
<td align="right" valign="top"><label>Street:</label></td>
<td><input type="text" name="street" id="street" tabindex="4" size="46" value="<?php echo $this->input->post('street'); ?>" class=""></td>

</tr>
<tr>
<td align="right" valign="top"><label>City:</label></td>
<td>
<select name="city" id="city" tabindex="5" class="required">
<option value="">Select City</option>
<?php foreach($this->template->get_city as $city){ ?>
<option <?php if($this->input->post('city') == $city->name){ ?>selected="selected"<?php } ?> value="<?php echo $city->name; ?>"><?php echo $city->name; ?></option>
<?php } ?>
</select>
</td>

</tr>
<tr>
<td align="right" valign="top"><label>Country:</label></td>
<td>
<select name="country" id="country" tabindex="6" class="">
<option value="">Select Country</option>
<?php foreach($this->template->get_country as $country){ ?>
<option <?php if($this->input->post('country') == $country->cid){ ?>selected="selected"<?php } ?> value="<?php echo $country->cid; ?>"><?php echo $country->cdesc; ?></option>
<?php } ?>
</select></td>

</tr>
<tr>
<td align="right" valign="top"><label>Post Code:</label></td>
<td><input type="text" name="code" id="code" value="<?php echo $this->input->post('code'); ?>" tabindex="7" size="46" class="required nospecialchars digits" minlength="3" maxlenth="6"></td>

</tr>
<tr>
<td align="right" valign="top"><label>Phone:</label></td>
<td><input type="text" name="phone" id="phone" value="<?php if($this->input->post('phone')){ echo $this->input->post('phone'); } ?>"  tabindex="8" size="46" class="digits" minlength="10" maxlength="12"></td>
<td>
<select id="phoneprivacy" name="phoneprivacy">
<option value="0" <?php if($privacy->phone==0) { echo 'selected="selected"'; } ?>>myself</option>
<option value="-1"  <?php if($privacy->phone==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
<option value="1"  <?php if($privacy->phone==1) { echo 'selected="selected"'; } ?>>everyone</option>
</select></td>
</tr>
<tr>
<td align="right" valign="top"><label>Mobile:</label></td>
<td><input type="text" name="mobile" id="mobile" value="<?php if($this->input->post('mobile')){echo $this->input->post('mobile');} else { echo ""; }  ?>" tabindex="9" size="46" class="digits" minlength="10" maxlength="12"></td>

<td>
<select id="mobileprivacy" name="mobileprivacy">
<option value="0" <?php if($privacy->mobile==0) { echo 'selected="selected"'; } ?>>myself</option>
<option value="-1"  <?php if($privacy->mobile==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
<option value="1"  <?php if($privacy->mobile==1) { echo 'selected="selected"'; } ?>>everyone</option>
</select></td>
</tr>
<tr>
<td align="right" valign="top"><label>Interested In:</label></td>
<td><div style="border:1px solid #ccc;">
<?php foreach($this->template->get_interest as $interest){ ?>
<input name="<?php echo $interest->interest; ?>" type="checkbox" value="<?php echo $interest->interest_id; ?>" <?php foreach($this->template->get_user_interest as $int)
{ if($int->interest_id==$interest->interest_id) { ?> checked="checked" <?php } } ?> />
<?php echo $interest->interest; ?>
<br/>
<?php } ?>
</div></td>


</tr>
<tr>
<td align="right" valign="top"><label>News Letter:</label></td>
<td><input type="radio" name="news" checked="checked" id="news" value="1" />Yes&nbsp;&nbsp;<input type="radio" name="news" id="news" <?php if($this->input->post('news') == 0){ ?>checked="checked"<?php } ?> value="0" />No</td>
</tr>
<tr>
  <td align="right" valign="top"><label>Email:</label></td>
  <td>
    <input type="text" name="email" id="email" value="<?php echo $this->input->post('email'); ?>" tabindex="9" size="46" class="required email title" if<?php if($this->input->post('email')!='') { ?> readonly="readonly" <?php } ?>/></td>

  <td><select id="emailprivacy" name="emailprivacy">
    <option value="0" <?php if($privacy->email==0) { echo 'selected="selected"'; } ?>>myself</option>
    <option value="-1"  <?php if($privacy->email==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
    <option value="1"  <?php if($privacy->email==1) { echo 'selected="selected"'; } ?>>everyone</option>
  </select></td>
</tr>
<tr>
  <td align="right" valign="top"><label>Show wall to</label></td>
  <td>
  <select id="wallprivacy" name="wallprivacy">
<option value="0" <?php if($privacy->wall==0) { echo 'selected="selected"'; } ?>>myself</option>
<option value="-1"  <?php if($privacy->wall==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
<option value="1"  <?php if($privacy->wall==1) { echo 'selected="selected"'; } ?>>everyone</option>
</select>
  </td>
</tr>
<tr>
  <td align="right" valign="top"><label>Show Videos to</label></td>
  <td>
  <select id="videoprivacy" name="videoprivacy">
<option value="0" <?php if($privacy->videos==0) { echo 'selected="selected"'; } ?>>myself</option>
<option value="-1"  <?php if($privacy->videos==-1) { echo 'selected="selected"'; } ?>>only my friends</option>
<option value="1"  <?php if($privacy->videos==1) { echo 'selected="selected"'; } ?>>everyone</option>
</select>
</td>
</tr>
<tr>
<td></td>
<td>
 <?php  echo UI::btn_("Submit", "invite", "Update", "", "","form","form");?>&nbsp;
<?php  echo UI::btn_("Button", "cancel", "Cancel", "", "window.location='".$this->docroot."profile'","form","form");?>
</td>
</tr>

</table>
</form>


