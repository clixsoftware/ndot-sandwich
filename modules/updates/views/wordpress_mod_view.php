<div class="span-13 f1">

                <div class="span-2  f1 text-align">
                <?php	
                // display user photo 
                //Nauth::getNameImage($this->row->u_id);
                Nauth::getPhoto($this->row->u_id, $this->row->name);
                

                ?>
                </div>

                <div class="span-10 f1">   
                <?php 
                //Nauth::get_Name($this->row->u_id); 
                Nauth::print_name($this->row->u_id, $this->row->name);  		
                // display description
                echo " ".$this->row->action_desc; ?>
                <a href="<?php echo $this->docroot; ?>events/showfull_events?eventid=<?php echo $this->row->type_id; ?>" title="<?php echo $this->row->desc; ?>" class="less_link">
                <?php echo $this->row->desc; ?>
                </a> 

                </div>

</div>


			