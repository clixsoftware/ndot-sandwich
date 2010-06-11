<?php //Nauth::get_Name($this->row->type_id);
Nauth::print_name($this->row->u_id, $this->row->name);  ?>  Wrote <a href="<?php echo $this->docroot; ?>profile/view/?uid=<?php echo $this->row->u_id; ?>&action=wall" ><?php echo ucfirst($this->row->desc);?></a> On 
<?php Nauth::get_Name($this->row->typeid);
//Nauth::print_name($this->row->u_id, $this->row->name);  ?>'s Wall
				
