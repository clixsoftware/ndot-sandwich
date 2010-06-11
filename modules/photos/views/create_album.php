 <?php defined('SYSPATH') or die('No direct script access.'); ?>
<script>
	$(document).ready(function()
	{	
		$("#album_form").validate();
	});
</script>

<div  id="create_album" class="ml-40">
  <form name="album_form" action="<?php echo $this->docroot;?>photos/<?php if(isset($this->album_get_data)){ echo "editalbum"; }else{echo "create_album"; } ?>" method="post"  id="album_form">
    <table border="0" cellpadding="5" cellspacing="2"  class="photo_up span-12a mt-20 clear  " align="center">
      <tr >
        <td class="text_right" valign="top"><label>Title:</label></td>
        <td   ><input type="text" name="title" id="title"   class="required texinp span-9" minlength="5" value="<?php if(isset($this->album_get_data)){echo trim($this->album_get_data->current()->album_title); }?>" title="Enter the Title" /></td>
      </tr>
      <tr>
        <td valign="top" class="text_right"  width="108px"><label>Description:</label></td>
        <td  width="350px"><input type="hidden" name="albumid" value="<?php if(isset($this->album_get_data)){echo $this->album_get_data->current()->album_id; }?>"  /><textarea name="description" id="description"  rows="5" class="required texare span-9" minlength="10" title="Enter the Description"><?php if(isset($this->album_get_data)){echo trim($this->album_get_data->current()->album_desc);}?></textarea></td>
      </tr>
      <tr>
        <td class="text_right"><label>Privacy Settings:</label></td>
        <td><select name="share" style="width:150px;" class="required"  id="share" title="Select the Settings">
        <?php if(isset($this->album_get_data)){$permission = $this->album_get_data->current()->album_permision;
		
		if($permission == 0){
			$type = "Everyone";
		}
		elseif($permission == 1){
			$type = "Only my friends";
		}
		elseif($permission == -1){
			$type = "None";
		}
		else{
			$type = "Select";
		}
		echo '<option value="'.$permission.'">'.$type.'</option>';?>
		<?php }if(!isset($this->album_get_data)){ ?>
            <option value="">select</option>
         <?php } ?>
            <option value="0">Everyone</option>
            <option value="1">Only my friends</option>
            <option value="-1">None</option>
          </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><?php  echo UI::btn_("Submit", "submit", "Submit", "", "", "edit_album","edit_album");?></td>
      </tr>
    </table>
  </form>
</div>


