
<!-- Display the user information -->
<?php
  foreach ($this->template->info_permission as $mod)
    {
    $email = $mod->email;
    $dob = $mod->dob;
    $phone = $mod->phone;
    $mobile = $mod->mobile;    
    $userid = $mod->user_id;
    
    }
    
    foreach($this->get_friend_id as $fid)
    {
        $friend_id = $fid->id;
    }
    if($this->template->module_permission->count() > 0)
    {
                foreach($this->template->module_permission as $permission)
                {
                        $profile = $permission->profile;
                        $mod_userid = $permission->user_id;
                }
    }
    
    if($this->userid && $profile == 1)
    {
                    ?>
                    <div class="info_basic">
                    <strong class="t_color">Basic Information</strong>
                    <div class="clear"><p class="info_bleft fl">City:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->city;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Country:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->cdesc;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Gender:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->gender;?></span></div>

                <?php 
                if($this->userid == $userid)
                {
                ?>
                    <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>

                    
                    
                    </div>
                 
                     <div class="info_basic">

                    <strong class="t_color">Contact Information</strong>

                   <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                <?php
                if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                {
                ?>
                     <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                     <?php
                     }
                    
                if($this->profile_info["mysql_fetch_array"]->phone != 0)
                {
                ?>

                    <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>


                    <?php
                    }
                    }
                    
                    /*************************** condition for everyone start*******************************/
                    elseif($this->userid != '' || $friend_id == '')
                    {
                                   if($dob == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                  
                                   if($email == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == 1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == 1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   
                    }
                    
                        /*************************** condition for everyone end*******************************/
                        
                         /*************************** condition for friends start *******************************/
                        
                       if($friend_id == $this->userid && $this->userid != '')
                        {
                                   if($dob == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                 
                                   if($email == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == -1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == -1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   /*************************** condition for friends end *******************************/
                    }
                    ?>
                 
                    </div>
                    <?php
    }
    
    elseif($profile == 0 && $this->userid == $mod_userid)
    {
    
                ?>
                
                <div class="info_basic">
                    <strong class="t_color">Basic Information</strong>
                    <div class="clear"><p class="info_bleft fl">City:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->city;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Country:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->cdesc;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Gender:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->gender;?></span></div>

                <?php 
                if($this->userid == $userid)
                {
                ?>
                    <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>

                    
                    
                    </div>
                 
                     <div class="info_basic">

                    <strong class="t_color">Contact Information</strong>

                   <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                <?php
                if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                {
                ?>
                     <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                     <?php
                     }
                    
                if($this->profile_info["mysql_fetch_array"]->phone != 0)
                {
                ?>

                    <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>


                    <?php
                    }
                    }
                    
                    /*************************** condition for everyone start*******************************/
                    elseif($this->userid != '' || $friend_id == '')
                    {
                                   if($dob == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                  
                                   if($email == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == 1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == 1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   
                    }
                    
                        /*************************** condition for everyone end*******************************/
                        
                         /*************************** condition for friends start *******************************/
                        
                       if($friend_id == $this->userid && $this->userid != '')
                        {
                                   if($dob == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                 
                                   if($email == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == -1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == -1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   /*************************** condition for friends end *******************************/
                    }
                    ?>
                 
                    </div>
                <?php
    }
    elseif(($friend_id == $this->userid && $profile == -1) || $this->userid == $userid)
    {
         ?>
                
                <div class="info_basic">
                    <strong class="t_color">Basic Information</strong>
                    <div class="clear"><p class="info_bleft fl">City:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->city;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Country:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->cdesc;?></span></div>
                    <div class="clear"><p class="info_bleft fl">Gender:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->gender;?></span></div>

                <?php 
                if($this->userid == $userid)
                {
                ?>
                    <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>

                    
                    
                    </div>
                 
                     <div class="info_basic">

                    <strong class="t_color">Contact Information</strong>

                   <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                <?php
                if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                {
                ?>
                     <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                     <?php
                     }
                    
                if($this->profile_info["mysql_fetch_array"]->phone != 0)
                {
                ?>

                    <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>


                    <?php
                    }
                    }
                    
                    /*************************** condition for everyone start*******************************/
                    elseif($this->userid != '' || $friend_id == '')
                    {
                                   if($dob == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                  
                                   if($email == 1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == 1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == 1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   
                    }
                    
                        /*************************** condition for everyone end*******************************/
                        
                         /*************************** condition for friends start *******************************/
                        
                       if($friend_id == $this->userid && $this->userid != '')
                        {
                                   if($dob == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Birthday:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->dob;?></span></div>
                                        <?php
                                   }
                                 
                                   if($email == -1)
                                   {
                                        ?>
                                        <div class="clear"><p class="info_bleft fl">Email:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->email;?></span></div>
                                        <?php
                                   }
                                   if($mobile == -1)
                                   {
                                   if($this->profile_info["mysql_fetch_array"]->mobile != 0)
                                  {
                                         ?>
                                      
                                        <div class="clear"><p class="info_bleft fl">Mobile:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->mobile;?></span></div>
                                        <?php
                                        }
                                        
                                        
                                   }
                                   if($phone == -1)
                                   {
                                        if($this->profile_info["mysql_fetch_array"]->phone != 0)
                                        {
                                        ?>
                                      
                                                <div class="clear"><p class="info_bleft fl">Phone:</p>	<span class="fl"><?php echo $this->profile_info["mysql_fetch_array"]->phone;?></span></div>
                                                <?php
                                                }
                                        }
                                  
                                   
                                   /*************************** condition for friends end *******************************/
                    }
                    ?>
                 
                    </div>
                    <?php
    }
    else
{
        echo "<div class='noresults'>Because of privacy user block the Profile Informations</div>";
}
    ?>
