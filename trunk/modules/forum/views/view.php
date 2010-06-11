<script type="application/javascript" language="javascript" >
// to validate the fields in post reply form
	$(document).ready(function()
	{
		//for create form validation
		$("#create_form").validate();
	});
</script>

<?php 
//$protocol = $_SERVER['HTTP'] == 'on' ? 'https' : 'http';
$a= $_SERVER["REQUEST_URI"];
$uri = substr($this->docroot,0,-1);
$url = $uri.$a;
?>

<?php
//forum information

if (count($this->get_forum_info)!= 0)
{
	foreach($this->get_forum_info as $row)
	{
	$author_id = $row->author_id;
	$f_id = $row->topic_id;
	$f_topic = $row->topic;			 
 ?>
        <div class="span-19a ml-10 mt-20 clear">
        <div class="span-5 fl"> 
	 <?php 
	//Nauth::getPhoto($row->author_id,$row->name);
	
	    $this->miniuserid = $row->author_id; // assign user ID here
            echo new view("profile/profile_view_mini");
        
	?>

	</div>

	<div class="span-13  ml-10">
        <p class="span-13">
    <?php echo htmlspecialchars_decode(nl2br($row->topic_desc));?>   
	</p>
	 
	 <div class="span-13">
         <ul class="inlinemenu">
         <li class="color999"><?php Nauth::print_name($row->author_id,$row->name); ?> </li>
         <li> <span class="quiet">Last Active</span> <?php echo common::getdatediff($row->lpost);?></li>
	<li class="color999"><span>in</span>
	<a href="<?php echo $this->docroot ;?>forum/search/?id=<?php  echo $row->category_id; ?>" title="<?php  echo $row->forum_category; ?>"><?php  echo $row->forum_category; ?></a>
	
	<li class="color999"><a href="#reply_start">Replies (<?php echo $row->posts;?>) </a></li>
        <li class="color999">Views (<?php echo $row->hit;?>)</li>
        
	</ul>
	</div>
	<div class="span-4 mt-10" ><?php echo favourite::my_favourite(urlencode($_SERVER['REQUEST_URI'])); ?></div>
<div class="span-7 mt-10" ><?php common::show_ratings($url,5,$row->topic_id);?></div>
	</div>
	</div>

<?php } 
} ?>


	    

<h3 id="reply_start" class="color2899DD pl-10 mb-10 mt-10 span-19 fl">Replies <?php if(count($this->get_comment)>0) { ?>(<?php echo count($this->get_comment);?>) <?php } ?></h3>
<?php
//start the discussion
if(count($this->get_comment)>0) 
{ ?>
<?php 
	foreach($this->get_comment as $row)
	{
	
	?>
	<div class="span-19a pl-10 clear fl border_bottom">
        <div class="span-1a fl ">

	 <?php 
	Nauth::getPhoto($row->commentor_id,$row->name);
	?>

	</div>

	<div class="span-17 ml-10 ">
        <p class="span-17 ml-10">
	<h3><?php echo htmlspecialchars_decode($row->subject); ?> </h3>
        <p><?php echo htmlspecialchars_decode($row->desc);?></p>
	</p>
    
	<div class="span-16">
        <ul class="inlinemenu">
	
	<li class="color999"><?php Nauth::print_name($row->commentor_id,$row->name); ?> </li>
	
	<li><span class="quiet">Posted on</span> <?php echo common::getdatediff($row->cdate);?></li>
	
	<?php 
	if($author_id == $this->userid || $row->commentor_id == $this->userid || $this->usertype == -1)
	{
	?>
	<li class="color999"><a href="javascript:;" id="delete_<?php echo $row->discuss_id;?>" title="Delete ">Delete</a></li>
	<?php } ?>
	
	</ul>
	</div>
                <script>
                $(document).ready(function(){
                 $("#delete_<?php echo $row->discuss_id;?>").click(function(){ $("#delete_form<?php echo $row->discuss_id;?>").toggle("show") });
                 $("#close<?php echo $row->discuss_id;?>").click( function(){  $("#delete_form<?php echo $row->discuss_id;?>").hide("slow");  });
                 $("#cancell<?php echo $row->discuss_id;?>").click( function(){  $("#delete_form<?php echo $row->discuss_id;?>").hide("slow");  });
		         });
	         </script>
	 
	         <!-- for delete -->
		<div id="delete_form<?php echo $row->discuss_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Reply</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->discuss_id;?>"  >
		</span>
		<div class="clear fl">Are you sure want to delete this Reply? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."forum/delete_discussion/?cid=".$row->discuss_id."&fid=".$f_id."&title=".$f_topic."' ", "delete_discussion","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->discuss_id."","");?>
		</div>
		</div>
		
	</div>
	</div>

	<?php
	} ?>

	<?php 
	//pagination link
	 if(count($this->cout)>10) echo $this->template->pagination;?>

<?php
}
else
{ ?>
      <div class="clear">
      <?php   echo UI::nodata_(); ?>
      </div>
<?php }
?>
<h3 class="color2899DD pl-10 mb-5 mt-5 clear fl">Post Your Reply</h3>
<hr/>
<div class="span-17 pl-10">
        <!--post comment jquery -->
        <form name="create_form" action="<?php echo $this->docroot;?>forum/postcomment" method="post" id="create_form">
        <table borde="0" cellpadding="5">
        <input type="hidden" name="last_segment" value="<?php echo $this->title;?>" />
        <input type="hidden" name="id" value="<?php echo $this->forum_id;?>" />
        <tr><td valign="top" valign="top"><label>Subject</label></td>
        <td><input type="text" name="subject" id="subject" size="50" class="span-11 required title" title="Enter the Subject" /></td></tr>
        <tr><td style="vertical-align:top;"><label>Description</label></td>
        <td><textarea name="comments" cols="56" rows="6" id="comments"  class="required" title="Enter the Description"></textarea></td></tr>
        <tr><td>&nbsp;</td><td>
         <?php  echo UI::btn_("Submit", "create_discussion", "Post Reply", "", "", "new_discussion","new_discussion");?>
         <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."forum' ", "cancel","");?>
        </td></tr>
        </table>
        </form>
        </div>



