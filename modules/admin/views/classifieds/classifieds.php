<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>
<script>
 
$(document).ready(function()
	{
		$("#search").validate();
	});
</SCRIPT>
<?php
$this->session = Session::instance();
$userid = $this->session->get('userid');
?>
<body>

<form  id="search" name="search" action="<?php echo $this->docroot;?>admin_classifieds/search" method="get" class="out_f" enctype="multipart/form-data">
   <table class="ml-20 mt-20 mb-20">
   <tr>
   <td valign="top"><input type= "text" name = "csearch" id = "csearch" size = "40"  class="ml-5"/></td>
   <td class="pl-5"><?php   echo UI::btn_("Submit", "search", "Search Classifieds", "", "","search","search");?></td>
   </tr>
   <tr>
   <td><span class="quiet">   Ex:Title, Price, Category..</span></td>
   </tr>
   </table>
</form>



<table width="742" class="ml-20" border="0" cellpadding="8" cellspacing="8">
<tr>
<td width="125"><?php echo UI::a_tag("post_ads", "post_ads", "Add Classifieds", $this->docroot."classifieds/post_ads");?>
</td>
</tr>

<tr>
<td></td>
<td></td>
</tr>
</table>
</table>

 <!--manage classifieds -->


 <?php
 if(count($this->template->get_classifieds)>0)
 {
 foreach($this->template->get_classifieds as $row)
 {
 //$this->model = new Classifieds_Model();
 //$this->count = $this->model->get_comments_count($row->id);
 ?>
 <script>
 $(document).ready(function(){
			 $("#edit_<?php echo $row->id;?>").click(function(){ $("#edit_info_<?php echo $row->id;?>").toggle("slow"); });
			 $("#delete_<?php echo $row->id;?>").click(function(){ $("#delete_form<?php echo $row->id;?>").toggle("show") });
			 $("#close<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->id;?>").click( function(){  $("#delete_form<?php echo $row->id;?>").hide("slow");  });

 });
 </script>
  <div class="span-19a border_bottom clear mb-10 pb-10 mt-10">
    <div class=" span2 mr_fr fl overflowh    mt-5">     
            <a href="<?php echo $this->docroot;?>classifieds/view/<?php echo url::title($row->title);?>_<?php echo $row->id;?>"><img src="<?php if($row->classifieds_photo) {
          echo $this->docroot.'public/classifieds_photo/50/'.$row->classifieds_photo; } else { echo $this->docroot.'public/images/no_image.jpg'; }
					 ?>" class="upd_photo"/>			
	</a>
    </div>
    <div class="span-12a fr mr-10">
    <p class="span-12a  "><a href="<?php echo $this->docroot;?>classifieds/view/<?php echo url::title($row->title);?>_<?php echo $row->id;?>"><?php echo $row->title?></a> <br>
    <span><?php $desc=html_entity_decode($row->desc); $desc1=strip_tags($desc); echo substr($desc1,0,180).'. . .';?></span>
    </p>
	
    <div class="v-align">
    <ul class="inlinemenu">
   
    <li>Posted by <a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $row->user_id;?>" title="<?php echo $row->username;?>"><?php echo $row->username;?></a></li> <li><?php if($row->dat==0) { echo "Today"; } else { echo $row->dat." days ago"; }?></li>
    <li>Category <a href="<?php echo $this->docroot;?>classifieds/category?cate=<?php echo $row->cat_id;?>"> <?php echo $row->category; ?></a></li>
    </ul> 
    </div>

	<!-- edit and delete option to classifieds -->
	<div class="v_align   overflowh clear fl mt-5">
	
	 <?php 
	 if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	 {
	 echo UI::btn_("button", "edit", "Edit", "", "javascript:window.location='".$this->docroot."classifieds/edit_ads/?classid=".$row->id."'", "","edit"); } ?> 
	
 	<?php 
 	if(($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	 {
 	        echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->id."","del");
 	 }
	 if($row->status == 0)
	 {
	 	echo UI::btn_("button", "Unblock", "Unblock", "", "javascript:window.location='".$this->docroot."admin_classifieds/block_unblock/?status=1&id=$row->id'", "","Unblock"); 
	 }
	 else
	 {
	 	echo UI::btn_("button", "Block", "Block", "", "javascript:window.location='".$this->docroot."admin_classifieds/block_unblock/?status=0&id=$row->id'", "","Block"); 
	 }
 	?>
	</div>

		<!-- div for delete classifieds -->
		<div id="delete_form<?php echo $row->id;?>" class="delete_alert width300 borderf clear mt-20" >
		<h3 class="delete_alert_head width280">Delete Classifieds</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->id;?>"  ></span>
		<div  class="clear fl">Are you sure to delete this classifieds? </div>
		<div class="mt-10 clear fl"> 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_classifieds/index/?del=yes&id=".$row->id."' ", "delete","");?> 
		
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$row->id."","del"); ?>
		
		</div>
		</div>

	</div>
	</div>
</body>



 <?php 
 }
 }
 else
 { ?>
 <div class="no_data">No data Found</div>
 <?php 
 }
 ?>

<?php if(count($this->template->get_allclassifieds)>10) 
{  

echo $this->template->pagination1;

} ?>







