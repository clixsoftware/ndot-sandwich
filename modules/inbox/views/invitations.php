<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/compose.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo $this->docroot ?>public/themes/<?php echo $this->get_theme;?>/css/jqdialog.css" rel="stylesheet" type="text/css" /> 


 
<!-- contentstart javascript:window.location='login_profile/logout'; -->
 
<div class="span-19a ">
 
<!--leftsidenavigationstart-->
 

<!--leftsidenavigationfinish-->
<div class="span-19b">	

<!--select--all--read--menu--start---> 




<?php 
if (count($this->inboxdata)==0)
{
	if($this->searchvalue!=1)	
	 	UI::nodata_();
	else
		echo UI::noresults_();
}		
else
{
?>
<div class="mail_select1 "  > 
<div class="title_2">Name</div>
<div class="title_1">Email</div>

</div>
<?php 

foreach($this->inboxdata as $inboxcontent)
{

?>


<div>
<div class="s_d" style="padding-left:30px;"><?php echo $inboxcontent->name; ?> </div>
<div class="f_t"><span class="fl"><p class="clear fl text_normal"><?php echo $inboxcontent->email; ?></p></span></div>
</div>

<?php }

} ?>
</div>




<!---mail2 finish-->


<!--select--all--read--menu--start--->
<div class="span-19b"><?php  echo '<div class="pagination">' . $this->pagination->render('classic') .'</div>';  ?>
</div>

</div>

