<!-- contents start -->
<script>
function delete_category(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_article/delete_category/?id='+id;
}
}
$(document).ready(function()
	{
		$("#addcat").validate();
	});
</script>

<form name="addcat" action="" method="post" id="addcat">
<table border="0" cellpadding="5">
<tr><td>Name:</td><td><input type="text" name="category_name" class="required"></td></tr>
<tr><td>&nbsp;</td><td>
<?php   echo UI::btn_("Submit", "add", "Add", "", "","add","addcat");?>
</td></tr>
</table>
</form>
<?php
						
if (count($this->result)!= 0)
{
	foreach($this->result as $row)
	{
				 
?>
 <script>
 $(document).ready(function(){
         $("#cat_<?php echo $row->category_id;?>").click(function(){ $("#edit_form_<?php echo $row->category_id;?>").toggle("slow"); });        
	 $("#delete_<?php echo $row->category_id;?>").click(function(){ $("#delete_form<?php echo $row->category_id;?>").toggle("show") });
	 $("#close<?php echo $row->category_id;?>").click( function(){  $("#delete_form<?php echo $row->category_id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->category_id;?>").click( function(){  $("#delete_form<?php echo $row->category_id;?>").hide("slow");  });
	 $(document).ready(function() 	{ $("#add_category<?php echo $row->category_id ?>").validate(); });
 });
 </script>

<div class="common_box_inner">
<br>
<span><?php echo $row->category_name;?></span><br>

<span>
<?php  echo UI::btn_("button", "edit", "Edit", "", "", "cat_".$row->category_id."","edit"); ?>
 &nbsp;
 <?php  echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->category_id."","delete"); ?>
</span>


<div id="edit_form_<?php echo $row->category_id;?>" style="display:none;">
<form name="add_category" action="" method="post" id = "add_category<?php echo $row->category_id ?>">
<table border="0" cellpadding="5">
<input type="hidden" name="category_id" value="<?php echo $row->category_id;?>">
<tr><td>Category:</td><td><input type="text" value="<?php echo $row->category_name;?>" name="category_name" class="required"></td></tr>
<tr><td>&nbsp;</td><td>
<?php   echo UI::btn_("Submit", "update", "Update", "", "","update","add_category");?>
</td></tr>
</table>
</form>
</div>
                 <!-- for delete -->
		<div id="delete_form<?php echo $row->category_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->category_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this category? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_article/delete_category/?id=".$row->category_id."' ", "delete_com","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->category_id."","");?>
		
		</div>
		</div>
		
		
		
		
</div>


  <?php } ?>

	<?php 
	//pagination
	if($this->article_category_count >15) 
	{
		echo $this->template->pagination;
	}
	?>

<?php
}
else
{
 ?>
<div class="no_data">No category Available</div>

<?php
 }
?>




