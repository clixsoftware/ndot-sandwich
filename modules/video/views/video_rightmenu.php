<?php
/**
 * Defines creating videos
 *
 * @package    Core
 * @author     M.BalaMurugan
 * @copyright  (c) 2010 Ndot.in
 */
 
?>
<div class="span-5  borderf p2">
<h2 class="sub-heading">Video Category</h2>
<ul class="pl-10 mt-10 mb-10">
 <?php
if(count($this->get_category)>0)
{
	foreach($this->get_category as $row)
	{
	if($row->category!='')
	{
	?>
		<li class="line-height25"> <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $row->cat_id;?>&cat_name=<?php echo urlencode($row->category);?>" class="pl-5">
		
		<strong><?php echo $row->category;?></strong></a></li>
	<?php
	}
	}
}
else
{
	echo UI::nodata_();
}?>

</ul>
</div>

<?php   

if(count($this->template->get_pop_videos)>0){
?>
<div class="span-5 suggestion borderf p2 overflowh pb-10 ">
<h3 class=" sub-heading  ">Most Viewed Video <?php if(count($this->template->get_pop_videos)>=4){ ?> <a href="<?php echo $this->docroot;?>video/popularvideos" class="fr"> View All</a> <?php } ?></h3>
	<?php 
	foreach ($this->template->get_pop_videos as $row )
	{?>
	<div class=" text_center clear fl mt-5 mb-5 ">
	        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>">
		<strong><?php echo htmlspecialchars_decode($row->video_title); ?></strong>
		</a>
	</div>
        <div class="span-3 border_bottom clear fl " >
        <div class="span-1-5 ml-30 pb-10"  > 
        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>" >
        <img src="<?php echo $row->thumb_url ?>" title="<?php echo $row->video_title;?>" alt="<?php echo $row->video_title;?>">
        </a>
        <?php ?>
        </div>
        <div class=" text_center clear fl mt-5 mb-5 ">
        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>">
				<span class="queit">Viewed :</span><?php echo $row->video_viewed; ?>
			</a>
        </div>
        </div>
        <?php    
	}
}
      ?>  
</div>
</ul>
</div>
