<div class="mr-18 span-4  border_full" style="padding:2px;" >
<?php echo $this->left; ?>
</div>
<div class="span-14a  border_full p2 ">
<div class="title_out">
<h2 class=" all_heading "><?php echo $this->title_content; ?></h2>
<p class="sub_ctitle">
	<?php  if(isset($this->status_message)){if($this->status_message!="") echo "\"".$this->status_message."\"" ; }  ?>
</p>
</div>
<?php echo $this->center; ?>
</div>

<div class="span-5 mr_fl p2 ">
<?php echo $this->right; ?>
</div>

