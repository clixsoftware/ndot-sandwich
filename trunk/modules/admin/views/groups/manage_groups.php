<!-- contents start -->
<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>/public/js/editor_script.js"></script>

<script>
/* function delete_group(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_groups/delete_group/?id='+id;
} */

}
function block_group(id)
{
var aa=confirm("Are you sure want to block it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_groups/block_group/?id='+id;
}

}
</script>
        
        <div class="span-15 border_bottom">
          <form name = "search" id = "search" action = "<?php $this->docroot;?>admin_groups/commonsearch/" method = "get">
            <table>
              <tr>
                <td valign="top">
                  <input type= "text" name = "search_value"  id = "search_value" size = "40" title= "Search Blog " />
                  <div class="quiet">Ex:Enter the Group Name,Description keys</div></td>
                <td class="pl-10"><?php   echo UI::btn_("Submit", "vsearch", "Search", "", "","search","search");?></td>
              </tr>
            </table>
          </form>
        </div>
        
<?php
if (count($this->template->get_groups)> 0)

{

	foreach($this->template->get_groups as $row)

	{

 ?>
 <script>

 $(document).ready(function(){

 $("#group_<?php echo $row->group_id;?>").click(function(){ $("#bedit_<?php echo $row->group_id;?>").toggle("show") });
 $("#delete_<?php echo $row->group_id;?>").click(function(){ $("#delete_form<?php echo $row->group_id;?>").toggle("show") });
	 $("#close<?php echo $row->group_id;?>").click( function(){  $("#delete_form<?php echo $row->group_id;?>").hide("slow");  });
	 $("#cancel<?php echo $row->group_id;?>").click( function(){  $("#delete_form<?php echo $row->group_id;?>").hide("slow");  });


 });


</script>
        


	<!--mani div starts-->
 
	<div class="span-19 border_bottom">
	<div span-18>
	<div class="span-2">
    	<img  class="left"  src="<?php echo $this->docroot;?>public/group_photo/50/<?php echo $row->group_photo?>" onerror="this.src='<?php echo $this->docroot;?>/public/images/no_image.jpg'";/>
    	</div>	
	<div class="span-15">

	<p class="span-15">
	<a href="<?php echo $this->docroot;?>groups/view?gid=<?php echo $row->group_id; ?>&action=info" title="<?php echo $row->group_name; ?>"><?php echo $row->group_name; ?></a> <br></p>

	<div class="span-15">
	<ul class="inlinemenu">
	<li ><span>Category</span>
	<a href="<?php echo $this->docroot ;?>groups/category?id=<?php  echo $row->group_category; ?>" title="<?php  echo $row->group_category_name; ?>">
	<?php  echo $row->group_category_name; ?></a>
</li>
	<li ><span>Started by </span>
	<a href="<?php echo $this->docroot ;?>profile/index/<?php  echo $row->user_id; ?>" title="<?php  echo $row->name; ?>">

		<?php if(!empty($row->name)) { echo $row->name; } else { echo "Guest"; } ?></a></li>


	<li><a href="<?php echo $this->docroot;?>groups/view?gid=<?php echo $row->group_id; ?>&action=info" title="<?php echo $row->group_name; ?>">Members (<?php echo $row->member_count;?>)</a></li>

	</ul>

	</div>
	<!-- edit and delete-->

	<div class="v_align">
	
	<?php 
	if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	{
	echo UI::btn_("button", "edit", "Edit", "", "javascript:window.location='".$this->docroot."admin_groups/edit/?gid=".$row->group_id."'", "","edit"); } ?>
	
	&nbsp;&nbsp;&nbsp;
	<?php 
	 if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	 {
	        echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->group_id."","del"); 
	 }
	 ?>
	 
 	 <?php 
        if( ($this->block_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
        {
	        if($row->group_status==1)
		 {
		 ?>
<?php echo UI::btn_("button", "block", "Block", "", "javascript:window.location='".$this->docroot."admin_groups/block_group?status=0&id=".$row->group_id."'", "","block");?>
		 <?php 
		 }
		 else
		 {?>

		  
<?php echo UI::btn_("button", "block", "Un Block", "", "javascript:window.location='".$this->docroot."admin_groups/block_group?status=1&id=".$row->group_id."'", "","block");?>
		 <?php 

		 }
        }
		 ?>
		 </div>

	    
		<!-- div for delete group -->
		<div id="delete_form<?php echo $row->group_id;?>" class="width400 delete_alert clear ml-10 mb-10 ">
		<h3 class="delete_alert_head">Delete Group</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->group_id;?>"  ></span>
		<div class="clear fl">Are you sure to delete this group? </div>
		<div class="clear fl mt-10"> 
		 <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_groups/delete_group/?id=".$row->group_id."' ", "delete_group","");?>
        <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->group_id."","");?>
        
		</div>
		</div>
		
</div>

	</div>
	</div>
	
	<!--mani div ends-->

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

<div class="no_data">No Groups Available</div>



<?php

 }

?>




