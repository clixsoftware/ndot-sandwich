<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>
<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#edit").validate();});
</script>
<?php
$this->session = Session::instance();
$userid = $this->session->get('userid');

?>
<div onLoad="document.getElementById('uname').focus();" >

<form  id="search" name="search" action="<?php echo $this->docroot;?>admin_forums/search" method="get" class="out_f" enctype="multipart/form-data">
   <table class="ml-20 mt-20 mb-20">
   <tr>
   <td valign="top"><input type= "text" name = "csearch" id = "csearch" size = "40"  class="ml-5"/></td>
   <td class="pl-5"><?php   echo UI::btn_("Submit", "search", "Search Forum", "", "","search","search");?></td>
   </tr>
   <tr>
   <td><span class="quiet">   Ex:Title, Category..</span></td>
   </tr>
   </table>

  <?php 
  if(count($this->template->forum_search)!=0)
  {
  
  echo UI::count_($this->total);
  }
  else
  {
  
  } 
  ?>
</form>

</tr>

<tr>
<td></td>
<td></td>
</tr>
</table>
</table>

 <!--manage classifieds -->


 <?php
						
if (count($this->template->forum_search)!= 0)
{
	foreach($this->template->forum_search as $row)
	{
				 
 ?> <script>
 $(document).ready(function(){
			 $("#forum_<?php echo $row->topic_id;?>").click(function(){ $("#fedit_<?php echo $row->topic_id;?>").toggle("show") });
			 $("#delete_<?php echo $row->topic_id;?>").click(function(){ $("#delete_form<?php echo $row->topic_id;?>").toggle("show") });
			 $("#close<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->topic_id;?>").click( function(){  $("#delete_form<?php echo $row->topic_id;?>").hide("slow");  });
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

			                $('div p').highlight('<?php if(isset($_GET["csearch"])) echo $_GET["csearch"];?>'); 			
		                });
			 </script>
	<div class="span-19 border_bottom">
	<div class="span-18">
	<div class="span-2">
	<img src="<?php echo $this->docroot;?>public/images/forum.png" alt="<?php echo $row->topic; ?>" title="<?php echo $row->topic; ?>">
	</div>

	<div class="span-15">
	<p class="span-15"><a href="<?php echo $this->docroot;?>forum/updatehit?id=<?php echo $row->topic_id; ?>"><?php echo $row->topic; ?></a> <br></p>
	<div class="v_align">
	<ul class="inlinemenu">
	<li><span>Category</span>
	<a href="<?php echo $this->docroot ;?>forum/search/?id=<?php  echo $row->category_id; ?>" title="<?php  echo $row->forum_category; ?>"><?php  echo $row->forum_category; ?></a>
	<li><span>Started by </span><a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php  echo $row->author_id; ?>" title="<?php  echo $row->name; ?>">
		<?php if(!empty($row->name)) { echo $row->name; } else { echo "Guest"; } ?></a></li>

	<li>Comments (<?php echo $row->posts;?>)</li>
        <li>Views (<?php echo $row->hit;?>)</li>
	<li>Last Active <?php if($row->lpost==0) { echo "Today"; } else { echo $row->lpost." days ago"; }?></li>
	</ul>
	</div>

	<div class="v_align">
	
	<?php  echo UI::btn_("button", "edit", "Edit", "", "", "forum_".$row->topic_id."","edit"); ?>
	&nbsp;
        <?php  echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->topic_id."","delete"); ?>
	</div>
 <div class="span-18">
	    <div id="fedit_<?php echo $row->topic_id;?>" class="hide">
	    <table border="0" cellpadding="5" >

            <form name="create_form" action="" method="post" onsubmit="return check()">
            <input type="hidden" name="forum_id" value="<?php echo $row->topic_id;?>" />

            <tr><td>Topic</td><td><input type="text" name="topic"  size="60" id="topic" value="<?php echo $row->topic;?>" /></td></tr>
	    <tr><td>Category</td>
	    <td>
            <select name="category" id="category" > 
            <?php foreach($this->get_category as $category) {?>
	<option value="<?php echo $category->category_id; ?>" <?php if($category->category_id==$row->category_id) { echo "selected";}?> ><?php echo $category->forum_category; ?></option>
            <?php } ?> 
            </select>
	    
	    </td></tr>
            <tr><td style="vertical-align:top;">Description</td>
	    <td><textarea name="topic_desc" cols="60" rows="10" id="desc" class="mceEditor"><?php echo htmlspecialchars_decode($row->topic_desc);?></textarea></td></tr>            
	    <tr><td>&nbsp;</td>
            <td>
	     <?php  echo UI::btn_("Submit", "submit", "Submit", "", "", "create_form","create_form"); ?>
            
	    </td></tr>
            </form>
	    </table>
	    </div>
				<!-- div for delete topic -->
		<div id="delete_form<?php echo $row->topic_id;?>" class="delete_alert">
		<h3 class="delete_alert_head">Delete Topic</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->topic_id;?>"  ></span>
		<div >Are you sure to delete this topic? </div>
		<div> 
		<?php echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_forums/delete_forum/?id=".$row->topic_id."'", "","delete");?> 
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$row->topic_id."","cancel"); ?>
		</div>
		</div>
 </div>
</div>
	</div>
	</div>

<?php } ?>
<?php 
if($this->total >15) {
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
</div>

