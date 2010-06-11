<div class="span-4 " >
<?php echo $this->left; ?>
<img src="<?php echo $this->docroot; ?>public/themes/default/images/ad1.jpg" />
</div>
<div class="span-15 commonbox "  >
<div class="title_out">
<h1 class=" all_heading "><?php echo $this->title_content; ?></h1>
<?php  if(isset($this->status_message)) { ?>
<p class="sub_ctitle">
	<?php  if(isset($this->status_message)){if($this->status_message!="") echo "\"".$this->status_message."\"" ; }  ?>
</p>
<?php } ?>
</div>
<?php echo $this->center; ?>
</div>

<div class="span-5 last " style="margin-top:5px;">
<?php echo $this->right; ?>

</div>