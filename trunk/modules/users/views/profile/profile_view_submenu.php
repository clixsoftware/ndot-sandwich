<?php defined('SYSPATH') OR die('No direct access allowed.');  ?>
<div class="profile_vsubmenu">
    <ul>
        <li><a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $this->template->id;?>" class="<?php echo $this->c_update; ?>" >Updates</a></li>
        <li><a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $this->template->id;?>&action=wall" class="<?php echo $this->c_wall; ?>">Wall</a>  </li>
        <li><a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $this->template->id;?>&action=info" class="<?php echo $this->c_info; ?>">Info</a></li>
        <li><a href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $this->template->id;?>&action=photos" class="<?php echo $this->c_photos; ?>">Photos</a></li>
    </ul>
</div>
 	