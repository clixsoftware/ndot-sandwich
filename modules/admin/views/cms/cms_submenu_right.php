<?php
/**
 * Defines left menu for admin module
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>
<!-- left side Start -->
<div class="left_side">

<div class="left_menu">
<ul>
<li><img src="<?php echo $this->docroot;?>public/images/home icon.jpg" border="0"  /><a href="<?php echo $this->docroot;?>admin_cms" title="Manage Pages">Manage Pages</a><li>
<?php  if($this->moderator_add == 1)  { ?>
<li><img src="<?php echo $this->docroot;?>public/images/home icon.jpg" border="0"  /><a href="<?php echo $this->docroot;?>admin_cms/create_pages   " title="Manage Pages">Create Page</a><li>
<?php } ?>
</ul>
</div>
</div>
<!-- left side end -->


 
