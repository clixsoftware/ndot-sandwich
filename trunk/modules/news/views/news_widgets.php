	<?php 
	/**
	 * Defines all  news lists
	 *
	 * @package    Core
	 * @author     M.Balamurugan
	 * @copyright  (c) 2010 Ndot.in
	 */
	 ?>

<div class="span-5 suggestion borderf p2">
<h2 class="sub-heading">News by Category</h2>
<ul>
 <?php
if(count($this->get_category)>0)
{
	foreach($this->get_category as $row)
	{
	if($row->category_name!='')
	{
	?>
		 <li  class="line-height25"><a href="<?php echo $this->docroot;?>news/category/?cate=<?php echo $row->category_id;?>">
		
		<?php echo $row->category_name;?></a></li>
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

