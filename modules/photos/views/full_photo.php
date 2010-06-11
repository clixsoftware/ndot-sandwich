<?php
/**
 * Defines all full size photo
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
 
?>
<script type = "text/javascript">

        //jquery to post the album
	$(document).ready(function()
	{
		$("#photo_comment").validate();
	});
</script>

<div class="fl">
  <?php
	foreach ($this->zomm_view  as $row)
	{
	        $this->author_id = $row->user_id;
                $this->type_id = $row->photo_id;
?>
    <div class="span-19b fl text-align">
    <div class="fr mt-20" id="photo"><?php echo UI::a_tag("Back","Back","Back",$this->docroot."photos/view/?album_id=".$row->album_id);?></div>
    
    	<div class="pho_fullimg  p2" style="background:#f8f8f8;"> 
        	<img src="<?php echo $this->docroot;?>public/album_photo/normal/<?php echo $row->photo_id ;?>.jpg" alt="<?php echo $row->photo_desc;?>" title="<?php echo $row->photo_desc;?>" class="imgborder"  />
      <p>
      
    <?php 
    	if($this->photo_index > 1 ){
			if($this->previous_img->count() > 0){
    ?>
    
    
    	<a href="<?php echo $this->docroot;?>photos/zoom/<?php echo $this->photo_index - 1; ?>/<?php echo $this->previous_img->current()->album_id;?>/<?php  echo $this->previous_img->current()->photo_id;?>.html#photo" class="fl"><img src="<?php echo $this->docroot;?>public/themes/default/images/back.gif"  /></a>
    <?php 
			}
    	}
    	if($this->photo_index > 0 && $this->photo_index < $this->album_photo_count ){
		
			if($this->next_img->count() > 0){
    ?>
    	<a href="<?php echo $this->docroot;?>photos/zoom/<?php echo $this->photo_index + 1; ?>/<?php echo $this->next_img->current()->album_id;?>/<?php  echo $this->next_img->current()->photo_id;?>.html#photo" class="fr"><img src="<?php echo $this->docroot;?>public/themes/default/images/more.gif"  /></a>
    <?php 
    		}
		}
	?>
      </p>
      
    </div>
    <p>
    <?php 
    //rating
        $url = substr($this->docroot,0,-1).$_SERVER["REQUEST_URI"];
        common::show_ratings($url,8,$this->type_id);?>

  
    </p>
  </div>
  </div>
  <?php common::get_comments($this->module."_comments",$this->type_id);?>
 
 <?php 
}
?>
</div>
