<script>
$(document).ready(function(){
        $("#add_category").validate();
});
</script>

<form name="add_category" id="add_category" method="post" action="<?php echo $this->docroot ?>admin_events/add_category">
<table cellpadding="8" cellspacing="8" width="742"  align="center" class="mt-20 mb-20">
<tr>
<td valign="top" align="right"><label>Category Name:</label></td>
<td><input type="text" name="category" id="category" class="required title" title="Category Name Required." /></td>
</tr>
<tr>
<td></td>
<td>
<?php  echo UI::btn_("Submit", "create", "Create", "", "", "new_q","create");?>
<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_events' ", "cancel","");?> 
</td>
</tr>
</table>

</form>

<div class="span-19a last mt-20">
<table cellpadding="8" cellspacing="8" class="span-12 ml-50 mb-20">
<?php 
if(count($this->template->get_category) > 0)
{
        ?>
        <tr>
        <td align="left"><label>Category Name</label></td>
        <!--<td align="left"><label>Edit</label></td>-->
        <td align="left"><label>Delete</label></td>
        </tr>
        <?php
        foreach($this->template->get_category as $cat)
        {
                ?>
                <script>
 			$(document).ready(function(){
			 $("#delete_<?php echo $cat->category_id;?>").click(function(){ $("#delete_form<?php echo $cat->category_id;?>").toggle("show") });
			 $("#close<?php echo $cat->category_id;?>").click( function(){  $("#delete_form<?php echo $cat->category_id;?>").hide("slow");  });
			 $("#cancell<?php echo $cat->category_id;?>").click( function(){  $("#delete_form<?php echo $cat->category_id;?>").hide("slow");  });
 			});
			 </script>
                <tr>
                <td class="span-6"><?php echo $cat->category_name; ?></td>
                <!--<td><?php  echo UI::btn_("button", "Edit", "Edit", "", "javascript:window.location='".$this->docroot."admin_events/delete_category/?cid=".$cat->category_id."'", "Edit","Edit");?></td> -->
                <td><?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$cat->category_id."","del");?></td>
                </tr>
               <tr id="delete_form<?php echo $cat->category_id;?>" class="delete_alert width300 borderf clear mt-20">
<td colspan="2">
                <div id="delete_form<?php echo $cat->category_id;?>" >
		<h3 class="delete_alert_head span-5">Delete Event</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $cat->category_id;?>"  ></span>
		<div  class="clear fl">Are you sure want to delete? </div>
		<div class="mt-10 clear fl"> 
		 
		<?php  echo UI::btn_("Submit", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_events/delete_category/?cid=".$cat->category_id."'", "new_q","Delete");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "cancell".$cat->category_id."", "", "Add New Event","");?>
		 
		 </div>
		 </div>
</td></tr>
                <?php
        }
}
?>
</table>
</div>
