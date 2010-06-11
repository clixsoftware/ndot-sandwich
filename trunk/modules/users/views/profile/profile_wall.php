<?php
/**
 * Defines the profile wall information.
 *
 * @package    Core
 * @author     saranraj.c
 * @copyright  (c) 2010 Ndot.in
 **/

//user wall
?>
<script language="javascript">
	$(document).ready(function()
	{
		//for create form validation
		$("#profile_wall").validate();
		

	});
</script>

<script src="<?php echo $this->docroot;?>/public/js/maxlen.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>/public/js/jquery.jgrow-0.4.min.js" type="text/javascript"></script>
<script language="javascript">
$("textarea#wall_message").jGrow({
	max_height: "300px"
});
</script>
<?php
  foreach ($this->template->info_permission as $mod)
    {
    $email = $mod->email;
    $dob = $mod->dob;
    $phone = $mod->phone;
    $mobile = $mod->mobile;    
    $userid = $mod->user_id;
    
    }
    if($this->get_friend_id->count() > 0)
    {
            foreach($this->get_friend_id as $fid)
            {
                $friend_id = $fid->user_id;
                $mod_friend_id = $fid->friend_id;
            }
    }
    else
    {
        $friend_id = '';
        $mod_friend_id = '';
    }
    if($this->template->module_permission->count() > 0)
    {
                foreach($this->template->module_permission as $permission)
                {
                        $profile = $permission->wall;
                        $mod_userid = $permission->user_id;
                }
    }


$profile_id=$this->profile_info["mysql_fetch_array"]->id;

//everyone
if($this->userid && $profile_id == 1)
{
//$profile_id=$this->profile_info["mysql_fetch_array"]->id;

?>
    <div class="span-14a  mt-20" >
   
    <div class="wall_post ">
    <!-- Post the wall -->
    <strong class="fl">Post on <?php echo $this->profile_info["mysql_fetch_array"]->name;?>'s Wall :</strong> 
 
	 
	<form action="<?php echo $this->docroot ;?>profile/post_wall" name="profile_wall" id="profile_wall" method="post"  id="wall" >
	<input type="hidden" name="userid" value="<?php echo $this->profile_info['mysql_fetch_array']->id;?>">
	<table border="0" cellpadding="5" cellspacing="2" align="center" class="clear" width="100%">
	<tr><td ><textarea rows="2" name="wall_message" id="wall_message"   onkeypress="return MaxLength(this,event);" class="required span-14" title="Enter the Wall Text"></textarea></td></tr>
     <tr><td>  <span id="limits_count" class="fl">Max 140 characters</span>  <p class="fr mr-15">
			<?php echo UI::btn_("Submit", "wall", "Post on Wall","","","wall","wall");?>
          </p>
</td></tr>
	 
	</table>
	</form>
    </div>
<div class="pho_topn clear fl"> </div>
	<div class="span-14 "  >
	<?php
	if(count($this->profile_wall)>0)
	{
		foreach($this->profile_wall as $wall)
		{
		
		?>
		<script>
                $(document).ready(function(){
                $("#reply_wall<?php echo $wall->wall_id; ?>").click(function(){
                $("#post_wall_reply<?php echo $wall->wall_id; ?>").toggle("slow");
                });
                
                //delete wall
        
        $("#delete_<?php echo $wall->wall_id;?>").click(function(){ $("#delete_form<?php echo $wall->wall_id;?>").toggle("show") });
 $("#close<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 $("#cancell<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 
                });
                </script>
        
		<div class="span-16 f1 border_bottom  pt-20 pb-20" > 
	    
		<div class="span-2  f1 text-align"> 
		<?php Nauth::getPhoto($wall->poster_id,$wall->name,$wall->user_photo); //get the user photo?>
		</div>
	    
		<div class="span-13 f1 ">
		<p >
		<?php echo nl2br(htmlspecialchars_decode($wall->wall_text));?> 
		</p>
		
		<div class="inlinemenu">
		<ul>
		<li><?php Nauth::print_name($wall->poster_id,$wall->name); ?></li>
		
		<li><span class="quiet">On</span> <?php echo common::getdatediff($wall->wall_date);?></li>
		<?php 
		 if($wall->receiver_user_id==$this->userid || $wall->poster_id==$this->userid)
                 {
		?>
		<li><a href="javascript:;" title="Delete wall" id="delete_<?php echo $wall->wall_id; ?>">Delete</a></li>
        
		<?php } ?>
         <?php
            //reply the wall
            if($wall->receiver_user_id==$this->userid)
            {
            ?>
           
           <li> <a href="javascript:;" id="reply_wall<?php echo $wall->wall_id;?>" title="reply">Reply</a></li>
            <?php } ?>
            </ul>
		</div>
	    
		</div>
	        
                        <!-- div for delete DISCUSSION -->
		        <div id="delete_form<?php echo $wall->wall_id;?>" class="delete_alert ml-70 clear">
		        <h3 class="delete_alert_head">Delete Wall</h3>
		        <span class="fl">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $wall->wall_id;?>"> </span>
		        <div class="clear mb-10">Are you sure want to delete this Wall? </div>
		        <div> 
		       
		       
<?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."profile/delete_wall/?id=".$wall->wall_id."&uid=".$this->template->id."'", "delete_com","new_q");?>  
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$wall->wall_id."","new_q");?>
    
		        </div>
		        </div>
		        
	       
            <?php 
			
			echo UI::btn_("Click", "drop", "Reply", "", "","reply_wall".$wall->wall_id,"");?>
            
	   <script language="javascript">
	$(document).ready(function()
	{
		//for create form validation
		$("#wall_frm<?php echo $wall->wall_id; ?>").validate();
		

	});
</script>
            <div id="post_wall_reply<?php echo $wall->wall_id; ?>" class="span-18 hide">
            <form action="<?php echo $this->docroot;?>profile/reply_wall" name="wall_frm<?php echo $wall->wall_id; ?>" method="post"  id="wall_frm<?php echo $wall->wall_id; ?>">
            <input type="hidden" name="poster_id" value="<?php echo $this->input->get('uid');?>">
            <input type="hidden" name="receiver_id" value="<?php echo $wall->poster_id;?>">
            <table border="0" cellpadding="5" cellspacing="3"  class="ml-70">
            <tr><td>
            <textarea rows="1" name="reply_message" id="reply_message<?php echo $wall->wall_id; ?>" class="w_ptexa span-10" onkeypress="return Count_MaxLength(this,event,'limits_count<?php echo $wall->wall_id; ?>');" class="required"></textarea></tr>
            <tr><td>  <span id="limits_count<?php echo $wall->wall_id; ?>" class="fl">Max 140 characters</span>
            <tr><td class="fr">
             <?php   echo  UI::btn_("Submit", "coment_button", "Post Reply", "", "","wall_frm".$wall->wall_id,"wall_frm".$wall->wall_id);
             
             //echo  UI::btn_("Click", "coment_button", "Post Reply", "", "valid_check('reply_message$wall->wall_id','wall_frm$wall->wall_id')","wall_frm".$wall->wall_id,"wall_frm".$wall->wall_id); ?>	
            </td></tr>
            </table>
            </form>
            </div>
            
            
            
		</div>
		<?php 
		}
	}
	else
	{ ?>
		<div class="no_data">No posts Available!</div>
	<?php 
	}
	?>

	<?php if(count($this->profile_wall)>1)
	{
	?>
		<div class="fr mt-10">
		 <?php  echo  UI::a_tag("more","more","More",$this->docroot."profile/wall/?id=$profile_id"); ?>
		</div>
	<?php
	}
	?>
	</div>

	</div>
<?php
}

//myself
elseif($profile_id == 0 && $this->userid == $mod_userid)
{

                ?>
                <div class="span-14a  mt-20" >
   
    <div class="wall_post ">
    <!-- Post the wall -->
    <strong class="fl">Post on <?php echo $this->profile_info["mysql_fetch_array"]->name;?>'s Wall :</strong> 
 
	 
	<form action="<?php echo $this->docroot ;?>profile/post_wall" name="profile_wall" id="profile_wall" method="post"  id="wall" >
	<input type="hidden" name="userid" value="<?php echo $this->profile_info['mysql_fetch_array']->id;?>">
	<table border="0" cellpadding="5" cellspacing="2" align="center" class="clear" width="100%">
	<tr><td ><textarea rows="2" name="wall_message" id="wall_message"   onkeypress="return MaxLength(this,event);" class="required span-14" title="Enter the Wall Text"></textarea></td></tr>
     <tr><td>  <span id="limits_count" class="fl">Max 140 characters</span>  <p class="fr mr-15">
			<?php echo UI::btn_("Submit", "wall", "Post on Wall","","","wall","wall");?>
          </p>
</td></tr>
	 
	</table>
	</form>
    </div>
<div class="pho_topn clear fl"> </div>
	<div class="span-14 "  >
	<?php
	if(count($this->profile_wall)>0)
	{
		foreach($this->profile_wall as $wall)
		{
		
		?>
		<script>
                $(document).ready(function(){
                $("#reply_wall<?php echo $wall->wall_id; ?>").click(function(){
                $("#post_wall_reply<?php echo $wall->wall_id; ?>").toggle("slow");
                });
                
                //delete wall
        
        $("#delete_<?php echo $wall->wall_id;?>").click(function(){ $("#delete_form<?php echo $wall->wall_id;?>").toggle("show") });
 $("#close<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 $("#cancell<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 
                });
                </script>
        
		<div class="span-16 f1 border_bottom  pt-20 pb-20" > 
	    
		<div class="span-2  f1 text-align"> 
		<?php Nauth::getPhoto($wall->poster_id,$wall->name,$wall->user_photo); //get the user photo?>
		</div>
	    
		<div class="span-13 f1 ">
		<p >
		<?php echo nl2br(htmlspecialchars_decode($wall->wall_text));?> 
		</p>
		
		<div class="inlinemenu">
		<ul>
		<li><?php Nauth::print_name($wall->poster_id,$wall->name); ?></li>
		
		<li><span class="quiet">On</span> <?php echo common::getdatediff($wall->wall_date);?></li>
		<?php 
		 if($wall->receiver_user_id==$this->userid || $wall->poster_id==$this->userid)
                 {
		?>
		<li><a href="javascript:;" title="Delete wall" id="delete_<?php echo $wall->wall_id; ?>">Delete</a></li>
        
		<?php } ?>
         <?php
            //reply the wall
            if($wall->receiver_user_id==$this->userid)
            {
            ?>
           
           <li> <a href="javascript:;" id="reply_wall<?php echo $wall->wall_id;?>" title="reply">Reply</a></li>
            <?php } ?>
            </ul>
		</div>
	    
		</div>
	        
                        <!-- div for delete DISCUSSION -->
		        <div id="delete_form<?php echo $wall->wall_id;?>" class="delete_alert ml-70 clear">
		        <h3 class="delete_alert_head">Delete Wall</h3>
		        <span class="fl">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $wall->wall_id;?>"> </span>
		        <div class="clear mb-10">Are you sure want to delete this Wall? </div>
		        <div> 
		       
		       
<?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."profile/delete_wall/?id=".$wall->wall_id."&uid=".$this->template->id."'", "delete_com","new_q");?>  
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$wall->wall_id."","new_q");?>
    
		        </div>
		        </div>
		        

            
	   <script language="javascript">
	$(document).ready(function()
	{
		$("#wall_validate<?php echo $wall->wall_id; ?>").validate();
		

	});
</script>
            <div id="post_wall_reply<?php echo $wall->wall_id; ?>" class="span-18 ">
            <form action="<?php echo $this->docroot;?>profile/reply_wall" name="wall_validate<?php echo $wall->wall_id; ?>" method="post"  id="wall_validate<?php echo $wall->wall_id; ?>">
            <input type="hidden" name="poster_id" value="<?php echo $this->input->get('uid');?>">
            <input type="hidden" name="receiver_id" value="<?php echo $wall->poster_id;?>">
            <table border="0" cellpadding="5" cellspacing="3"  class="ml-70">
            <tr><td>
            <textarea rows="1" name="reply_message" id="reply_message<?php echo $wall->wall_id; ?>"  onkeypress="return Count_MaxLength(this,event,'limits_count<?php echo $wall->wall_id; ?>');" class="required w_ptexa span-10"></textarea></tr>
            <tr><td>  <span id="limits_count<?php echo $wall->wall_id; ?>" class="fl">Max 140 characters</span>
            <tr><td class="fr">
             <?php  
             echo  UI::btn_("Submit", "coment_button", "Post Reply", "", "","wall_frm","wall_frm");
 ?>	
            </td></tr>
            </table>
            </form>
            </div>
            
            
            
		</div>
		<?php 
		}
	}
	else
	{ ?>
		<div class="no_data">No posts Available!</div>
	<?php 
	}
	?>

	<?php if(count($this->profile_wall)>1)
	{
	?>
		<div class="fr mt-10">
		 <?php  echo  UI::a_tag("more","more","More",$this->docroot."profile/wall/?id=$profile_id"); ?>
		</div>
	<?php
	}
	?>
	</div>

	</div>
                
                <?php
}

//friend
elseif((($friend_id == $this->userid || $mod_friend_id == $this->userid) && $profile == -1))  //|| $this->userid == $userid)
{
        ?>
        <div class="span-14a  mt-20" >
   
    <div class="wall_post ">
    <!-- Post the wall -->
    <strong class="fl">Post on <?php echo $this->profile_info["mysql_fetch_array"]->name;?>'s Wall :</strong> 
 
	 
	<form action="<?php echo $this->docroot ;?>profile/post_wall" name="profile_wall" id="profile_wall" method="post"  id="wall" >
	<input type="hidden" name="userid" value="<?php echo $this->profile_info['mysql_fetch_array']->id;?>">
	<table border="0" cellpadding="5" cellspacing="2" align="center" class="clear" width="100%">
	<tr><td ><textarea rows="2" name="wall_message" id="wall_message"   onkeypress="return MaxLength(this,event);" class="required span-14" title="Enter the Wall Text"></textarea></td></tr>
     <tr><td>  <span id="limits_count" class="fl">Max 140 characters</span>  <p class="fr mr-15">
			<?php echo UI::btn_("Submit", "wall", "Post on Wall","","","wall","wall");?>
          </p>
</td></tr>
	 
	</table>
	</form>
    </div>
<div class="pho_topn clear fl"> </div>
	<div class="span-14 "  >
	<?php
	if(count($this->profile_wall)>0)
	{
		foreach($this->profile_wall as $wall)
		{
		
		?>
		<script>
                $(document).ready(function(){
                $("#reply_wall<?php echo $wall->wall_id; ?>").click(function(){
                $("#post_wall_reply<?php echo $wall->wall_id; ?>").toggle("slow");
                });
                
                //delete wall
        
        $("#delete_<?php echo $wall->wall_id;?>").click(function(){ $("#delete_form<?php echo $wall->wall_id;?>").toggle("show") });
 $("#close<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 $("#cancell<?php echo $wall->wall_id;?>").click( function(){  $("#delete_form<?php echo $wall->wall_id;?>").hide("slow");  });
 
                });
                </script>
        
		<div class="span-16 f1 border_bottom  pt-20 pb-20" > 
	    
		<div class="span-2  f1 text-align"> 
		<?php Nauth::getPhoto($wall->poster_id,$wall->name,$wall->user_photo); //get the user photo?>
		</div>
	    
		<div class="span-13 f1 ">
		<p >
		<?php echo nl2br(htmlspecialchars_decode($wall->wall_text));?> 
		</p>
		
		<div class="inlinemenu">
		<ul>
		<li><?php Nauth::print_name($wall->poster_id,$wall->name); ?></li>
		
		<li><span class="quiet">On</span> <?php echo common::getdatediff($wall->wall_date);?></li>
		<?php 
		 if($wall->receiver_user_id==$this->userid || $wall->poster_id==$this->userid)
                 {
		?>
		<li><a href="javascript:;" title="Delete wall" id="delete_<?php echo $wall->wall_id; ?>">Delete</a></li>
        
		<?php } ?>
         <?php
            //reply the wall
            if($wall->receiver_user_id==$this->userid)
            {
            ?>
           
           <li> <a href="javascript:;" id="reply_wall<?php echo $wall->wall_id;?>" title="reply">Reply</a></li>
            <?php } ?>
            </ul>
		</div>
	    
		</div>
	        
                        <!-- div for delete DISCUSSION -->
		        <div id="delete_form<?php echo $wall->wall_id;?>" class="delete_alert ml-70 clear">
		        <h3 class="delete_alert_head">Delete Wall</h3>
		        <span class="fl">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $wall->wall_id;?>"> </span>
		        <div class="clear mb-10">Are you sure want to delete this Wall? </div>
		        <div> 
		       
		       
<?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."profile/delete_wall/?id=".$wall->wall_id."&uid=".$this->template->id."'", "delete_com","new_q");?>  
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$wall->wall_id."","new_q");?>
    
		        </div>
		        </div>
		        
	       
            <?php //echo UI::btn_("Click", "drop", "Reply", "", "","reply_wall".$wall->wall_id,"");?>
            
	   <script language="javascript">
	$(document).ready(function()
	{
		//for create form validation
		$("#wall_frm<?php echo $wall->wall_id; ?>").validate();
		

	});
</script>
            <div id="post_wall_reply<?php echo $wall->wall_id; ?>" class="span-18 hide">
            <form action="<?php echo $this->docroot;?>profile/reply_wall" name="wall_frm<?php echo $wall->wall_id; ?>" method="post"  id="wall_frm<?php echo $wall->wall_id; ?>">
            <input type="hidden" name="poster_id" value="<?php echo $this->input->get('uid');?>">
            <input type="hidden" name="receiver_id" value="<?php echo $wall->poster_id;?>">
            <table border="0" cellpadding="5" cellspacing="3"  class="ml-70">
            <tr><td>
            <textarea rows="1" name="reply_message" id="reply_message<?php echo $wall->wall_id; ?>" class="w_ptexa span-10" onkeypress="return Count_MaxLength(this,event,'limits_count<?php echo $wall->wall_id; ?>');" class="required"></textarea></tr>
            <tr><td>  <span id="limits_count<?php echo $wall->wall_id; ?>" class="fl">Max 140 characters</span>
            <tr><td class="fr">
             <?php  
             echo  UI::btn_("Submit", "coment_button", "Post Reply", "", "","wall_frm".$wall->wall_id,"wall_frm".$wall->wall_id);
             
             //echo  UI::btn_("Click", "coment_button", "Post Reply", "", "valid_check('reply_message$wall->wall_id','wall_frm$wall->wall_id')","wall_frm".$wall->wall_id,"wall_frm".$wall->wall_id); ?>	
            </td></tr>
            </table>
            </form>
            </div>
            
            
            
		</div>
		<?php 
		}
	}
	else
	{ ?>
		<div class="no_data">No posts Available!</div>
	<?php 
	}
	?>

	<?php if(count($this->profile_wall)>10)
	{
	?>
		<div class="fr mt-10">
		 <?php  echo  UI::a_tag("more","more","More",$this->docroot."profile/wall/?id=$profile_id"); ?>
		</div>
	<?php
	}
	?>
	</div>

	</div>
        <?php
}
else
{
        echo "<div class='noresults'>Because of privacy user block the Wall</div>";
}
?>
