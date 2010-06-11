<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<script>
function deleteevent(e_id,e_name)
{
	var ok = confirm("Are you sure to delete" +e_name+ "Event"); 
	if(ok)
	{
		window.location='<?php echo $this->docroot;?>admin_events/delete_event/?e_id='+e_id+'&e_name='+e_name;
	}
}


</script>
<table cellpadding="8" cellspacing="8" width="742">
<tr>


<td><div class="fr">
<?php  echo UI::btn_("button", "Add New Category", "Add New Category", "", "javascript:window.location='".$this->docroot."admin_events/add_category' ", "Add New Category","");?>
<?php  echo UI::btn_("button", "Add New Event", "Add New Event", "", "javascript:window.location='".$this->docroot."events/create' ", "Add New Event","");?> </div>
</td>
</tr>
</table>
<div class="span-19a mt-20 mb-20 pb-20 border_bottom">
<form name="search_form" id="search_form" action="<?php echo $this->docroot;?>admin_events/event_search" method="get">
<table cellpadding="8" cellspacing="8" width="742">
<tr>
<td align="right"><label>Search Key :</label></td>
<td width="250"><input type="text" name="search_value" id="search_value" class="title" value="Keyword" onClick="if(this.value=='Keyword'){this.value='';}" /><br /><span class="quiet">Search Title,venue</span></td>
<td><?php  echo UI::btn_("Submit", "Search", "Search", "", "", "new_q","Search");?>
</td>
</tr>
 
</table>
</form>
</div>



<?php
if(count($this->template->get_allevents)>0)
{
	$i = 1;
	foreach($this->template->get_allevents as $events)
	{?>	
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
	        <div class="span-19a border_bottom mb-20 clear pl-10 pb-10">
		
		<div class="span-19  ">
			 <script>
 			$(document).ready(function(){
			 $("#delete_<?php echo $events->event_id;?>").click(function(){ $("#delete_form<?php echo $events->event_id;?>").toggle("show") });
			 $("#close<?php echo $events->event_id;?>").click( function(){  $("#delete_form<?php echo $events->event_id;?>").hide("slow");  });
			 $("#cancell<?php echo $events->event_id;?>").click( function(){  $("#delete_form<?php echo $events->event_id;?>").hide("slow");  });
 			});
			 </script>
	
		
		<p><h2><a href="<?php echo $this->docroot;?>events/view/<?php echo url::title($events->event_name); ?>_<?php echo $events->event_id; ?>"><strong><?php echo htmlspecialchars_decode($events->event_name); ?></strong></a></h2></p>
		
		<p class="mt-5"><span class="quiet">Event time: </span><?php echo $events->start_time; ?> <span class="quiet">to </span><?php echo $events->end_time; ?> &nbsp;&nbsp;<?php $dat=strtotime($events->event_date); echo  date("l, F j",$dat);?></p>
		
		<p class="span-19 mt-10"><?php echo htmlspecialchars_decode(substr($events->event_description,0,300)).',..'; ?></p>
		
		<p class="mt-5"><a href="<?php echo $this->docroot; ?>profile/view/?uid=<?php echo $events->user_id; ?>"><strong><?php echo $events->name; ?></strong></a> <span class="quiet ml-10">Posted </span><?php echo common::getdatediff($events->posted_date);  ?>
		
		<span class="quiet ml-10">Category : </span><a href="<?php echo $this->docroot; ?>admin_events/category_search/?cat_id=<?php echo $events->category_id ?>"><strong><?php echo $events->category_name;  ?></a></strong>
		
		
		<div class="span-19a mt-10  pt-10 clear">
		
		<?php  echo UI::btn_("button", "Photos", "Photos", "", "javascript:window.location='".$this->docroot."admin_events/event_photos/?eid=".$events->event_id."'", "Photos","Photos");?>
		
		<?php 
		 if( ($this->edit_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	         {
		 echo UI::btn_("button", "Edit", "Edit", "", "javascript:window.location='".$this->docroot."events/edit_event/?event_id=".$events->event_id."&type=normal'", "Edit","Edit"); } ?>


                <?php  
                if( ($this->delete_permission == 1 && $this->usertype == -2) || ($this->usertype == -1) )
	        {
                echo UI::btn_("button", "del", "Delete", "", "", "delete_".$events->event_id."","del");
                }
				
				if($events->status == 1)
				{
					echo UI::btn_("button", "Block", "Block", "", "javascript:window.location='".$this->docroot."admin_events/block_unblock/?event_id=".$events->event_id."&status=0'", "Block","Block");
				}
				else
				{
					echo UI::btn_("button", "Unblock", "Unblock", "", "javascript:window.location='".$this->docroot."admin_events/block_unblock/?event_id=".$events->event_id."&status=1'", "Unblock","Unblock");
				}
                ?>

 
 
		
		</div>
		 
		<!-- div for delete event -->
		<div id="delete_form<?php echo $events->event_id;?>" class="delete_alert width300 borderf clear mt-20">
		<h3 class="delete_alert_head width280">Delete Event</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $events->event_id;?>"  ></span>
		<div  class="clear fl">Are you sure want to delete? </div>
		<div class="mt-10 clear fl"> 
		
		<?php  echo UI::btn_("Submit", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_events/delete_event/?e_id=".$events->event_id."'", "new_q","Delete");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "cancell".$events->event_id."", "javascript:window.location='".$this->docroot."admin_events/' ", "Add New Event","");?>
		 
		 </div>
		 </div>
		 
 </div>
 </div>
		

<?php

	}
?>
<tr>
<td align="right" colspan="5"><?php echo '<div class="span-19 text-right mb-10">' . $this->pagination->render('classic') .'</div>';  ?></td>
</tr>
<?php
}
else
{ 
        echo UI::nodata_(); 
}
?>

</div>
</div>
