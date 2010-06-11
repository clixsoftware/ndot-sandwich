<script type="text/javascript">
function confirmDelete(request_id,friend_id,user_id,name)
 {
 temp = window.confirm('Are you want to delete '+name);
 if (temp){
	url = '/profile/remove_friends/'+request_id+'/'+friend_id+'/'+name;
 	window.location=url;
 }
 } 
</script>
<script src="<?php echo $this->docroot;?>public/js/jquery.validation.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
$('#search_form').validate();
});
</script>
<?php
if($this->input->get('friend_search'))
{
        ?>
        <script type="text/javascript">
        window.onload= function(){
        document.getElementById('friend_search').focus();
        }
        </script>
        <?php
}
?>

<div class="span-19">
<form name="search_form" id="search_form" method="get" action="<?php echo $this->docroot; ?>profile/search_my_frend/">
<table align="right" cellpadding="5" cellspacing="5" border="0" class="pb-10">
<tr>
<input type="hidden" name="uid" id="uid" value="<?php echo $this->input->get('uid'); ?>" />
<td align="right" valign="top"><label>Name / City :</label></td>
<td ><input type="text" id="friend_search" name="friend_search" class="title required" /><br /></td>
<td valign="top"><?php  echo UI::btn_("Submit", "Search", "Search  My Friends", "", "","form1","form1");?></td>
</tr>
</table>
</form>
  <?php
if(count($this->template->list_friends)>0){
$cnt = count($this->template->list_friends); ?>

  <?php
	foreach($this->template->list_friends as $friends)
	{  ?>
	
	<script>
         $(document).ready(function(){
			        
			         $("#delete_<?php echo $friends->id;?>").click(function(){ $("#delete_form<?php echo $friends->id;?>").toggle("show") });
			         $("#close<?php echo $friends->id;?>").click( function(){  $("#delete_form<?php echo $friends->id;?>").hide("slow");  });
			         $("#cancel<?php echo $friends->id;?>").click( function(){  $("#delete_form<?php echo $friends->id;?>").hide("slow");  });

         });
         </script>
  <div style="padding:10px;" class="span-21" >
    <div class="span-2 text-align">
      <?php Nauth::getPhoto($friends->id, $friends->name); ?>
    </div>
    <div class="span-7"> <?php echo Nauth::print_name($friends->id, $friends->name); ?> <br/><?php echo $friends->city; ?></div>
    <div class="span-8">
      <?php if($this->template->user_id == $this->userid ){ ?>
      <p> <a href="<?php echo $this->docroot;?>inbox/compose?name=<?php echo $friends->name; ?>&fid=<?php echo $friends->id; ?>" title="Email" class="p_inbox" style="text-decoration:none;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Send Message</a> 
      
        &nbsp;&nbsp;&nbsp;&nbsp;
      <a style="cursor:pointer;" title="Delete" id="delete_<?php echo $friends->id; ?>"><img  src="<?php echo $this->docroot;?>/public/images/icons/delete.gif" title="Delete" class="friends" title="delete"style="text-decoration:none;"  /> Remove from Friends</a>
      
      
      
      
      </p>
      <?php } ?>
      <!-- div for delete classifieds -->
		        <div id="delete_form<?php echo $friends->id;?>" class="delete_alert clear  span-10  mt-20 mb-10">
			        <span class="fr">
		        <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $friends->id;?>"  ></span>
		        <h3 class="delete_alert_head clear fl">Remove this Friend</h3>
	
		        <div  class="clear fl">Are you sure to remove from your list? </div>
		        <div class="clear fl"> 
		
		      <?php  echo UI::btn_("button", "delete_com", "Remove", "", "javascript:window.location='".$this->docroot."/profile/remove_friends/?frid=".$friends->request_id."&fid=".$friends->id."&name=".trim($friends->name)."'" , "delete","");?> &nbsp;
		      
		      <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancel".$friends->id."","Cancel");?>

		        </div>
		        </div>
    </div>
  </div>
  <hr class="span-21"/>
  <?php  } 
	if($this->total >  10){
		echo $this->template->pagination;
	}
}
else
{
	echo UI::nodata_();
}

?>
</div>
