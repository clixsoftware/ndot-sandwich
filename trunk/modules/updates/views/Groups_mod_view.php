		<?php 		
	
		 if($this->row->action_id==29)
		{ ?>
		<?php      
		//Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc; $this->get_album_id=$this->model->get_album($this->row->typeid);  ?>
		<a href="<?php echo $this->docroot; ?>groups/zoom/?photo_id=<?php echo $this->row->type_id; ?>&gid=<?php echo $this->get_album_id['mysql_fetch_row']->album_id; ?>">
		<?php echo htmlspecialchars_decode($this->row->desc); ?></a><?php
		}
		else if($this->row->action_id==32 || $this->row->action_id==33)
		{ ?>
		<?php     
		// Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc; $this->get_forum_id=$this->model->get_forum($this->row->typeid);  ?>
		<a href="<?php echo $this->docroot; ?>groups/discussion/?id=<?php echo $this->row->type_id; ?>&gid=<?php echo $this->get_forum_id['mysql_fetch_row']->group_id; ?>">
		<?php echo htmlspecialchars_decode($this->row->desc); ?></a><?php
		}
		else if($this->row->action_id==31)
		{ ?>
		<?php     
		// Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc; $this->get_album_id=$this->model->get_album($this->row->typeid);  ?>
		<a href="<?php echo $this->docroot; ?>groups/zoom/?photo_id=<?php echo $this->row->type_id; ?>&gid=<?php echo $this->get_album_id['mysql_fetch_row']->album_id; ?>">
		<?php echo htmlspecialchars_decode($this->row->desc); ?></a><?php
		}
		else 
		{ ?>
		<?php      
		//Nauth::get_Name($this->row->u_id);
		Nauth::print_name($this->row->u_id, $this->row->name);
		echo " ".$this->row->action_desc; ?>
		<a href="<?php echo $this->docroot; ?>groups/view/?gid=<?php echo $this->row->type_id; ?>&action=wall">
		<?php echo htmlspecialchars_decode($this->row->desc); ?></a><?php
		}
 ?>


		
