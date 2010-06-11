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
//$protocol = $_SERVER['HTTP'] == 'on' ? 'https' : 'http';
$a= $_SERVER["REQUEST_URI"];
$uri = substr($this->docroot,0,-1);
$url = $uri.$a;
?>
<script type="application/javascript">
$(document).ready(function(){
$("#share").click(function(){ $("#show_share").toggle("slow"); });
$("#send_mail").click(function(){ $("#send_mail_show").toggle("slow"); });
$("#sendmail").validate();
$("#post").validate();
});   


</script>
<?php 
 //show the video
 if(count($this->show_video)>0)
 {
        $this->author_id = $this->show_video['mysql_fetch_object']->user_id;
        $this->type_id = $this->show_video['mysql_fetch_object']->video_id;
 ?>

<div class="span-19a p10 overflowh  " >
  <div class="span-12 padding3"> <?php echo htmlspecialchars_decode($this->show_video['mysql_fetch_object']->embed_code);?> </div>
  <div class="span-6"> 
  <strong class="mt-10 clear fl mb-10">Description :</strong>
    <p><?php echo htmlspecialchars_decode(ucfirst($this->show_video['mysql_fetch_object']->video_desc)); ?>     </p>
        <strong class="mt-10 clear fl mb-10"> Details :</strong> 

    <ul class="inlinemenu">
              <li><span class="quiet"> Posted By : </span> <span><strong> <?php Nauth::print_name($this->show_video['mysql_fetch_object']->user_id,$this->show_video['mysql_fetch_object']->name) ?></strong></span></li> 
      <li><span class="quiet"> Posted on : </span> <?php echo common::getdatediff($this->show_video['mysql_fetch_object']->date); ?> </li>
      <li ><span class="quiet"> Category : </span>  <?php echo $this->show_video['mysql_fetch_object']->category; ?> </li>
       <li ><span class="quiet"> Tags : </span>  <?php echo $this->show_video['mysql_fetch_object']->video_tag; ?> </li>
      <li ><span class="quiet"> Viewed : </span>  <?php echo $this->show_video['mysql_fetch_object']->video_viewed; ?> </li>
      
      </ul>
      
   
     <strong class="mt-10 clear fl mb-10"> Share This Video :</strong>
                 <!-- For Fshare,Twitter,Orkut and Email -->
                <div class="span-7 ">
                <?php 
		$desc = htmlspecialchars_decode(ucfirst($this->show_video['mysql_fetch_object']->video_desc));
		$title = htmlspecialchars_decode(ucfirst($this->show_video['mysql_fetch_object']->video_title));
		echo UI::share($this->docroot.substr($_SERVER['REQUEST_URI'],1),$title,$desc); 
		?>
	        <?php echo favourite::my_favourite(urlencode($_SERVER['REQUEST_URI'])); ?>
		</div>
		
		</div>
		<span class="ml-10 span-6 fl mt-10"><?php common::show_ratings($url,9,$this->type_id);?></span>
		 <div class="span-7   clear fl">
                <?php echo new View("related_video"); ?>
                </div>
 
</div>
<!-- For Fshare,Twitter,Orkut and Email  div end here-->
<?php  
}
?>

<?php common::get_comments($this->module."_comments",$this->type_id);?>
</div>
