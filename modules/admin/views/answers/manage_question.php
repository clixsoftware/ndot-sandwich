<?php
/**
 * Defines all the question management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>
<script language="javascript">
function delete_one(id)
{

var answer = confirm ("Are you want to delete?")
if (answer)
{
window.location="<?php echo $this->docroot;?>admin_answers/delete_question/?id="+id;
}
}
</script>

<?php
if(count($this->template->manage_question)>0)
{
foreach($this->template->manage_question as $row)
{
?>

 <script>
 $(document).ready(function(){
	
	 $("#delete_<?php echo $row->id;?>").click(function(){ $("#delete_form<?php echo $row->id;?>").toggle("show") });
	 $("#close<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });
 });
 </script>
<div class="span-14 border_bottom">
<div class="span-2" >
<?php Nauth::getPhoto($row->user_id,$row->name); //get the user photo ?>

</div>

<div class="span-11">
<p class="span-11">  
<a href="<?php echo $this->docroot;?>answers/view/?<?php echo url::title($row->question).'_'.$row->question; ?>"><?php echo $row->question;?></a><br>
</p>

<div class="v_align fl mt-10">
<ul class="inlinemenu" >
<li>

<?php 
 if(($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
 {
 echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->id."","del"); } ?>
</li>
<li>

<?php 
                    if( ($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	            {
			 if($row->status==0)
			 {
			 ?>			 
			 <?php echo UI::btn_("button", "block", "Block", "", "javascript:window.location='".$this->docroot."admin_answers/question_access?status=1&id=".$row->id."'", "","Block");?>
			 <?php }
			 else
			 {?>
			 
			 <?php echo UI::btn_("button", "Unblock", "Un block", "", "javascript:window.location='".$this->docroot."admin_answers/question_access?status=0&id=".$row->id."'", "","Unblock");?>
			<?php } 
		    }
			?>

 </li>
</ul>
</div>
<!-- for delete -->
		<div id="delete_form<?php echo $row->id;?>" class="delete_alert" style="clear:both;">
		<h3 class="delete_alert_head">Delete Question</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->id;?>"  ></span>
		<div >Are you sure to delete this question? </div>
		<div> 
		<?php echo UI::btn_("button", "delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_answers/delete_question/?id=".$row->id."&qid".$row->id."'", "","delete");?>  
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancell".$row->id."","cancel"); ?>
		
		
		
		</div>
		</div>
</div>
</div>


 <?php 
 }
 ?>
 
 
<?php 

}

else
{
        echo UI::nodata_();
}
?>

<?php 
if($this->total_admin_question >10)
{
?>
<div style="float:right;">
<?php echo $this->template->pagination;?>
</div>
<?php 
}
?>


