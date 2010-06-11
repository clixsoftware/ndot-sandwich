<?php
/**
 * Defines left menu for admin module
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>
<!-- left side Start -->
 

<div class="left_menu">
<ul class="admin_lefmenu">

<?php

 if($this->usertype == -1){?>
     <li><h3 class="left_box">System Settings</h3></li>
    <li> <a href="<?php echo $this->docroot;?>admin"  class="admin_modulesset">Admin Home</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/general_settings" title="General settings" class="admin_generalset">General Settings</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/modules"  class="admin_modulesset">Module Settings</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/manage_users" class="admin_manageusers" >Manage Users</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/manage_role" class="admin_permissionset">Manage Roles</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/permission" class="admin_permissionset">Role Settings</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin/themes" class="admin_themes">Themes</a><li>
    <li> <a href="<?php echo $this->docroot;?>admin_cms/" class="admin_managecms" >Manage CMS</a><li>
    
    <li>
        
        <a href="<?php echo $this->docroot;?>admin/email" class="admin_emailtoall">Email to all</a>
     <li>
    <li>
      
        <a href="<?php echo $this->docroot;?>admin_mailtemplates/" class="admin_emailtemplates">Email Templates</a>
    <li>
 <?php } ?>  
  
    <li><hr/><h3 class="left_box">Manage Modules</h3></li>
<?php 
        if($this->usertype == -1)
		{ 
		 foreach($this->get_module as $key => $mod){
			if($mod == "blog"){
				$mod = "blogs";
			}
			if($mod == "forum"){
				$mod = "forums";
			}
			if($mod == "video"){
				$mod = "videos";
			}
			?>
		<li><a href="<?php echo $this->docroot;?>admin_<?php echo $mod; ?>" class="admin_a<?php echo $mod ?>"><?php echo $key; ?></a></li>
		
        <?php } ?>
    	<?php }
		if($this->usertype == -2)
		{
			$user_module = $this->session->get("u_mod");

                        ?>
                        <?php
                         
			if(in_array(2, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_answers" class="admin_aanswers">Answers</a></li>
                        <?php   } ?>
                        
                        <?php 
			if(in_array(3, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_blogs" class="admin_ablogs">Blogs</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(6, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_classifieds" class="admin_aclassifieds">Classifieds</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(7, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_events" class="admin_aevents">Events</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(8, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_forums" class="admin_aforums">Forums</a></li>
                        <?php   } ?>
                        
                        <?php 
			if(in_array(9, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_groups" class="admin_agroups">Groups</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(11, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_news" class="admin_anews">News</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(13, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_news" class="admin_anews">Notification</a></li>
                        <?php   } ?>
                        
                         <?php 
			if(in_array(12, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_photos" class="admin_aphotos">Photos</a></li>
                        <?php   } ?>
                        
                        <?php 
			if(in_array(13, $user_module))
			{?>
                        <li><a href="<?php echo $this->docroot;?>admin_videos" class="admin_avideos">Videos</a></li>
                        <?php   } ?>
                        
                        
            <?php }
		 ?>
   
    
</ul>
</div>
 

