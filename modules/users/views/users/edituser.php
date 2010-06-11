
<script>
$(document).ready(function(){
 
$("#dob").datepicker({dateFormat: $.datepicker.W3C });
		//for edit user form validation
		$("#edit_form").validate();
});
</script>
<script>
$(document).ready(function() {
 
	// validate signup form on keyup and submit
	var validator = $("#form").validate({
 
		rules: {
			f_name: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			dob: {
				required: true,
				dateISO: true
			},
			street: {
				required: true
			},
			city: {
				required: true
			},
			code: {
				required: true,
				minlength: 6,
				maxlength: 6,
				number: true
			},
			phone: {
				number: true
			},
			mobile: {
				required: true,
				minlength: 10,
				maxlength: 10,
				number: true
			},
			country: "required",
			user_status: "required",
			gender: "required"
		},
		messages: {
			f_name: {
				required: "First Name Required."
			},
			email: {
				required: "Email Required."
			},
			dob: {
				required: "Date of Birth Required."
			},
			street: {
				required: "Street Required."
			},
			city: {
				required: "City Required."
			},
			code: {
				required: "Postal code Required."
			},
			mobile: {
				required: "Mobile Number Required."
			},
			country: "Country Required.",
			user_status: "User status Required.",
			gender: "Gender Required."

		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.next() );
			else
				error.appendTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		 
		// set this class to error-labels to indicate valid fields
		success: function(label) { 
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});

	// propose username by combining first- and lastname
	 

});
</script>

<?php

//left menu
echo new View("/users/settings_menu");
?>


<form name="edit_form" id="edit_form" action="<?php echo $this->docroot;?>users/adduser" method="post">
<input type="hidden" name="adduser" id="adduser" value="edituser" />
<table cellpadding="5" width="100%" cellspacing="5" border="0">
<?php if(count($this->template->get_users)>0)
 	  {
	  	foreach($this->template->get_users as $row)
		{
		 ?>
		 <input type="hidden" name="userid" value="<?php echo $row->user_id; ?>" />
		<tr>
		<th colspan="2" >Edit <?php echo $row->first_name; ?></th>
		</tr>
		<tr>
		<td width="20%">First name:</td>
		<td><input type="text" name="f_name" id="f_name" value="<?php echo $row->first_name; ?>" class="txtbox" class="required" ><span class="mandatory">*</span></td>
		
		</tr>
		
		<tr>
		<td>Last name:</td>
		<td><input type="text" name="l_name" id="l_name" value="<?php echo $row->last_name; ?>" class="txtbox" class="required" ></td>
	
		</tr>
		<tr>
		<td>Email:</td>
		<td><input type="text" name="email" id="email" value="<?php echo $row->email; ?>" class="txtbox" class="required email" ><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Date of Birth:</td>
		<td><input type="text" readonly name="dob" id="dob" value="<?php echo $row->dob; ?>" class="txtbox"><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Gender:</td>
		<td>
		<select name="gender" id="gender" style="width:308px;*width:309px;">
		<option value="">Select Gender</option>
		<option value="male" <?php if($row->gender=="male") { echo "selected";}?>>Male</option>
		<option value="female" <?php if($row->gender=="female") { echo "selected";}?>>Female</option>
		</select><span class="mandatory">*</span>
		</td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Street:</td>
		<td><input type="text" name="street" id="street" value="<?php echo $row->street; ?>" class="txtbox"><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>City:</td>
		<td><input type="text" name="city" id="city" value="<?php echo $row->city; ?>" class="txtbox"><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Country:</td>
		<td>
		<select name="country" id="country" style="width:308px;*width:307px;">
				  <option value="">Select a country...</option>
				<?php if(!empty($this->template->get_country)){
							foreach($this->template->get_country as $row1){
								echo '<option value="'.$row1->id.'" ';
								if($row->country == $row1->id){
									echo "selected";
								}
								echo ' >'.$row1->cdesc.'</option>';
							}
		  				}
				?>
				</select>
		<span class="mandatory">*</span>
		</td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Postal Code:</td>
		<td><input type="text" name="code" id="code" value="<?php echo $row->post_code; ?>" class="txtbox"><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Phone:</td>
		<td><input type="text" name="phone" id="phone" value="<?php echo $row->phone; ?>" class="txtbox"></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>Mobile:</td>
		<td><input type="text" name="mobile" id="mobile" value="<?php echo $row->mobile; ?>" class="txtbox"><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>User Status</td>
		<td><select name="user_status" id="user_status" style="width:308px;*width:309px;">
		<option value="">Select user stauts</option>
		<option value="1" <?php if($row->user_status=="1") { echo "selected";}?>>Active</option>
		<option value="0" <?php if($row->user_status=="0") { echo "selected";}?>>Block</option>
		</select><span class="mandatory">*</span></td>
		<td class="status"></td>
		</tr>
		<tr>
		<td>News Letter Subscription:</td>
		<td><input type="radio" value="1" checked="checked" name="news" id="news">Yes&nbsp;&nbsp;<input type="radio" name="news" value="0" id="news">No</td>
		</tr>
		
		
		<tr>
		<td></td>
		<td>
        <input type="submit" value="Submit" >&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript:window.location='<?php echo $this->docroot;?>users/manageusers'"</td>
		</tr>
		<?php }
		}
		else
		{?>
			
		<?php } ?>
		</table>
		</form>
