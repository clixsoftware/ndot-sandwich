<!-- contents start -->
<script>
function delete_category(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_forums/delete_category/?id='+id;
}

}

$(document).ready(function()
	{
		$("#addcat").validate();
	});
</script>

<form name="addcat" action="" method="post" id="addcat">
<table border="0" cellpadding="5">
<tr><td align="right"><lable>Name:</label></td><td><input type="text" name="category_name" class="required"></td></tr>
<tr><td valign="top" align="right"><label>Description:</label></td>
<td><textarea name="category_description" cols="21" class="required"></textarea></td></tr>
<tr><td>&nbsp;</td><td>

<?php  echo UI::btn_("Submit", "add", "Add", "", "", "",""); ?>

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
 });
 </script>

<div class="common_box_inner border_bottom">
<span><?php echo $row->forum_category;?></span><br>
<span><?php echo $row->category_description;?></span><br>
<span>Total Discussion (<?php echo $row->total_discussion;?>)


<?php  echo UI::btn_("button", "edit", "Edit", "", "", "cat_".$row->category_id."","edit"); ?>
 &nbsp;
 <?php  echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->category_id."","delete"); ?>

</span>
<div id="edit_form_<?php echo $row->category_id;?>" style="display:none;">
<form name="add_category" action="" method="post">
<table border="0" cellpadding="5">
<input type="hidden" name="category_id" value="<?php echo $row->category_id;?>">
<tr><td>Name:</td><td><input type="text" value="<?php echo $row->forum_category;?>" name="category_name"></td></tr>
<tr><td style="vertical-align:top;">Description</td><td><textarea name="category_description" cols="21"><?php echo $row->category_description;?></textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" value="Update"></td></tr>
</table>
</form>
</div>
<!-- for delete -->
		<div id="delete_form<?php echo $row->category_id;?>" class="delete_alert" style="clear:both;">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->category_id;?>"  ></span>
		<div >Are you sure to delete this category? </div>
		<div> 
		
		<?php echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_forums/delete_category/?id=".$row->category_id."'", "","delete");?> 
		
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->category_id."","cancel"); ?>
		
		</div>
		</div>
</div>


  <?php } ?>

	<?php 
	//pagination
	if($this->forum_category_count >25) 
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




