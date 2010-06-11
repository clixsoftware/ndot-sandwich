<?php
/**
 * Creates new forum.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>

<!-- form validation for crate forum -->
<script>
	//jquery to post the album
	$(document).ready(function()
	{
		//for create form validation
		$("#create_form").validate();
		

	});
</script>



            <form name="create_form"  id="create_form" action="" method="post" >
            <table border="0" cellpadding="5">
            <input type="hidden" name="id" value="" />

            <tr><td  valign="top" align="right"><label>Topic:</label></td>
            <td><input type="text" name="topic"  size="71" id="topic" class="required title span-12" title="Enter the Topic" /></td></tr>
            <tr><td></td><td class="quiet">Enter your Discussion Topic.</td></tr>
	    <tr><td align="right"><label>Category:</label></td>
	    <td>
            <select name="category" id="category" class="required" title="Select the Category" > 
            <option value="">-Select-</option>
            <?php foreach($this->result as $row) {?>
			<option value="<?php echo $row->category_id; ?>"><?php echo $row->forum_category; ?></option>
            <?php } ?> 
            </select>
	    
	    </td></tr>
	    <tr><td></td><td class="quiet">Select the right category to place your Discussion.</td></tr>
	    
            <tr><td valign="top" align="right" title="Enter the Description"><label>Description:</label></td>
	    <td><textarea name="topic_desc" cols="62" rows="6" class="required" title="Enter the Description" ></textarea></td></tr>            
	    <tr><td></td><td class="quiet">Enter the full description of your Discussion.</td></tr>
	    
	    <tr><td>&nbsp;</td>
            <td>
                <?php  echo UI::btn_("Submit", "create_forum", "Post", "", "", "new_forum","post_forum");?>
                <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."forum' ", "cancel","");?>
	    </td></tr>
	    </table>
            </form>



