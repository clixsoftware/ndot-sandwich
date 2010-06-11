

<script>
$(document).ready(function() {	$("#add_category").validate();	});
</script>
<div >

<form name="add_category" id="add_category" method="post" class="addcat" enctype="multipart/form-data">
<table class="span-10" >
<tr>
<td>Category:</td>
<td><input type="text" style="width:200px;" name="category" class="required"></td>
<td >
<?php   echo UI::btn_("Submit", "add", "Add", "", "","add","add_category");?>
</td>
</tr>
</table>
</form>

<b><br><h3>All Category</b></h3>
<?php  if(count($this->category)>0)
 { 
		
		foreach($this->category as $row)
		{
?>
<script>
 $(document).ready(function(){
			 $("#edit_<?php echo $row->category_id;?>").click(function(){ $("#edit_info_<?php echo $row->category_id;?>").toggle("slow"); });
			 $("#delete_<?php echo $row->category_id;?>").click(function(){ $("#delete_form<?php echo $row->category_id;?>").toggle("show") });
			 $("#close<?php echo $row->category_id;?>").click( function(){  $("#delete_form<?php echo $row->category_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->category_id;?>").click( function(){  $("#delete_form<?php echo $row->category_id;?>").hide("slow");  });
                         $("#edit_category<?php echo $row->category_id;?>").validate();	
 });
 </script>
 
 
 
<table border="0">
<tr width="400">
<td width="200"><?php echo $row->category_name;?></td>
<td width="100">
<?php  echo UI::btn_("button", "edit", "Edit", "", "", "edit_".$row->category_id."","edit");?>

</td>
<td width="100">

<?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->category_id."","del");?>

<!-- a href="javascript:;" onClick="delete_cat(<?php echo $row->category_id;?>);" title="delete" >
<img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />Delete</a --></td>
<td id="edit_info_<?php echo $row->category_id;?>" class="hide_tag" style="display:none;"> 
        <form name="edit_category<?php echo $row->category_id;?>" id="edit_category<?php echo $row->category_id;?>" action="editcat" method="post" >
                <table>
                <tr>
                <td>
                <input type="hidden" name="type" value="edit" >
                <input type="hidden" name="category_id" value="<?php echo $row->category_id;?>" >
	        Category:</td>
	        <td><input type="text"  name="category"  value="<?php echo $row->category_name;?>" class="required"/></td>
	        <td>	<?php   echo UI::btn_("Submit", "update", "Update", "", "","update","edit_category<?php echo $row->category_id;?>");?></td>
	        </tr>
	        </table>
	</form>

</td>
</tr>
     
		
				 <!-- for delete -->
		<div id="delete_form<?php echo $row->category_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->category_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this Category? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_news/addcat/?del=yes&id=".$row->category_id."' ", "delete_com","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->category_id."","");?>
		
		</div>
		</div>
		
		
		</div>
</table>
		
<?php  } 
}
 else
 {
echo UI::nodata_();
 }
 ?>
 </div>

