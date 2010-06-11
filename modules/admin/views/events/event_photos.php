<div class="span-19 ml-20 mt-15 mb-15">
<?php
if(count($this->template->event_photos) > 0) 
{
	foreach($this->template->event_photos as $photos)
	{
		$file_path= end(explode('.', $photos->photo_name));
?>		
		<div class="event_photo_show fl width145 ml-3 ">
		<div class="event_photo_show_img borderf">
		<img src="<?php echo $this->docroot; ?>public/event_photos/<?php echo $photos->photo_id.'.jpg'; ?>" alt="Event Photo" "  />
		</div>
       <!-- <p class="text_center"><a href="<?php echo $this->docroot;?>events/delete_event_photo/?photo_id=<?php echo $photos->photo_id; ?>&event_id=<?php echo $photos->event_id; ?>"   />Delete</a></p> -->
        <div class="span-2 ml-40 mt-5">
        <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_events/delete_event_photo/?event_id=".$photos->event_id."&photo_id=".$photos->photo_id."'", "Delete","Delete");?> 
        </div>
		</div>
<?php
	}
}
else
{
echo UI::nodata_();
}
?>
</div>
