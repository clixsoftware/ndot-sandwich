					<?php 	    //Nauth::get_Name($this->row->u_id);	
					Nauth::print_name($this->row->u_id, $this->row->name);	
					// display description
					echo " ".$this->row->action_desc; ?>
					<a href="<?php echo $this->docroot; ?>forum/view/<?php echo url::title($this->row->desc); ?>_<?php echo $this->row->type_id; ?>" class="less_link" title="<?php echo $this->row->desc; ?>">
					<?php echo $this->row->desc; ?>
                    </a>
			
