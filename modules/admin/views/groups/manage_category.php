<!-- contents start -->
<script>
function delete_category(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_groups/delete_category/?id='+id;
}

}
	$(document).ready(function()
	{
		$("#add_category").validate();
	});
	
</script>

<form name="add_category" action="" method="post" enctype="multipart/form-data" id="add_category">
<table border="0" cellpadding="5" cellspacing="5" class="mt-20 ml-20">
<input type="hidden" name="type" value="add">
<tr><td valign="top" align="top"><label>Name:</label></td><td><input type="text" name="category_name" class="required title" title="Enter the Category"></td></tr>
<tr><td>&nbsp;</td><td>
<?php  echo UI::btn_("Submit", "add_category", "Add", "", "", "add_category","add_category");?>
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
	 $("#cat_<?php echo $row->group_category_id;?>").click(function(){ $("#edit_form_<?php echo $row->group_category_id;?>").toggle("slow"); });
	 $("#delete_<?php echo $row->group_category_id;?>").click(function(){ $("#delete_form<?php echo $row->group_category_id;?>").toggle("show") });
	 $("#close<?php echo $row->group_category_id;?>").click( function(){  $("#delete_form<?php echo $row->group_category_id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->group_category_id;?>").click( function(){  $("#delete_form<?php echo $row->group_category_id;?>").hide("slow");  });
	 $(document).ready(function() 	{ $("#update_category<?php echo $row->group_category_id;?>").validate();	});
 });
 </script>

<div class="common_box_inner">

<table cellpadding="5" cellspacing="5" width="500" class="ml-20">
<tr width="290">
<td width="150"><?php echo $row->group_category_name;?></td>
<td width="50"><?php echo UI::btn_("button", "edit", "Edit", "", "", "cat_".$row->group_category_id."","edit");?></td>
<td width="100">
<?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->group_category_id."","del"); ?>

</tr>
</table>
<div id="edit_form_<?php echo $row->group_category_id;?>" style="display:none;">
<form name="update_category<?php echo $row->group_category_id;?>" action="" method="post"  id="update_category<?php echo $row->group_category_id;?>">
<table border="0" cellpadding="5">
<input type="hidden" name="type" value="update">
<input type="hidden" name="category_id" value="<?php echo $row->group_category_id;?>">
<tr><td>Category:</td><td><input type="text" value="<?php echo $row->group_category_name;?>" name="category_name" class="required title" title="Enter the Category"></td></tr>
<tr><td>&nbsp;</td><td><?php  echo UI::btn_("Submit", "update_category", "Update", "", "", "update_category","update_category".$row->group_category_id."");?></td></tr>
</table>
</form>
</div>
<!-- for delete -->
		<div id="delete_form<?php echo $row->group_category_id;?>" class="width400 delete_alert clear ml-10 mb-10 ">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->group_category_id;?>"  ></span>
		<div class="clear fl">Are you sure to delete this category? </div>
		<div class="clear fl mt-10"> 
		 <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_groups/delete_category/?id=".$row->group_category_id."' ", "delete_category","");?>
        <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->group_category_id."","");?>
        
		</div>
		</div>
		
</div>


  <?php } ?>

	<?php 
	//pagination
	if($this->category_count >15) 
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




