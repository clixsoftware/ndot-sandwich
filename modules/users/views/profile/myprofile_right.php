<?php $uid=$this->user_id;?>
<div>
<a href="<?php echo $this->docroot;?>profile/wall?id=<?php echo $uid;?>">Wall</a> &nbsp; | &nbsp;
<a href="<?php echo $this->docroot;?>profile/view?uid=<?php //echo $this->template->id;?>&action=info">Info</a> &nbsp; | &nbsp;
<a href="<?php echo $this->docroot;?>updates/myupdate?uid=<?php //echo $this->template->id;?>&action=updates">Updates</a> &nbsp; | &nbsp;
<a href="<?php echo $this->docroot;?>photos/?uid=<?php //echo $this->template->id;?>&action=photos">Photos</a>
</div>
<?php //echo new View("profile/profile_view_submenu"); ?>
<?php echo new View("profile/users_status_mes"); ?>
<?php echo new View("friends/friends_request"); ?>
<?php echo new View("profile/profile_wall"); 

//check the user friends updates

/*if(($this->template->view_update=="true"))
{?>
<h3 class="sub-heading">Friends Updates</h3>
<?php  echo new View("upd_updates"); 
}*/
?>


<?php //$action_type=$this->input->get("action");
?>

