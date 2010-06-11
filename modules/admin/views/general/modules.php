
<div class="notice"> This is very important settings to enable & disable modules in the application. Default tells that those modules ettings you cant change bcoz it requires by default. You can activate / deactivate other modules based on requirements. </div>
<div class="span-19">
  <?php
		
		$msg=$this->input->get('msg');
                if($msg==1)
                {
                echo '<font color=red>Please set permission for application/config folder!</font>';
                }?>
  <div  class="span-18 ">
    <table cellpadding="10" cellspacing="5">
      <tr>
        <th>Modules</th>
        <th>Description</th>
        <th>Status</th>
        <th>Need Login</th>        
      </tr>
      <?php
		foreach($this->module_setting as $row)
		{ ?>
      <tr>
        <td><a href="<?php echo $this->docroot.$row->link;?>" style=" text-transform:capitalize;"><?php echo $row->name;?></a></td>
        <td><p class="margin_left3"><?php echo $row->description;?></p></td>
        <td><?php 
                            if($row->system_module!=1)
                            {
                                    if($row->status==0)
                                    {
                                    ?>
          <span><a href="<?php echo $this->docroot;?>admin/activate/?id=<?php echo $row->id;?>&status=1" title="Deactive" style="color:red;" >Deactivate</a></span>
          <?php } else { ?>
          <span><a href="<?php echo $this->docroot;?>admin/activate/?id=<?php echo $row->id;?>&status=0" title="Activate" style="color:blue" >Activate</a></span>
          <?php } 
                            }
                            else
                            {?>
          <span><b>Default</b></span>
          <?php }
                            ?></td>
                            
                            <td><?php 
                            if($row->system_module!=1)
                            {
                                    if($row->login==0)
                                    {
                                    ?>
          <span><a href="<?php echo $this->docroot;?>admin/login_need/?id=<?php echo $row->id;?>&login=1" title="Yes" style="color:red;" >Yes</a></span>
          <?php } else { ?>
          <span><a href="<?php echo $this->docroot;?>admin/login_need/?id=<?php echo $row->id;?>&login=0" title="No" style="color:blue" >No</a></span>
          <?php } 
                            }
                            else
                            {?>
          <span><b>Default</b></span>
          <?php }
                            ?></td>
      </tr>
      <?php 
		}
		?>
    </table>
  </div>
</div>
