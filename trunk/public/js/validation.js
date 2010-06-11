
        function text_clear(control)
        { 
			if(document.getElementById(control.id).value=="Share your status with your friends" || document.getElementById(control.id).value=='Enter your text' || document.getElementById(control.id).value=='Enter your Reply comment')
			{
				document.getElementById(control.id).value="";  
				document.getElementById(control.id).style.background="none";
			}
        }
	
	function valid_check(ctrlid,frmname)
	{     
		if(document.getElementById(ctrlid).value=="" || document.getElementById(ctrlid).value=="Share your status with your friends" || document.getElementById(ctrlid).value=="Enter your text" || document.getElementById(ctrlid).value=="Enter your Reply comment")
		{   
			document.getElementById(ctrlid).style.background="#FBC0C0";
				if(ctrlid=='user_message')
				{
			document.getElementById(ctrlid).value="Share your status with your friends";
				}
				else if(ctrlid=='wall_message')
				{
				document.getElementById(ctrlid).value="Enter your text";
				}
				else if(ctrlid=='reply_message' || ctrlid=='comments')
				{ 
				document.getElementById(ctrlid).value="Enter your Reply comment";
				} 
			return false;
		}
		else
		{  
			eval('document.' + frmname +'.submit()'); 
		}
	}
 
       function MaxLength(Object,event)
        { 
                var val=event.which;
                if(Object.value.length<140)
                {
                        document.getElementById('limits_count').innerHTML = 139-Object.value.length + " Characters left";
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

