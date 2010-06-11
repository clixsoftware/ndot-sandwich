<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script>
var userresult;
tinyMCE.init({
	plugins : '-example', // - tells TinyMCE to skip the loading of the plugin
	mode : "textareas",
	theme : "advanced",
	editor_selector : "mceEditor",
	theme_advanced_buttons1 : "mymenubutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,fontselect,fontsizeselect,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom"
});

</script>

<script>
  $(document).ready(function(){ document.getElementById('title').focus();	$("#add_category").validate();	});
</script>

<div class="span-18 no_data1">

<form  action="/admin_news" id="add_category" method="post" class="out_f" enctype="multipart/form-data" name="add_category" >
<table  border="0" cellspacing="5" cellpadding="5">
<input type="hidden" name="type" value="add" >
  <tr>
    <td align="right" valign="top"><label>Title:</label></td>
    <td ><input type="text" size="53" name="title" id="title" class="required" title="Enter the Title"  tabindex="1"></td>
  </tr>
  <tr>
    <td  valign="top" align="right"><label>Category:</label></td>
    <td>
	<select id="category" name="category"  id="category" class="required" tabindex="2" title="Select the Category">
        <option value="" selected>select</option>
	    <?php 
		foreach($this->category as $row)
		{
		?>
	    <option value="<?php echo $row->category_id;?>" ><?php echo $row->category_name;?></option>
        <?php } ?>
        </select>
		</td>
  </tr>
 
 
  <tr>
    <td valign="top" align="right"><label>Description:</label> </td>
    <td> <textarea name="desc" class="required" id="descrip"  tabindex="3" cols="59" title="Enter the Description"></textarea></td>
  </tr>
<tr><td align="right"><label>News Photo:</label></td><td><input name="news_image" type="file" id="news_image" tabindex="4"></td></td></tr>
  <tr>
    <td></td>
    <td>
        <?php   echo UI::btn_("Submit", "upd", "Submit", "", "","upd","add_category");?>
        <?php   echo UI::btn_("button", "cancel", "Cancel", "", "window.location='".$this->docroot."admin_news/'","cancel","add_category");?>
</td>
  </tr>
</table>
  </form>

</div>
 <!--manage news -->
<h3>Manage News</h3>

 <?php
 if(count($this->template->get_news)>0)
 {
 foreach($this->template->get_news as $row)
 {
 ?>
	 <script>
	 $(document).ready(function(){
	 $("#edit_<?php echo $row->news_id;?>").click(function(){ $("#edit_info_<?php echo $row->news_id;?>").toggle("slow"); });
 	$("#delete_<?php echo $row->news_id;?>").click(function(){ $("#delete_form<?php echo $row->news_id;?>").toggle("show") });
	 $("#close<?php echo $row->news_id;?>").click( function(){  $("#delete_form<?php echo $row->news_id;?>").hide("slow");  });
	 $("#cancel<?php echo $row->news_id;?>").click( function(){  $("#delete_form<?php echo $row->news_id;?>").hide("slow");  });
	 });
	 </script>
	 
	  <div class="span-14 ">
	 
	    <div class="span-2 fl ">
	    <a href="<?php echo $this->docroot;?>news/view/?nid=<?php echo $row->news_id;?>" title="<?php echo $row->news_title?>"> <img src="<?php echo $this->docroot;?>public/news_photo/50/<?php echo $row->news_photo?>" onerror="this.src='<?php echo $this->docroot;?>/public/images/no_image.jpg'";/></a>
	    </div>

	    <div class="span-11 fl " >
	    <p class="span-11"><a href="<?php echo $this->docroot;?>news/view/?nid=<?php echo $row->news_id;?>" title="<?php echo $row->news_title?>"><?php echo $row->news_title?></a> <br>
	    <span><?php $desc=html_entity_decode($row->news_desc); $desc1=strip_tags($desc); echo substr($desc1,0,180).'. . .';?></span>
	    </p>
	    <div class="v_align">
	    <ul class="inlinemenu">
	   
	    <li>Posted -<?php if($row->dat==0) { echo "Today"; } else { echo $row->dat." days ago"; }?></li>
	    </ul>
	    </div>

		<!-- edit and delete option to news -->
		<div class="v_align">
		<?php  
		if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	        {
		        echo UI::btn_("button", "edit", "Edit", "", "", "edit_".$row->news_id."","edit"); 
		}
		?>
		
        	 <?php  
        	 if( ($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	         {
        	        echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->news_id."","delete"); 
        	 }
        	 ?>
		</div>
	</div>
	
                <script>
                $(document).ready(function(){  $("#edit_news<?php echo $row->news_id;?>").validate(); });
                </script>
	
	
		<!-- edit form to news -->
		<div id="edit_info_<?php echo $row->news_id;?>" class="span-14 hide">
		

		<form name="edit_news<?php echo $row->news_id;?>" id="edit_news<?php echo $row->news_id;?>" action="/admin_news/editnews" method="post" class="out_f" enctype="multipart/form-data" >
		<table  border="0" cellpadding="5" cellspacing="5">
		<input type="hidden" name="type" value="edit" >
		<input type="hidden" name="news_id" value="<?php echo $row->news_id;?>" >
		<tr>
		<td valign="top" align="right"><label>Title:</label></td>
		<td ><input type="text" name="title"  value="<?php echo $row->news_title?>" class="required span-10" /></td>
		</tr>
		<tr>
		<td headers="38" valign="top" align="right"><label>Category:</label></td>
		<td>
		<select id="category" name="category"  id="category" class="required span-10">
		<option value="" selected>select</option>
		<?php 
		foreach($this->category as $value)
		{
		?>
		<option value="<?php echo $value->category_id;?>" <?php if($value->category_id==$row->news_category){ echo "Selected";}?> ><?php echo $value->category_name;?></option>
		<?php } ?>
		</select>
		</td>
		</tr>


		<tr>
		<td valign="top" align="right"> <label>Description: </label> </td>
		<td> <textarea name="desc" class="mceEditor required span-10" id="descrip" ><?php echo $row->news_desc;?></textarea></td>
		</tr>
		<tr><td>News Photo:</td><td><input name="news_image" type="file" id="news_image"></td></td></tr>
		<tr>
		<td></td>
		<td>
		<?php   echo UI::btn_("Submit", "update", "Update", "", "","update","edit_news<?php echo $row->news_id;?>");?>
		</td>
		</tr>
		</table></form>
		
		</div>
		
		
		 <!-- for delete -->
		<div id="delete_form<?php echo $row->news_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete News</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->news_id;?>"  >
		</span>
		<div class="clear fl">Are you sure to delete this News? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."admin_news/index/?del=yes&id=".$row->news_id."' ", "delete_com","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->news_id."","");?>
		
		</div>
		</div>
		
	

		</div>
		


 <?php 
 }
 }
 else
 { 
 echo UI::nodata_();
 }
 ?>

<?php 

if(count($this->template->get_allnews) >10) 
{ 
?>
<?php echo $this->template->pagination;?> 
<?php } ?>







