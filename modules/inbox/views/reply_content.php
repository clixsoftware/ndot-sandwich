<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/compose.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot ?>public/css/autocomplete/jquery.autocompletefb.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot ?>public/css/jqdialog.css" rel="stylesheet" type="text/css" /> 

<script src="<?php echo $this->docroot;?>public/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jqdialog.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jqdialog.js" type="text/javascript"></script>

<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.bgiframe.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.dimensions.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.autocompletefb.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>



	<script type="text/javascript">
			$(document).ready(function() {
				var acfb = 
				$("ul.first").autoCompletefb({urlLookup:"/inbox/autoname"});
				
				
				
				function acfbuild(cls,url){
					var ix = $("input"+cls);
					ix.addClass('acfb-input').wrap('<ul class="'+cls.replace(/\./,'')+' acfb-holder"></ul>');
					return $("ul"+cls).autoCompletefb({urlLookup:url});
				}
				
				
				
			});
		</script>


<script>

function deletemail(mid,mpage)

{
jqDialog.confirm("Are you sure want to delete message?",
			function() {
			window.location='<?php echo $this->docroot;?>inbox/delete_mail/?mailid='+mid+'&page='+mpage;
				},		// callback function for 'YES' button
			function() {
			  
			
				}		// callback function for 'NO' button
		);
	


}

	function deletemailone(mid){

var answer = confirm ("Are you want to delete message?")

if (answer)

{

	var url = '/ajax/deletemail?mid='+mid;

	$.post(url,function(check){ 

	alert(check);

	$('#'+mid).hide();

	});

	}

	else{}

	}	

	function movetoarchive(mid){

	//alert(mid);

	//var url = '/ajax/test?mid='+mid;

	var url = '/ajax/movearchive?mid='+mid;

	$.post(url,function(check){ 

	//$("#myfriends"+count).text(check);	

	//alert(check);

	$('#'+mid).hide();

	//$('#'+mid).animate({ opacity: "hide" }, "slow")

	});

	}

	function verifyuser()

{ 

	var result2;

	var tk=$("#toidname").val(); 

//	alert(tk);

	k=tk;

//	alert(k);

//	var k=document.getElementById("toidname").value

	//var s=k.substr(0,k.length-1)
	s=k;
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
 //document.insertmail.submit();
//return result;

}

        //validation
        
        function validation()

	{ 
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



	

	function showrpy(id,name,subject)

	{
	//alert('chandru');
	

	$(".repy").animate({opacity:"show"},"fast");

		$(".status").hide();


		$('#toidnameone').show();

		//$('#setname').val('<span>nanda</span> <img class="p" src="/public/images/delete.gif"></img>');
		document.getElementById("setname").innerHTML = '<span>'+name+'</span> <img class="p" src="/public/images/delete.gif"></img>';
		$('#toidname').val(id);

		$('#subject').val('Re:'+subject);



		document.getElementById("message").focus();		

		return true;

	}

	

function showfwd(id,name)

{

$(".repy").animate({opacity:"show"},"fast")

		$(".status").hide();


		$('#toidnameone').show();

//		$('#toidnameone').val('');
		document.getElementById("setname").innerHTML = '';
		$('#toidname').val('');
		$('#subject').val(name);



}



$(document).ready(function(){

$(".repy").hide();


	$("#discard").click(function(){

		$(".repy").animate({opacity:"hide"},"fast")

		$(".status").show();

		$(".status").text('Message has been discard'); 

		//document.getElementById("replyy").innerHTML='dsdfgfg';

		return false;

	});

	



	});

	function loademailto(id,val){



if(val!=""){ 



		var checkval=document.getElementById(id).value;

		if(checkval=="")

		{

		checkval=checkval+"one";

		}

		var check=checkval.indexOf(val);

		

		if(check!=-1 || checkval!="" )

		{

		if(document.getElementById(id).value.indexOf(val+",")<0){

			document.getElementById(id).value = document.getElementById(id).value + val +',';

			//document.getElementById(id).focus();

			

			var valto=val+'to';

			var temp = document.getElementById("emailto").innerHTML;

			var temp2 = "<span id='"+valto+"' style='border:0px solid red;'  onmousedown=javascript:deletecontact('"+valto+"','"+val+"')>"+val+"<img src='/images/delete.gif' />  ,</span>"; 

			document.getElementById("emailto").innerHTML = temp+temp2;

		}

		}

		

		if(check >= 0)

		{

		jqDialog.alert("Email Aready entered");

		}

	}

}

function deletecontact(contactval,val)

{

full=$('#toidname').val();

//alert(full);

val=val.concat(",");



var extract=full.replace(val,"")

//alert(extract);

$("#"+contactval).remove();

$('#toidname').val(extract);

}
</script>


<!--contentstart-->
<div class="span-19b" >
  <div class=" reply_con">
    <?php foreach($this->replydata as $replydata) {?>
    <div class="reply_top bgF1F4F8">
      <ul>
        <li  ><a href="<?php echo $this->docroot;?>inbox/<?php echo $this->template->title;?>">Back to <?php echo $this->back; ?></a>&nbsp;|&nbsp;</li>
        <?php if($this->back!='Archive' && $this->back!='Sent Mails' ){?>
        <li><a href="<?php echo $this->docroot;?>inbox/moveto_archive/?mailid=<?php echo $replydata->sentmail_id;?>

&page=inbox/<?php echo $this->template->title;?>" >Archive</a>&nbsp;|&nbsp;</li>
        <?php }?>
        <li><a href="javascript:onclick=deletemail('<?php echo $replydata->sentmail_id;?>','inbox/<?php echo $this->template->title;?>')">Delete</a></li>
      </ul>
    </div>
    <div class="reply_dnam">
      <div class="span19b  clear pl-10  ">
        <div class="mt-1 mb-1 bgF7F9FB   span-13 fl mt-10 pt-20 pb-20 borderf">
          <ul>
            <li>
		 <?php if($this->back!='Sent Mails') 

		{

		?>
              <p  class="text_right width103 fl">From:</p>
		<?php } else { ?>
		 <p  class="text_right width103 fl">To:</p>
		<?php  } ?>
              <strong class="fl pl-5"><?php echo $replydata->name;  ?></strong></li>
            <!--<li><p class="text_right width103 fl">To:</p><p class="fl pl-5">Madhiyalagan Pichandi </p></li>-->
            <li>
              <p class="text_right width103 fl">Date:</p>
              <p class="fl pl-5"><?php echo $replydata->dat;  ?></p>
            </li>
            <li>
              <p class="text_right width103 fl">Subject:</p>
              <strong class="fl pl-5"><?php echo $replydata->subject;  ?></strong> </li>
          </ul>
        </div>
        <div class="span-5  ">
        <?php
            $this->miniuserid = $replydata->id; // assign user ID here
            echo new view("profile/profile_view_mini");
        ?>
        </div>
      </div>
      <?php if($this->back=='Sent Mails') 

{

?>
      <h2 class="n_reply"><font style="font-weight:normal; color:#333;">me to</font>&nbsp;&nbsp;<?php echo $replydata->name;  ?>&nbsp;&nbsp;<font style="font-weight:normal; color:#333;"></font></h2>
      <div class="quiet rep_date"><?php echo $replydata->dat;?>&nbsp;(
        <?php $this->gF->dateTimeDiff($replydata->mail_date);?>
        )</div>
      <?php } else {

?>
      <h2 class="n_reply"><?php echo $replydata->name;  ?>&nbsp;&nbsp;<font style="font-weight:normal; color:#333;">to me</font></h2>
      <div class="quiet rep_date"><?php echo $replydata->dat; ?>&nbsp;(
        <?php $this->gF->dateTimeDiff($replydata->mail_date);?>
        )</div>
    </div>
    <?php }?>
    <hr />
    <div class="reply_dnam2"> <?php echo htmlspecialchars_decode($replydata->message); ?></div>
    <div class="reply_options" align="right">
      <?php 
$name = html::specialchars($replydata->name);
$subject = html::specialchars($replydata->subject);
$id = html::specialchars($replydata->id);
?>
      <?php if($this->back=='Sent Mails')

{

?>
      <ul>
        <li>
          <?php  echo UI::btn_("button", "forward", "Forward", "", "showfwd('$subject')", "forward","");?>
        </li>
      </ul>
      <?php }else {
//echo html::specialchars($replydata->subject);
?>
      <ul class="ml-50">
        <li>
          <?php  echo UI::btn_("button", "reply", "Reply", "", "showrpy('$id','$name','$subject')", "reply","");?>
          <?php  //echo UI::btn_("button", "forward", "Forward", "", "showfwd('$id','$subject')", "forward","");?>
      </ul>
      <?php }?>
      <br/>
    </div>
    <div class="repy" id="replyy" >
    
      <form name="insertmail" action="<?php echo $this->docroot;?>inbox/insertmail/?mainpage=<?php echo $this->template->title;?>" method="post" class="from_out" onSubmit="return user()">
      <table cellpadding="5" class="span-19" cellspacing="5" border="0">
          <?php if($this->back=='Sent Mails')

	{?>
          <tr>
            <td  align="right" valign="top"><label>E-Mail to :</label></td>
            <td  ><div id="content">
			
				<ul class="first acfb-holder">
					
					<input type="text" class="city acfb-input"/>
				</ul>
				<br/>
				
			
		</div> </td>
            <?php }else {?>
          <tr>
            <td align="right" valign="top"><label>E-Mail to :</label></td>
            <td   ><div id="content">
			
				<ul class="first acfb-holder span-13">
					<li id='setname'  class="acfb-data fl "></li>
					<input type="text" class="city acfb-input fl "/>
				</ul>
				<br/>
				
			
		</div>
            </td>
            <?php }



	?>
            <td width="73"><input type="hidden" name="toid" class="tex_box" id="toidname" value="" />
            </td>
            
          </tr>
          <tr>
            <td align="right" valign="top"><label>Subject :</label></td>
            <td colspan="2" align="left"  ><input name="mail_subject" id="subject" type="text"   class="title span-14" value="<?php echo $replydata->subject?>"/></td>
          </tr>
          <tr>
            <td align="right" valign="top"><label>Message :</label></td>
            <td colspan="2">
            <textarea name="mail_message"  class="span-14" rows="7" id="message"></textarea>
              <input type="hidden" value="replyvalue"/>
            </td>
          </tr>
          <tr>
            <td></td>
            <td align="right">
                 <?php  //echo UI::btn_("button", "send", "Send", "", "return user()", "sendmail","");?>
                 <?php  echo UI::btn_("Submit", "compose", "Post", "", "", "new_q","compose");?>
              <?php  echo UI::btn_("button", "discard", "Discard", "", "", "discard","");?>
            </td>
          </tr>
        </table>
      </form>
    </div>
    <?php } ?>
    <div class="reply_top bgF1F4F8">
      <ul>
        <li><a href="<?php echo $this->docroot;?>inbox/<?php echo $this->template->title;?>">Back to <?php echo $this->back; ?></a>&nbsp;|&nbsp;</li>
        <?php if($this->back!='Archive' && $this->back!='Sent Mails' ){?>
        <li><a href="<?php echo $this->docroot;?>inbox/moveto_archive/?mailid=<?php echo $replydata->sentmail_id;?>,&page=inbox/<?php echo $this->template->title;?>">Archive</a>&nbsp;|&nbsp;</li>
        <?php }?>
        </li>
        <li><a href="javascript:deletemail('<?php echo $replydata->sentmail_id;?>','inbox/<?php echo $this->template->title;?>');">Delete</a></li>
      </ul>
    </div>
  </div>
</div>

</div>
