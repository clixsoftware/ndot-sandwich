<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script>
/* delete news*/
$(document).ready(function(){$("#general_settings").validate();});
</script>
<?php
		$title=$meta_keywords=$meta_desc='';
		foreach($this->general_setting as $row)
		{
			$title=$row->title;
			$meta_keywords=$row->meta_keywords;
			$meta_desc=$row->meta_desc;
			$logo_path=$row->logo_path;
		}
		?>
<form name="general_settings" method="post" action="" enctype="multipart/form-data" id="general_settings" id= "general_settings">

<div class="notice"> Update general settings to change your title of your product installed. </div>
<table cellpadding="5" cellspacing="5" >
  <tr>
    <td align="right"><label>Site Name:</label></td>
    <td><input type="text" name="title" class="title span-14"  value="<?php echo $title;?>" class="required" /></td>
  </tr>
  <tr>
    <td align="right"><label>Meta Keywords:</label></td>
    <td><input type="text" name="meta_keywords" class="title span-14"   value="<?php echo $meta_keywords;?>" class="required" /></td>
  </tr>
  <tr>
    <td valign="top" align="right"><label>Meta Description:</label></td>
    <td><textarea name="meta_description" class="span-14 required " rows="6"  ><?php echo $meta_desc;?></textarea></td>
  </tr>
  <tr>
    <td valign="top" align="right"><label>Logo:</label></td>
    <td valign="top"><input type="file" name="logo" class="upload_logo"  style="vertical-align:top;"/>
      <img src="/upload/<?php echo $logo_path;?>"  alt="<?php echo $title;?>" title="<?php echo $title;?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><!--<input type="submit" value="Update" name="settings"/>-->
      <?php  echo UI::btn_("Submit", "settings", "Update", "", "", "general_settings","general_settings");?>
    </td>
  </tr>
</table>
</form>
