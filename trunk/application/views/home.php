<script src="<?php echo $this->docroot;?>public/js/ui.datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
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
<script src="<?php echo $this->docroot;?>public/js/signup_validation.js" type="text/javascript"></script>

<div class="banner_outer" style="margin-top:20px;" >
  <div class="banner_inner" >
    <div class="banner_left"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/banner_left.jpg" /> 
    <p>
    <strong>&bull; Friends&nbsp;&nbsp;&bull; Answers&nbsp;&nbsp;&bull; Inbox&nbsp;&nbsp;&bull; Videos&nbsp;&nbsp;&bull; Photos&nbsp;&nbsp;&bull; Groups&nbsp;&nbsp;&bull; Forum&nbsp;&nbsp;&bull; Ads&nbsp;&nbsp; & Lot more!</strong>
    </p>
    </div>
    <?php
		echo new View("user_login");
	?>
    <div class="sign_up" >
      <h2  > IT'S FREE, AND ANYONE CAN JOIN </h2>
      <form name="form" id="form" action="<?php echo $this->docroot;?>register/adduser" method="post" onsubmit="return validate()">
        <input type="hidden" name="adduser" id="adduser" value="adduser" />
        <table border="0"   class="form_table" align="">
          <tr>
            <td>First Name: </td>
            <td><input type="text" name="f_name" id="f_name" maxlength="40"  onkeypress="javascript:success_message(this)" value="<?php echo $this->input->post('f_name'); ?>" class="text_box">
              <br/>
              <span id="fname_err"></span> </td>
          </tr>
          <tr>
            <td>Last Name:</td>
            <td><input type="text" name="l_name" id="l_name" maxlength="40"  onkeypress="javascript:success_message4(this)" value="<?php echo $this->input->post('l_name'); ?>" class="text_box">
              <br/>
              <span id="lname_err"></span></td>
          </tr>
          <tr>
            <td>Your Email:</td>
            <td align="left"><input type="text" name="email" id="email" maxlength="100" onkeypress="javascript:success_message1(this)" value="<?php echo $this->input->post('email'); ?>" class="text_box"></td>
          </tr>
          <tr>
            <td>Enter Password:</td>
            <td><input type="password" name="password" maxlength="14" id="password1" onkeypress="javascript:success_message2(this)" value="<?php echo $this->input->post('password'); ?>" class="text_box">
              <br/>
              <span id="pass_err"></span></td>
          </tr>
          <tr>
            <td>Re Enter Password:</td>
            <td><input type="password" name="password2" id="password2" maxlength="20" onkeypress="javascript:check_pass(this)" value="<?php echo $this->input->post('password2'); ?>" class="text_box">
              <br/>
              <span id="pass1_err"></span></td>
          </tr>
          <tr>
            <td>Date of Birth:</td>
            <td><input type="text" name="dob" id="dob" value="<?php echo $this->input->post('dob'); ?>" readonly class="text_box" /></td>
          </tr>
          <tr>
            <td>Gender:</td>
            <td align="left"><input type="radio" name="gender" id="gender"  <?php if($_POST){ if($this->input->post('gender') == 'Male'){ echo 'checked'; } } ?> value="Male" />
              Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="gender" id="gender" value="Female" <?php if($_POST){ if($this->input->post('gender') == 'Female'){ echo 'checked'; } } ?> />
              Female&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td>City:</td>
            <td><input type="text" name="city" id="city" class="span-4" />
              <div id="city_error"></div>
              
            </td>
          </tr>
          <tr>
            <td colspan="3"  style=" text-align:left; line-height:30px;  "><div class="submit_width">
                <input style="background:#FF9779; vertical-align:middle; display:inline; float:none;"   type="checkbox"   class="checkbox" id="terms" name="terms"   />
                I agree the terms &amp; conditions of NDOT</div></td></tr>
              <tr>
            <td colspan="3"  >
              <input name="submit" type="image" 
    src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/signup_button.jpg"  style="float:right;padding-right:60px;"/></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
</div>
