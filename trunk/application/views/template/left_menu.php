<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="left_inner">
<?php 

if(count($this->profile_info) > 0){
	$myid = $this->profile_info["mysql_fetch_row"]->id;
}
else{
	 Nauth::setMessage(-1,"Page Not Found ");
	 url::redirect($this->docroot.'profile');
}
	foreach($this->profile_info as $row){

		$img = "public/user_photo/".$myid.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($myid.$row->name)."?d=wavatar&s=125"; 
			$img_path = $img_url;
		}
		//get the facebook user photo  
		if($this->session->get("f_user_photo") && $this->userid == $myid)
		{
		        $img_path = $this->session->get("f_user_photo");
		}
?>
<div class="profile_phob mb-5" style="overflow:hidden">
	<a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $myid; ?>" title="<?php echo $row->name; ?>" > 
    	<img src="<?php echo $img_path;?>"  alt="<?php echo $row->name; ?>" title="<?php echo $row->name; ?>"  class="profile_photo" />
    </a>

<div class="left_pedit fl clear mt-10  mb-10"><a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $myid; ?>" title="<?php echo $row->name; ?>"><strong><?php echo $row->name; ?></strong></a>
<?php 
	if($myid == $this->userid){ ?>
               
         <a href="<?php echo $this->docroot;?>profile/updateprofile" class=" clear fl"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/pro_nedit.jpg" border="0"  />Edit My Profile</a>
         
         
          <a href="<?php echo $this->docroot;?>profile/favourites" class=" clear fl"> <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/pro_nedit.jpg" border="0"  />My favourites</a>
 <?php 
 	} else {
		$diff = time() - strtotime($row->dob);
		$years = round($diff / (365*60*60*24));
			
?>
        <p class=" clear fl"><span><?php if($years > 0 ){ echo $years.","; }?></span><?php echo $row->gender; ?></p>
        <p class=" clear fl"><?php echo $row->city; ?></p>
<?php	
		if(count($this->find_frnd_not) == 0){
?>	
	<a href="<?php echo $this->docroot;?>profile/add_as_friend/?uid=<?php echo $myid; ?>" class=" clear fl">Add as a Friend </a>
<?php 
		}
	}
} 
?>
	</div>
 </div>
<div  class="left_menu clear fl">
<ul class="ul_ch pro_lefmenu clear fl">
 <?php if($myid != $this->userid){ 
 	 /* <!-- <li><a href="<?php ///echo $this->docroot;?>profile/view/?uid=<?php //echo $this->userid;?>"  class="p_profile">My Profile </a></li>  --> */
 } ?>
    <li><a href="<?php echo $this->docroot;?>profile/friends?uid=<?php echo $myid; ?>"  title="Friends" class="p_friends">Friends</a>
    	<?php 
			$url_seg = $this->uri->segment(2);
			if(($url_seg == "friends" || $url_seg == "invite_friends" ||  $url_seg == "openrequest"  ||  $url_seg == "openinvites"  ||  $url_seg == "invite" ) && $myid == $this->userid ){
		?>
        	 <li><a href="<?php echo $this->docroot;?>profile/invite_friends" title="Import Contacts" class="text_normal">Import Contacts</a></li>
        	 <li><a href="<?php echo $this->docroot;?>profile/invite" title="Invite Friends" class="text_normal">Invite Friends</a></li>
             <li><a href="<?php echo $this->docroot;?>profile/openinvites" title="Open Friends" class="text_normal">Open Invitations</a></li>
             <li><a href="<?php echo $this->docroot;?>profile/openrequest" title="Open Friend Request" class="text_normal">Open Requests</a></li>
        <?php
			}
  		?>
    </li>
    <li><a href="<?php echo $this->docroot;?>profile/view?uid=<?php echo $myid; ?>"  title="Updates" class="p_updates">Updates</a></li>
    
    
  <?php
  
  	foreach($this->get_module as $mod){
			if($mod == "photos"){
	?>
    <li>
    	<a href="<?php echo $this->docroot;?>photos/?uid=<?php echo $myid; ?>"  title="Photos" class="p_photos">Photos</a>
		<?php 
			if($this->uri->segment(1) == "photos" && $myid == $this->userid ){
		?>
        	 <li><a href="<?php echo $this->docroot;?>photos/?uid=<?php echo $myid; ?>" title="My Photos" class="text_normal">My Uploads</a></li>
             <li><a href="<?php echo $this->docroot;?>photos/friendsalbum" class="text_normal" title="Friends Albums">Friends Albums</a></li>
        <?php
			}
  		?>
  </li>
  <?php } if($mod == "video"){ ?>
   <li><a href="<?php echo $this->docroot;?>video/?uid=<?php echo $myid; ?>" title="Videos"  class="p_video">Videos</a> 
    	<?php if($this->uri->segment(1) == "video" &&  $myid == $this->userid){ ?>
        <div> 
        	<ul>
                <li><a href="<?php echo $this->docroot;?>video" title="Recent Videos" class="text_normal">Recent Videos</a></li>
                <li><a href="<?php echo $this->docroot;?>video/myvideo" title="My Videos" class="text_normal">My Videos</a></li>
                <li><a href="<?php echo $this->docroot;?>video/createvideo" title="Upload Videos" class="text_normal">Upload Videos</a></li>
                <li><a href="<?php echo $this->docroot;?>video/popularvideos" title="Popular Videos" class="text_normal">Popular Videos</a></li>
                <li><a href="<?php echo $this->docroot;?>video/friends_videos" title="Friends Videos" class="text_normal">Friends Videos</a></li>
            </ul>
        </div>
   <?php } ?></li>

 <?php 
 		} 
	}
  	if($myid == $this->userid){ ?>
   <?php 
   /* <li><a href="<?php echo $this->docroot;?>profile">Profile</a></li> -->
  	 <!--  <li><a href="<?php echo $this->docroot;?>updates/myupdate/?id=<?php //echo $myid?>">Updates</a></li> -->
   */ ?>
    <li><a href="<?php echo $this->docroot;?>inbox" title="Inbox"  class="p_inbox">Inbox</a> 
    <?php if($this->uri->segment(1) == "inbox"){ ?>
 	<div> 
    	<ul>
            <li><a href="<?php echo $this->docroot;?>inbox/compose"  title="Compose Mail"class="text_normal">Compose Mail</a></li>
            <li><a href="<?php echo $this->docroot;?>inbox/sent_mails" title="Sent Mail" class="text_normal">Sent Mail</a></li>
            <li><a href="<?php echo $this->docroot;?>inbox/archive_mails" title="Archive Mail" class="text_normal">Archive</a></li>
        </ul>
    </div>
   <?php  }   ?>
    </li>
 <li> 
 	 <div  class="module_menu mt-10">
 <?php 
 if(count($this->get_module) > 0){
 ?>
     <h2>Applications</h2>
    	<ul> 
  <?php  

 foreach($this->get_module as $key => $mod){
 	$module_name = $mod;
  	if($module_name == "inbox" || $module_name == "photos" || $module_name == "video" ){}else{
  ?> 
     	<li>
        <img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/leftmenu/<?php echo $module_name; ?>.jpg" border="0"  /><a href="<?php echo $this->docroot.$module_name;?>" title="<?php echo $key ?>"><?php echo trim(ucfirst($key)) ?></a>
        </li>
   
<?php } } ?>
     	</ul>
 <?php } ?>
    </div>
</li>	 
	 
	<?php  } ?>
</ul>
</div>
</div>
 
