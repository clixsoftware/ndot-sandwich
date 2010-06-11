<?php 		
		 if($this->row->action_id == 25){ ?>
        
      
<?php      
		//Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc;
		$this->get_album_id=$this->model->get_album($this->row->typeid); 
		
		if(count($this->get_album_id) > 0){
		?>
		<a href="<?php echo $this->docroot; ?>photos/view/?album_id=<?php echo  $this->get_album_id['mysql_fetch_row']->album_id; ?>" > <?php echo htmlspecialchars_decode($this->row->desc); ?></a>
<?php		}
		}
		else if($this->row->action_id==24)
		{ ?>
<?php     
		// Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc; ?>
<a href="<?php echo $this->docroot; ?>photos/view/?album_id=<?php echo $this->row->type_id; ?>"> <?php echo htmlspecialchars_decode($this->row->desc); ?></a>
<?php
		}
		else
		{?>
<?php     
		// Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo "added ".$this->row->photo_count." photos in album"; ?>
<a href="<?php echo $this->docroot; ?>photos/view/?album_id=<?php echo $this->row->type_id; ?>"> <?php echo htmlspecialchars_decode($this->row->desc); ?></a>
<?php  $this->photo_name = common::get_album_photo($this->row->type_id);
		 $i=1; 
		 echo "<div>";
		foreach($this->photo_name as $photo)
		{     if( $i== 4 || $i > $this->row->photo_count) {  break ;  }?>  
		<a href="<?php echo $this->docroot; ?>photos/view/?album_id=<?php echo $this->row->type_id; ?>">
		<img src="<?php echo $this->docroot.'public/album_photo/'.$photo->photo_id.'.jpg' ?>"  title = "<?php echo $photo->photo_title ?>" class="imgborder"/> </a>
		<?php $i++; } echo "</div>"; ?>
<?php
		}	
 ?>
