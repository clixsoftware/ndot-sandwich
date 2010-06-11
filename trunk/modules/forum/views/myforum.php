<script>
//delete forum

function delete_forum(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>forum/delete/?fid='+id;
}
}
</script>

<!-- contents start -->
<?php
						
if (count($this->result)!= 0)
{
        //show the counts
                echo UI::count_(count($this->result));
                
	foreach($this->result as $row)
	{
	 			 
 ?>

			<script>
			 $(document).ready(function(){
			 $("#edit<?php echo $row->topic_id; ?>").click(function(){ $("#edit_show<?php echo $row->topic_id; ?>").toggle("slow"); });
	 $("#delete_<?php echo $row->topic_id;?>").click(function(){ $("#delete_form<?php echo $row->topic_id;?>").toggle("show") });
	 $("#close<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
			 });
			 </script>
				 
        <div class="span-19 pl-10 border_bottom mb-10 pb-10">
        <div class="span-1a fl">
	<?php 
	Nauth::getPhoto($row->author_id,$row->name);
	?>
	</div>

    <div class="span-17 ml-10">
    <p class="span-17">
    <a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" title="<?php echo $row->topic; ?>" class="text_bold">
    <?php echo $row->topic; ?></a> <br>
    </p>
	<div class="span-17">
        <ul class="inlinemenu">
        <li class="color999"><?php Nauth::print_name($row->author_id,$row->name); ?> </li>
	<li><span class="quiet">Last Active</span> <?php echo common::getdatediff($row->lpost);?></li>
	<li class="color999"><span>in</span>
	<a href="<?php echo $this->docroot ;?>forum/search/?id=<?php  echo $row->category_id; ?>" title="<?php  echo $row->forum_category; ?>">
	<?php  echo $row->forum_category; ?></a></li>
	<li class="color999">
	<a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" title="<?php echo $row->topic; ?>">Replies (<?php echo $row->posts;?>) </a> </li>
        <li class="color999"><a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" title="<?php echo $row->topic; ?>" class="text_bold">Views (<?php echo $row->hit;?>)</a></li>
	
	</ul>
	</div>
	
	 <!--<div class="span-17">
	<span><a href="<?php echo $this->docroot;?>forum/edit/?id=<?php echo $row->topic_id;?>" title="Edit Forum">Edit</a> &nbsp;
<a href="javascript:;" id="delete_<?php echo $row->topic_id;?>" title="Delete ">&nbsp;Delete</a>
	</div>-->
	
	<div class="span-10 mt-10">
    <?php  echo UI::btn_("button", "Edit", "Edit", "", "javascript:window.location='".$this->docroot."forum/edit/?id=".$row->topic_id."'", "Edit","Edit");?>
    <?php  echo UI::btn_("button", "Delete", "Delete", "", "", "delete_".$row->topic_id."","Delete");?>
    </div>

	</div>
                <!-- for delete -->
		<div id="delete_form<?php echo $row->topic_id;?>"  class="width400 delete_alert clear ml-10 mb-10 ">
		<h3 class="delete_alert_head">Delete Discussion</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->topic_id;?>"  ></span>
		<div class="clear fl">Are you sure want to delete? </div>
		<div class="clear fl mt-10" > 
		
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."forum/delete/?fid=".$row->topic_id."' ", "delete_blog","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->topic_id."","");?>
			
		</div>
		</div>
	</div>

<?php } ?>
<?php
if(count($this->cout) >15) {
echo $this->template->pagination;
}
?>

<?php
}
else
{
  echo UI::nodata_();
  
 }
?>




