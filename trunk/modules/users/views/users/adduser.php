<script>
$(document).ready(function(){
 
$("#dob").datepicker({dateFormat: $.datepicker.W3C });

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
			password: {
				required: true
			},
			password2: {
				required: true,
				equalTo: "#password"
			}
		},
		messages: {
			f_name: {
				required: "First Name Required."
			},
			email: {
				required: "Email Required."
			},
			password: {
				required: "Password Reqired."
			},
			password2: {
				required: "Confirm Password Required."
			}
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

<form name="form" id="form" action="<?php echo $this->docroot;?>register/adduser" method="post">
<input type="hidden" name="adduser" id="adduser" value="adduser" />
<table cellpadding="5" width="100%" cellspacing="5" border="0">

<tr>
<th colspan="2" align="left"; >Add New User</th>
</tr>
<tr>
<td width="20%">Name:</td>
<td><input type="text" name="f_name" id="f_name" maxlength="50" value="<?php echo $this->input->post('f_name'); ?>" class="txtbox"><span class="mandatory">*</span></td>
<td class="status"></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" id="email" maxlength="100" value="<?php echo $this->input->post('email'); ?>" class="txtbox"><span class="mandatory">*</span></td>
<td class="status"></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="password" maxlength="20" id="password" value="<?php echo $this->input->post('password'); ?>" class="txtbox"><span class="mandatory">*</span></td>
<td class="status"></td>
</tr>
<tr>
<td>Confirm Password:</td>
<td><input type="password" name="password2" id="password2" maxlength="20" value="<?php echo $this->input->post('password2'); ?>" class="txtbox"><span class="mandatory">*</span></td>
<td class="status"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Submit" >&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript:window.location='<?php echo $this->docroot;?>users/manageusers'"</td>
</tr>

</table>
</form>
