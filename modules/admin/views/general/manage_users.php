<div class="notice"> Edit / Delete / Manage Users of your site. You can view <a href="">Site Analytics here</a>. </div>

<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/facebox/facebox.js" type="text/javascript"></script>
<link href="<?php echo $this->docroot;?>public/js/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script>
function setValue1(id) {
	document.getElementById('user_id').value = id;

}
function setuid(id) {
	document.getElementById('usr_id').value = id;

}

	function sentmail(){
  	var toid = document.getElementById("toid2").value;
	var fromid = document.getElementById("senderid").value;
	var subject = document.getElementById("subject").value;
	var message = document.getElementById("message").value;


	if(toid!='' && fromid!='' && subject!=''&& message!=''){
		var url = '/admin/sentmail?uid='+fromid+'&toid='+toid+'&sub='+subject+'&msg='+message;
		
		$.post(url,function(check){
			alert(check);
		$.facebox.close();
		$("#messagedisplay").show();

		$('#messagedisplay').innerHTML = check;
		$('#messagedisplay').animate({opacity: 1.0}, 3000)
      	$('#messagedisplay').fadeOut('slow');
		$("#sent_mail").hide('slow');

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
    <tr>
      <td colspan="2"><h1 class="boxtitle" id="heading" >Send Email</h1>
        <div id="heading">&nbsp;</div></td>
    </tr>
    <tr>
      <td class="label"><font >Subject :</font> </td>
      <td><input type="text" name="sub" id="sub"  style="width:307px;" class="textboxs"  onchange="document.getElementById('subject').value = this.value"/></td>
    </tr>
    <tr valign="top">
      <td class="label"><font >Details :</font> </td>
      <td><input type="hidden" id="toid2" name="toid2" value="" />
        <input type="hidden" id="senderid" value="<?php echo $this->userid;?>" />
        <textarea name="msg"  id="msg"  style="width:300px;" class="textboxs" rows="6" onchange="document.getElementById('message').value =this.value" ></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td> 
      <?php  echo UI::btn_("button", "sendEmail", "Send", "", "javascript:sentmail();","");?>
        </td>
    </tr>
  </table>
  <input type="hidden" id="subject" value="" />
  <input type="hidden" id="message" value="" />
</div>
<!-- End Email Box -->

<div class="span-15 border_bottom">
          <form name = "search" id = "search" action = "/admin/search_users/" method = "get">
            <table>
              <tr>
                <td valign="top">
                  <input type= "text" name="search_value"  id = "search_value" size = "40" title= "Search Blog " />
                  <div class="quiet">Ex:Enter the First Name, Last Name and Email</div></td>
                <td class="pl-10"><?php   echo UI::btn_("Submit", "vsearch", "Search", "", "","search","search");?></td>
              </tr>
            </table>
          </form>
        </div>
        
<?php
if(count($this->template->get_user)>0)
{
foreach($this->template->get_user as $row)
{

 ?>
<script>
	   $(document).ready(function(){
		 $("#edit_user<?php echo $row->id;?>").click( function(){  $("#edit_user_info<?php echo $row->id;?>").toggle("slow");  });
		 
		 $("#m_permission<?php echo $row->id;?>").click( function(){  $("#module_permission<?php echo $row->id;?>").toggle("slow");  });
		 
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
  <div  style="padding:5px;width:65px;float:left;"> <a href="/profile/index/<?php echo $row->id;?>">
    <?php Nauth::getPhoto($row->id,$row->name,$row->user_photo); //get the user photo?>
    </a> </div>
  <div  style=" float:left; padding:5px;" >
    <div>
      <?php Nauth::print_name($row->id, $row->name); ?>
    </div>

    <div class="v_align">
      <?php 
		 if($row->user_status == 1)
		 {
		 ?>
      <a href="/admin/user_access?status=0&id=<?php echo $row->id;?>"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" /> Block</a>
      <?php }
		 else
		 {?>
      <a href="/admin/user_access?status=1&id=<?php echo $row->id;?>"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" /> Un Block</a>
      <?php 
		 }
		 ?>
     &nbsp;&nbsp; <a href="#email_form" id="s_email" rel="facebox" onmouseover="javascript:setValue('<?php echo $row->id;?>','<?php echo $this->userid;?>');"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/mail.gif" title="Mail" style="margin:0px 2px 0px 2px;" /> Mail</a>&nbsp;&nbsp; <a href="javascript:;" id="delete_user<?php echo $row->id;?>" > <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/delete.gif" title="Delete" class="admin" /> Delete</a>&nbsp;&nbsp; 
     <a id="edit_user<?php echo $row->id;?>" style="cursor:pointer;"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/edit.gif" title="Edit" class="admin" style="vertical-align:middle;"/> Edit</a>
     &nbsp;&nbsp;
      <?php 
	  if( $row->user_type == -1){
	  ?>
	  			<a href="#user_status" id="u_id" rel="facebox" onmouseover="javascript:setValue1(<?php echo $row->id;?>)"> 
                	<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" style="color:red;" /> ADMIN </a>
	  	<?php 
		 }
		 elseif($row->user_type == -2){
		 ?>
      <a href="#user_status" id="u_id" rel="facebox" onmouseover="javascript:setValue1(<?php echo $row->id; ?>)"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" style="color:red;" /> MODERATOR </a>
      <?php }
		 else
		 {?>
      <a href="#user_status" id="u_id" rel="facebox" onmouseover="javascript:setValue1(<?php echo $row->id; ?>)"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" style="color:green;" /> USER </a>
      <?php 
		 }
		 ?>
         &nbsp;&nbsp;
         <a  href="javascript:;" id="m_permission<?php echo $row->id;?>" >
         <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/edit.gif" title="Edit" class="admin" style="vertical-align:middle;"/> Module Permission </a>
    </div>
   
   
    <!-- module permission -->
    
    <div id="module_permission<?php echo $row->id;?>" class="span-15 hide">
    <?php 
    $user_assigned_modules = $row->module_id; 
    $user_mod_id = explode(",",$user_assigned_modules)
    ?>
    <h3>Module Permission</h3>
    <form action="<?php echo $this->docroot;?>/admin/module_permission/" method="post" >
    	
    	<div style="width:auto;" class="mt-10">
     
      <?php foreach($this->get_user_role  as $role) { ?>  
        	<div style="margin:5px;" class="fl">
            	<input name="permission[]"  type="checkbox" value="<?php echo $role->module_id; ?>" <?php if(in_array($role->module_id,$user_mod_id))
			{ ?>checked="checked" <?php }?> />&nbsp;&nbsp;<label>
            	<?php echo ucfirst($role->members_type); ?></label>
            </div>
       <?php } ?>    
       <input type="hidden" name="usr_id" id="usr_id" value="<?php echo $row->id; ?>"/>
        </div>
        
        <div style="margin:auto; width:100px;">
        <?php   echo UI::btn_("Submit", "update", "Update", "", "","update","update");?>
        </div>
   
    </form>
    </div>
    
    
    
    <div id="edit_user_info<?php echo $row->id;?>" style="padding:5px;margin:2px;display:none;">
      <table border="0" cellpadding="5" cellspacing="5" width="100%">
        <form name="user_edit" method="post" action="<?php echo $this->docroot;?>/admin/edit_profile/">
          <input type="hidden" name="userid" value="<?php echo $row->id;?>"/>
          <tr>
            <td align="right"><label>Frist Name:</label></td>
            <td><input type="text" name="first_name" value="<?php echo $row->name;?>" class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Last Name:</label></td>
            <td><input type="text" name="last_name" value="<?php echo $row->last_name;?>"  class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Email:</label></td>
            <td><input type="text" name="email" value="<?php echo $row->email;?>"  class="t_width" readonly="yes"/></td>
          </tr>
          <tr>
            <td align="right"><label>Street:</label></td>
            <td><input type="text" name="street" value="<?php echo $row->street;?>"  class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>City:</label></td>
            <td><input type="text" name="city" value="<?php echo $row->city;?>" class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Country:</label></td>
            <td><select name="country" id="country" style="width:185px;">
                <option value="">-Select-</option>
                <?php foreach($this->country_list as $country){
		?>
                <option value="<?php echo $country->cid;?>" <?php if($country->cid == $row->country){ echo "selected";}?> > <?php echo $country->cdesc;?></option>
                <?php 
		}?>
              </select>
            </td>
          </tr>
          <tr>
            <td align="right"><label>Postcode:</label></td>
            <td><input type="text" name="postcode" value="<?php echo $row->post_code;?>" class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Phone:</label></td>
            <td><input type="text" name="phone" value="<?php echo $row->phone;?>" class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Mobile:</label></td>
            <td><input type="text" name="mobile" value="<?php echo $row->mobile;?>" class="t_width"/></td>
          </tr>
          <tr>
            <td align="right"><label>Date of Birth:</label></td>
            <td><input type="text" name="dob" value="<?php echo $row->dob;?>" id="dob" class="dob"/></td>
          </tr>
          <tr>
            <td align="right"><label>Gender:</label></td>
            <td><select name="gender" style="width:185px;">
                <option value="">Gender</option>
                <option value="Male" <?php if(strtolower($row->gender)=="male" ) { echo "selected";}?>>Male</option>
                <option value="Female" <?php if(strtolower($row->gender)=="female") { echo "selected";}?>>Female</option>
              </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td> <?php   echo UI::btn_("Submit", "update", "Update", "", "","update","update");?></td>
          </tr>
        </form>
      </table>
    </div>
    
    <!-- div for delete user -->
    <div id="delete_user_info<?php echo $row->id;?>" class="width400 delete_alert clear ml-10 mb-10 ">
      <h3 class="delete_alert_head">Delete User</h3>
      <span class="fr"> 
      <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->id;?>"  ></span>
      <div class="clear fl">Are you sure want to delete this user? </div>
    
      <div class="clear fl mt-10"> 
		 <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin/delete_user/?id=".$row->id."' ", "delete_user","");?>
        <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->id."","");?>
        
	</div>
		
    </div>
  </div>
</div>
<?php 
}
}
else
{
        echo UI::nodata_();
}
?>
<?php
	if($this->total_admin_user>10)
	{
	?>
                <div style="padding:5px;float:right;"> <?php echo $this->template->pagination;?> </div>
<?php
	}
	?>
    
    <div id="user_status" style="display:none;">
    <form action="" method="post" >
  <table width="100%" cellspacing="5">
    <tr>
      <td colspan="2"><h3 class="boxtitle" id="heading" >USER PERMISSION </h3>
        <div id="heading">&nbsp;</div></td>
         <td colspan="2">
          
        </td>
    </tr>   
     <tr>
      <td><input name="user"  type="checkbox" value="1"  /> User </td>
       <td><input name="moderator"  type="checkbox" value="-2"  /> Moderator </td>
    </tr>  
    <tr>
      <td>
      	<input name="admin"  type="checkbox" value="-1" /> Admin</td>
      <td></td>
    </tr> 
      
    <tr>
      <td></td>
      <td>
      <?php   echo UI::btn_("Submit", "update", "Update", "", "","update","update");?>
      <input type="hidden" name="user_id" id="user_id"/></td>
    </tr>
  </table>
</form>
</div>

   
