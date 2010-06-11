<?php 
/**
 * Defines listing videos
 *
 * @package    Core
 * @author     M.BalaMurugan
 * @copyright  (c) 2010 Ndot.in
 */
 ?>
<!--manage Videos -->
<script src="<?php echo $this->docroot;?>/public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>

<div class="span-15 border_bottom">
  <form name = "search" id = "search" action = "/video/commonsearch/" method = "get">
    <table>
      <tr>
        <td valign="top"><?php     $search_type = $this->uri->last_segment(); ?>
          <input type="hidden" name ="search_type" value="<?php echo $search_type  ?>">
          <input type= "text" name = "search_value"  id = "search_value" size = "40" title= "Enter youtube URL " />
          <div class="quiet">Ex:Search video,Category,User </div></td>
        <td class="pl-10"><?php   echo UI::btn_("Submit", "vsearch", "Search Video", "", "","search","search");?></td>
        <td><?php   echo UI::a_tag("updvideo","updvideo","Upload Video",$this->docroot."video/createvideo/");?>
        </td>
      </tr>
    </table>
  </form>
</div>
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
			  
			  
			  /* for highlighting search */
			  $(function () {
			$(".runnable")
				.attr({ title: "Click to run this script" })
				.css({ cursor: "pointer"})
				.click(function () {
					// here be eval!
					eval($(this).text());
				});

			$('div p').highlight('<?php if(isset($_GET["search_value"]))echo $this->value;?>');
		});
			 </script>
<div class="span-15 border_bottom ">
  <div class="span-2 borderf p2 v_w "> <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" class=""> <span class="videobox" style="background-image:url(<?php echo $row->thumb_url; ?>);"> <em> </em> </span></a> </div>
  <div class="span-10 pl-10">
    <p class="span-10"> <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <?php echo ucfirst(htmlspecialchars_decode($row->video_title));?>  </a> </p>
    <p >Category : <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $row->cat_id;?>" title="<?php echo $row->category; ?> " class="admin"><?php echo $row->category; ?></a> </p>
    <p class="clear fl  line-height20 "> <?php //echo htmlspecialchars_decode(ucfirst($row->video_desc)) ;?> </p>
    <div class="span-12">
      <ul class="inlinemenu">
        <li>
          <?php  Nauth::print_name($row->user_id,$row->name);  echo "<span class='color999'>Posted on </span>";
        echo "<span  class='color999'>".common::getdatediff($row->date) ." &nbsp;</span>";  ?>
        </li>
        <li> <a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 "><?php echo $row->comment_count; ?> Comments</a> </li>
        <li><a href="<?php echo $this->docroot;?>video/upd_video_view?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 "><?php echo $row->video_viewed; ?> Views</a> </li>
      </ul>
    </div>
  </div>
  <div class="span-12 last ml-10">
    <ul class="inlinemenu clear fl">
      <?php if($row->user_id == $this->user_id)
                { ?>
      <li> <a href="javascript:;" id="<?php echo "edit".$row->video_id; ?>"><img src="<?php echo $this->docroot;?>public/themes/default/images/icons/edit.gif" /> Edit</a>
        <?php // echo UI::btn_("button", "edit", "Edit", "", "", "edit".$row->video_id."","edit"); ?>
      </li>
      <li> <a href="javascript:;" id="<?php echo "delete_".$row->video_id; ?>"><img src="<?php echo $this->docroot;?>public/themes/default/images/icons/delete.gif" /> Delete</a>
        <?php // echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->video_id."","delete"); ?>
      </li>
      <?php } ?>
    </ul>
  </div>
  <div id="edit_show<?php echo $row->video_id; ?>" class="span-15 hide">
    <table>
      <form  action="<?php echo $this->docroot;?>video/edit_video" method="post"  name = "edit<?php echo $row->video_id; ?>" id = "edit<?php echo $row->video_id; ?>" >
        <input type="hidden" name="video_id" id="video_id" value="<?php  echo $row->video_id; ?>" >
        <tr>
          <td>Title </td>
          <td><input type="text" name="video_title" id="v_title" value="<?php  echo htmlspecialchars_decode($row->video_title); ?>" size="50" class="title"></td>
        </tr>
        <tr>
          <td valign="top">Description </td>
          <td><input type="text" size="50" name="desc" id="desc" value="<?php  echo htmlspecialchars_decode($row->video_desc); ?>" size="5" class="title" ></td>
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
          <td><?php   echo UI::btn_("Submit", "edit", "Save", "", "","edit","edit".$row->video_id);?>
      </form>
    </table>
  </div>
  <!-- for delete -->
  <div id="delete_form<?php echo $row->video_id;?>" class="width400 delete_alert clear ml-10 mb-10">
    <h3 class="delete_alert_head">Delete Video</h3>
    <span class="fr"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->video_id;?>"  > </span>
    <div class="clear fl">Are you sure to delete this video? </div>
    <div class="clear fl mt-10" >
      <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."video/delete_video/?id=".$row->video_id."' ", "delete_video","");?>
      <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->video_id."","");?>
    </div>
  </div>
</div>
<?php 
	}?>
<?php
}
else
{
        if(isset($_GET['search_value']))
        {
        echo UI::noresults_();
        }
        else
        {
        echo UI::nodata_();
        }
}
?>
<div class="span-15">
  <?php 
if(count($this->template->get_allvideos)>10)
{
echo $this->template->pagination1; } ?>
</div>
