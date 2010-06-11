<script type="text/javascript">
function confirmDelete(request_id,friend_id)
 {
 temp = window.confirm('Are you want to delete');
 if (temp){
	url = '/profile/deleteinvites/'+request_id+'/'+friend_id;
 	window.location = url;
 }
 } 
</script>
<?php defined('SYSPATH') OR die('No direct access allowed.');  ?>
	<div class="span-19">
<?php

	if( $this->openinvites->count() > 0){
		foreach($this->openinvites as $open)
		{ 
?>
<script>
         $(document).ready(function(){
			        
			         $("#delete_<?php echo $open->friend_id;?>").click(function(){ $("#delete_form<?php echo $open->friend_id;?>").toggle("show") });
			         $("#close<?php echo $open->friend_id;?>").click( function(){  $("#delete_form<?php echo $open->friend_id;?>").hide("slow");  });
			         $("#cancel<?php echo $open->friend_id;?>").click( function(){  $("#delete_form<?php echo $open->friend_id;?>").hide("slow");  });

         });
         </script>
  	<div style="padding:10px;" class="span-21" >
    	<div class="span-2 text-align">
      		<?php Nauth::getPhoto($open->friend_id, $open->name); ?>
    	</div>
    	<div class="span-6"> <?php echo Nauth::print_name($open->friend_id, $open->name); ?> <br/>
      		<span class="margin_left3"> <?php echo $open->city; ?> </span>
        </div>
         
        <div class="span-4">
        	<a onclick="javascript:$('#delete_form<?php echo$open->friend_id;?>').toggle('slow');" href="javascript:;" title="Remove Open Invites" > <img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="friends" title="delete" /> Remove from List </a>
        </div>
        
   </div>
   
   <div id="delete_form<?php echo$open->friend_id;?>" class="delete_alert clear  span-10  mt-20 mb-10">
			        <span class="fr">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $open->friend_id;?>"  ></span>
		        <h3 class="delete_alert_head clear fl">Remove this Friend</h3>
	
		        <div  class="clear fl">Are you sure to remove from your list? </div>
		        <div class="clear fl"> 
		
		      <?php  echo UI::btn_("button", "delete_com", "Remove", "", "javascript:window.location = '/profile/deleteinvites/".$open->request_id."/".$open->friend_id."'" , "delete","");?> &nbsp;
		      
		      <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$open->friend_id."","Cancel");?>

		        </div>
		        </div>
   
  <hr class="span-21"/>
<?php  } 
	}
	else{
		echo UI::nodata_();
	}
	
	echo $this->template->pagination;
?>
</div>
