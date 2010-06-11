<?php
/**
 *
 * @package    Core
 * @author     M.Balamurugan
 * @copyright  (c) 2010 Ndot.in
 */

?>
<!--manage cmss -->
<div class="notice">Create / Edit / Delete / Manage Pages for your site. You can view Site Page Analytics here.  </div>
   <div class="span-19 border_bottom">
  <?php   echo UI::a_tag("create_page","create_page","Create New Page",$this->docroot."admin_cms/create_pages");?> 
   </div>
 
 
 <?php
 if(count($this->template->get_pages)>0)
 {
	foreach($this->template->get_pages as $row)
	{?>
	                        
                                
			<div class="span-19 border_bottom" >
                                <script>
                                $(document).ready(function(){
                                $("#delete_<?php echo $row->cms_id;?>").click(function(){ $("#delete_form<?php echo $row->cms_id;?>").toggle("show") });
                                $("#close<?php echo $row->cms_id;?>").click( function(){  $("#delete_form<?php echo $row->cms_id;?>").hide("slow");  });
                                $("#cancel<?php echo $row->cms_id;?>").click( function(){  $("#delete_form<?php echo $row->cms_id;?>").hide("slow");  });
                                });
                                </script>
                                <div class="span-18" >
                                <h3><?php echo htmlspecialchars_decode(ucfirst($row->cms_title));?> </h3>
                                <div class="v_align mt-10 fl">
                                <ul class="inlinemenu">
                                <li id="edit<?php echo $row->cms_id; ?>">
                                 <a href="<?php echo $this->docroot;?>admin_cms/edit_cms/?id=<?php echo $row->cms_id;?>" >
                                <img src="<?php echo $this->docroot;?>/public/images/icons/edit.gif" title="Edit" class="admin" />Edit</a>
                                </li>
                                <li>
           
                                <a href="javascript:;" id="delete_<?php echo $row->cms_id;?>" title="Delete cms">
                                <img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />Delete</a> 
                                </li>
                                <li><a href="<?php echo $this->docroot;?>cms?page=<?php echo $row->cms_title; ?>"  >
                                <img src="<?php echo $this->docroot;?>/public/images/icons/resource.jpg" title="Preview" class="admin" />Preview :
                               <?php echo $this->docroot;?>cms?page=<?php echo $row->cms_title; ?></a>				
                                </li>
                               
                                </li>
                                </ul> 
                               </div>
                                </div>
                          
			</div>
			
			
			
			<!-- div for delete cms -->
                                <div id="delete_form<?php echo $row->cms_id;?>" class="width400 delete_alert clear ml-10 mb-10">
                                <h3 class="delete_alert_head">Delete Page</h3>
                                <span class="fr">
                                <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->cms_id;?>"  ></span>
                                <div class="clear fl">Are you sure to delete this page? </div>
                                <div class="clear fl mt-10"> 
                                <?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_cms/delete_page/?id=".$row->cms_id."' ", "delete_com","");?>
                                 <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$row->cms_id."","");?>
                                </div>
                                </div>
			                   
			<?php 


	}?>
			<div style="float:right;">
			<?php if(count($this->total_cms_pages)>10) { echo $this->template->pagination; } ?>
			</div><?php
}
else
{
echo UI::nodata_();
}
?>
