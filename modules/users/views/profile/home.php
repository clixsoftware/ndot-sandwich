<?php //echo new View("friends/friends_request"); ?>
<?php echo new View("profile/users_status_mes"); ?>
<?php 
//check the user friends updates
	if(($this->template->view_update == "true")){
?>
<h3 class=" border_bottom mb-20 clear">Friends Updates</h3> 
<?php  
		echo new View("upd_updates"); 
	}
?>
