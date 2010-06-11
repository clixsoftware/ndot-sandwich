<?php 
//$protocol = $_SERVER['HTTP'] == 'on' ? 'https' : 'http';
$a= $_SERVER["REQUEST_URI"];
$uri = substr($this->docroot,0,-1);
$url = $uri.$a;
?>
<script>
$(document).ready(function()
	{
		//for create form validation
		$("#post").validate();
	});

</script>

<?php 
   foreach ( $this->template->name as $row )
   {
        $this->author_id = $row->user_id;
        $this->type_id = $row->blog_id;
   ?>
   
   <div class="span-19a ml-10 mt-20">
   

    <div class="span-18  ml-10">
    <p class="span-18">
    	<?php echo nl2br(htmlspecialchars_decode($row->blog_desc));?>
    </p>
    
    <div class="span-18">
    <ul class="inlinemenu">
    <li class="color999"><?php Nauth::print_name($row->user_id,$row->name); ?> </li>
    <li> <span class="quiet">Posted on</span> <?php echo common::getdatediff($row->DATE);?></li> 
    
   <li><span class="quiet">in</span>
   <a href="<?php echo $this->docroot ;?>blog/category/?id=<?php  echo $row->blog_category; ?>" title="<?php  echo $row->category_name; ?>" class="pl-3">
   <?php echo $row->category_name;?></a></li>
 
    </ul>
    </div>
    <div class="span-5 mt-10" ><?php echo favourite::my_favourite(urlencode($_SERVER['REQUEST_URI'])); ?></div>
<div class="span-7 mt-10" ><?php common::show_ratings($url,2,$this->type_id);?></div>
    </div>
     
    </div>

        <?php common::get_comments($this->module."_comments",$this->type_id);?>
        	 
     <?php } ?>
        
        </div>

	
