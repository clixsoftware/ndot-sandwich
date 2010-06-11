<?php
/**
 * Defines creating videos
 *
 * @package    Core
 * @author     M.BalaMurugan
 * @copyright  (c) 2010 Ndot.in
 */
 
?>
<script>
window.onload= function(){ document.getElementById('url').focus(); }

	$(document).ready(function()
	{
		//for create form validation
		$("#video").validate();
	});


</script>

<form  action="<?php echo $this->docroot;?>video/createvideo/" method="post" class="out_f" name="video" id="video" >
  <table border="0"  cellspacing="5"   class="mt-10 mb-10 ml-10"  cellpadding="4">
    <tr>
      <td class="span-4 text-right"><label>Video URL : </label></td>
      <td><input type="text" name="url" id="url"  title= "Enter Valid Youtube URL"  class="required url  text width325" tabindex="1">
      <div class= "quiet">Ex: http://www.youtube.com/watch?v=7dGjAgXBl</div>
      </td>
    </tr>
    <tr>
      <td class="span-4 text-right"><label>Category :</label></td>
      <td><select name="category" id="category"  class="required" tabindex="2" title= "Select Category for Video">
          <option selected="selected" value="">Select Category</option>
          <?php foreach($this->template->get_category as $cat){ ?>
          <option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->category; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
      <?php   echo UI::btn_("Submit", "upd", "Upload", "", "","add_url","video");?>
<?php   echo UI::btn_("button", "upd", "Cancel", "", "window.location='".$this->docroot."video/createvideo/'","video","video");?>
  </td>
    </tr>
  </table>
</form>
<hr>
<h3>All Videos</h3>
<? //php echo new View("video"); ?>
<!--manage Videos -->
<?php 
 if(count($this->template->get_videos)>0)
 {
	foreach($this->template->get_videos as $row)
	{?>
<script>
			 $(document).ready(function(){
			 $("#edit<?php echo $row->video_id; ?>").click(function(){ $("#edit_show<?php echo $row->video_id; ?>").toggle("slow"); });
	 $("#delete_<?php echo $row->video_id;?>").click(function(){ $("#delete_form<?php echo $row->video_id;?>").toggle("show") });
	 $("#close<?php echo $row->video_id;?>").click( function(){  $("#delete_form<?php echo $row->video_id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->video_id;?>").click( function(){  $("#delete_form<?php echo $row->video_id;?>").hide("slow");  });
			 });
			 </script>
<div class="span-19 border_bottom p20">
  <div class="span-2 borderf p2 v_w "> <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" class=""> <span class="videobox" style="background-image:url(<?php echo $row->thumb_url; ?>);"> <em> </em> </span></a> </div>
  <div class="span-10  pl-10">
    <p class="span-10"> <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <strong><?php echo htmlspecialchars_decode(ucfirst($row->video_title));?> </strong> </a> </p>
    <ul class="inlinemenu">
      <li> <span>Category : <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $row->cat_id;?>" title="<?php echo $row->category; ?> " class="admin"><?php echo $row->category; ?></a> </span> </li>
    </ul>
    <p > <?php echo htmlspecialchars_decode(ucfirst($row->video_desc)) ;?> </p>
    <div class="span-15">
      <ul class="inlinemenu">
        <li> <span class="color999">Posted By</span>
          <?php  Nauth::get_Name($row->user_id); echo "on "; echo "<span  class='color999'>".common::getdatediff($row->date)."</span>";  ?>
        </li>
        <li><img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 ">Comments(<?php echo $row->comment_count; ?>)</li>
        <li><a href="<?php echo $this->docroot;?>video/view_video?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 "><?php echo $row->video_viewed; ?> Views</a> </li> 
      </ul>
    
    </div>
  </div>
  <div id="edit_show<?php echo $row->video_id; ?>" class="span-15 hide">
    <table>
      <form  action="<?php echo $this->docroot;?>video/edit_video" method="post"  name = "edit<?php echo $row->video_id; ?>" id = "edit<?php echo $row->video_id; ?>">
        <input type="hidden" name="video_id" id="video_id" value="<?php  echo $row->video_id; ?>" >
        <tr>
          <td>Title </td>
          <td><input type="text" name="video_title" id="v_title" value="<?php  echo htmlspecialchars_decode($row->video_title); ?>" size="50"></td>
        </tr>
        <tr>
          <td valign="top">Description </td>
          <td><input type="text" size="50" name="desc" id="desc" value="<?php  echo htmlspecialchars_decode($row->video_desc); ?>" size="5" ></td>
        </tr>
        <!-- <tr><td valign="top">Emmbed Code </td>
                <td><textarea name="emb_code" id="emb_code" cols="37" rows="6" ><?php  echo htmlspecialchars_decode($row->
        embed_code); ?>
        </textarea>
        </td>
        </tr>
        
        -->
        <tr>
          <td>&nbsp;</td>
          <td><?php   echo UI::btn_("Submit", "edit", "Edit", "", "","edit","edit".$row->video_id);?>
          </td>
        </tr>
      </form>
    </table>
  </div>
  <!-- for delete -->
  <div id="delete_form<?php echo $row->video_id;?>" class="delete_alert" style="clear:both;">
    <h3 class="delete_alert_head">Delete Comment</h3>
    <span class="fl"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->video_id;?>"  ></span>
    <div >Are you sure to delete this video? </div>
    <div>
      <input type="button" name="delete_com" id="delete_com" value="Delete" onclick="window.location='<?php echo $this->docroot;?>video/delete_video/?id=<?php echo $row->video_id;?>'"  />
      <input type="button" name="cancel" id="cancell<?php echo $row->video_id;?>"  value="Cancel" />
    </div>
  </div>
</div>
<?php 
	}?>
<?php
}
else
{
echo UI::nodata_();
}
?>
<div class="span-15">
  <?php 
if(count($this->template->get_allvideos)>10)
{
echo $this->template->pagination1; } ?>
</div>
