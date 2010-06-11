<div class="notice"> Roles, Permissions & Module settings. </div>

<form name="permission" id="permission" method="post" action="">
  <table border="0" cellpadding="5" cellspacing="3">
    <!--
<tr><td>Choose Module</td>
<td colspan="3">
<select name="module" id="module">
<option value="-1">users</option>
<?php 
foreach($this->
    get_modules as $module)
    { ?>
    <option value="<?php echo $module->mod_id;?>"><?php echo $module->mod_name;?></option>
    <?php } 
?>
    </select>
    
    </td>
    </tr>
    
    -->
    <tr>
      <th>Members role</th>
      <th>Add</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>Block</th>
    </tr>
    <?php
foreach($this->get_permission as $row)
{
?>
    <tr >
      <td><?php echo $row->members_type;?> </td>
      <td ><input type="checkbox" name="add[]" <?php  if($row->action_add==1){ ?> checked="checked"<?php }?> <?php if($row->status==0){ ?>disabled="disabled" <?php }?> value="<?php echo $row->id;?>" >
      </td>
      
      <td><input type="checkbox" name="edit[]" <?php  if($row->action_edit==1){ ?> checked="checked"<?php }?> 
 <?php if($row->status==0){ ?>disabled="disabled" <?php }?> value="<?php echo $row->id;?>"></td>
 
      <td><input type="checkbox" name="delete[]" <?php  if($row->action_delete==1){ ?> checked="checked"<?php }?> <?php if($row->status==0){ ?>disabled="disabled" <?php }?> value="<?php echo $row->id;?>"></td>
      
      <td><input type="checkbox" name="block[]" <?php  if($row->action_block==1){ ?> checked="checked"<?php }?> <?php if($row->status==0){ ?>disabled="disabled" <?php }?>  value="<?php echo $row->id;?>"></td>
    </tr>
    <?php
}
?>
    <tr>
      <td colspan="4"><!--input type="submit" value="Change"-->
        <?php  echo UI::btn_("Submit", "permission", "Save", "", "", "permission","permission");?>
      </td>
    </tr>
  </table>
</form>
