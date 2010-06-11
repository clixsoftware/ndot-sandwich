<!-- contents start -->
<script>
//validate the category
function validate_category()
{
	if(document.getElementById("category_name").value=="")
	{
	alert("Enter the Category");
	return false;
	}
}

//delete category
function delete_category(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_answers/delete_category/?id='+id;
}

}
$(document).ready(function()
	{
		$("#add_category").validate();
	});
</script>


<form name="add_category" id="add_category" action="" method="post">
<table border="0" cellpadding="5" cellspacing="5" width="70%" class="mt-20 ml-20">
<input type="hidden" name="type" value="add">
<tr><td align="right" valign="top"><label>Name : </label></td>
<td><input type="text" name="category_name" id="category_name" class="required title"></td></tr>
<tr><td>&nbsp;</td><td>
<?php  echo UI::btn_("Submit", "Add", "Add", "", "", "Add","Add");?>
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

<div class="span-13 fl p5 border_bottom">
<div class="span-7"><?php echo $row->category_name;?></div>

<div class="span-2 fl">
<a href="javascript:;" id="cat_<?php echo $row->category_id;?>" title="Edit category"><img src="<?php echo $this->docroot;?>/public/images/icons/edit.gif" title="Edit" class="admin" />&nbsp;Edit</a></div>
<div class="span-2 fl">
<a href="javascript:;" id="delete_<?php echo $row->category_id;?>" title="Delete "><img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />&nbsp;Delete</a></div>
 
</div>

<div id="edit_form_<?php echo $row->category_id;?>" class="delete_alert width300 borderf clear mt-20">
<form name="add_category" action="" method="post" >
<table border="0" cellpadding="5">
<input type="hidden" name="type" value="update">
<input type="hidden" name="category_id" value="<?php echo $row->category_id;?>">
<tr><td>Category:</td><td><input type="text" value="<?php echo $row->category_name;?>" name="category_name" id="category_name"></td></tr>
<tr><td></td><td><?php  echo UI::btn_("Submit", "Update", "Update", "", "", "Update","Update");?></td></tr>
</table>
</form>
</div>
<!-- for delete -->
		<div id="delete_form<?php echo $row->category_id;?>" class="delete_alert width300 borderf clear mt-20">
		<h3 class="delete_alert_head width280">Delete Category</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->category_id;?>"  ></span>
		<div  class="clear fl">Are you sure to delete this category? </div>
		<div class="mt-10 clear fl"> 
 
		
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_answers/delete_category/?id=".$row->category_id."'", "Delete","Delete");?> 
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->category_id."","Cancel");?>
		</div>
		</div>



  <?php } ?>

	<?php 
	//pagination
	if($this->blog_category_count >15) 
	{
		echo $this->template->pagination;
	}
	?>

<?php
}
else
{
        echo UI::nodata_();
 }
?>




