<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<?php 

/**
 * Defines front page of blog
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
  if(count($this->template->get_blog)>0)       
  {
         echo UI::count_(count($this->template->get_blog));
     
        
   foreach ( $this->template->get_blog as $row )
   {
    ?>
               <script>
		  /* for highlighting search */
			  $(function () {
			$(".runnable")
				.attr({ title: "Click to run this script" })
				.css({ cursor: "pointer"})
				.click(function () {
					// here be eval!
					eval($(this).text());
				});

			$('div p').highlight('<?php if(isset($_GET["search_text"]))echo $this->value;?>'); 
			$('div p').highlight('<?php if(isset($_GET["search_value"]))echo $this->value;?>'); 			
		});
			 </script>
 <div class="span-15 pl-10 border_bottom mb-10 pb-10   "  >

     <div class="span-1a fl">
     <?php 
	
	Nauth::getPhoto($row->user_id,$row->name);  ?>
    </div>
  <div class="span-13 ">
    <div class="span-13 ml-10">
    <p class="span-13">
    
    <a href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>" title="<?php echo $row->blog_title; ?>" class="font13 text_bold">  
    <?php echo $row->blog_title; ?> </a> <br>
    <span>
<?php if(strlen(htmlspecialchars_decode($row->blog_desc))>=200) 
	{ 
	echo nl2br(substr(htmlspecialchars_decode($row->blog_desc),0,200))."..."; 
	} else { 
	echo nl2br(htmlspecialchars_decode($row->blog_desc)); 
	}?>
    </span>
    </p>
    </div>
    <div class="span-12  ml-10"> 
    <ul class="inlinemenu">
     <li class="color999"><?php Nauth::print_name($row->user_id,$row->name); ?> </li>
     <li> <span class="quiet">Posted on</span> <?php echo common::getdatediff($row->DATE);?></li> 
   <li class="color999">
   <span>in</span>
      <a href="<?php echo $this->docroot ;?>blog/category/?id=<?php echo $row->blog_category; ?>"><?php echo $row->category_name;?></a></li>
    <li class="color999"> 
    <a  href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>" title="Comments">Comments (<?php echo $row->counts;?>)</a></li>

    </ul>
    </div>
 
    </div></div>
 

<?php 	}
	
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
}
?>

<!-- innercontentfinish-->

<?php if($this->total>15)
  echo $this->template->pagination ; ?>




