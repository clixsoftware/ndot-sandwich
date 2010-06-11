<div style="padding:10px;" class="span-20" >
  <?php
if(count($this->favorites)>0)
{
?>

  <?php
	foreach($this->favorites as $fav)
	{  
	
	?>
        <p>
        <a href="<?php echo urldecode($this->docroot.substr($fav->url,1));?>" title="My favorites">
        <?php echo urldecode($this->docroot.substr($fav->url,1));?> </a>
        </p>

      <?php }
 
}
else
{
	echo UI::nodata_();
}

?>
</div>
