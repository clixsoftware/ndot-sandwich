<?php
/**
 * Defines one album photo... List out all photos in one album.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>

<script>
function delete_photo(pid,aid)
{

var answer = confirm ("Are you want to delete?")
if(answer)
{ 
  window.location="<?php echo $this->docroot;?>admin_photos/delete_photo/?photo_id="+pid+"&album_id="+aid;
}
 
}
</script>



<div id="cont_pb" style="margin:10px;">

<?php
	if(count($this->template->view_albumphoto) > 0){
  		echo UI::a_tag("","","Upload Photos",$this->docroot."admin_photos/upload/?album_id=".$this->template->view_albumphoto['mysql_fetch_row']->album_id);
 	} 
?>

<?php 

$page = 1;
if($this->template->pagination->current_page > 1){
	$page = $this->template->pagination->current_first_item;
}

if (count($this->template->show_photo) > 0)
{
$i = 3;
$k = 1;
?>
<br />
<div style="border:1px solid #ccc;" class="mt-10">
<?php 
foreach ($this->template->show_photo as $row)
{

if ($i % 3 == 0)
{
?>
<div   style=" background:#f1f2f1;overflow:hidden;margin-left:10px;_margin-left:10px;margin-bottom:10px;height:auto;padding-bottom:10px;">
<?php 
}
?>
	<script>
	$(document).ready(function()
	{
			 $("#delete_<?php echo $row->photo_id;?>").click(function(){  $("#delete_form<?php echo $row->photo_id;?>").toggle("show") });
			 $("#close<?php echo $row->photo_id;?>").click( function(){  $("#delete_form<?php echo $row->photo_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->photo_id;?>").click( function(){  $("#delete_form<?php echo $row->photo_id;?>").hide("slow");  });
	});
	</script>
		<div align="center" style="width:235px;float:left;margin:3px;" > 

		<div style="overflow:hidden;border:1px solid #ccc;padding:3px;">
		<a href="<?php echo $this->docroot;?>admin_photos/zoom/<?php echo $page?>?album_id=<?php echo $row->album_id;?>" title="<?php echo $row->photo_title;?>">
		<img src="<?php echo $this->docroot;?>/public/album_photo/<?php echo $row->photo_id;?>.jpg" alt="<?php echo $row->photo_title;?>"  />
		</a>
		</div>

		<div id="name<?php echo $row->photo_id;?>"><?php echo substr($row->photo_title, 0, 10);?></div>

		<div class="photo_name" id="ed<?php echo $row->photo_id;?>">
		
		<?php  echo UI::btn_("button", "edit", "Edit", "", "", "photo_edit".$row->photo_id."","edit"); ?>
		&nbsp;&nbsp;
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "", "delete_".$row->photo_id."","Delete"); ?>
		
		</div>
		
		
		<div id="delete_form<?php echo $row->photo_id;?>" class="delete_alert width300 borderf clear mt-20"  >
		<h3 class="delete_alert_head width280">Delete Photo</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->photo_id;?>"  ></span>
		<div  class="clear fl">Are you sure want to delete? </div>
		<div class="mt-10 clear fl"> 
 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_photos/delete_photo/?photo_id=".$row->photo_id."&album_id=".$row->album_id."'", "Delete","Delete");?> 
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->photo_id."","Cancel");?>
		
		</div>
		</div>
	 
		
		

		<?php //jquery for edit album ?>

		<script>
		$(document).ready(function()
		{

		/*edit album*/
		$("#photo_edit<?php echo $row->photo_id;?>").click(function()
		{

		$("#edit_photo<?php echo $row->photo_id;?>").show("slow");
		});
		/*cancel edit album album*/
		$("#cancel<?php echo $row->photo_id;?>").click(function()
		{
		$("#edit_photo<?php echo $row->photo_id;?>").hide("slow");
		});

		});
		</script>

		<div class="delete_alert width300 borderf clear mt-20"  id="edit_photo<?php echo $row->photo_id;?>">
		<form name="edit_photo" action="<?php echo $this->docroot;?>admin_photos/edit_photo/?photo_id=<?php echo $row->photo_id;?>&album_id=<?php echo $row->album_id;?>" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr><td>&nbsp;</td><td><input type="text" name="photo_name11" value="<?php echo $row->photo_title;?>" /></td></tr>
		<tr><td></td><td><input type="checkbox" name="album_cover" value="<?php echo $row->photo_id;?>" />Album cover</td></tr>
		<tr><td>&nbsp;</td><td><?php  echo UI::btn_("Submit", "Update", "Update", "", "", "update". $row->photo_id."","Cancel");?>&nbsp;<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel". $row->photo_id."","Cancel");?></td></tr>
		</table>
		</form>
		</div>

		</div>
		<!-- end of photo lists-->

	<?php 
	if ($k % 3 == 0)
	{
	echo '</div>';
	}
	$k++;
	$i++;
	$page++;
}
echo '</div>';
	//pagination
	if ($this->total > 9)
	{
	echo $this->template->pagination;
	}

}
else
{
?>
<div class="no_data">No photos available</div>
<?php 
}
?>
</div>

</div>

<?php
if (count($this->template->show_photo) % 3 != 0)
{
echo '</div>';
}
?>
