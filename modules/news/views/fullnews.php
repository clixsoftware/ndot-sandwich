		
<?php 
                 if(count($this->template->full_news)>0)
		 {
		 foreach ( $this->template->full_news as $row )
   		 {
           		 $this->author_id = $row->user_id;
           		 $this->type_id = $row->news_id;
   		 ?>
            <div class="span-19a ml-10 mt-20">
            
            <div class="span-5 fl">
             <?php 
               // $img = new Image('public/images/saranraj.jpg'); 
               // $img->watermark(new Image('public/images/water.png')); 
               // $img->render(true);
               // exit;
                $img = "public/news_photo/".$row->news_photo."";
               
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($row->news_id.$row->news_title)."?d=wavatar&s=180"; 
			$img_path = $img_url;
		}  
		?>

           <a href="<?php echo $this->docroot;?>news/view/?nid=<?php echo $row->news_id;?>" title="<?php echo $row->news_title;?>">
            <img   src="<?php echo $img_path;?>" alt="<?php echo $row->news_title;?>"  />
            </a>
            </div>
            
            <div class="span-13  ml-10">
               <p class="span-13">  
               <?php $desc=nl2br(html_entity_decode($row->news_desc));    echo $desc; ?>
             </p>
             
              <div class="span-13">
              <ul class="inlinemenu">
              <li class="color999"><span>Posted In</span>
              <a href="<?php echo $this->docroot;?>news/category/?cate=<?php echo $row->category_id;?>" title="<?php echo  $row->category_name; ?>"><?php echo  $row->category_name; ?></a></li>
              <li class="color999">On <?php echo common::getdatediff($row->news_date);?></li>
              
              <li color999>
              <?php UI::share($this->docroot.substr($_SERVER['REQUEST_URI'],1),$row->news_title,$row->news_desc); ?>
              </li>
              <li><?php echo favourite::my_favourite(urlencode($_SERVER['REQUEST_URI'])); ?></li>
              </ul>
              </div>
              
              </div>
              
            </div>
         
	
<?php
   }
   }?>

 <?php common::get_comments($this->module."_comments",$this->type_id);?>	 
 </div>
