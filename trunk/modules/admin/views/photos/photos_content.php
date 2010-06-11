<?php
/**
 * Defines the photos home page. list out the all albums
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>
<script>
	//delete the album
	function deletealbum(id)
	{

	var answer = confirm ("Are you want to delete?")
	if (answer)
	{
	window.location="<?php echo $this->docroot;?>admin_photos/delete_album/?album_id="+id;
	}
	}

	//jquery to post the album
	$(document).ready(function()
	{
	$("#photo_album").click(function()
	{
	$("#create_album").toggle("slow");
	});
	$("#addcat").validate();

	});

</script>
	<?php //create the album ?>	
	<a  id="photo_album" class="create_new_album" style="margin:10px;" title="Create New Album"></a>

	<div  id="create_album" style="display:none;">
	<form name="addcat" action="<?php echo $this->docroot;?>admin_photos/create_album" method="post" id="addcat">
	<table border="0" cellpadding="2" cellspacing="2">
	<tr>
	<td>Title</td>
	<td><input type="text" name="title" class="required"></td>
	</tr>
	<tr>
	<td valign="top">Description</td>
	<td><textarea name="description" cols="45" rows="7" class="required"></textarea></td>
	</tr>
	<tr>
	<td>Shared with</td>
	<td><select name="share" style="width:150px;">
	<option value="">select</option>
	<option value="0">Everyone</option>
	<option value="1">Only my friends</option>
	<option value="-1">None</option>
	</select></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td><input type="submit" value="Create" class="convey">
	</tr>
	</table>
	</form>
	</div>

<!--album content -->

<?php

if(count($this->template->display_album)>0){
$i=1;
foreach($this->template->display_album as $row)
{
	if($i%2==0){
?>
<div class="span-19 border_bottom">
<?php 
	}
	else{
?>
<div class="span-19 border_bottom">
<?php 
	}
?>

<?php 
    
		$img = "public/album_photo/".$row->album_cover.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($row->album_cover.$row->album_title)."?d=wavatar&s=100"; 
			$img_path = $img_url;
		}  
    ?>

	<div class="span-19">
	<div class="span-3">
	<a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>">
	<img src="<?php echo $img_path?>" title="<?php echo $row->album_title;?>" alt="<?php echo $row->album_title;?>"/> </a>
	</div>

	<div class="span-15">
	<p class="span-15">
	<a href="<?php echo $this->docroot;?>admin_photos/view/?album_id=<?php echo $row->album_id;?>">
	<?php echo substr(htmlspecialchars_decode($row->album_title),0,50);?>&nbsp;(<?php echo $row->total;?>&nbsp;photos)</a>
	<br>
	<?php echo substr(htmlspecialchars_decode($row->album_desc),0,150);?>..,
	</p>
	

	<div class="v_align spa-15">
	<ul class="inlinemenu">
	<li><a href="<?php echo $this->docroot;?>admin_photos/view/?album_id=<?php echo $row->album_id;?>">View Album</a>&nbsp;|</li>
	
	<?php 
	if( ($this->add_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{
	?>
	<li><a href="<?php echo $this->docroot;?>admin_photos/upload/?album_id=<?php echo $row->album_id;?>">Add More Photos</a>&nbsp;|</li>
	<?php } ?>
	
	<?php 
	if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{ ?>
	<li><a id="edit<?php echo $row->album_id;?>" style="cursor:pointer;">Edit Album</a>&nbsp;|</li>
	<?php } ?>
	
	<?php 
	if( ($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{ ?>
	<li><a href="javascript:;" id="delete_<?php echo $row->album_id;?>" title="Delete album"><img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />&nbsp;&nbsp;Delete</a>&nbsp;|</li>
	<?php } ?>
	<li><span>Posted by</span>&nbsp;<a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $row->id;?>"><?php echo $row->name;?></a>&nbsp;|&nbsp;</li>
	<?php 
	if(($row->DATE)==0)
	{
	echo '<li> on&nbsp;today</li>';
	}
	elseif(($row->DATE)==1)
	{
	echo '<li>on&nbsp;'.$row->DATE.'&nbsp;day ago</li>';
	}
	else
	{
	echo '<li>on&nbsp;'.$row->DATE.'&nbsp;days ago</li>';
	}
	?>
	</ul>
	</div>
	</div>

	<?php //jquery for edit album ?>
	<script>

	$(document).ready(function()
	{
			$("#edit<?php echo $row->album_id;?>").click(function(){ $("#edit_album<?php echo $row->album_id;?>").toggle("slow");	});
			 $("#delete_<?php echo $row->album_id;?>").click(function(){ $("#delete_form<?php echo $row->album_id;?>").toggle("show") });
			 $("#close<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->album_id;?>").click( function(){  $("#edit_album<?php echo $row->album_id;?>").hide("slow");  });

	});
	</script>

	<?php //edit album form ?>

	<div style="margin-top:0px;margin-left:115px;width:600px;display:none;float:left;" id="edit_album<?php echo $row->album_id;?>">
	<form name="edit_form" action="<?php echo $this->docroot;?>admin_photos/edit/?album_id=<?php echo $row->album_id;?>" method="post">
	<table border="0" cellpadding="2" cellspacing="5">
	<tr><td>Title</td><td><input type="text" style=" width:500px" name="edit_title" value="<?php echo $row->album_title;?>"/></td></tr>
	<tr><td valign="top">Description</td><td><textarea name="edit_description" rows="7" style=" width:500px"><?php echo $row->album_desc;?></textarea></td></tr>
	<tr><td>&nbsp;</td><td><?php  echo UI::btn_("Submit", "Update", "Update", "", "", "update". $row->album_id."","update");?>&nbsp;<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->album_id."","Cancel");?></td></tr>
	</table>
	</form>
	</div>
		<!-- div for delete album -->
		<div id="delete_form<?php echo $row->album_id;?>"class="delete_alert width300 borderf clear mt-20">
		<h3 class="delete_alert_head width280">Delete Album</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->album_id;?>"  ></span>
		<div class="clear fl">Are you sure to delete this album? </div>
		<div> 
		
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_photos/delete_album/?album_id=".$row->album_id."'", "Delete","Delete");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->album_id."","Cancel");?>
		
		</div>
		</div>
</div>
</div>
<?php //closing div for album 

$i++;
}


}
else
{
echo UI::nodata_();
}

?>


<?php 
if($this->total> 10){
	echo $this->template->pagination;
}
?>

