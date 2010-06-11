
<!-- Display the user information -->
<?php
  foreach ($this->template->info_permission as $mod)
    {
    $email = $mod->email;
    $dob = $mod->dob;
    $phone = $mod->phone;
    $mobile = $mod->mobile;    
    }
    ?>
    <div class="info_basic">
    <strong class="t_color">Basic Information</strong>
    <div class="clear"><p class="info_bleft fl">City:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->city;?></span></div>
    <div class="clear"><p class="info_bleft fl">Country:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->cdesc;?></span></div>
    <div class="clear"><p class="info_bleft fl">Gender:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->gender;?></span></div>
   <?php 
   
   if ($dob == 1 ) 
   {
   ?>
    <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
  <?php 
  } 
  ?>
    
    
    </div>
 
     <div class="info_basic">
     <?php 
   
   if ($email == 1 ||  $mobile == 1 || $phone == 1) 
   {
   ?>
    <strong class="t_color">Contact Information</strong>
     <?php 
   }
   if ($email == 1 ) 
   {
   ?>
   <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
   <?php 
  } 
     
   if ($mobile == 1 ) 
   {
   ?>
     <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
      <?php 
  } 
     
   if ($phone == 1 ) 
   {
   ?>
    <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
    <?php 
  } 
  ?>
    </div>
 

