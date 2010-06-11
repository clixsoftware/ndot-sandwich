	function valid_message(id)
	{
		var email = id.value;
		if(isValidEmailAddress(email))
			{
				document.getElementById('username').style.background = '#BBFFBB';
			}
			else
			{
				document.getElementById('username').style.background = '#FF9779';
				return false;
			}
	}
	function valid_message1(id)
	{
		var pass = id.value;
		if(pass!= '')
			{
				document.getElementById('password').style.background = '#BBFFBB';
			}
			else
			{
				document.getElementById('password').style.background = '#FF9779';
				return false;
			}
	}
	function cleartext()
	{
		var email = document.getElementById('username').value;
		if(email == 'Email id')
		{
			document.getElementById('username').value = '';
		}
	
	}
	function clearpass()
	{
		var pass = document.getElementById('password').value;
		if(pass == 'Password')
		{
			document.getElementById('password').value = '';
		}
	}
	function fillmail()
	{
		var email = document.getElementById('username').value;
		if(email == '')
		{
			document.getElementById('username').value = 'Email id';
		}
	}
	function fillpass()
	{
		var pass = document.getElementById('password').value;
		if(pass == '')
		{
			document.getElementById('password').value = 'Password';
		}
	}
	function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
	}
	function submitform()
	{
		var username = document.getElementById('username').value;
		var pass = document.getElementById('password').value;
		if(username != '')
		{
			if(isValidEmailAddress(username))
			{
				document.getElementById('username')..style.background = '#BBFFBB';
				document.forms["form"].submit();
			}
			else
			{
			   document.getElementById('username').style.background = '#FF9779';
			   return false;
			}
	    	
		}
		else
		{
			document.getElementById('username').style.background = '#FF9779';
			return false;
		}
		if(pass != '')
		{
			document.getElementById('password')..style.background = '#BBFFBB';
		}
		else
		{
			document.getElementById('password')..style.background = '#FF9779';
			return false;
		}
	}
 

