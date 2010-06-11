<?php
/**
 * Defines creating videos
 *
 * @package    Core
 * @author     M.BalaMurugan
 * @copyright  (c) 2010 Ndot.in
 */
 
?>

<?php   

if(count($this->related_videos)>0)
{
?>
<div class="span-19 suggestion borderf p2 overflowh pb-10  ">   
<h3 class=" sub-heading  ">Related Video <?php if(count($this->related_videos)>=3){ ?> <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $this->show_video['mysql_fetch_object']->cat_id ?>&cat_name=<?php echo $this->show_video['mysql_fetch_object']->category; ?>" class="fr mr-10"> View All</a> <?php } ?></h3>
	<table border="0"><tr>
	<?php 
	foreach ($this->related_videos as $row )
	{?><td>
	<div class=" text_center clear fl mt-5 mb-5 ">
	        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>">
		<strong><?php echo htmlspecialchars_decode(substr($row->video_title, 0,15)).".."; ?></strong>
		</a>
	</div>
	
	
        <div class="span-2a   clear fl   " >
        <div class="span-1-5 ml-10 pb-10"  > 
        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>" >
        <span class="pop_videobox" > <img src="<?php echo $row->thumb_url ?>" title="<?php echo $row->video_title;?>" alt="<?php echo $row->video_title;?>"></span>
        </a>
        <?php ?>
        </div>
        <div class=" text_center clear fl mt-5 mb-5 ">
        <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>">
				<span class="queit">Viewed :</span><?php echo $row->video_viewed; ?>
			</a>
        </div>
        </div></td>
        <?php    
	}
	?></tr></table>
	<?php 
}
      ?>  
 
