<script>
$(document).ready(function(){$("#addcat").validate();});
</script>
<div class="mt-10 border_bottom">
<form name="addcat" action="/admin_videos/category" method="post" id="addcat">
<table cellpadding="5" cellspacing="5">
<tr>
<td><label>Category:</label></td>
<td><input type="text" name="category" class="required"></td>
</tr>
<tr>
<td></td>
<td >
<?php  echo UI::btn_("Submit", "cat", "Submit", "", "", "addcat","addcat");?>
</td>
</tr>
</table>
</form>
<b><br><h3>All Category</b></h3>
<?php  if(count($this->template->get_cate)>0)
 { 
		
		foreach($this->template->get_cate as $row)
		{
?>
<script>
 $(document).ready(function(){
 			$("#edit_<?php echo $row->cat_id;?>").click(function(){ $("#edit_info_<?php echo $row->cat_id;?>").toggle("slow"); });
			 $("#delete_<?php echo $row->cat_id;?>").click(function(){ $("#delete_form<?php echo $row->cat_id;?>").toggle("show") });
			 $("#close<?php echo $row->cat_id;?>").click( function(){  $("#delete_form<?php echo $row->cat_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->cat_id;?>").click( function(){  $("#delete_form<?php echo $row->cat_id;?>").hide("slow");  });
 });
 </script>
<table>
<tr width="400">
<td width="200"><?php echo $row->category;?></td>
<td width="100">
<?php  echo UI::btn_("button", "edit", "Edit", "", "", "edit_".$row->cat_id."","edit"); ?>

</td>

<td width="100">
 <?php  echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->cat_id."","delete"); ?>

<!-- a href="javascript:;" onClick="delete_cat(<?php echo $row->cat_id;?>);" title="delete">
<img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />Delete</a --></td>
</tr>


<tr id="edit_info_<?php echo $row->cat_id;?>" class="hide_tag hide"> 
<td>
	<table  border="0" cellspacing="5"   style="margin-top:20px; margin-left:10px;margin-bottom:20px;">

	<form name="edit_cat" action="<?php echo $this->docroot;?>admin_videos/edit_category" method="post" class="out_f">
	<input type="hidden" name="cat_id" value="<?php echo $row->cat_id;?>" >
	<td>Category:<input type="text" style="width:200px;" name="category"  value="<?php echo $row->category;?>"/>
	<?php  echo UI::btn_("Submit", "submit", "Submit", "", "", "edit_cat","edit_cat");?>
	<!-- input name="submit"  class="convey" type="submit" value="Submit"  / --></td>
	</form>
</table></td></tr>

		               <!-- for delete -->
		<div id="delete_form<?php echo $row->cat_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->cat_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this Category? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_videos/delete_cat?id=".$row->cat_id."' ", "delete_category","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->cat_id."","");?>
		
		</div>
		</div>


		
		</div>

</table>
		
<?php  } 
} else { ?>
</div>
  <div class="no_data">No data Found</div>
 <?php 
 }
 ?>
 </div>

