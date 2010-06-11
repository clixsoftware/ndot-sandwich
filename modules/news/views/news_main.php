	
	
	
	<?php 
	/**
	 * Defines all  news lists
	 *
	 * @package    Core
	 * @author     Saranraj
	 * @copyright  (c) 2010 Ndot.in
	 */
 	
	$i=1;
	if(count($this->template->news)>0)
	{
	        if($this->input->get("search_text") || $this->input->get("search_category"))
                {
                        echo UI::count_(count($this->template->news));
                }
        
	foreach ($this->template->news as $row )
	{ ?>
        <div class="span-15 pl-10 border_bottom mb-10 pb-10  ">

        <div class="span-1a fl mt-5">
        <?php 
                $img = "public/news_photo/50/".$row->news_photo."";
               
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($row->news_id.$row->news_title)."?d=wavatar&s=40"; 
			$img_path = $img_url;
		}  
		?>

           <a href="<?php echo $this->docroot;?>news/view/<?php echo url::title($row->news_title);?>_<?php echo $row->news_id;?>" title="<?php echo $row->news_title;?>">
            <img   src="<?php echo $img_path;?>" alt="<?php echo $row->news_title;?>"  class="upd_photo" />
            </a>
        </div>	
        
        <div class="span-13 ml-10">
        <p class="span-13">
        <a href="<?php echo $this->docroot;?>news/view/<?php echo url::title($row->news_title);?>_<?php echo $row->news_id;?>" title="<?php echo $row->news_title;?>" class="text_bold" ><?php  echo  $row->news_title; ?></a>  <br />
        <span class="margin_left2">
		<?php $desc=html_entity_decode($row->news_desc); $desc1=strip_tags($desc); echo substr($desc1,0,180).'. . .';?>
        </span>
        </p>
        
        <div class="span-12">
    <ul class="inlinemenu">
        <li class="color999"><span>Posted in</span> 
        <a href="<?php echo $this->docroot;?>news/category/?cate=<?php echo $row->category_id;?>" title="<?php echo $row->category_name;?>"><?php echo $row->category_name;?></a></li>
        
       <li> <span class="quiet">On </span><?php echo common::getdatediff($row->news_date);?></li>
        <li class="color999"> 
        <a href="<?php echo $this->docroot;?>news/view/<?php echo url::title($row->news_title);?>_<?php echo $row->news_id;?>" title="Comments"> Comments (<?php echo $row->comment_count;?>) </a></li>
        </ul>
        </div>
        
        </div>
        </div>
        
	<?php } 
	}
	else
	{ 
	        if($_GET)
	        {
	         echo UI::noresults_();
	        }
	        else
	        {
	                if($this->uri->last_segment() != "search")
	                {
	                        echo UI::nodata_();
	                }
	        }
	} ?>
	
	<?php
	//pagination
	if($this->total>10)
	{
	?>
	<?php  echo  $this->template->pagination; ?>
	<?php } ?>
    
	
