<?php
/**
 * Defines the Answers Management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>

<form  id="search" name="search" action="<?php echo $this->docroot;?>admin_answers/commonsearch" method="get" class="out_f" enctype="multipart/form-data">
   <table class="ml-20 mt-20 mb-20">
   <tr>
   <td valign="top"><input type= "text" name = "search_value" id = "search_value" size = "40"  class="ml-5"/></td>
   <td class="pl-5"><?php   echo UI::btn_("Submit", "search", "Search Answers", "", "","search","search");?></td>
   </tr>
   <tr>
   <td><span class="quiet">   Ex:Question, Answer, Category..</span></td>
   </tr>
   </table>
</form>

<?php

if(count($this->template->manage_answer)>0)
{
foreach($this->template->manage_answer as $row)
{

?>
    
 <script>

 $(document).ready(function(){
	 $("#delete_<?php echo $row->answers_id;?>").click(function(){ $("#delete_form<?php echo $row->answers_id;?>").toggle("show") });
	 $("#close<?php echo $row->answers_id;?>").click( function(){  $("#delete_form<?php echo $row->answers_id;?>").hide("slow");  });
	 $("#cancel<?php echo $row->answers_id;?>").click( function(){  $("#delete_form<?php echo $row->answers_id;?>").hide("slow");  });
 });
</script>
	  	<div class="span-14 border_bottom ">
		<div class="span-14" >
        
		<div class="span-2">
		<?php Nauth::getPhoto($row->user_id,$row->name); //get the user photo?>
		</div>

			<div class="span-11">
			<p class="span-11"> <?php echo nl2br(htmlspecialchars_decode($row->answer));?> <br></p>

			<div class="v_align fl">
			<ul class="inlinemenu" >
			<li>
			<?php 
			 if(($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
			 {
			   echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->answers_id."","del"); 
			 }
			 ?>
			 	 

			</li>
			<li>
			<?php 
			 if(($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
			 {
			         
			         if($row->status==0)
			         {
			         ?>			 
			         <?php echo UI::btn_("button", "block", "Block", "", "javascript:window.location='".$this->docroot."admin_answers/answer_access?status=1&id=".$row->answers_id."'", "","Block");?>
			         <?php }
			         else
			         {?>
			         
			         <?php echo UI::btn_("button", "Unblock", "Un block", "", "javascript:window.location='".$this->docroot."admin_answers/answer_access?status=0&id=".$row->answers_id."'", "","Unblock");?>
			        <?php } 
			
			}
			?>

			</li>
			</ul>
			</div>
	<!-- div for delete answer -->
		<div id="delete_form<?php echo $row->answers_id;?>" class="delete_alert" style="clear:both;">
		<h3 class="delete_alert_head">Delete Answer</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->answers_id;?>"  ></span>
		<div >Are you sure want to delete this answer? </div>
		
		<div> 
		
		 <?php 
		 echo UI::btn_("button", "delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_answers/delete_answer/?aid=".$row->answers_id."&qid".$row->id."'", "","delete");?>  
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$row->answers_id."","cancel"); ?>
		</div>
		
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
if($this->total_admin_answer >10)
{
?>
<div class="fr">
<?php echo $this->template->pagination;?>
</div>

<?php 
}
?>

