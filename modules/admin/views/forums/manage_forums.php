<!-- contents start -->
<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>/public/js/editor_script.js" type="text/javascript"></script>

<script type = "text/javascript">
function delete_forum(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_forums/delete_forum/?id='+id;
}

}
$(document).ready(function()
	{
		$("#form").validate();
	});
</script>


<form  id="search" name="search" action="<?php echo $this->docroot;?>admin_forums/search" method="get" class="out_f" enctype="multipart/form-data">
   <table class="ml-20 mt-20 mb-20">
   <tr>
   <td valign="top"><input type= "text" name = "csearch" id = "csearch" size = "40"  class="ml-5"/></td>
   <td class="pl-5"><?php   echo UI::btn_("Submit", "search", "Search Forum", "", "","search","search");?></td>
   </tr>
   <tr>
   <td><span class="quiet ml-3">   Ex:Title, Category..</span></td>
   </tr>
   </table>
</form>


<?php
						
if (count($this->result)!= 0)
{
	foreach($this->result as $row)
	{
				 
 ?> <script>
 $(document).ready(function(){
			 $("#forum_<?php echo $row->topic_id;?>").click(function(){ $("#fedit_<?php echo $row->topic_id;?>").toggle("show") });
			 $("#delete_<?php echo $row->topic_id;?>").click(function(){ $("#delete_form<?php echo $row->topic_id;?>").toggle("show") });
			 $("#close<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
                        $(document).ready(function()	{ $("#forms<?php echo $row->topic_id;?>").validate();	});

 });
 </script>
	<div class="span-16 border_bottom">
	<div class="span-16">
	
	<div class="span-15 ml-10">
	<p class="span-15"><a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>"><?php echo $row->topic; ?></a> <br></p>
	<div class="v_align">
	<ul class="inlinemenu">
	<li><span>Category</span>
	<a href="<?php echo $this->docroot ;?>forum/search/?id=<?php  echo $row->category_id; ?>" title="<?php  echo $row->forum_category; ?>"><?php  echo $row->forum_category; ?></a>
	<li><span>Started by </span><a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php  echo $row->author_id; ?>" title="<?php  echo $row->name; ?>">
		<?php if(!empty($row->name)) { echo $row->name; } else { echo "Guest"; } ?></a></li>

	<li><a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>">Comments (<?php echo $row->posts;?>)</a></li>
        <li><a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>">Views (<?php echo $row->hit;?>)</a></li>
	<li>Last Active <?php if($row->lpost==0) { echo "Today"; } else { echo $row->lpost." days ago"; }?></li>
	</ul>
	</div>

	<div class="v_align clear fl"> 
	<?php  
	if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{
	        echo UI::btn_("button", "edit", "Edit", "", "", "forum_".$row->topic_id."","edit"); 
	}
        ?>
	&nbsp;
        <?php  
        if( ($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{
                echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->topic_id."","delete"); 
        }
        ?>
	</div>
 <div class="span-18">
	    <div id="fedit_<?php echo $row->topic_id;?>" class="hide">
	    

            <form name="forms" action="" method="post" id="forms<?php echo $row->topic_id;?>">
            <table border="0" cellpadding="5" >
            <input type="hidden" name="forum_id" value="<?php echo $row->topic_id;?>" />

            <tr><td align="right"><label>Topic:</label></td><td><input type="text" name="topic"  size="53" id="topic" value="<?php echo $row->topic;?>" class="required" title="Enter the topic"/></td></tr>
	    <tr><td align="right"><label>Category:</label></td>
	    <td> 
            <select name="category" id="category" class="required" title="Select category"> 
            <?php foreach($this->all_category as $category) {?>
	<option value="<?php echo $category->category_id; ?>" <?php if($category->category_id==$row->category_id) { echo "selected";}?> ><?php echo $category->forum_category; ?></option>
            <?php } ?> 
            </select>
	    
	    </td></tr>
            <tr><td align="right" valign="top"><label>Description:</label></td>
	    <td><textarea name="topic_desc" cols="60" rows="10" id="desc"  class="required" title="Enter the description"><?php echo htmlspecialchars_decode($row->topic_desc);?></textarea></td></tr>            
	    <tr><td>&nbsp;</td>
            <td>
	     <?php  echo UI::btn_("Submit", "submit", "Submit", "", "", "create_form","create_form"); ?>
            
	    </td></tr>
            </form>
	    </table>
	    </div>
				<!-- div for delete topic -->
		<div id="delete_form<?php echo $row->topic_id;?>" class="width400 delete_alert clear ml-10 mb-10 ">
		<h3 class="delete_alert_head">Delete Topic</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->topic_id;?>"  ></span>
		<div class="clear fl">Are you sure to delete this topic? </div>

		<div class="clear fl mt-10"> 
		<?php 
		
		echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_forums/delete_forum/?id=".$row->topic_id."'", "","delete");?> 
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$row->topic_id."","cancel"); ?>
		</div>
		</div>
 </div>
</div>
	</div>
	</div>

<?php } ?>
<?php 
if($this->cout >15) {
echo $this->template->pagination;
}
?>

<?php
}
else
{
 ?>
<div class="no_data">No Topics Available</div>

<?php
 }
?>




