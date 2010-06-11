<?php
/**
 * Defines creating the blog
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
?>
<script src="<?php echo $this->docroot;?>public/js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script language="javascript">
	$(document).ready(function()
	{
	
	//for create form validation
	$("#create_blog").validate();
	
	});

</script>



<form action="" method="post"  name="create_blog" id="create_blog">
<table border="0" cellpadding="5">
<tr><td align="right" valign="top"><label>Title:</label></td>
<td><input name="title" type="text" id="title" size="61" class="required " title="Enter the Title" /></td></tr>
<tr><td></td><td class="quiet">Enter the title.</td></tr>
<tr><td align="right"><label>Category:</label></td><td><select id="category" name="category" class="create_select required" title="Select the Category">
        <option value="" >select</option>
	<?php foreach($this->category as $row)
	{?>
	<option value="<?php echo $row->category_id;?>"><?php echo $row->category_name;?></option>
	<?php } ?>
	</select></td>
<tr><td></td><td class="quiet">Select right category to place your blog.</td></tr>
<tr><td align="right" valign="top"><label>Description:</label></td>
<td>
<textarea name="desc"   id="desc" cols="70" rows="7" class="required" title="Enter the Description" ></textarea>
</td></tr>
<tr><td></td><td class="quiet">Enter the full description about your blog.</td></tr>
<tr><td>&nbsp;</td><td>
<?php  echo UI::btn_("Submit", "create_blog", "Post", "", "", "new_q","create_blog");?>
<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."blog' ", "cancel","");?>
</table>
</form>

 

 
