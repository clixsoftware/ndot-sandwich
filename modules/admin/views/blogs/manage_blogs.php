<!-- contents start -->
<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>

<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<script>
function delete_blog(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_blogs/delete_blog/?id='+id;
}

}
function change_status(status,id)
{
	window.location = '<?php echo $this->docroot; ?>admin_blogs/change_status/?status='+status+'&id='+id;
}
</script>

<div class="span-15 border_bottom">
  <form name = "search" id = "search" action = "/admin_blogs/commonsearch/" method = "get">
    <table>
      <tr>
        <td valign="top">
           <?php     $search_type = $this->uri->last_segment(); ?>
              <input type="hidden" name ="search_type" value="<?php echo $search_type  ?>">
        <input type= "text" name = "search_value"  id = "search_value" size = "40" title= "Search Blog " />
          <div class="quiet">Ex:Search Blog,Category,User </div></td>
        <td class="pl-10"><?php   echo UI::btn_("Submit", "vsearch", "Search Blog", "", "","search","search");?></td>
      </tr>
    </table>
  </form>
</div>

<?php

						
if (count($this->template->get_blog)> 0)
{
	foreach($this->template->get_blog as $row)
	{
				 
 ?>
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
 <script>
 $(document).ready(function(){
 			$("#blog_<?php echo $row->blog_id;?>").click(function(){ $("#bedit_<?php echo $row->blog_id;?>").toggle("show") });
			 $("#delete_<?php echo $row->blog_id;?>").click(function(){ $("#delete_form<?php echo $row->blog_id;?>").toggle("show") });
			 $("#close<?php echo $row->blog_id;?>").click( function(){  $("#delete_form<?php echo $row->blog_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->blog_id;?>").click( function(){  $("#delete_form<?php echo $row->blog_id;?>").hide("slow");  });
        		 $(document).ready(function() 	{ $("#update_blog<?php echo $row->blog_id;?>").validate(); });
 });
 </script>

	<div class="span-15 border_bottom">
		<div class="span-15">
	<div class="span-2">
	<?php Nauth::getPhoto($row->user_id,$row->name); //get the user photo?>
	</div>

	<div class="span-12">
	<p class="span-12">
	<a href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>" title="<?php echo $row->blog_title; ?>"><?php echo $row->blog_title; ?></a> <br></p>
	<div class="v_align">
	<ul class="inlinemenu">
	<li><span>Category</span>
	<a href="<?php echo $this->docroot ;?>blog/category/?id=<?php  echo $row->blog_category; ?>" title="<?php  echo $row->category_name; ?>">
	<?php  echo $row->category_name; ?></a>
	<li><span>Started by </span>
	<a href="<?php echo $this->docroot ;?>profile/index/<?php  echo $row->user_id; ?>" title="<?php  echo $row->name; ?>">
		<?php if(!empty($row->name)) { echo $row->name; } else { echo "Guest"; } ?></a></li>

	<li><a href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>">Comments (<?php echo $row->counts;?>)</a></li>
	</ul>

	</div>
	<!-- edit and delete-->
	<div class="span-10">
         <?php  
         if(($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	 {
                //echo UI::btn_("button", "edit", "Edit", "", "", "blog_".$row->blog_id."","edit"); 
                ?>
                <a href="javascript:;" id="blog_<?php echo $row->blog_id ; ?>" name="blog_<?php echo $row->blog_id ; ?>" title="Edit"><img src="<?php echo $this->docroot; ?>public/images/icons/edit.gif">&nbsp;Edit</a>
                <?php
         }
         ?>
         
	<?php  
	 if(($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	 {
	 ?>
	        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="delete_<?php echo $row->blog_id ; ?>" name="blog_<?php echo $row->blog_id ; ?>" title="Delete"><img src="<?php echo $this->docroot; ?>public/images/icons/delete.gif">&nbsp;Delete</a>
	 <?php
	       // echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->blog_id."","delete");
	 } 
	 if($row->status == 0)
	 {
	        ?>
	        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="unblock<?php echo $row->blog_id ; ?>" name="unblock<?php echo $row->blog_id ; ?>" title="Unblock" onclick="javasctipt:change_status('1',<?php echo $row->blog_id ; ?>);"><img src="<?php echo $this->docroot; ?>public/images/icons/unblock.gif">&nbsp;Unblock</a>
	        <?php
	 }
	 else
	 {
	        ?>
	        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="block<?php echo $row->blog_id ; ?>" name="block<?php echo $row->blog_id ; ?>" title="Block" onclick="javasctipt:change_status('0',<?php echo $row->blog_id ; ?>);"><img src="<?php echo $this->docroot; ?>public/images/icons/block.gif">&nbsp;Block</a>
	        <?php
	 }
	 ?>
        </div>



	<!-- edit form -->
	    <div class="span-14">
	    <div id="bedit_<?php echo $row->blog_id;?>" class="hide">
	    <form name="update_blog" id="update_blog<?php echo $row->blog_id;?>" action="" method="post" onsubmit="return check()">
             <table border="0" cellpadding="5" >
            <input type="hidden" name="blog_id" value="<?php echo $row->blog_id;?>" />

            <tr><td>Title</td><td><input type="text" name="title"  size="50" id="title" value="<?php echo $row->blog_title;?>" class= "required" /></td></tr>
	    <tr><td>Category</td>
	    <td>
            <select name="category" id="category" > 
            <?php foreach($this->all_category as $category) {?>
	<option value="<?php echo $category->category_id; ?>" <?php if($category->category_id==$row->blog_category) { echo "selected";}?> ><?php echo $category->category_name; ?></option>
            <?php } ?> 
            </select>
	    
	    </td></tr>
            <tr><td style="vertical-align:top;">Description</td>
	    <td><textarea name="description" cols="50" rows="10" id="description" class="mceEditor required" >
	    <?php echo htmlspecialchars_decode($row->blog_desc);?></textarea></td></tr>            
	    <tr><td>&nbsp;</td>
            <td>
            <?php   echo UI::btn_("Submit", "update", "Update", "", "","update","update_blog");?>
	    </td></tr>
           
	    </table> </form>
	    </div>
	    
	    
	    	 <!-- for delete -->
		<div id="delete_form<?php echo $row->blog_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Blog</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->blog_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this Blog? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_blogs/delete_blog/?id=".$row->blog_id."' ", "delete_com","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->blog_id."","");?>
		
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




