function validate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   return reg.test(email);
}

function trim(str){
	var	str = str.replace(/^\s\s*/,''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

function checkAll(email_list){
//alert(email_list);return false;
	var status = true;
	var i = 0;
	var emails = email_list.split(",");
	for(i=0; i<emails.length; i++){
		if(!validate(trim(emails[i]))){			
			alert("Please Check the Format and make sure that the emails are seprated using comma(,)");
			status = false;
			break;
			
		}
	}
	if(status==true){
		//alert("List validated, "+i+" emails found");
		return true;
	}
	else
	{
		//alert("wrong, "+i+" emails found");
		return false;
	}
}

