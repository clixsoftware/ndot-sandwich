  <script>
	function sentmail(){
  	var toid = document.getElementById("toid2").value;
	var fromid = document.getElementById("senderid").value;
	var subject = document.getElementById("subject").value;
	var message = document.getElementById("message").value;

	//alert("to"+toid+"fromid"+fromid+"subject"+subject+"mess"+message);
	if(toid!='' && fromid!='' && subject!=''&& message!=''){
		var url = '/admin/sentmail?uid='+fromid+'&toid='+toid+'&sub='+subject+'&msg='+message;
		
		$.post(url,function(check){
			alert(check);
		$.facebox.close();
		$("#messagedisplay").show();
		 //document.getElementById("messagedisplay").innerHTML = check;
		$('#messagedisplay').innerHTML = check;
		$('#messagedisplay').animate({opacity: 1.0}, 3000)
      	$('#messagedisplay').fadeOut('slow');
		$("#sent_mail").hide('slow');
	//	$("#sent_mail").dialog('close');
    //	document.getElementById("sent_mail_reply").innerHTML = check;
		document.getElementById("toid2").value ='';
		document.getElementById("senderid").value = '';
		document.getElementById("subject").value='';
		document.getElementById("message").value='';
		return;
	    });
	}else{
		alert("Please Enter Subject & Message");
	}
  }
  

	
function setValue(fid,uid) {
	document.getElementById('toid2').value = fid;
	document.getElementById('senderid').value = uid;
}

$(document).ready(function(){
	date_obj = new Date();
    $(".dob").datepicker({dateFormat: $.datepicker.W3C });  
//face box
	jQuery(document).ready(function($) {
  	$('a[rel*=facebox]').facebox()
})

  });

 </script>


	<!-- Email Box -->
	 <div id="email_form" style="display:none;">
	
	 <table width="100%" cellspacing="5">
	 <tr><td colspan="2">
	 <h1 class="boxtitle" id="heading" >Send Email</h1>
	 <div id="heading">&nbsp;</div>
	 </td></tr>
	 <tr>
	 <td class="label">
	 <font >Subject :</font> </td><td><input type="text" name="sub" id="sub"  style="width:307px;" class="textboxs"  onchange="document.getElementById('subject').value = this.value"/></td>
	 </tr>
	 <tr valign="top">
	 <td class="label">
	 <font >Details :</font> </td><td>	<input type="hidden" id="toid2" name="toid2" value="" />
	<input type="hidden" id="senderid" value="<?php echo $this->userid;?>" />
	<textarea name="msg"  id="msg"  style="width:300px;" class="textboxs" rows="6" onchange="document.getElementById('message').value =this.value" ></textarea></td>
	 </tr>
	 <tr><td></td><td><input type="button" name="sendEmail" value="Send" id="send_Email" onClick="javascript:sentmail();" /></td></tr>
	 </table>
	 
	<input type="hidden" id="subject" value="" />
	<input type="hidden" id="message" value="" /></div>
	<!-- End Email Box -->


<?php
foreach($this->template->get_user as $row)
{

 ?>
         <script>
	   $(document).ready(function(){
		 $("#edit_user<?php echo $row->id;?>").click( function(){  $("#edit_user_info<?php echo $row->id;?>").toggle("slow");  });
	 $("#delete_user<?php echo $row->id;?>").click( function(){  $("#delete_user_info<?php echo $row->id;?>").toggle("slow");  }); 
	 $("#close<?php echo $row->id;?>").click( function(){  $("#delete_user_info<?php echo $row->id;?>").hide("slow");  });
	 $("#cancel<?php echo $row->id;?>").click( function(){  $("#delete_user_info<?php echo $row->id;?>").hide("slow");  });
//face box
	jQuery(document).ready(function($) {
  	$('a[rel*=facebox]').facebox()
})
	  });
	  </script>

      		<div  style="width:790px;margin:5px;float:left;border-bottom:1px solid #ccc;">

	  	<div  style="padding:5px;width:65px;float:left;">
		<a href="<?php echo $this->docroot;?>profile/index/<?php echo $row->id;?>">
		<?php Nauth::getPhoto($row->id,$row->name,$row->user_photo); //get the user photo?>
		</a>
		</div>
 
		<div  style=" float:left; padding:5px;" >
		<div>
		<a href="<?php echo $this->docroot;?>profile/index/<?php echo $row->id; ?>"><?php echo $row->name;?></a>
		</div>
<?php
//admin area
if($this->usertype==-1)
{
?>
		<div class="v_align">

		<?php 
		 
		 if($row->user_status==1)
		 {
		 ?>
		 <a href="<?php echo $this->docroot;?>admin/user_access?status=0&id=<?php echo $row->id;?>">
		<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" />Block</a>
		 <?php }
		 else
		 {?>
		  <a href="<?php echo $this->docroot;?>admin/user_access?status=1&id=<?php echo $row->id;?>">
		  <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" />Un Block</a>
		 <?php 
		 }
		 ?>

		   <a href="#email_form" id="s_email" rel="facebox" onmouseover="javascript:setValue('<?php echo $row->id;?>','<?php echo $this->userid;?>');">
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/mail.gif" title="Mail" style="margin:0px 2px 0px 2px;" />Mail</a>
		   <a href="javascript:;" id="delete_user<?php echo $row->id;?>" >
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/delete.gif" title="Delete" class="admin" />Delete</a>
		   <a id="edit_user<?php echo $row->id;?>" style="cursor:pointer;">
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/edit.gif" title="Edit" class="admin" style="vertical-align:middle;"/>Edit</a>
		   <?php 
		 if($row->user_type==-2)
		 {
		 ?>
		 <a href="<?php echo $this->docroot;?>admin/make_moderator?user_type=1&id=<?php echo $row->id;?>">
		  <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" />Deactive as Moderator</a>
		  
		 <?php }
		 else
		 {?>
		  <a href="<?php echo $this->docroot;?>admin/make_moderator?user_type=-2&id=<?php echo $row->id;?>">
		<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" />Active as Moderator</a>
		 <?php 
		 }
		 ?>

 </div>
<?php
}
else if($this->usertype==-2)
{ 
//moderator
?>
   <div  >

		<?php 
		//checking the block with moderator
		 if($this->moderator_block==1)
		 {
			 if($row->user_status==1)
			 {
			 ?>
			 <a href="<?php echo $this->docroot;?>admin/user_access?status=0&id=<?php echo $row->id;?>">
			<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" />Block</a>
			 <?php }
			 else
			 {?>
			  <a href="<?php echo $this->docroot;?>admin/user_access?status=1&id=<?php echo $row->id;?>">
			  <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" />Un Block</a>
			 <?php 
			 }
		 }
		 ?>
		   <a href="#email_form" id="s_email" rel="facebox" onmouseover="javascript:setValue('<?php echo $row->id;?>','<?php echo $this->userid;?>');">
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/mail.gif" title="Mail" style="margin:0px 2px 0px 2px;" />Mail</a>
		   <?php
		   //checking the edit with moderator
		   if($this->moderator_delete==1)
		   {
		   ?>
	
   <a href="javascript:;" id="delete_user<?php echo $row->id;?>" >
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/delete.gif" title="Delete" class="admin" />Delete</a>
		   <?php } ?>
		   
		   <?php
		   //checking the edit with moderator
		   if($this->moderator_edit==1)
		   {
		   ?>
		   <a id="edit_user<?php echo $row->id;?>" style="cursor:pointer;">
		   <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/edit.gif" title="Edit" class="admin" style="vertical-align:middle;"/>Edit</a>
		   <?php } ?>

 </div>
<?php 
}
else
{
}
?>


		 <div id="edit_user_info<?php echo $row->id;?>" style="padding:5px;margin:2px;display:none;">
		 <table border="0" cellpadding="5" cellspacing="5" width="100%">
		 <form name="user_edit" method="post" action="">
		 <input type="hidden" name="userid" value="<?php echo $row->id;?>"/>
		 <tr><td>Name</td><td><input type="text" name="first_name" value="<?php echo $row->name;?>" class="t_width"/></td></tr>
		 <tr><td>Full Name</td><td><input type="text" name="last_name" value="<?php echo $row->last_name;?>"  class="t_width"/></td></tr>
		 <tr><td>Email</td><td><input type="text" name="email" value="<?php echo $row->email;?>"  class="t_width" readonly="yes"/></td></tr>
		 <tr><td>Street</td><td><input type="text" name="street" value="<?php echo $row->street;?>"  class="t_width"/></td></tr>

		 <tr><td>City</td><td><input type="text" name="city" value="<?php echo $row->city;?>" class="t_width"/></td></tr>
		 <tr><td>Country</td><td>
		<select name="country" id="country" style="width:185px;">
		<option value="">-Select-</option>
		<?php foreach($this->country_list as $country){
		?>
		<option value="<?php echo $country->cid;?>" <?php if($country->cid == $row->country){ echo "selected";}?> > <?php echo $country->cdesc;?></option>
		<?php 
		}?>
		</select>
		</td></tr>
		 <tr><td>Postcode</td><td><input type="text" name="postcode" value="<?php echo $row->post_code;?>" class="t_width"/></td></tr>
		 <tr><td>Phone</td><td><input type="text" name="phone" value="<?php echo $row->phone;?>" class="t_width"/></td></tr>
		 <tr><td>Mobile</td><td><input type="text" name="mobile" value="<?php echo $row->mobile;?>" class="t_width"/></td></tr>

		 <tr><td>Date of Birth</td><td>
		 <input type="text" name="dob" value="<?php echo $row->dob;?>" id="dob" class="dob"/></td></tr>
		 <tr><td>Gender</td><td><select name="gender" style="width:185px;"><option value="">Gender</option>
		 <option value="Male" <?php if(strtolower($row->gender)=="male" ) { echo "selected";}?>>Male</option>
		 <option value="Female" <?php if(strtolower($row->gender)=="female") { echo "selected";}?>>Female</option>
		 </select></td></tr>
		 <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Update" /></td></tr>
		 </form>
		 </table>
		 </div>

		<!-- div for delete user -->
		<div id="delete_user_info<?php echo $row->id;?>" class="delete_alert">
		<h3 class="delete_alert_head">Delete Comment</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->id;?>"  ></span>
		<div >Are you sure want to delete this user? </div>
		<div> 
		<input type="button" name="delete_com" id="delete_com" value="Delete" onclick="window.location='<?php echo $this->docroot;?>admin/delete_user/?id=<?php echo $row->id;?>'"  />
		<input type="button" name="cancel" id="cancel<?php echo $row->id;?>"  value="Cancel" />
		</div>
		</div>
  </div>
  </div>

	<?php 
}
?>
	<?php
	if($this->total_admin_user>10)
	{
	?>
	<div style="padding:5px;float:right;">
	<?php echo $this->template->pagination;?>
	</div>
	<?php
	}
	?>

