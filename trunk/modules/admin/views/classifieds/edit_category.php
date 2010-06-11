<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>
<script>
/* delete news
function delete_cat(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_classifieds/addcat/?del=yes&id='+id;
}
} */
$(document).ready(function(){$("#addcat").validate();});

 $(document).ready(
  function()
  {
	 // show
	   $("#subcat").click(function()
	    {
		$("#tblshow").show("slow");
	    });
		 // hide
	   $("#maincat").click(function()
	    {
		$("#tblshow").hide("slow");
	    }); 
  });


</script>
<div >
<form name="addcat" action="" method="post" id="addcat">
<table width="500" cellpadding="5" cellspacing="5" class="mt-20">
<tr>
<td wdith="200" align="right" valign="top">Category:</td>
<td><input type="text" name="category" class="required"></td>
<td></td>
</tr>

<tr>
<td valign="top" wdith="200" align="right"><strong>Type :</strong></td>
<td ><input type="radio" name="caty" value="main" checked="true" id="maincat" title="Already User Table Exists"/>
  Main Category
  <input type="radio" name="caty" value="subcat" id="subcat"  title="Create Ndot's User Table"/>
  Sub Category</td>
</tr>
<tr >
<td colspan="2">
<table  id="tblshow" style="display:none;">

<td valign="top" align="right" width="100"><strong>Main Category :</strong></td>
<td class="pl-10">
<select  name="main_category"   id="main_category" class="width200" title="Select Category">
	
	<?php foreach($this->category as $category)
{ 
if($category->parent_id==0)
{ 
?>
<option value="<?php echo $category->cat_id; ?>"><?php echo $category->category; ?></option>
<?php 
}
} ?>
</select>

</td>

 </table>
 </td>
 </tr>
<tr>
<td></td>
<td align="left">
<?php  echo UI::btn_("Submit", "submit", "Create", "", "", "addcat","addcat");?>

</td>
</tr>
</table>
</form>
<b><br><h3 class="ml-20">All Category</b></h3>
<?php  if(count($this->category)>0)
 { 
		
		foreach($this->category as $row)
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
<table cellpadding="3" cellspacing="3" width="400" class="ml-20">
<tr>
<td width="200"><?php echo $row->category;?></td>
<td width="100">
<?php echo UI::btn_("button", "edit", "Edit", "", "", "edit_".$row->cat_id."","edit");?>
</td>

<td width="100">
<?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->cat_id."","del"); ?>

</td>
</tr>


<tr id="edit_info_<?php echo $row->cat_id;?>" class="hide_tag hide"> 
<td>
	<table  border="0" cellspacing="5"   style="margin-top:20px; margin-left:10px;margin-bottom:20px;">

	<form name="edit_news" action="<?php echo $this->docroot;?>admin_classifieds/editcat" method="post" class="out_f">
	<input type="hidden" name="type" value="edit" >
	<input type="hidden" name="cat_id" value="<?php echo $row->cat_id;?>" >
	<td>Category:<input type="text" style="width:200px;" name="category"  value="<?php echo $row->category;?>"/>
	<?php   echo UI::btn_("Submit", "submit", "Edit", "", "","edit_news","edit_news");?>
	</td>
	</form>

</table>

</td></tr>

<tr>
<td width="300">
		<!-- div for delete album -->
		<div id="delete_form<?php echo $row->cat_id;?>" class="delete_alert" style="clear:both; ">
		<h3 class="delete_alert_head">Delete Category</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->cat_id?>"  ></span>
		<div >Are you sure to delete this category? </div>
		<div> 
		<input type="button" name="delete_com" id="delete_com" value="Delete" onclick="window.location='<?php echo $this->docroot;?>admin_classifieds/addcat/?del=yes&id=<?php echo $row->cat_id?>'"  />
		<input type="button" name="cancel" id="cancell<?php echo $row->cat_id?>"  value="Cancel" />
		</div>	
	
</td></tr>            
		</div>	
</div>
</table>
		
<?php  } 
} 
else 
{ ?>
</div>
  <div class="no_data">No data Found</div>
 <?php 
 }
 ?>
 </div>

