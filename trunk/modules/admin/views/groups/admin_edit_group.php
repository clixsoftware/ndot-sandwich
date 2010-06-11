<?php 
/**
 * Defines creating group
 *
 * @package    Core
 * @authors     Ashokkumar.C
 * @copyright  (c) 2010 Ndot.in
 */
?>
<!-- edit the group information -->
<script>
$(document).ready(function() {
 
		//for create form validation
		$("#form").validate();
	// propose username by combining first- and lastname
});
</script>


<?php
if(count($this->edit_group)>0)
{
	foreach($this->edit_group as $row)
	{
?>
        <form name="form" id="form" method="post" class="group_out_f1" enctype="multipart/form-data">
        <input type="hidden" name="gid" id="gid" value="<?php echo $this->input->get('gid'); ?>" />
        <table width="742" border="0" cellpadding="8" cellspacing="8">
        <tr>
        <td valign="top" align="right"> <label>Group Title:</label></td>
        <td ><input type="text" name="title" id="title" size="46" value="<?php echo $row->group_name;?>" class="required title" title="Enter the Group Name"></td>
        </tr>
        
        <tr >
        <td valign="top" align="right"><label>Group Logo:</label></td>
        <td>
        <input name="group_image" id="group_image" type="file" style="vertical-align:top;"/>
        <img src="<?php echo $this->docroot;?>/public/group_photo/50/<?php echo $row->group_photo;?>" alt="<?php echo $row->group_name; ?>" onerror="this.src='<?php echo $this->docroot;?>/public/group_photo/50/no_image.jpg'" class="profile_photo">
        </td>
        </tr>
        <tr>
          <td valign="top" align="right"><label>Description:</label></td>
          <td><textarea name="desc"  id="desc" style="width:410px;height:100px;" class="required" title="Enter the Group Description"><?php echo $row->group_desc;?></textarea></td>
        </tr>
        
        <tr>
        <td align="right"><label>Location:</label></td>
        <td ><input type="text" name="location" id="location"  size="46" value="<?php echo $row->location;?>" class="required" title="Enter the Group Location"></td>
        </tr>


        <tr>
        <td align="right"><label>City:</label></td>
        <td>
        <select name="country" id="country" >
        <option selected="selected" value="">Select City</option>
        <?php foreach($this->get_city as $city){ ?>
        <option value="<?php echo $city->id; ?>" <?php if($city->id==$row->group_country) { echo "selected";}?>> <?php echo $city->name; ?></option>
        <?php } ?>
        </select></td>
        </tr>
        <tr>
        <td align="right"><label>Group Access:</label></td>
        <td><input type="radio" name="access" <?php if($row->group_access==0){ ?>checked="checked" <?php } ?> id="access" value="0" />
          Automatic membership access
          <input type="radio" name="access" id="access" <?php if($row->group_access==1){ ?> checked="checked" <?php } ?> value="1" />
          Approval from admin</td>
        </tr>
        <tr>
        <td align="right"><label>Category:</label></td>
        <td>
        <select name="category" id="category" >
        <option selected="selected" value="">Select Category</option>
        <?php foreach($this->template->get_category as $category){ ?>
        <option value="<?php echo $category->group_category_id; ?>" <?php if($category->group_category_id==$row->group_category) { echo "selected";}?> ><?php echo $category->group_category_name; ?></option>
        <?php } ?>
        </select></td>
        </tr>
        <tr>
        <td align="right"><label>Website:</label></td>
        <td ><input type="text" name="website" id="website"  size="46" value="<?php echo $row->website;?>" class="required url" title="Enter the Website" ></td>
        </tr>
        <tr>
          <td align="right"><label>Company:</label></td>
          <td><input type="text" name="company" id="company"  size="20" value="<?php echo $row->company_name;?>" class="required" title="Enter the Company" />
          </td>
        </tr>
        <tr>
        <td></td>
        <td>
        <?php  echo UI::btn_("Submit", "update", "Update", "", "", "update","update");?>
        <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_groups' ", "cancel","");?>

        </td>
        </tr>
        </table>
        </form>
        
        <?php
   }
}
		?>
