<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/compose.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo $this->docroot ?>public/css/jqdialog.css" rel="stylesheet" type="text/css" /> 
<script src="<?php echo $this->docroot;?>public/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jqdialog.min.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jqdialog.js" type="text/javascript"></script>
<script>

function deletemail(mid){
	
	
	var url = '/ajax/deletemailinbox?mid='+mid;
	$.post(url,function(check){ 
	$('#'+mid).remove();
	
	});
	}
	
	function movetoarchive(mid){
	
	var url = '/ajax/movearchive?mid='+mid;
	$.post(url,function(check){ 
	//alert(check);
		$('#'+mid).remove();
	
	
	});
	

	}
	function selectall() {
	
if(document.form1.scripts.length==undefined)
{
document.form1.scripts.checked=true;
}

for(var i=0; i < document.form1.scripts.length; i++){
if(!document.form1.scripts[i].checked)
{
document.form1.scripts[i].checked=true;
}
}

} 
function unselectall()
{
if(document.form1.scripts.length==undefined)
{
document.form1.scripts.checked=false;
}
for(var i=0; i < document.form1.scripts.length; i++){
if(document.form1.scripts[i].checked)
document.form1.scripts[i].checked=false;
}
}
function selectunread(uid) {
unselectall();
//alert(uid);
if(document.form1.scripts.length==undefined)
{
var readstatus=document.form1.scripts.id;
if(readstatus=='-1' || readstatus!=uid)
{
if(!document.form1.scripts.checked)
document.form1.scripts.checked=true;
}
}
for(var i=0; i < document.form1.scripts.length; i++){
var readstatus=document.form1.scripts[i].id;
//alert(readstatus);

if(readstatus=='-1' || readstatus!=uid)
{
if(readstatus!='3')
{
if(!document.form1.scripts[i].checked)

document.form1.scripts[i].checked=true;

}
}}

} 

function selectread(uid) {
unselectall();
//alert(uid);
if(document.form1.scripts.length==undefined)
{
var readstatus=document.form1.scripts.id;
if(readstatus=='3' || readstatus==uid)
{
if(!document.form1.scripts.checked)
document.form1.scripts.checked=true;
}
}
for(var i=0; i < document.form1.scripts.length; i++){
var readstatus=document.form1.scripts[i].id;
//alert(readstatus);
if(readstatus=='3' || readstatus==uid)
{
if(!document.form1.scripts[i].checked)
document.form1.scripts[i].checked=true;
}}
} 
	
	

function showmail(mid,uid)
{

	var url = '/ajax/readstatus?mid='+mid+'&uid='+uid;
	$.post(url,function(check){ 
	//alert(check);
	window.location = "/inbox/reply/?mailid="+mid; 
	});

return false;
}



$(document).ready(function(){

$("body div").highlight("you", { wordsOnly: true });

$('.responsedis').animate({opacity: 1.0}, 3000) 
      $('.responsedis').fadeOut('slow'); 
$('.responsetwo').hide();
	$('#deleteselect').click(function(){
	
  delete k;
	var val = [];
	k=0;
    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	 // alert(val[i]);
	 k=k+1;
	
    });
//	alert(k);
	if(k!=0)
	{
	//alert('ok');]
	
	// confirm dialog
	
		jqDialog.confirm("Are you sure want to click either of these buttons?",
			function() {
			delete_mail();
				},		// callback function for 'YES' button
			function() {
			  unselectall(); 
			
				}		// callback function for 'NO' button
		);
	

	}
	else
	{
	jqDialog.alert("No Message Has been selected");
	}
	delete k;	
	});

	
	
  $('#deleteselectone').click(function(){
  delete k;
	var val = [];
	k=0;
    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	 // alert(val[i]);
	 k=k+1;
	
    });
//	alert(k);
	if(k!=0)
	{
	// confirm dialog
	
		jqDialog.confirm("Are you sure want to click either of these buttons?",
			function() {
			delete_mail();
				},		// callback function for 'YES' button
			function() {
			  unselectall(); 
			
				}		// callback function for 'NO' button
		);
	}
	else
	{
	jqDialog.alert("No Message Has been selected");
	}
	delete k;	
	});
  
	$('#movetoarchive').click(function(){
  delete k;
	var val = [];
	k=0;
    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	 // alert(val[i]);
	 k=k+1;
	
    });
//	alert(k);
	if(k!=0)
	{
	// confirm dialog
	
		jqDialog.confirm("Are you sure want to click either of these buttons?",
			function() {
			moveto_archive();
				},		// callback function for 'YES' button
			function() {
			  unselectall(); 
			
				}		// callback function for 'NO' button
		);
	}
	else
	{
	jqDialog.alert("No Message Has been selected");
	}
	delete k;	
	});
  $('#movetoarchiveone').click(function(){
  delete k;
	var val = [];
	k=0;
    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	 // alert(val[i]);
	 k=k+1;
	
    });
//	alert(k);
	if(k!=0)
	{
	// confirm dialog
	
		jqDialog.confirm("Are you sure want to click either of these buttons?",
			function() {
			moveto_archive();
				},		// callback function for 'YES' button
			function() {
			  unselectall(); 
			
				}		// callback function for 'NO' button
		);
	}
	else
	{
	jqDialog.alert("No Message Has been selected");
	}
	delete k;	
	});
  
 });

	
	function delete_mail()
	{
	
	var val = [];
	k=0;

   	 $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	
	 k=k+1;
	 deletemail(val[i]);

   	 })
	setTimeout("location.reload(true);",1000);
	$('.responsetwo').text(k+'  The conversation has been deleted.');
	$('.responsetwo').show();
	$('.responsedis').hide();
	delete k;
	
	
	}	
	function moveto_archive()
	{
		var val = [];
	
	k=0;

    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
	
	 k=k+1;
	 movetoarchive(val[i]);

    })
	setTimeout("location.reload(true);",1000);
	$('.responsetwo').text(k+'  The conversation has been archived.');
	$('.responsetwo').show();
$('.responsedis').hide();
	delete k;
	}

	function loademailto(id,val){
if(val!=""){
		if(document.getElementById(id).value.indexOf(val+",")<0){
			document.getElementById(id).value = document.getElementById(id).value + val +',';
			document.getElementById(id).focus();
		}
	}
}

function hidemessage(id){ //alert(id);
$("#message_content"+id).hide();
$(".deleteout").show();
	//document.getElementById("message_content"+id).style = none;
}
	

</script>
 
<!-- contentstart javascript:window.location='login_profile/logout'; -->
 
<div class="span-19a ">
 
<!--leftsidenavigationstart-->
 
<form name="form1" method="post">
<!--leftsidenavigationfinish-->
<div class="span-19b">	

<!--select--all--read--menu--start---> 
<div class="overflowh border_bottom">
<div class="span-2" style="float:right;"><?php  echo UI::btn_("button", "compose_mail", "Compose", "button_com fr mt-10 mr-20 mb-10", "javascript:window.location='".$this->docroot."inbox/compose' ", "compose_mail","");?> </div>
<!--<div class="border_bottom overflowh"><input type="button" onclick="javacript:window.location='/inbox/compose'" value="Compose Mail" class="button_com fr mt-10 mr-20 mb-10" /></div>-->
</div>
<div class="mail_select">

<ul>
<li> <b class="sele">Select&nbsp;:&nbsp;</b></li>
<li><a href="javascript:onclick=selectall()">All</a>|</li>
<li><a href="javascript:onclick=unselectall()" > None </a>|</li>
<li><a href="javascript:onclick=selectread('<?php echo $this->uid; ?>')" >Read</a>|</li>
<li><a href="javascript:onclick=selectunread('<?php echo $this->uid; ?>')" >UnRead </a>|</li>
<li><a  id="deleteselect" href="javascript:;"> Delete </a>|</li>
<li><a  id="movetoarchive" href="javascript:;">Move to Archive</a></li>

</ul>
</div>
<!--select--all---read---menu--finish--->

<!-- from--subject--delect start-->

<div class="mail_select1 "  > 
<div class="title_2">Subject</div>
<div class="title_1">Sender</div>
<div class="title_3">Date</div>
</div>
<!-- from--subject--delect finish-->

<?php 
if (count($this->inboxdata)==0)
{
	if($this->searchvalue!=1)	
	 	UI::nodata_();
	else
		echo UI::noresults_();
}		
else
{
?>
<?php foreach($this->inboxdata as $inboxcontent)
{
if($inboxcontent->read_status==$this->uid && $inboxcontent->read_status!=3){
	echo ' <div class="span-19b overflowh"><div class="inner_mail pl-5" id="'.$inboxcontent->sentmail_id.'">';
}else{
echo ' <div class="span-19b  overflowh"><div class="inner_mail_unread border_bottom pt-10 pb-20  " id="'.$inboxcontent->sentmail_id.'">';
}
?>

<input name="scripts" type="checkbox" value="<?php echo $inboxcontent->sentmail_id;?>" id="<?php echo $inboxcontent->read_status;?>" class="check mr-5"/>
<div class="mail_con_out" onclick="showmail('<?php echo $inboxcontent->sentmail_id;?>','<?php echo $this->uid ?>')" >
<div class="s_d"><?php echo $inboxcontent->subject; ?> </div>
<div class="f_t"><span class="fl"><?php Nauth::getphoto($inboxcontent->id,$inboxcontent->name); ?></span> <div class="fl pt-0 pl-10 width135"><?php Nauth::print_name($inboxcontent->id,$inboxcontent->name); ?><p class="clear fl text_normal"><?php echo $inboxcontent->email; ?></p><p><?php if(!empty($inboxcontent->city))echo $inboxcontent->city?><?php if(!empty($inboxcontent->cdesc)) echo ', '.$inboxcontent->cdesc; ?></p></div></div>

<?php if(!empty($inboxcontent->ttitle))
{?>
<div class="d_o"><?php echo $inboxcontent->ttitle;?></div>
<?php }if(!empty($inboxcontent->gtitle))
{?>
<div class="d_o"><?php echo $inboxcontent->gtitle;?></div>
<?php }if(!empty($inboxcontent->etitle))
{?>
<div class="d_o"><?php echo $inboxcontent->etitle;?></div>
<?php }

?>
<div class="d_t"><?php echo $inboxcontent->dat;?><?php //echo common::getDateDiff($inboxcontent->mail_date);?></div></div>
<?php echo '</div></div>';?>
<?php }?>

<?php } ?>
<!---mail2 finish-->


<!--select--all--read--menu--start--->
<div class="span-19b"><?php if(count($this->inboxdata) > 0){ echo '<div class="pagination">' . $this->pagination->render('classic') .'</div>'; } ?>
</div>
<div class="mail_select bgF1F4F8">

<ul>
<li> <strong class="sele">Select&nbsp;:&nbsp;</strong></li>
<li><a href="javascript:onclick=selectall()">All</a>|</li>
<li><a href="javascript:onclick=unselectall()" > None </a>|</li>
<li><a href="javascript:onclick=selectread('<?php echo $this->uid; ?>')" >Read</a>|</li>
<li><a href="javascript:onclick=selectunread('<?php echo $this->uid; ?>')" >UnRead </a>|</li>
<li><a id="deleteselectone" href="javascript:;"> Delete </a>|</li>
<li><a id="movetoarchiveone" href="javascript:;">Move to Archive</a></li>
</ul>
</div>
</div></form>
</div>
