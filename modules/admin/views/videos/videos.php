<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
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
$(document).ready(function() 	{ $("#add_url").validate();	});
window.onload= function(){ document.getElementById('url').focus(); }
$(document).ready(function(){
        $('#add_video').click(function(){
                $('#new_video').toggle('slow');
        });
});
</script>

<div class="notice">Upload / Edit / Delete / Manage Video for your site. You can view User Video Analytics here.  </div>
   <div class="span-18 border_bottom ml-10 pb-20">
   <form name = "search" id = "search" action = "/admin_videos/commonsearch/" method = "get">
   <table border="0" class="span-13">
   <tr>
   <td valign="top" align="left"><input type= "text" name = "search_value"  id = "search_value" size = "40" />
   <div class="quiet"> Ex:Search video,Category,User </div>
   </td>
   <td class="pl-10"><?php   echo UI::btn_("Submit", "vsearch", "Search Video", "", "","search","search");?><?php  echo UI::btn_("button", "Add", "Add", "", "", "add_video","Add");?></td>
  
   </tr>
   </table>
</form>

</div>
 <div class="span-18 border_bottom ml-10 mt-10 pb-20 hide" id="new_video">
<form  action="/admin_videos" method="post"  id="add_url" name = "add_url">
<table border="0"  cellspacing="5"   >
<tr><td align ='left'><label> Video URL :</label></td><td><input type="text" name="url" id="url" size="40" style="height:20px;" class="required url" tabindex="1" title= "Enter Valid Youtube URL">      <div class= "quiet">Ex: http://www.youtube.com/watch?v=7dGjAgXBl</div> </td></tr>
<tr><td align ='left'><label>  Category  :</label> </td>
<td>
<select name="category" id="category"  class="required" tabindex="2" title= "Select Category for Video">
<option selected="selected" value="">Select Category</option>
<?php foreach($this->template->get_cat as $cat){ ?>
<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->category; ?></option>
<?php } ?>
</select>
</td></tr>
<tr><td></td><td>
<?php   echo UI::btn_("Submit", "upd", "Upload", "", "","add_url","add_url");?>
<?php   echo UI::btn_("button", "upd", "Cancel", "", "window.location='".$this->docroot."admin_videos/'","add_url","add_url");?>
</td>
</tr>
</table>
</form>
  </div>
<hr>

 <!--manage Videos -->
<h3>Manage Videos</h3>

 
 <?php
 if(count($this->template->get_videos)>0)
 {
	foreach($this->template->get_videos as $row)
	{?>	          
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

			                $('div p').highlight('<?php if(isset($_GET["search_value"])) echo $_GET["search_value"];?>'); 			
		                });
			 </script>
			<div class="span-19 border_bottom" >
			<script>
			 $(document).ready(function(){
			 $("#edit<?php echo $row->video_id; ?>").click(function(){ $("#edit_show<?php echo $row->video_id; ?>").toggle("slow"); });
			 $("#delete_<?php echo $row->video_id;?>").click(function(){ $("#delete_form<?php echo $row->video_id;?>").toggle("show") });
			 $("#close<?php echo $row->video_id;?>").click( function(){  $("#delete_form<?php echo $row->video_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->video_id;?>").click( function(){  $("#delete_form<?php echo $row->video_id;?>").hide("slow");  });
			 });
			 </script>
			<div class="span-19" >
			<div class="span-4" >
	                <a href="<?php echo $this->docroot;?>video/view_video?video_id=<?php echo $row->video_id; ?>">
			<img src="<?php echo $row->thumb_url; ?>" alt="No video image"></a>
			</div>
			<div class="span-14" >
	                <a href="<?php echo $this->docroot;?>video/view_video?video_id=<?php echo $row->video_id; ?>">
			<p class="span-13"> <?php echo htmlspecialchars_decode(ucfirst($row->video_title));?> </p>
			</a>
			<div class="v_align span-10 ">
			<ul class="inlinemenu">
			<li>
			<?php  
			if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	                {
			        echo UI::btn_("button", "edit", "Edit", "", "", "edit".$row->video_id."","edit");
			}
			?>
			</li>
			<li>
                        <?php  
                        if( ($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	                {
                            echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->video_id."","delete"); 
                        }
                        ?>
			</li>
			<li>
			<?php 
			if( ($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	                {
	
			if($row->status==1)
			{
			 echo UI::btn_("button", "unblock", "Unblock", "", "javascript:window.location='".$this->docroot."admin_videos/video_access?status=0&id=".$row->video_id."' ", "unblock","");

			 }
			else
			{
			  echo UI::btn_("button", "block", "Block", "", "javascript:window.location='".$this->docroot."admin_videos/video_access?status=1&id=".$row->video_id."' ", "block","");
			
			}
			
			}
			 ?>
			</li>
			</ul>
			</div>
			<div class="span-10">
			<ul class="inlinemenu">
			<li > Category: <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $row->cat_id;?>" title="<?php echo $row->category; ?> " class="admin"><?php echo $row->category; ?> </a>
			</li>
			  <li> <a href="<?php echo $this->docroot;?>video/view_video?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 "><?php echo $row->comment_count; ?> Comments</a> </li>
        <li><a href="<?php echo $this->docroot;?>video/view_video?video_id=<?php echo $row->video_id; ?>" title="<?php echo $row->video_title;?>"> <img src="/public/themes/default/images/comment.jpg"  class="verticalalignm mr-5 "><?php echo $row->video_viewed; ?> Viewed</a> </li>
			<li> 
			<img src="<?php echo $this->docroot;?>/public/images/icons/user.jpg" title="Unblock" class="admin" /><?php  Nauth::get_Name($row->user_id); echo "on ".common::getdatediff($row->date);  ?> 
			</li>
			</ul> 
			<div class="span-14">
			<div id="edit_show<?php echo $row->video_id; ?>" class="hide"> 
			<table>
			<form  action="/admin_videos/edit_video" method="post"  name="edit<?php  echo $row->video_id; ?>">
			<input type="hidden" name="video_id" id="video_id" value="<?php  echo $row->video_id; ?>" >
			<tr><td>Title </td><td><input type="text" name="video_title" id="v_title" value="<?php  echo htmlspecialchars_decode($row->video_title); ?>" size="50"></td></tr>
			<tr><td>Description </td><td><input type="text" size="50" name="desc" id="desc" value="<?php  echo htmlspecialchars_decode($row->video_desc); ?>"  ></td></tr>
			<!-- <tr><td>Emmbed Code </td><td><textarea name="emb_code" id="emb_code" style="width:410px;" ><?php  echo htmlspecialchars_decode($row->embed_code); ?></textarea></td></tr> -->
			<tr><td>
			<?php  echo UI::btn_("Submit", "edit", "Edit", "", "", "","edit".$row->video_id);?>
			<!-- input type="submit" name="edit" id="edit" value="Edit" -->
			</td><td>
                        <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_videos' ", "cancel","");?>
                        </td></tr></form>
			</table>
			</div>
	
		
		               <!-- for delete -->
		<div id="delete_form<?php echo $row->video_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Video</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->video_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this video? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_videos/delete_video/?id=".$row->video_id."' ", "delete_video","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->video_id."","");?>
		
		</div>
		</div>
		
		
		
			</div>
			</div>

			</div>
			</div>
			</div><?php 


	}?>
			<div style="float:right;">
			<?php if(count($this->template->get_allvideos)>10) { echo $this->template->pagination1; } ?>
			</div><?php
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





