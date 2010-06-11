<!-- contents start -->


<?php
						
if (count($this->result)!= 0)
{
	foreach($this->result as $row)
	{
				 
 ?>


	<div class="span-19 border_bottom">
	
	<a href="<?php echo $this->docroot;?>forum/search/?id=<?php echo $row->category_id;?>" title="<?php echo $row->forum_category;?>" class="text_bold ml-3"><?php echo $row->forum_category;?></a>
	<br>
   <?php /* <p class="span-19 margin_left3">
	<span><?php echo $row->category_description;?></span> <br>
	<span><a href="<?php echo $this->docroot;?>forum/search/?id=<?php echo $row->category_id;?>" title="All Discussions" >All Discussions (<?php echo $row->total_discussion;?>)</a></span>
	</p>
	*/ ?>
	</div>

<?php } ?>
<?php
if(count($this->cout) >10) {
echo $this->template->pagination;
}
?>

<?php
}
else
{
 ?>
<div class="no_data">No Category Available</div>

<?php
 }
?>




