<script src="<?php echo $this->docroot;?>/public/js/validation.js" type="text/javascript"></script>

<?php
/**
 * Defines all the wall message
 *
 * @package    Core
 * @author     saranraj.c
 * @copyright  (c) 2010 Ndot.in
 **/
//the wall
?>
<script src="<?php echo $this->docroot;?>/public/js/maxlen.js" type="text/javascript"></script>
<?php
if(count($this->wall)>0)
{
	foreach($this->wall as $wall)
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
  
        <div class="span-19 f1 border_bottom mt-20">
        
        <div class="span-2  f1 text-align">
        <?php Nauth::getPhoto($wall->poster_id,$wall->name,$wall->user_photo); //get the user photo?>
        </div>
    
        <div class="span-15 fl">
        
        <p><?php echo nl2br(htmlspecialchars_decode($wall->wall_text));?></p>
        
        <div class="span-18">
        <ul class="inlinemenu">
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
		        <input type="button" name="delete_com" id="delete_com" class="photo_delete fl mr-10" onclick="window.location='<?php echo $this->docroot;?>profile/delete_wall/?id=<?php echo  $wall->wall_id; ?>&uid=<?php echo $this->input->get('uid');?>'"  />
		        <input type="button" name="cancel" id="cancell<?php echo $wall->wall_id;?>"  class="pho_cancel " />
		        </div>
		        </div>
		        
       
            <div id="post_wall_reply<?php echo $wall->wall_id; ?>" class="span-18 hide">
            <form action="<?php echo $this->docroot;?>profile/reply_wall" name="wall_frm<?php echo $wall->wall_id; ?>" method="post"  id="wall_frm">
            <input type="hidden" name="poster_id" value="<?php echo $this->input->get("id");?>">
            <input type="hidden" name="receiver_id" value="<?php echo $wall->poster_id;?>">
            <table border="0" cellpadding="5" cellspacing="3"  class="ml-70">
<tr><td><textarea rows="3" name="reply_message" id="reply_message<?php echo $wall->wall_id; ?>" class="w_ptexa span-10" onkeypress="return Count_MaxLength(this,event,'limits_count<?php echo $wall->wall_id; ?>');"></textarea></tr>
            <tr><td>  <span id="limits_count<?php echo $wall->wall_id; ?>" class="fl">Max 140 characters</span>
            <tr><td class="fr">

             <?php  echo  UI::btn_("Click", "coment_button", "Post", "", "valid_check('reply_message$wall->wall_id','wall_frm$wall->wall_id')","wall_frm".$wall->wall_id); ?>	
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
<div style="padding:5px;">No walls Available</div>
<?php 
}
?>
	<?php
	//pagination
	if($this->total_wall>10)
	{
	?>
	<div style="float:left;width:600px;text-align:right;">
	<?php
	echo $this->template->pagination;
	?>
	</div>
	<?php } ?>
