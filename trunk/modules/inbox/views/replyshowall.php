<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/compose.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $this->docroot;?>/public/js/jquery.js"></script>
<script>
function loademailto(id,val){
if(val!=""){
		if(document.getElementById(id).value.indexOf(val+",")<0){
			document.getElementById(id).value = document.getElementById(id).value + val +',';
			document.getElementById(id).focus();
		}
	}
}


function verifyuser()
{ 
	var result2;
	var k=$("#toidname").val(); 
	
	//alert(k);
//	var k=document.getElementById("toidname").value
	var s=k.substr(0,k.length-1)
	if(s=='toall')
	{
	
	var url = '/inbox/ajax/checkuser?unames='+s; 
		$.post(url,function(check){  
		if(check == 'correct'){ 
		result2 = 'true';
		document.insertmail.submit();
		return true;
		
		}
		else{  
		alert(check);
		document.getElementById("toidname").focus(); 
		result2 = 'false';
		return false;	
		}
		});
		//alert('t');
		return false;
	}
	else{ 
		var url = '/ajax/checkuser?unames='+s; 
		$.post(url,function(check){  
		if(check == 'correct'){ 
		result2 = 'true';
		document.insertmail.submit();
		return true;
		
		}
		else{  
		alert(check);
		document.getElementById("toidname").focus(); 
		result2 = 'false';
		return false;	
		}
		});
		//alert('t');
		return false;
	}  
	}


function user()
{
//var result=true;
var result;
var userresult=false;
var verify;
 result = validation(); 
 if(result == false){ 
 	return result;
 }
 if(result == true){ 
 	verify = verifyuser();  
	if(verify == false){
		return false;
	}else{
	
		return true;
	}
 }
 
return false;
}



function validation()
	{ 
	if(document.getElementById("toidname").value=="")
	{
	alert('Atleast specify one Mail id');
	return false;
	}
	if(document.getElementById("message").value=="")
	{
	alert('Enter the message');
		return false;
	}
	if(document.getElementById("subject").value=="")
	{
	alert('Enter the Subject');
		return false;
	}
	return true;
	//alert(message);
	//alert('Mail has been sent');
	//return false;
	}
	
</script>
<?php
echo '<style>', "\n"; 
include Kohana::find_file($this->docroot.'/public/css/', 'compose', TRUE, 'css'); 
echo '</style>';

?>
</head>
<body>
<!--<div class="responsemsg" id="error"></div>-->
<div class="outter">
  <!--contentstart-->
  <!--top heading bar start

<div class="top_bar"><h1 class="heading">Reply Message</h1></div>
-->
  <!--topheadingbarfinish-->
  <!--leftsidenavigationstart-->
  <div class="left_navi">
    <ul>
      <li><a href="<?php echo $this->docroot;?>inbox/inboxshow" >Inbox (<?php echo count($this->unread);?>)</a></li>
      <li><a href="<?php echo $this->docroot;?>inbox/sent_mails" >Sent Mail</a></li>
      <li><a href="<?php echo $this->docroot;?>inbox/compose" >Compose Mail</a></li>
      <li><a href="<?php echo $this->docroot;?>inbox/archive_mails" >Archive</a></li>
    </ul>
  </div>
  <!--leftsidenavigationfinish        onSubmit="return user()"-->
  <div class="mail_con">
    <!--mail_con start-->
    <?php foreach($this->replydata as $replydata) {?>
    <form name="insertmail" action="<?php echo $this->docroot;?>inbox/insertmail" method="post" class="from_out" onSubmit="return user()">
      <label class="name_lable">E-Mail to :</label>
      <input type="text" name="toid" class="tex_box" id="toidname" value="<?php echo $replydata->name; ?>," />
      <select name="maillist" onChange="loademailto('toidname',this.value);">
        <option value="">friends to send email</option>
        <option value="toall" style="font-weight:bold;">All of my friends</option>
        <?php 
				foreach($this->friend as $field)
				{?>
        <option value="<?php echo $field->friend_name?>" id="<?php echo $field->friend_id?>" style="font-weight:bold;"><?php echo $field->friend_name;?></option>
        <?php }?>
      </select>
      <br />
      <br />
      <label class="name_lable">Subject  :&nbsp;&nbsp;</label>
      <textarea name="mail_subject"  class="tex_box"  id="subject" ><?php echo $replydata->subject; ?></textarea>
      <br />
      <br />
      <label class="name_lable">Message : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <textarea name="mail_message"  class="mceEditor" cols="85" rows="10" id="message"> <?php echo $replydata->subject; ?></textarea>
      <br />
      <div class="button">
      <input type="button" name="submitbt"  value="Send" id="sendmail" onClick="return user()" style="float:left;width:50px;">
      <input type="button" name="submitbtn" value="Cancel" style="float:left;width:60px; padding:0px 0px 0px 0px ;margin:0px 0px 0px 10px;" onClick="javascript:window.location='<?php echo $this->docroot;?>inbox/inboxshow';">
      <div>
    </form>
    <?php } ?>
    <!-- innercontentfinish-->
  </div>
</div>
</body>
</html>
