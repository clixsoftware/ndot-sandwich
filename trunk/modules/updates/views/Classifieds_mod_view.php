			<?php	
				/* For Advertisement comment 	 */
				if($this->row->action_id==12)
				{
					// display user photo ?>
					<?php 	  
					// Nauth::get_Name($this->row->u_id); 		
					Nauth::print_name($this->row->u_id, $this->row->name);
					// display description
					echo " ".$this->row->action_desc; ?>
					<a href="<?php echo $this->docroot; ?>classifieds/view/<?php echo url::title($this->row->desc); ?>_<?php echo $this->row->type_id; ?>" title="<?php echo $this->row->desc; ?>">
					<?php echo $this->row->desc; ?>
                    </a> 
					<?php 
				}
				else    /* For post Advertisement */
				{
				?>
                 <?php 
						 //Nauth::get_Name($this->row->u_id);  		
						 Nauth::print_name($this->row->u_id, $this->row->name);
					// display description
					echo " ".$this->row->action_desc; ?> 
					<a href="<?php echo $this->docroot; ?>classifieds/view/<?php echo url::title($this->row->desc); ?>_cid=<?php echo $this->row->type_id; ?>" title="<?php echo $this->row->desc; ?>">
					<?php echo $this->row->desc; ?></a> 
					<?php 
				}
			?>

