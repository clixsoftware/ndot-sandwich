<script src="<?php echo $this->docroot;?>/public/js/highlight.js" type="text/javascript"></script>
<?php
/**
 * Defines the photos home page. list out the all albums
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
$this->profile = new Profile_Model();
?>
<script>
	$(document).ready(function()
	{
		$("#photo_album").click(function(){
			$("#create_album").toggle("slow");
		});
		$("#album_form").validate();
		

	});
</script>
<?php

    
    if(count($this->template->display_album) >0)
    {
        foreach($this->template->display_album as $row)
        {
             $this->template->module_permission = $this->profile->get_mod_permission($row->user_id);
             $this->get_friend_id = $this->profile->find_frnd_not($row->user_id,$this->userid,1);
             if($this->get_friend_id->count() > 0)
            {
                        $friend_id = $this->get_friend_id['mysql_fetch_array']->user_id;
                        $mod_friend_id = $this->get_friend_id['mysql_fetch_array']->friend_id;
            }
            else
            {
                $friend_id = '';
                $mod_friend_id = '';
            }
             if($this->template->module_permission->count() > 0)
            {
                        foreach($this->template->module_permission as $permission)
                        {
                                $photo = $permission->photo;
                                $mod_userid = $permission->user_id;
                        }
            } 
            else
            {
                $photo = '';
                $mod_userid = '';
            }
                $userid = $row->user_id;
        }
        //$userid = $this->template->display_album['mysql_fetch_array']->user_id;
    }
    else
    {
        $userid = '';
        $photo = '';
        $mod_userid = '';
        $friend_id = '';
        $mod_friend_id = '';
    }
	$uid = $this->input->get("uid"); 
	$action = $this->input->get("action");
	
	// every one
if($this->userid && $photo == 1)
{	

	if($this->userid == $uid || $uid == '') {?>
<div class="fr mt-10">
 <?php  echo UI::btn_("button", "Create New Album", "Create New Album", "", "javascript:window.location='".$this->docroot."photos/create_newalbum'", "cancel","");?>
</div>

<?php } ?>
<?php
 $page = $this->input->get("action");
if($page == "photos"){
	$photo_class = "span-14a";
	$photo_right_class = "span-10";
	$edit_photo = "span-9";
}
else{
	$photo_class = "span-19a";
	$photo_right_class = "span-14";
	$edit_photo = "span-13";
}

if(count($this->template->display_album) > 0){
$i=1;
foreach($this->template->display_album as $row)
{
        $userid = $row->user_id;
	?>
	  
	<script>
	$(document).ready(function()
	{
			 $("#delete_<?php echo $row->album_id;?>").click(function(){ $("#delete_form<?php echo $row->album_id;?>").toggle("show") });
			 $("#close<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
	});
	</script>
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
<div class="<?php echo $photo_class;?> border_bottom mb-20 clear " >
  <!-- Album photo -->
  <div class="span-4 profile_photo">
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
    <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>" class="img_pholeft"> <img src="<?php echo $img_path;?>" title="<?php echo $row->album_title;?>" alt="<?php echo $row->album_title;?>" /> </a> </div>
  <!-- Album Information -->
  <div class="<?php echo $photo_right_class;?>"> <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>"><strong> <?php echo substr(htmlspecialchars_decode($row->album_title),0,50);?>&nbsp;</strong>(<?php echo $row->total;?>&nbsp;photos)</a> <br>
    <p class="<?php echo $photo_right_class;?>"> <?php echo htmlspecialchars_decode($row->album_desc);?> </p>
    <div class="<?php echo $photo_right_class;?>">
      <ul class="inlinemenu">
        <li class="quiet"><span>Posted on</span> <?php echo common::getdatediff($row->album_date);?></li>
      </ul>
      <?php 
	if($this->userid==$row->user_id)
	{
	?>
      <ul class="inlinemenu clear fl mt-10">
      	<li><?php  echo UI::a_tag("","","Add Photos",$this->docroot."photos/upload/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::a_tag("","","Edit",$this->docroot."photos/editalbum/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->album_id."","del");?></li>
        <!--
        <li>sd<a href="<?php echo $this->docroot;?>photos/upload/?album_id=<?php echo $row->album_id;?>" class="add_morep" title="Add Photos"> </a> </li>
        <li><a id="edit<?php echo $row->album_id;?>" class="photo_edit" title="Edit"> </a> </li>
        <li><a href="javascript:;" id="delete_<?php echo $row->album_id;?>" title="Delete" class="photo_delete"> </a></li>
        -->
      </ul>
      <?php } ?>
    </div>
  </div>
  <?php //jquery for edit album ?>

  <?php //edit album form ?>
  
  <!-- for delete -->
  <div id="delete_form<?php echo $row->album_id;?>" class="delete_alert span-12 ml-70 clear mb-20 "  > <span class="fr"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->album_id;?>" ></span>
    <h3 class="delete_alert_head clear">Delete Album</h3>
    <div  class="fl">Are you sure want to delete this album? </div>
    <div class="clear fl mt-10">
    <?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."photos/delete_album/?album_id=".$row->album_id."'", "delete_com","new_q");?>
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$row->album_id,"new_q");?>
    <!--
      <input type="button" name="delete_com" id="delete_com"  onclick="window.location='<?php echo $this->docroot;?>photos/delete_album/?album_id=<?php echo $row->album_id;?>'"  class="photo_delete	 fl" />
      <input type="button" name="cancel" id="cancell<?php echo $row->album_id;?>"    class="pho_cancel fl ml-20"/>-->
    </div>
  </div>
  <!-- end of content div -->
</div>
<?php
		
		
$i++;
}


}
else
{

echo UI::noresults_("");
 }
}

//myself
elseif($photo == 0 && $this->userid == $mod_userid)
{

if($this->userid == $uid || $uid == '') {?>
<div class="fr mt-10">
 <?php  echo UI::btn_("button", "Create New Album", "Create New Album", "", "javascript:window.location='".$this->docroot."photos/create_newalbum'", "cancel","");?>
</div>

<?php } ?>
<?php
 $page = $this->input->get("action");
if($page == "photos"){
	$photo_class = "span-14a";
	$photo_right_class = "span-10";
	$edit_photo = "span-9";
}
else{
	$photo_class = "span-19a";
	$photo_right_class = "span-14";
	$edit_photo = "span-13";
}

if(count($this->template->display_album) > 0){
$i=1;
foreach($this->template->display_album as $row)
{
        $userid = $row->user_id;
	?>
	  
	<script>
	$(document).ready(function()
	{
			 $("#delete_<?php echo $row->album_id;?>").click(function(){ $("#delete_form<?php echo $row->album_id;?>").toggle("show") });
			 $("#close<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
	});
	</script>
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
<div class="<?php echo $photo_class;?> border_bottom mb-20 clear " >
  <!-- Album photo -->
  <div class="span-4 profile_photo">
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
    <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>" class="img_pholeft"> <img src="<?php echo $img_path;?>" title="<?php echo $row->album_title;?>" alt="<?php echo $row->album_title;?>" /> </a> </div>
  <!-- Album Information -->
  <div class="<?php echo $photo_right_class;?>"> <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>"><strong> <?php echo substr(htmlspecialchars_decode($row->album_title),0,50);?>&nbsp;</strong>(<?php echo $row->total;?>&nbsp;photos)</a> <br>
    <p class="<?php echo $photo_right_class;?>"> <?php echo htmlspecialchars_decode($row->album_desc);?> </p>
    <div class="<?php echo $photo_right_class;?>">
      <ul class="inlinemenu">
        <li class="quiet"><span>Posted on</span> <?php echo common::getdatediff($row->album_date);?></li>
      </ul>
      <?php 
	if($this->userid==$row->user_id)
	{
	?>
      <ul class="inlinemenu clear fl mt-10">
      	<li><?php  echo UI::a_tag("","","Add Photos",$this->docroot."photos/upload/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::a_tag("","","Edit",$this->docroot."photos/editalbum/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->album_id."","del");?></li>
        <!--
        <li>sd<a href="<?php echo $this->docroot;?>photos/upload/?album_id=<?php echo $row->album_id;?>" class="add_morep" title="Add Photos"> </a> </li>
        <li><a id="edit<?php echo $row->album_id;?>" class="photo_edit" title="Edit"> </a> </li>
        <li><a href="javascript:;" id="delete_<?php echo $row->album_id;?>" title="Delete" class="photo_delete"> </a></li>
        -->
      </ul>
      <?php } ?>
    </div>
  </div>
  <?php //jquery for edit album ?>

  <?php //edit album form ?>
  
  <!-- for delete -->
  <div id="delete_form<?php echo $row->album_id;?>" class="delete_alert span-12 ml-70 clear mb-20 "  > <span class="fr"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->album_id;?>" ></span>
    <h3 class="delete_alert_head clear">Delete Album</h3>
    <div  class="fl">Are you sure want to delete this album? </div>
    <div class="clear fl mt-10">
    <?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."photos/delete_album/?album_id=".$row->album_id."'", "delete_com","new_q");?>
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$row->album_id,"new_q");?>
    <!--
      <input type="button" name="delete_com" id="delete_com"  onclick="window.location='<?php echo $this->docroot;?>photos/delete_album/?album_id=<?php echo $row->album_id;?>'"  class="photo_delete	 fl" />
      <input type="button" name="cancel" id="cancell<?php echo $row->album_id;?>"    class="pho_cancel fl ml-20"/>-->
    </div>
  </div>
  <!-- end of content div -->
</div>
<?php
		
		
$i++;
}


}
else
{

echo UI::noresults_("");
 }

}
//friends
elseif((($friend_id == $this->userid || $mod_friend_id == $this->userid) && $photo == -1) || $this->userid == $userid)
{
if($this->userid == $uid || $uid == '') {?>
<div class="fr mt-10">
 <?php  echo UI::btn_("button", "Create New Album", "Create New Album", "", "javascript:window.location='".$this->docroot."photos/create_newalbum'", "cancel","");?>
</div>

<?php } ?>
<?php
 $page = $this->input->get("action");
if($page == "photos"){
	$photo_class = "span-14a";
	$photo_right_class = "span-10";
	$edit_photo = "span-9";
}
else{
	$photo_class = "span-19a";
	$photo_right_class = "span-14";
	$edit_photo = "span-13";
}

if(count($this->template->display_album) > 0){
$i=1;
foreach($this->template->display_album as $row)
{
$userid = $row->user_id;
	?>
	  
	<script>
	$(document).ready(function()
	{
			 $("#delete_<?php echo $row->album_id;?>").click(function(){ $("#delete_form<?php echo $row->album_id;?>").toggle("show") });
			 $("#close<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->album_id;?>").click( function(){  $("#delete_form<?php echo $row->album_id;?>").hide("slow");  });
	});
	</script>
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
<div class="<?php echo $photo_class;?> border_bottom mb-20 clear " >
  <!-- Album photo -->
  <div class="span-4 profile_photo">
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
    <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>" class="img_pholeft"> <img src="<?php echo $img_path;?>" title="<?php echo $row->album_title;?>" alt="<?php echo $row->album_title;?>" /> </a> </div>
  <!-- Album Information -->
  <div class="<?php echo $photo_right_class;?>"> <a href="<?php echo $this->docroot;?>photos/view/?album_id=<?php echo $row->album_id;?>"><strong> <?php echo substr(htmlspecialchars_decode($row->album_title),0,50);?>&nbsp;</strong>(<?php echo $row->total;?>&nbsp;photos)</a> <br>
    <p class="<?php echo $photo_right_class;?>"> <?php echo htmlspecialchars_decode($row->album_desc);?> </p>
    <div class="<?php echo $photo_right_class;?>">
      <ul class="inlinemenu">
        <li class="quiet"><span>Posted on</span> <?php echo common::getdatediff($row->album_date);?></li>
      </ul>
      <?php 
	if($this->userid==$row->user_id)
	{
	?>
      <ul class="inlinemenu clear fl mt-10">
      	<li><?php  echo UI::a_tag("","","Add Photos",$this->docroot."photos/upload/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::a_tag("","","Edit",$this->docroot."photos/editalbum/?album_id=".$row->album_id);?></li>
      	<li><?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->album_id."","del");?></li>
        <!--
        <li>sd<a href="<?php echo $this->docroot;?>photos/upload/?album_id=<?php echo $row->album_id;?>" class="add_morep" title="Add Photos"> </a> </li>
        <li><a id="edit<?php echo $row->album_id;?>" class="photo_edit" title="Edit"> </a> </li>
        <li><a href="javascript:;" id="delete_<?php echo $row->album_id;?>" title="Delete" class="photo_delete"> </a></li>
        -->
      </ul>
      <?php } ?>
    </div>
  </div>
  <?php //jquery for edit album ?>

  <?php //edit album form ?>
  
  <!-- for delete -->
  <div id="delete_form<?php echo $row->album_id;?>" class="delete_alert span-12 ml-70 clear mb-20 "  > <span class="fr"> <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->album_id;?>" ></span>
    <h3 class="delete_alert_head clear">Delete Album</h3>
    <div  class="fl">Are you sure want to delete this album? </div>
    <div class="clear fl mt-10">
    <?php  echo UI::btn_("Button", "delete_com", "Delete", "", "window.location='".$this->docroot."photos/delete_album/?album_id=".$row->album_id."'", "delete_com","new_q");?>
    <?php  echo UI::btn_("Button", "cancel", "Cancel", "", "", "cancell".$row->album_id,"new_q");?>
    <!--
      <input type="button" name="delete_com" id="delete_com"  onclick="window.location='<?php echo $this->docroot;?>photos/delete_album/?album_id=<?php echo $row->album_id;?>'"  class="photo_delete	 fl" />
      <input type="button" name="cancel" id="cancell<?php echo $row->album_id;?>"    class="pho_cancel fl ml-20"/>-->
    </div>
  </div>
  <!-- end of content div -->
</div>
<?php
		
		
$i++;
}


}
else
{

echo UI::noresults_("");
 }
}
else
{
        echo "<div class='noresults'>Because of privacy user block the Photos</div>";
}
 //finish content

if($this->total > 1){
	echo $this->template->pagination;
}
?>
