<?php
/**
 * Defines one album photo... List out all photos in one album.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>
<div class="fl">
<?php
	if($this->template->view_albumphoto->count() > 0){ 
?>
<div class="mt-20 fr mr-20">
  <?php  
  
  if($this->template->view_albumphoto->current()->user_id == $this->userid){
  echo  UI::a_tag("Upload the Photos","Upload the Photos","Upload the Photos",$this->docroot."photos/upload/?album_id=".$this->template->view_albumphoto->current()->album_id."&userid=".$this->template->view_albumphoto->current()->user_id); 
  }
  if($this->usertype == -1)
  {
        echo  UI::a_tag("Back","Back","Back",$this->docroot."admin_photos"); 
  }
  else
  {
        echo  UI::a_tag("Back","Back","Back",$this->docroot."photos"); 
  }

  ?>
  </div>
<?php } ?>
<?php 
//display the no of photos
if( $this->photo_total > 0){
$i = 3;$k = 1;
$cont = 1;
foreach ($this->template->show_photo as $row)
{
	if ($i % 3 == 0){
	?>
	<div  class="span-19  ml-25 mt-20">
	<?php 
	}
?>
		<div class=" span-4" > 

		        <div align="center" >
		        <a href="<?php echo $this->docroot;?>photos/zoom/<?php echo $cont ?>/<?php echo $row->album_id;?>/<?php  echo $row->photo_id;?>.html" title="<?php echo $row->photo_title;?>" class=" p2 displayblock ">
		        <img src="<?php echo $this->docroot;?>/public/album_photo/<?php echo $row->photo_id;?>.jpg" alt="<?php echo $row->photo_title;?>" class="imgborder" />
		        </a>
		        </div>

		        <div id="name<?php echo $row->photo_id;?>" class="mauto" align="center"> <a href="<?php echo $this->docroot;?>photos/zoom/<?php echo $cont ?>/<?php echo $row->album_id;?>/<?php  echo $row->photo_id;?>.html" title="<?php echo $row->photo_title;?>" class=" p2 displayblock "><?php echo $row->photo_title;?></a></div>
		<?php 
		if($this->userid == $row->user_id){
		?>
		        <div  id="ed<?php echo $row->photo_id;?>" class="text_center" >
                
            <?php    
                 echo UI::btn_("button", "edit", "Edit", "", "", "photo_edit".$row->photo_id."","edit");
				 echo UI::btn_("button", "delete", "Delete", "", "", "delete_".$row->photo_id."","delete"); 
                
          ?>      

		        </div>
		<?php } ?>

		<?php //jquery for edit album ?>

		<script>
		$(document).ready(function()
		{

		/*edit album*/
		$("#photo_edit<?php echo $row->photo_id;?>").click(function()
		{

		$("#edit_photo<?php echo $row->photo_id;?>").toggle("slow");
		$("#delete_form<?php echo $row->photo_id;?>").hide("slow");  		
		});
		/*cancel edit album album*/
		$("#cancel<?php echo $row->photo_id;?>").click(function()
		{
		$("#edit_photo<?php echo $row->photo_id;?>").hide("slow");
		});
         $("#delete_<?php echo $row->photo_id;?>").click(function(){ 
         $("#delete_form<?php echo $row->photo_id;?>").toggle("show") 
         $("#edit_photo<?php echo $row->photo_id;?>").hide("slow"); });
	 $("#close<?php echo $row->photo_id;?>").click( function(){  $("#delete_form<?php echo $row->photo_id;?>").hide("slow");  });
	 $("#cancell<?php echo $row->photo_id;?>").click( function(){  $("#delete_form<?php echo $row->photo_id;?>").hide("slow");  });
	
		});
	 
		</script>

		<div class="span-5 hide  mb-20 borderf p5 " id="edit_photo<?php echo $row->photo_id;?>">
		<form name="edit_photo" action="<?php echo $this->docroot;?>photos/edit_photo/?photo_id=<?php echo $row->photo_id;?>&album_id=<?php echo $row->album_id;?>" method="post">
		<table border="0" cellpadding="0" cellspacing="0" align="left">
		<tr><td>
		<input type="text" name="photo_name11" class="span-3" value="<?php echo $row->photo_title;?>" /></td></tr>
		<tr> <td class="pb-10 text-left "><input type="checkbox" name="album_cover" value="<?php echo $row->photo_id;?>" />Album cover</td></tr>
		<tr> <td>
		<?php  echo UI::btn_("Submit", "edit_photo", "Update", "", "", "", "submit".$row->photo_id."","");?>
		
		&nbsp;
		
		<?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancel".$row->photo_id."","");?>
		</td></tr>
		</table>
		</form>
		</div>
                         <!-- div for delete  -->
		        <div id="delete_form<?php echo $row->photo_id;?>" class="delete_alert clear width145 ml-20 mb-10 " >
                <span class="fr">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->photo_id;?>"  ></span>
		        <h3 class="delete_alert_head clear fl">Delete Photo</h3>
		        
		        <div class="clear fl pb5" >Are you sure want to delete this photo? </div>
		        <div> 
		        
		        		        
		        <?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:window.location='".$this->docroot."photos/delete_photo/?photo_id=".$row->photo_id."&album_id=".$row->album_id."' ", "delete","delete");?> 
		        
		        <?php  echo UI::btn_("button", "cancel", "Cancel", "", "", "cancell".$row->photo_id."","");?> 
		        
		        
		        </div>
		        </div>
		</div>

		<?php 
        if ($k % 3 == 0)
        {
        echo '</div>';
        }
        $k++;
        $i++;
		$cont++;
}

	//pagination
	if ($this->photo_total > 15)
	{
	?> <div class="span-19 fl"><?php echo $this->template->pagination;?></div>
    
	<?php }

}
else
{
?>
<div class="no_data">No photos available</div>
<?php 
}
?>
</div>

</div>

<?php
if (count($this->template->show_photo) % 3 != 0)
{
echo '</div>';
}
?>
<hr/>
<p class="quiet">Total Photos in this Album : <?php echo $this->photo_total; ?></p>
