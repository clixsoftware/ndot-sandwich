<p>
<?php  
//Nauth::get_Name($this->row->u_id);
Nauth::print_name($this->row->u_id, $this->row->name);
//description
 echo "Says ".htmlspecialchars_decode(ucfirst($this->row->desc))." in  update status message";  
?>
</p>
