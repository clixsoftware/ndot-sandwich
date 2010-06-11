<div class="span-5  borderf p2">
<h2 class="sub-heading">Video Category</h2>
<ul class="pl-10 mt-10 mb-10">
 <?php
if(count($this->get_category)>0)
{
	foreach($this->get_category as $row)
	{
	if($row->category!='')
	{
	?>
		<li class="line-height25"> &#187 <a href="<?php echo $this->docroot;?>video/category/?cat=<?php echo $row->cat_id;?>" class="pl-5">
		
		<strong><?php echo $row->category;?></strong></a></li>
	<?php
	}
	}
}
else
{
	echo'<li>No Category Available</li>';
}?>

</ul>
</div>

