<?php	
				/* For Question */
				if($this->row->action_id==8)
				{?>
<?php     		
                                        //Nauth::get_Name($this->row->u_id);
                                        Nauth::print_name($this->row->u_id, $this->row->name);
                                        // display description
                                        echo " ".$this->row->action_desc; ?>

<a href="<?php echo $this->docroot; ?>answers/view/<?php echo url::title($this->row->desc); ?>_<?php echo $this->row->type_id; ?>"> <?php echo $this->row->desc; ?></a>
<?php 
				}
				else    /* For Answer */
				{?>
<?php 	
                                        Nauth::print_name($this->row->u_id, $this->row->name);	
                                        	//Nauth::get_Name($this->row->u_id);
                                        // display description
                                        echo " ".$this->row->action_desc; 
                                         $this->question_title=$this->model->get_question_title($this->row->type_id);
                                        ?>
                        <a href="<?php echo $this->docroot; ?>answers/view/<?php echo url::title($this->question_title['mysql_fetch_object']->question);?>_<?php echo $this->row->type_id;?>" title="<?php echo $this->question_title['mysql_fetch_object']->question;?>">
                        <?php
                                        echo $this->question_title["mysql_fetch_object"]->question; ?>
</a>
<?php 
				}?>
