<div class="span-15 pb5" >
<div class="span-2 mr_fl_l text-align">
  <?php
		//Nauth::getPhotoNameHor($this->row->u_id,$this->row->name);
Nauth::getPhoto($this->row->u_id, $this->row->name);
?>
</div>
<div class="span-12 fl">
  <?php
 echo new View($this->row->mod_name."_mod_view");
?>
  <div class="span-14 f1 pb5" > <span class="quiet">
    <?php  		//print the date 
			 echo common::getdatediff($this->row->date); ?>
    - </span>
    <!-- script for jquery display -->
    <script type="application/javascript" language="javascript">
			$(document).ready(
			function()
			{
				$("#comment<?php echo $this->row->id; ?>").click(function()
			    	{
				$("#comment_content<?php echo $this->row->id; ?>").toggle("slow");
				});

				$("#comment_show<?php echo $this->row->id; ?>").click(function()
			    	{
				$("#cmd_content<?php echo $this->row->id; ?>").toggle("slow");
				});
				$("#comment_hide<?php echo $this->row->id; ?>").click(function()
			    	{
				$("#cmd_content<?php echo $this->row->id; ?>").hide("slow");
				});
				
			});
			</script>
    <?php		
$isfriend = common::is_friend($this->template->id);
if($isfriend)
{?>
    <img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/comment.gif" /> <a href="javascript:;" id="comment<?php echo $this->row->id; ?>" class="less_link">Comment</a>
    <?php 
			/* function check the count for comment if(count>0) show comment will show */
			if(count($this->model->comment_count($this->row->id))>=1) 
			{
			?>
    <span class="quiet"> - </span> <a href="javascript:;" id="comment_show<?php echo $this->row->id; ?>" class="less_link">Show/Hide Comment</a>
    <?php }  ?>
    <!-- function to check for LIKE -->
    <span class="quiet"> - </span>
    <?php  if(count($this->model->up_like($this->row->id,$this->user_id))>=1) 
				{ ?>
    <a href="javascript:;" id="comment_like<?php echo $this->row->id; ?>"  onclick="showlike(<?php echo $this->row->id ?>, <?php echo $this->user_id ?>, this.innerHTML)" class="less_link">Unlike</a><br/>
    <?php
				 }
				 else
				 {     ?>
    <img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/thumb_up.png" /> 				 
    <a href="javascript:;" id="comment_like<?php echo $this->row->id; ?>"  onclick="showlike(<?php echo $this->row->id ?>,<?php echo $this->user_id ?>,this.innerHTML)" class="less_link">Like</a><br/>
    <?php } ?>
    <!-- Like show here -->
    <div id="upd_like<?php echo $this->row->id;?>"  >
      <?php 
				$this->show_like=$this->model->show_like($this->row->id); 
				if(count($this->show_like) <=5	)
				{
					$names= '';
					if(count($this->show_like))
					{	
						foreach($this->show_like as $r)
						{
						//print_r($r);
						//$names.= ucfirst($r->name).",";
						$names.= Nauth::print_name($r->id, $r->name).",";
						}
						$names=substr($names,0,-1);
						echo $names;
						if(count($this->show_like) >1)
						echo  " are likes this";
						else
						echo  " likes this"; 
					}
				}
				else
				{
					echo count($this->show_like)." People like this";
				}?>
    </div>
  </div>
  <!-- Like Ends Here -->
  <!-- commented contents -->
  <?php }
?>
  <?php
 	$this->com=$this->model->show_upd($this->row->id); 
?>
  <div id="cmd_content<?php echo $this->row->id; ?>">
    <?php 
			/* for getting posted updates comments */
			if(count($this->com)>0)
			{
			?>
    <!-- 	<div class="span-11 border_full box">-->
    <?php 
			foreach($this->com as $com) 
			{
			//print_r($com);
	 ?>
    <div class="m0 span-11  box border_bottom" style="border-color:white; border: 2px solid white;"  >
      <!-- display user name and photo -->
      <div class="span-2 mr_fl_l text-align">
        <?php	/* Nauth::getPhotoNameHor($com->user_id,$com->name); */ Nauth::getPhoto($com->user_id);	?>
      </div>
      <script type="application/javascript" language="javascript">
				$(document).ready(
				function()
				{
				$("#delete_form<?php echo $com->id;?>").click(function()
				{
				$("#delete_form_show<?php echo $com->id;?>").toggle("slow");
				});
				$("#cancel<?php echo $com->id;?>").click(function()
				{
				$("#delete_form_show<?php echo $com->id;?>").hide("slow");
				});
				$("#close<?php echo $com->id;?>").click(function()
				{
				$("#delete_form_show<?php echo $com->id;?>").hide("slow");
				});
				});
				</script>
      <div class="span-9 last">
        <!-- display description -->
        <p>
          <?php Nauth::print_name($com->user_id, $com->name); ?>
          <span class="quiet">says</span> <?php echo htmlspecialchars_decode($com->desc);?> </p>
        <?php  
				/* DATE FORMATE */
				 echo " <span class='quiet'> ". common::getdatediff($com->date); 
                                 echo " - </span>&nbsp;";
				/* FUNCTION CHECK DELETE PERMISSION */
				if($this->user_id==$com->user_id || $this->user_id==$com->owner_id )
				 { ?>
        <a href="javascript:;" id="delete_form<?php echo $com->id;?>" class="less_link" title="delete"  >Delete</a>
        <div id="delete_form_show<?php echo $com->id;?>" class="width300 delete_alert clear ml-10 mb-10">
          <h3 class="delete_alert_head" >Delete Comment</h3>
          <span class="fr"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $com->id;?>"></span>
          <div class="clear fl">Are you sure you want to delete this comment? </div>
          <div class="clear fl mt-10">
            <?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:del_comment(".$com->id.",".$this->row->id.")", "delete_com","");?>
            <?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$com->id."","");?>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
    <?php } // For Loop ?>
    <!-- </div>-->
    <?php } // If condition?>
  </div>
  <!-- commented contents Ends Here -->
  <!-- div display post comment text box -->
  <!-- if update have comment it wil show the "leave comment text form" otherwise it wil hide" -->
  <?php 
  if($isfriend)
  {
  if(count($this->com))
				{ ?>
  <div id="comment_content<?php echo $this->row->id; ?>" class="">
    <?php }
				else
				{ ?>
    <div id="comment_content<?php echo $this->row->id; ?>" class=" hide">
      <?php } ?>
      <form name="comment" action="" method="post" >
        <textarea id="coment_text<?php echo $this->row->id; ?>" name="comenttext" rows="1" class="span-11" onfocus="clear_text(this)" onkeypress="return imposeMaxLength(this,event,<?php echo $this->row->id; ?>);" style="height:20px;" ></textarea>
        <div class="span-5 append-bottom">
          <?php   echo UI::btn_("Button", "coment_button", "Comment", "", "show_comment(".$this->row->id.",document.getElementById('coment_text".$this->row->id."').value);","coment_button".$this->row->id);?>
          <span id="limits<?php echo $this->row->id; ?>" class="quiet">Max 140 characters</span> </div>
      </form>
    </div>
    <?php 
   }
   ?>
  </div>
</div>
<hr   />
