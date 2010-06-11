<div class="left_outer">
<div class="left_inner">
<?php 
$myid=$this->template->profile_info["mysql_fetch_row"]->id;

foreach($this->template->profile_info as $row)
{?>

<div class="profile_photo">

	 <img src="<?php echo $this->docroot;?>public/user_photo/<?php  echo $row->user_photo;?>"  alt="<?php echo $row->name; ?>" title="<?php echo $row->name; ?>" onerror="this.src='<?php echo $this->docroot;?>/public/images/no_image.jpg'" class="profile_photo" />
     <div class="left_pedit fl clear mt-10  mb-10"><a href="#"><strong>nandhukumarkom29</strong></a>
     <a href="#"><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/pro_nedit.jpg" border="0" alt="Edit My Profile" />Edit My Profile</a>
     </div>
</div>
<?php }

?>
 
<div class="left_menu clear fl ">
<ul>
<?php
if($this->userid==$myid)
{
?>
<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/home.jpg" border="0" alt="My Home" />
<a href="<?php echo $this->docroot;?>profile/" title="My Home">My Home</a><li>

<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/myupdates.jpg" border="0"  />
<a href="<?php echo $this->docroot;?>updates/myupdate/?id=<?php echo $myid;?>" title="My updates">My Updates</a><li>

<li><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/icons/profile.jpg" border="0" alt="My Profile" />
<a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $myid;?>" title="My Profile">My Profile</a><li>
<li><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/icons/wall.jpg" border="0"  alt="walls"/>
<a href="<?php echo $this->docroot;?>profile/wall/?id=<?php echo $myid;?>" title="Walls">Walls</a><li>

<li><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/icons/photos.jpg" alt="photos"/>
<a href="<?php if($this->userid==$myid) { ?><?php echo $this->docroot;?>photos/?uid=<?php echo $myid;?> <?php } else {?>/photos/friends_photo/?uid=<?php echo $myid;?><?php } ?>" title="Photos">Photos</a><li>

<li>
<img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/invitefriends.jpg" border="0"  alt="Invite Friends"/>
<a href="<?php echo $this->docroot;?>users/invite_friends" title="Invite Friends">Inivite Friends</a><li>

<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/settings.jpg" border="0"  alt="Settings"/>
<a href="<?php echo $this->docroot;?>users/settings" title="Settings">Settings</a><li>




<?php }else{

?>
<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/profile.jpg" border="0" alt="Profile" />
<a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $myid;?>" title="Profile">Profile</a><li>

<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/myupdates.jpg" border="0" alt="updates" />
<a href="<?php echo $this->docroot;?>updates/myupdate/?id=<?php echo $myid;?>" title="Updates">Updates</a><li>

<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/wall.jpg" border="0"  alt="walls"/>
<a href="<?php echo $this->docroot;?>profile/wall/?id=<?php echo $myid;?>" title="Walls">Walls</a><li>

<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/icons/photos.jpg" alt="photos"/>
<a href="<?php if($this->userid==$myid) { ?><?php echo $this->docroot;?>photos/<?php } else {?>/photos/friends_photo/?uid=<?php echo $myid;?><?php } ?>" title="Photos">Photos</a><li>

<?php 

if (count($this->template->find_frnd_not) == 0) 
{
?>
<li><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/user.jpg" alt="Add as friend"/>
<a href="<?php echo $this->docroot; ?>profile/add_friend_left/?uid=<?php echo $myid;?>" title="Photos">Add as friend</a><li>
<?php 
}
}
?>
</ul>
</div>
</div>
</div>
