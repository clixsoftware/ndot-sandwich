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
window.location="<?php echo $this->docroot;?>admin/delete_question/?id="+id;
}
}
</script>

<?php
if(count($this->template->manage_question)>0)
{
foreach($this->template->manage_question as $row)
{
?>
<div class="common_box_inner">

<div class="common_photo_box">
<a href="<?php echo $this->docroot ;?>profile/index/<?php echo $row->user_id;?>" title="<?php echo $row->name;?>">
<?php Nauth::getPhoto($row->user_id,$row->name,$row->user_photo); //get the user photo ?>
</a>
</div>

<div class="common_cont_box">
<p class="common_box_c">  <a href="<?php echo $this->docroot;?>answers/view/?question_id=<?php echo $row->id; ?>&best_answer=0"><?php echo $row->question;?></a><br></p>

<div class="common_box_bl">
<ul>
<li>
<a href="javascript:onclick=delete_one('<?php echo $row->id; ?>')"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/delete.gif" title="Delete" class="admin" />Delete</a>
</li>
<li><?php 
 if($row->status==0)
 {
 ?>
 <a href="<?php echo $this->docroot;?>admin/question_access?status=1&id=<?php echo $row->id;?>"><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" />Block</a>
 <?php }
 else
 {?>
 <a href="<?php echo $this->docroot;?>admin/question_access?status=0&id=<?php echo $row->id;?>"><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" />Unblock</a>
 <?php 
 }
 ?></li>
</ul>
</div>

</div>
</div>


 <?php 
 }
 ?>
 
 </div>
 
  
<?php 

}

else
{
?>
<div class="no_data">
No Questions Found
</div>
<?php 
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


