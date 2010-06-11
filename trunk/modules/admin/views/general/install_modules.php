
<div class="notice">This is very important settings to install new modules in the application. Before procceding read the install document clearly! </div>
<div class="span-19">
  <?php
		
		$msg=$this->input->get('msg');
                if($msg==1)
                {
                echo '<font color=red>Please set permission for application/config folder!</font>';
                }?>
  <div  class="span-18 ">
    
      
               <p>There is no install.php in the <font color=red><strong><?php $mod_name=$this->input->get("mod"); echo $mod_name;?></strong></font> module folder.            <p> Read the New Module installation document before procceding..
         </p> 
      
  </div>
</div>
