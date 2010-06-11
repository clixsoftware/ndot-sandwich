<!-- contents start -->
<script>
//validate the category
function validate_category()
{
	if(document.getElementById("name").value=="")
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
		$("#add_role").validate();
	});
</script>


<form name="add_role" id="add_role" action="" method="post">
<table border="0" cellpadding="5" cellspacing="5" width="500" class="mt-20 ml-20 mb-20">
<input type="hidden" name="type" value="add">
<tr><td valign="top" align="right"><label>Role Name : </label></td>
<td><input type="text" name="name" id="name" class="required span-6 title" title="Enter the Role Name"></td></tr>
<tr><td valign="top" align="right"><label>Assign Module : </label></td><td>
<select name="module_name" class="required span-4" title="Select the Module">
<option value="">select</option>
<?php  foreach($this->modules_name as $row) { ?>
<option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
<?php } ?>
</select>
</td></tr>
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
 $("#cat_<?php echo $row->id;?>").click(function(){ $("#edit_form_<?php echo $row->id;?>").toggle("slow"); });
	 $("#delete_<?php echo $row->id;?>").click(function(){ $("#delete_form<?php echo $row->id;?>").toggle("show") });
	 $("#close<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });
 });
 </script>

<div class="span-19 ml-20 fl mt-0">
<div class="span-5 fl"><?php echo $row->members_type;?></div>
<?php if($row->role_type != -1) { ?>


<div class="span-2 fl"><a href="javascript:;" id="cat_<?php echo $row->id; ?>" name="cat_<?php echo $row->id; ?>" title="Edit"><img src="<?php echo $this->docroot; ?>public/images/icons/edit.gif">&nbsp;Edit</a></div>
<div class="span-2 fl"><a href="javascript:;" id="delete_<?php echo $row->id; ?>" name="delete_<?php echo $row->id; ?>" title="Delete"><img src="<?php echo $this->docroot; ?>public/images/icons/delete.gif">&nbsp;Delete</a></div>
 <?php } ?>

 
<div id="edit_form_<?php echo $row->id;?>" class="delete_alert width300 borderf clear mt-20" >
<form name="add_category" action="" method="post" >
<table border="0" cellpadding="5">
<input type="hidden" name="type" value="update">
<input type="hidden" name="id" value="<?php echo $row->id;?>">
<tr><td align="right"><label>Role Name : </label></td><td><input type="text" value="<?php echo $row->members_type;?>" name="name" id="name"></td></tr>
<tr><td></td><td><?php  echo UI::btn_("Submit", "Update", "Update", "", "", "Update","Update");?></td></tr>
</table>
</form>
</div>

                <!-- for delete -->
		<div id="delete_form<?php echo $row->id;?>" class="delete_alert width300 borderf clear mt-20" >
		<h3 class="delete_alert_head width280">Delete Role</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->id;?>"  ></span>
		<div class="clear fl">Are you sure want to delete this role? </div>
		<div class="mt-10 clear fl"> 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin/delete_role/?id=".$row->id."'", "Delete","Delete");?> 
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->id."","Cancel");?>
		
		</div>
		</div>
</div>

<hr/>
  <?php } ?>

	
<?php
}
else
{
        echo UI::nodata_();
 }
?>




