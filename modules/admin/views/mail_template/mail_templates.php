<script language="javascript">
function delete_temp(id)
{
var answer = confirm ("Are you want to delete?")
if (answer)
{
window.location="<?php echo $this->docroot;?>admin_mailtemplates/delete_template/?id="+id;
}
}
</script>
<?php  
foreach($this->template->get_alltemplates as $row)
{?>
	<script>

	$(document).ready(function()
	{
			$("#delete_<?php echo $row->mail_temp_id;?>").click(function(){ $("#delete_form<?php echo $row->mail_temp_id;?>").toggle("show") });
			 $("#close<?php echo $row->mail_temp_id;?>").click( function(){  $("#delete_form<?php echo $row->mail_temp_id;?>").hide("slow");  });
			 $("#cancell<?php echo $row->mail_temp_id;?>").click( function(){  $("#delete_form<?php echo $row->mail_temp_id;?>").hide("slow");  });

	});
	</script>

<div class="span-19 border_bottom">
<div class="span-7 fl p5"><label><?php echo  ucfirst($row->mail_temp_title); ?></label> </div>
<div class="v_align p5">
<ul class="inlinemenu">
<li >
<a href="<?php echo $this->docroot;?>admin_mailtemplates/view_temp?id=<?php echo $row->mail_temp_id; ?>"><img src="<?php echo $this->docroot;?>/public/images/icons/edit.gif" title="Edit" class="admin" />&nbsp;Edit</a>
</li>
<li>
<!-- a href="javascript:onclick=delete_temp('<?php echo $row->mail_temp_id; ?>')">
<img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />Delete</a -->
<a href="javascript:;" id="delete_<?php echo $row->mail_temp_id;?>" title="Delete "><img src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="admin" />&nbsp;Delete</a>
</li>	
</ul>
</div>
		<!-- div for delete album -->
		<div id="delete_form<?php echo $row->mail_temp_id;?>" class="delete_alert width300 borderf clear mt-20">
		<h3 class="delete_alert_head width280">Delete Template</h3>
		<span class="fl">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->mail_temp_id;?>"  ></span>
		<div  class="clear fl">Are you sure to delete this template? </div>
		<div class="mt-10 clear fl"> 
		
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."admin_mailtemplates/delete_template/?id=".$row->mail_temp_id."'", "Delete","Delete");?> 
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->mail_temp_id."","Cancel");?>
		</div>
		</div>
</div>
<?php }
?>

