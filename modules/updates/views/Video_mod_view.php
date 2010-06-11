<?php      
//Nauth::get_Name($this->row->u_id);
Nauth::print_name($this->row->u_id, $this->row->name);
// display description
echo " ".$this->row->action_desc; ?>
<a href="<?php echo $this->docroot; ?>video/view_video?video_id=<?php echo $this->row->type_id; ?>">
<?php echo htmlspecialchars_decode($this->row->desc); ?></a>
<a href="<?php echo $this->docroot; ?>video/view_video?video_id=<?php echo $this->row->type_id; ?>">
<?php if(common::get_video($this->row->type_id)) {?> <span class="videobox" style="background-image:url(<?php echo common::get_video($this->row->type_id); ?>);"> <em> </em> </span> <!-- img src="<?php echo common::get_video($this->row->type_id); ?>"  / --> <?php }  ?>
</a>
