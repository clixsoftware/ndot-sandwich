<!-- includes all file -->

<?php echo new View("profile/profile_view_submenu"); ?>
<?php
//get the action type
$action=$this->input->get("action"); 
if($action=="wall")
{
	//wall
	echo new View("profile/profile_wall"); 
}
else if($action=="info")
{
	//info
	echo new View("profile/info"); 
}
else if($action=="photos")
{
	//photos
	echo new View("photos_content");; 
}
else
{
 	//user updates
	echo new View("upd_myupdates"); 
}
?>

