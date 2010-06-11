<?php 
//$protocol = $_SERVER['HTTP'] == 'on' ? 'https' : 'http';
$a= $_SERVER["REQUEST_URI"];
$uri = substr($this->docroot,0,-1);
$url = $uri.$a;
?>

<link  href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme ?>/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen"/>		

<script src="<?php echo $this->docroot;?>public/js/lightbox/jquery.lightbox-0.5.js"></script>
	

<script >

function send_mail(elem)
{
	var sub = document.getElementById('sub').value;
	var mess = docement.getElementById('msg').value;
	alert(sub);
	alert(mess);
}

</script>

<!--roundbox-->
<div class="span-19a clear "  >

<?php if (count($this->eventdata)==0)
{
?>
	<div class="span-19a">
	<h2 class="cal_name">No events schedule on this year</h2></div>
<?php 
}
else
{
?>
	<div  class="span-11 fl mt-20 mb-20  "  >
<?php 
foreach($this->eventdata as $eventdata)
{ 
         $this->author_id = $eventdata->user_id;
         $this->type_id = $eventdata->event_id;
         
?>
<div  class="span-11 ml-20 ">

<table border="0" cellpadding="3" cellspacing="0">
<tr>
<td align="right">
<b>Event-time:&nbsp;&nbsp;</b></td><td><?php echo $eventdata->start_time; ?>&nbsp;&nbsp;to&nbsp;<?php echo $eventdata->end_time; ?>&nbsp;&nbsp;&nbsp;<?php echo $eventdata->dat; ?></td>
<?php
if($eventdata->address!='')
{ 
	echo '<tr><td align="right"><b>Venue : &nbsp;</b></td><td>';
	echo nl2br(htmlspecialchars_decode($eventdata->address)); 
	echo '</td></tr>';
}
?> 
<?php 
if($eventdata->event_place!='')
{
	echo '<tr><td align="right"><strong >Location : </strong>&nbsp;</td><td>';
	echo htmlspecialchars_decode($eventdata->event_place); 
	echo '</td></tr>';
}
?> 
<?php 
if($eventdata->contacts!='' && $eventdata->contacts!='0' && !empty($eventdata->contacts))
{
	echo '<tr><td align="right"><strong >Contact No : </strong>&nbsp;</td><td>';
	echo htmlspecialchars_decode($eventdata->contacts); 
	echo '</td></tr>';
}
?>
<?php 
if($eventdata->contact_email!='')
{
	echo '<tr><td align="right"><strong >Contact Email : </strong>&nbsp;';
	?><a href="mailto:<?php echo htmlspecialchars_decode($eventdata->contact_email); ?>"></td><td><?php echo htmlspecialchars_decode($eventdata->contact_email); ?></a><?php
	echo '</td></tr>';
}
if($eventdata->category_id!='')
{
	echo '<tr><td align="right"><strong >Category : </strong>&nbsp;';
	?> <a href="<?php echo $this->docroot; ?>events/category/?cat_id=<?php echo $eventdata->category_id ?>"></td><td> <?php echo htmlspecialchars_decode($eventdata->category_name); ?> </a><?php
	echo '</td></tr>';
}
?>
</table>
<?php if($eventdata->event_description!='')
{
	echo '<p class="span-11 mt-10 mb-10"><span><strong>Event Description : </strong></span>';
	echo nl2br(htmlspecialchars_decode($eventdata->event_description)); 
	echo '</p>';
}

 ?>
 
 <?php 
if($this->userid != '')
{
if($eventdata->date_diff >=0 ){
?>
 <?php  echo UI::btn_("button", "Invite Friends", "Invite Friends", "", "javascript:window.location='".$this->docroot."inbox/compose/?subject=".urlencode($eventdata->event_name)."&message=".urlencode($eventdata->event_description)."'", "Invite Friends","Invite Friends");?> 
 


<?php  echo UI::btn_("button", "Upload Photos", "Upload Photos", "", "javascript:window.location='".$this->docroot."events/event_upload_photo/?event_id=".$eventdata->event_id."&url=".url::title($eventdata->event_name)."_".$eventdata->event_id."'", "Upload Photos","Upload Photos");?>
<?php if($this->userid==$eventdata->exis)
{
?>
 

<?php  echo UI::btn_("button", "Unjoin this Events", "Unjoin this Events", "", "javascript:window.location='".$this->docroot."events/unjoin/?event_id=".$eventdata->eid."&userid=".$this->userid."&url=".url::title($eventdata->event_name)."_".$eventdata->event_id."'", "Unjoin this Events","Unjoin this Events");?>

<?php 
}
?>

<?php 

if($this->userid!=$eventdata->exis) 
{ ?>
 

<?php  echo UI::btn_("button", "Join this Events", "Join this Events", "", "javascript:window.location = '".$this->docroot."events/join/?event_id=".$eventdata->eid."&userid=".$this->userid."&url=".url::title($eventdata->event_name)."_".$eventdata->event_id."'", "Join this Events","Join this Events");?>
<?php  }

 ?>
<p class="mt-10 fl" ><?php echo favourite::my_favourite(urlencode($_SERVER['REQUEST_URI'])); ?></p>
<?php
 
}
}
?>
<div class="span-7 mt-10" ><?php common::show_ratings($url,4,$eventdata->event_id);?></div>
<?php
	echo '</div>';
	
}

}
?>
</div>

<script>

function char_count(Object,event)
{ 
        var val=event.which;

        if(Object.value.length<140)
        {
                document.getElementById('message').innerHTML = 139-Object.value.length + " Characters left";
                return true;
        }
        else
        {
                
                if(val<30)
                {
                return true;
                }
                else
                {
                //alert("max 140 char");
                return false;
                }
        }

}
 
</script>




 <!-- right side box start -->

<div class="span-8 mr_fl  mt-20 mr-10 borderf p2">
<h3  class="sub-heading"><strong>Joined Members </strong><span class="fr mr-5"><?php if(count($this->eventdata1) >= 8) { ?><a href="/events/event_users/?event_id=<?php if(count($this->eventdata1) > 0) { echo $this->eventdata1['mysql_fetch_array']->event_id; } ?>">View all (<?php echo count($this->eventdata1); ?>)</a> <?php }else{ echo 'Members ( '. count($this->eventdata1).')';} ?></span></h3>

<div class="span-8 pl-10 mr-10 mt-20">
<?php
if(count($this->eventdata1)>0)
{ 
        $i = 1;
	foreach($this->eventdata1 as $row)
	{ 
	        if($i <= 8){?>
		<div class="width70 fl mr-10 ml-5 mb-20 "><?php Nauth::getNameImage($row->id,$row->name);?></div>
	<?php
	}
	$i++;
	}
}
else
{
	echo UI::nodata_();
}
?>
</div>

</div>



<script type="text/javascript">
$(function() {
	$('#gallery a').lightBox();
});
</script>

<div class="span-8 mr_fl  mt-20 mr-10 borderf p2">
<h3  class="sub-heading"><strong> Event Photos <span class="fr mr-5"><?php if(count($this->event_photo_show) > 4) { ?><a href="/events/event_photos/?event_id=<?php if(count($this->event_photo_show) > 0) { echo $this->event_photo_show['mysql_fetch_array']->event_id; } ?>">View all (<?php echo count($this->event_photo_show) ?>)</a> <?php } ?></span></h3>
<div id="gallery" class="span-8" >
<ul>
<li  class="mb-20   " >
<?php
if(count($this->event_photo_show)>0)
{
        $j = 1;
	foreach($this->event_photo_show as $row)
	{
	        if($j <=4)
	        {
		$file_path= end(explode('.', $row->photo_name));
		?>
		<a  class="m10 height100" href="<?php echo $this->docroot; ?>public/event_photos/normal/<?php echo $row->photo_id.'.jpg'; ?>">
		<img src="<?php echo $this->docroot; ?>public/event_photos/<?php echo $row->photo_id.'.jpg'; ?>" alt="Event Photo" "  />
		</a>
		<?php
		}
		$j++;
	}
}
else
{  
 echo UI::nodata_();
}
?>
</li>
</ul>
</div>
</div>
</div>
<!-- end of right side and left side  -->

<?php common::get_comments($this->module."_comments",$this->type_id);?>
</div>


