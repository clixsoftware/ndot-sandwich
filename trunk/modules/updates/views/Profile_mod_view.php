 		
			<!-- display description-->
				<?php  
				//Nauth::get_Name($this->row->u_id); 
				Nauth::print_name($this->row->u_id, $this->row->name);  
				
				$this->gender=$this->model->get_gender($this->row->u_id); 
				$this->gender=$this->gender["mysql_fetch_row"]->gender;
				if($this->gender=="male") { echo "updated his profile "; } else	{ echo "updated her profile "; }
				if($this->row->action_id=='37')
				{
				echo "photo"; ?><br/>
				<a href="<?php echo $this->docroot; ?>profile/view/?uid=<?php echo $this->row->u_id; ?>">
		<img src="<?php echo $this->docroot.'public/user_photo/'.$this->row->u_id.'.jpg' ; ?>" class="imgborder"  title = "<?php echo $this->row->name ?>"/> </a>
				<?php 
				}
				else
				{
				echo "information";				
				}
			?>
