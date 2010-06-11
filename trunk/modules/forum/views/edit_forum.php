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

	})
</script>

<table border="0" cellpadding="5">

            <form name="create_form" id="create_form" action="" method="post" >
            <input type="hidden" name="id" value="<?php echo $this->edit_forum['mysql_fetch_array']->topic_id;?>" />

            <tr><td valign="top" align="right"><label>Topic:</label></td>
            <td><input type="text" name="topic"  size="55" id="topic" value="<?php echo $this->edit_forum['mysql_fetch_array']->topic;?>" class="required title span-12" title="Enter the topic" /></td></tr>
	    <tr><td align="right"><label>Category:</label></td>
	    <td>
            <select name="category" id="category"> 
            <?php foreach($this->result as $row) {?>
	   <option value="<?php echo $row->category_id; ?>" <?php if($row->category_id==$this->edit_forum['mysql_fetch_array']->category_id){ echo "selected";}?>><?php echo $row->forum_category; ?></option>
            <?php } ?> 
            </select>
	    
	    </td></tr>
            <tr><td valign="top" align="right"><label>Description:</label></td>
	    <td><textarea name="topic_desc" cols="60" rows="10" id="desc" class="required" ><?php echo htmlspecialchars_decode($this->edit_forum['mysql_fetch_array']->topic_desc);?></textarea></td></tr>            
	    <tr><td>&nbsp;</td>
            <td>
	     <?php  echo UI::btn_("Submit", "update_discussion", "Update", "", "", "update_discussion","update_discussion");?>
             <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."forum/myforums' ", "cancel","");?>
	    </td></tr>
            </form>
</table>

