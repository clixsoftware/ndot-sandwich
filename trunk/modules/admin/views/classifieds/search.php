<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>/public/js/jquery.validate.js" type="text/javascript"></script>
<script type = "text/javascript">
/* delete classifieds*/
/* function delete_classifieds(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>admin_classifieds/index/?del=yes&id='+id;
}
} */
/* validation */
$(document).ready(function(){$("#edit").validate();});
</script>
<?php
$this->session = Session::instance();
$userid = $this->session->get('userid');

?>
<div onLoad="document.getElementById('uname').focus();" >

<form name = "search" id = "search" action = "/admin_classifieds/search" method = "get">
   <table class="ml-20 mt-20 mb-20">
   <tr>
   <td valign="top"><input type= "text" name = "csearch" id = "csearch" size = "40"  class="ml-5"/></td>
   <td class="pl-5"><?php   echo UI::btn_("Submit", "search", "Search Classifieds", "", "","search","search");?></td>
   </tr>
   <tr>
   <td><span class="quiet pl-5">   Ex:Title, Price, Category..</span></td>
   </tr>
   </table>
  <?php 
  if(count($this->template->classifieds_search)!=0)
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
 if(count($this->template->classifieds_search)>0)
 {
 foreach($this->template->classifieds_search as $row)
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

			$('div p').highlight('<?php if(isset($_GET["csearch"])) echo $_GET["csearch"];?>'); 

		});
			 </script>
 <script>
 $(document).ready(function(){
			 $("#edit_<?php echo $row->class_id;?>").click(function(){ $("#edit_info_<?php echo $row->class_id;?>").toggle("slow"); });
			 $("#delete_<?php echo $row->class_id;?>").click(function(){ $("#delete_form<?php echo $row->class_id;?>").toggle("show") });
			 $("#close<?php echo $row->class_id;?>").click( function(){  $("#delete_form<?php echo $row->class_id;?>").hide("slow");  });
			 $("#cancel<?php echo $row->class_id;?>").click( function(){  $("#delete_form<?php echo $row->class_id;?>").hide("slow");  });

 });
 </script>
  <div class="span-19a border_bottom  clear fl mb-10 pb-10">
    <div class="span-1a mr_fl_l  mt-5  mr-10 ml-10">    
        <a href="<?php echo $this->docroot;?>classifieds/view/?cid=<?php echo $row->class_id;?>"><img src="<?php echo $this->docroot;?>public/classifieds_photo/50/<?php echo $row->classifieds_photo?>" onerror="this.src='<?php echo $this->docroot;?>/public/images/no_image.jpg'"; class="upd_photo"/></a>
    </div>
    <div class="span-17" >
    <p class="span-18"><a href="<?php echo $this->docroot;?>classifieds/view?cid=<?php echo $row->class_id;?>" class="font13 text_bold"><?php echo $row->title?></a> <br>
    <span><?php $desc=html_entity_decode($row->desc); $desc1=strip_tags($desc); echo substr($desc1,0,180).'. . .';?></span>
    </p>
	
    <div class="span-16">
    <ul class="inlinemenu">
    <li><?php Nauth::print_name($row->user_id,$row->username); ?><span class="quiet">Posted On</span></li>
    <li><span >
    <?php 
    echo common::getdatediff($row->DATE);   ?> 
    </span></li>
    <li><span class="quiet">in </span><a href="<?php echo $this->docroot;?>classifieds/category?cate=<?php echo $row->cat_id;?>" title="<?php echo $row->category;?>"><strong><?php echo $row->category;?></strong></a></li>
    
    <li><a href="<?php echo $this->docroot;?>classifieds/view?cid=<?php echo $row->class_id;?>" >Comments (<?php echo $row->count_comments;?>)</a></li>
    </div>
    

         <!-- edit and delete option to classifieds -->
	<div class="v_align">	
	<?php  echo UI::btn_("button", "edit", "Edit", "", "javascript:window.location='".$this->docroot."classifieds/edit_ads/?classid=".$row->class_id."'", "","edit");?>
	<?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->class_id."","del");?>	 	
	</div>
	
	
		<!-- div for delete classifieds -->
		<div id="delete_form<?php echo $row->class_id;?>" class="delete_alert clear fl mt-20 span-10">
        <span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->class_id;?>"  ></span>
		<h3 class="delete_alert_head clear fl">Delete Classifieds</h3>
		
		<div class="clear fl" >Are you sure to delete this classifieds? </div>
		<div> 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."classifieds/category/?del=yes&id=".$row->class_id."&cate=".$row->cat_id."' ", "delete","");?> 
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_classifieds/'", "cancel","");?> 
		</div>
		</div>

	</div>
	</div>




 <?php 
 }
 }
 else
 {
 echo UI::noresults_($this->total);
 }

 if($this->total>10) 
 { 
        echo $this->template->pagination1;
 } 
 
 ?>

</div>

