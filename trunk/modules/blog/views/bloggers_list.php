<div class="span-19 mt-10 ml-10">
<?php   
 $blogs=$this->template->name1;

if(count($blogs)>0)
{
$i = 1;
?>


 
	<?php 
	foreach ($blogs as $row )
	{
	if($i <= 4){	
	?>
	<div class="span-4a fl">
        <div class="span-1a mr_fl_l  ">
	<?php
		Nauth::getPhoto($row->user_id,$row->name); 
 ?>
	</div>

	<div class="span-3  pl-5">
	<span class="margin_left3 fl clear"><?php Nauth::print_name($row->user_id,$row->name); ?></span>
	<span class="margin_left3 fl clear"><?php echo $row->city;?></span> <br>
	<span class="margin_left3"><a href="<?php echo $this->docroot; ?>blog/total_blogs/?uid=<?php echo $row->user_id ?>" title="Top Bloggers">Total Blogs (<?php echo $row->total;?>)</a></span>
	</div>

	</div>
	<?php 
	}
	$i++;
	}
} else {

echo UI::nodata_();
} ?>

</div>