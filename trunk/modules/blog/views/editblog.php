<?php
/**
 * Defines edit blog
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
?>
<script src="<?php echo $this->docroot;?>public/js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script language="javascript">

	$(document).ready(function()
	{
		//for create form validation
		$("#edit_blog").validate();
		

	});

});
</script>


<!--leftsidenavigationfinish-->
<?php  
   foreach ( $this->template->edits as $row )
   {
?>
<table border="0" cellpadding="10" cellspacing="5">
<form name="edit_blog" id="edit_blog" action="" onsubmit="return validation(this)"  method="post" >
<input type="hidden" name="bid" value="<?php echo $row->blog_id; ?>" >
<tr><td align="right">Title:</td><td><input name="title" type="text" id="title" value="<?php echo $row->blog_title; ?>" size=60" class="required" /></td></tr>
<tr><td align="right">Category:</td>
<td>
<select id="category" name="category" class="create_select" class="required">
        <?php foreach($this->category as $val)
	{?>
	<option value="<?php echo $val->category_id;?>" <?php if($val->category_id==$row->blog_category) { echo "selected";}?>><?php echo $val->category_name;?></option>
	<?php } ?>

        </select>
</td></tr>

<tr><td valign="top" align="right">Description:</td><td><textarea name="desc" id="description" cols="69" rows="6" class="mceEditor required" >
<?php echo htmlspecialchars_decode($row->blog_desc); } ?></textarea></td>
</tr>

<tr><td>&nbsp;</td>
<td>         <?php  echo UI::btn_("Submit", "update_blog", "Update", "", "", "update_blog","update_blog");?>
             <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."blog/myblog' ", "cancel","");?>
              &nbsp;</td></tr>
</form>
</table>
