//validation 
function validate()
{
	
	var username = document.getElementById('f_name').value;
	var l_name = document.getElementById('l_name').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password1').value;
	var confirm_password = document.getElementById('password2').value;
	var terms = document.getElementById('terms').checked;
	var dob = document.getElementById('dob').value;
	var city = document.getElementById('city').value;
	if(username == '' && l_name == '' && email == '' && password == '' && confirm_password == '' && dob == '' && city == '')
	{
	        document.getElementById('f_name').style.background = '#FF9779';
	        document.getElementById('l_name').style.background = '#FF9779';
	        document.getElementById('email').style.background = '#FF9779';
	        document.getElementById('password1').style.background = '#FF9779';
	        document.getElementById('password2').style.background = '#FF9779';
	        document.getElementById('dob').style.background = '#FF9779';
	        document.getElementById('city').style.background = '#FF9779';
		return false;
	}
	if(username != '')
	{
	        
		var f_name = username.substr(0,2);
			if(!isNaN(f_name))
			{ 
				document.getElementById('f_name').style.background = '#FF9779';
				return false;
			}
			else
			{
			        if(username.length >=6 && username.length <= 40)
	                        {
	                                document.getElementById('f_name').style.background = '#BBFFBB';
	                        }
	                        else
	                        {
	                               document.getElementById('f_name').style.background = '#FF9779';
	                                return false;
	                        }
				
			}
	}
	else
	{
		document.getElementById('f_name').style.background = '#FF9779';
		return false;
	}
	
	if(l_name != '')
	{
	        if(l_name.length >=6 && l_name.length <= 40)
	        {
	                document.getElementById('l_name').style.background = '#BBFFBB';
	        }
	        else
	        {
	               document.getElementById('l_name').style.background = '#FF9779';
	               return false;
	        }
		
	}
	else
	{
		document.getElementById('l_name').style.background = '#FF9779';
		return false;
	}
	
	if(isValidEmailAddress(email))
	{
	}
	else
	{
		document.getElementById('email').style.background = '#FF9779';
		return false;
	}
	if(password != '')
	{
	        if(password.length >=6 && password.length <=14)
	        {
		        document.getElementById('password1').style.background = '#BBFFBB';
	        }
	        else
	        {
	                document.getElementById('password1').style.background = '#FF9779';
	        }
	}
	else
	{
		document.getElementById('password1').style.background = '#FF9779';
		return false;
	}

	if(confirm_password != '')
	{
		document.getElementById('password2').style.background = '#BBFFBB';
	}
	else
	{
		document.getElementById('password2').style.background = '#FF9779';
		return false;
	}
	if(password != confirm_password)
	{
		document.getElementById('password2').style.background = '#FF9779';
		return false;
	}
		
	if(dob != '')
	{
		document.getElementById('dob').style.background = '#BBFFBB';
	}
	else
	{
		document.getElementById('dob').style.background = '#FF9779';
		return false;
	}
	if(city != '')
	{
	        if(!isNaN(city))
	        {
		        
		        document.getElementById('city_error').innerHTML = 'Enter only Characters';
	                document.getElementById('city_error').style.color = 'red';
	                document.getElementById('city_error').style.size = '12';
	                document.getElementById('city').style.background = '#FF9779';
	                return false;
	        }
	        else
	        {
	                document.getElementById('city').style.background = '#BBFFBB';
	        }
	}
	else
	{
		document.getElementById('city').style.background = '#FF9779';
		return false;
	}
	if(terms == false)
	{
		alert('Please check Terms and Conditions.');
		return false;
	}
	
	
}

function success_message(id)
{
	var fname = id.value;
	if(fname != '')
	{
		if(isNaN(fname))
		{
			var f_name = fname.substr(0,2);
			if(!isNaN(f_name))
			{
				document.getElementById('f_name').style.background = '#FF9779';
				
				return false;
			}
			else
			{
			        if(fname.length >=5 && fname.length <= 40)
	                        {
	                                document.getElementById('f_name').style.background = '#BBFFBB';
	                                document.getElementById('fname_err').innerHTML = '';
	                        }
	                        else
	                        {
	                               document.getElementById('f_name').style.background = '#FF9779';
	                               document.getElementById('fname_err').innerHTML = 'First Name should be 6-40 chars';
				       document.getElementById('fname_err').style.color = 'red';
	                                return false;
	                        }
				
			}
		}
		else
		{
			document.getElementById('f_name').style.background = '#FF9779';
			return false;
		}
	}
	else
	{
		document.getElementById('f_name').style.background = '#FF9779';
		return false;
	}
	
}

function success_message4(id)
{
	var lname = id.value;
	if(lname != '')
	{
		if(isNaN(lname))
		{
			var l_name = lname.substr(0,2);
			if(!isNaN(l_name))
			{
				document.getElementById('l_name').style.background = '#FF9779';
				
				return false;
			}
			else
			{
			        if(lname.length >=5 && lname.length <= 40)
	                        {
	                                document.getElementById('l_name').style.background = '#BBFFBB';
	                                document.getElementById('lname_err').innerHTML = '';
	                        }
	                        else
	                        {
	                               document.getElementById('l_name').style.background = '#FF9779';
	                               document.getElementById('lname_err').innerHTML = 'Last Name should be 6-40 chars';
				       document.getElementById('lname_err').style.color = 'red';
	                                return false;
	                        }
				
			}
		}
		else
		{
			document.getElementById('l_name').style.background = '#FF9779';
			return false;
		}
	}
	else
	{
		document.getElementById('l_name').style.background = '#FF9779';
		return false;
	}
	
}
function success_message1(id)
{
	var email = id.value;
	if(isValidEmailAddress(email))
		{
			document.getElementById('email').style.background = '#BBFFBB';
		}
		else
		{
			document.getElementById('email').style.background = '#FF9779';
			return false;
		}

}

function success_message2(id)
{
	var pass1 = id.value;
	var pass2 = document.getElementById('password2').value;
	
	if(pass1!= '' )
	{
	        if(pass1.length >=5 && pass1.length <=14)
	        {
		        document.getElementById('password1').style.background = '#BBFFBB';
		        document.getElementById('pass_err').innerHTML = '';
	        }
	        else
	        {
	                document.getElementById('password1').style.background = '#FF9779';
	                document.getElementById('pass_err').innerHTML = 'Password should be 6-14 chars';
			document.getElementById('pass_err').style.color = 'red';
	                return false;
	        }
	}
	else
	{
		document.getElementById('password1').style.background = '#FF9779';
		return false;
	}
	
}

function check_pass(id)
{
        pass2 = id.value;
        if(pass2!= '' )
	{
		if(pass2 == document.getElementById('password1').value)
		{
			document.getElementById('password2').style.background = '#BBFFBB';
			document.getElementById('pass1_err').innerHTML = "";
		}
		else
		{
			document.getElementById('password2').style.background = '#FF9779';
			document.getElementById('pass1_err').innerHTML = "Password doesn't match";
			document.getElementById('pass1_err').style.color = 'red';
			return false;
		}
	}
	else
	{
		document.getElementById('password2').style.background = '#FF9779';
		return false;
	}
}
