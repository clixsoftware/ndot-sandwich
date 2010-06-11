<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/compose.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot ?>public/css/autocomplete/jquery.autocompletefb.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot ?>public/css/jqdialog.css" rel="stylesheet" type="text/css" />
<style>
input.btncrud {
	background-color:#CCCCCC;
	margin:5px 0pt 2pt;
	border:1px solid;
	padding:3px 8px;
	font-size:12px;
	color:#000000;
}
.btn2 {
	display:none;
}
</style>
<script src="<?php echo $this->docroot;?>public/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jqdialog.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.bgiframe.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.autocompletefb.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.dimensions.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
			$(document).ready(function() {
				var acfb = 
				$("ul.first").autoCompletefb({urlLookup:"/inbox/autoname"});
				
				$("#show_value1" ).click(function(){alert(acfb.getData());});
				$("#clear_value1").click(function(){acfb.clearData();	  });
				
				function acfbuild(cls,url){
					var ix = $("input"+cls);
					ix.addClass('acfb-input').wrap('<ul class="'+cls.replace(/\./,'')+' acfb-holder"></ul>');
					
					return $("ul"+cls).autoCompletefb({urlLookup:url});
				}
				
				
				
			});
		</script>
<script>
function verifyuser()
{ 
 
	var result2;
	var tk=$("#toidname").val(); 
	
	k=tk;
	
	s = k; 
	if(s=='toall')
	{
	
	var url = '/ajax/checkuser?unames='+s; 
		$.post(url,function(check){  
		if(check == 'correct'){ 
		result2 = 'true';
		document.insertmail.submit();
		return true;
		
		}
		else{  
		//alert(check);
		jqDialog.alert(check);	
		//document.getElementById("toidname").focus(); 
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
		//alert(check);
		jqDialog.alert(check);
		//document.getElementById("toidname").focus(); 
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
        //document.insertmail.submit();
//return result;
}


        //validate the form
        
        function validation()
	{ 
	
	//alert(acfb.getData());
	
        if(document.getElementById("toidname").value=="")
	{
	        jqDialog.alert("Atleast specify one Mail id");
	        return false;
	}
	
	if(document.getElementById("subject").value=="")
	{
	        jqDialog.alert("Enter the Subject");
		return false;
	}
	
	if(document.getElementById("message").value=="")
	{
	        jqDialog.alert("Enter the Message");
		return false;
	}
	
	return true;
	
	}
	

function deletecontact(contactval,val)
{
full=$('#toidname').val();
alert(contactval);
val=val.concat(",");

var extract=full.replace(val,"")
//alert(extract);
$("#"+contactval).remove();
$('#toidname').val(extract);
}
function deletecontactcc(contactval,val)
{
full=$('#ccidname').val();
//alert(full);
val=val.concat(",");

var extract=full.replace(val,"")
//alert(extract);
$("#"+contactval).remove();
$('#ccidname').val(extract);
}
</script>



<div class="span-19">
  <div class="span-19">
    <!--mail_con start-->
    <form name="insertmail" action="<?php echo $this->docroot;?>inbox/insertmail/?mainpage=inboxshow" method="post" class="from_out" onSubmit="return user()">
      <table cellpadding="5" class="span-19" cellspacing="5" border="0">
        <tr>
          <td align="right" valign="top"><label>E-Mail to :</label></td>
          <td><div id="content">
              <ul class="first acfb-holder span-15-a">
                <?php if(!empty($this->name)) {  ?>
                <li class="acfb-data"><span><?php echo $this->name; ?></span> <img class="p" src="/public/images/delete.gif"/></li>
                <?php } ?>
                <input type="text" class="city acfb-input"/>
              </ul>
              <br/>
            </div></td>
        </tr>
        <input type="hidden"  name="toid" class="title"  id="toidname" value="<?php if(!empty($this->fid)) echo $this->fid;  ?>" />
        <input type="hidden"  name="ccid" class="title"  id="ccidname" value="" />
        <tr>
          <td align="right" valign="top"><label>Subject :</label></td>
          <td colspan="2"><input type="text" name="mail_subject" value="<?php echo $this->subject; ?>" class="title span-16" id="subject" />
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><label>Message :</label></td>
          <td colspan="2"><textarea name="mail_message"  class="span-16" rows="6" id="message"> <?php if($this->message) { echo $this->message; } ?></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><?php  //echo UI::btn_("button", "submitbt", "Send", "", "return user()", "sendmail","");?>
          <?php  echo UI::btn_("Submit", "compose", "Post", "", "", "new_q","compose");?>
            <?php  echo UI::btn_("button", "submitbtn", "Cancel", "", "javascript:window.location='".$this->docroot."inbox/inboxshow';", "sendmail","");?>
             </td>
          <td></td>
        </tr>
      </table>
    </form>
  </div>
</div>
