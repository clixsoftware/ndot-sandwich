<?php
/**
 * Defines the Answers Management
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
window.location="<?php echo $this->docroot;?>admin/delete_answer/?id="+id;
}
}
</script>
<?php
foreach($this->template->manage_answer as $row)
{
?>
    
	  
<div class="common_box_inner">

<div class="common_photo_box">
<a href="<?php echo $this->docroot ;?>profile/index/<?php echo $row->user_id;?>" title="<?php echo $row->name;?>">
<?php Nauth::getPhoto($row->user_id,$row->name,$row->user_photo); //get the user photo?>
</a>
</div>

<div class="common_cont_box">
<p class="common_box_c"> <?php echo htmlspecialchars_decode($row->answer);?> <br></p>

<div class="common_box_bl">
<ul>
<li>
<a href="javascript:onclick=delete_one('<?php echo $row->answers_id; ?>')">
<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/delete.gif" title="Delete" class="admin" />Delete</a>
</li>
<li>
<?php 
 if($row->status==0)
 {
 ?>
 <a href="<?php echo $this->docroot;?>admin/answer_access?status=1&id=<?php echo $row->answers_id;?>"><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/block.gif" title="Block" class="admin" />Block</a>
 <?php }
 else
 {?>
 <a href="<?php echo $this->docroot;?>admin/answer_access?status=0&id=<?php echo $row->answers_id;?>"><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/unblock.gif" title="Unblock" class="admin" />Unblock</a>
<?php } ?>

</li>
</ul>
</div>

</div>
</div>

<?php 
}
?>

<?php 
if($this->total_admin_answer >10)
{
?>
<div style="padding:5px;float:right;">
<?php echo $this->template->pagination;?>
</div>
<?php 
}
?>

