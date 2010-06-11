<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div style="width:500px; height:auto; margin:50px; float:left;">
	<?php foreach($this->analytics as $key=>$row ){
	
	if($key == "blog"){
		$key = "blogs";
	}
	if($key == "forum"){
		$key = "forums";
	}
	if($key == "video"){
		$key = "videos";
	}
	 ?>
    <div style="float:left; width:200px;font-weight:bold; font-size:15px; margin:10px;"><a href="<?php if($key == "users"){echo $this->docroot."admin/manage_users";}else{echo $this->docroot."admin_".$key; }?>"><img src="<?php echo $this->docroot."public/images/analytics/".$key;?>.jpg" />&nbsp;<?php echo $row."&nbsp;".$key; ?></a></div>
    <?php } ?>
</div>
