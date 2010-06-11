<?php
/**
 * Defines top blogger and popular category
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
?>
<div class="span-5 suggestion borderf p2">
<h2 class="sub-heading">Popular Category</h3>
<div class="mt-5">
<ul>
<?php
if(count($this->popular_category)>0)
{
foreach($this->popular_category as $popular)
{
        if($popular->category_name)
        {
        ?>
        <li  class="line-height25"> <a href="<?php echo $this->docroot ;?>blog/category/?id=<?php  echo $popular->category_id; ?>" title="<?php  echo $popular->category_name; ?>">
        <?php echo $popular->category_name;?></a></li>
        <?php
        }
}
}
else
{
echo "<li>No category Available</li>";
}
?>
</ul>
</div>
</div>

<div class="span-5 suggestion borderf p2 overflowh pb-10 ">
<h3  class="sub-heading">Top Bloggers<span class="fr mr-5"><?php if(count($this->template->name1) >= 1) { ?><a href="/blog/top_bloggers_list/">View all (<?php echo count($this->template->name1); ?>)</a> <?php } ?></span></h3>
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
	<div class="span-4a border_bottom clear fl">
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


