
<?php 
$this->model=new Update_model_Model();
$this->session=Session::instance();
$user_id=$this->session->get('userid');
 ?>
<script src="<?php echo $this->docroot;?>public/js/updcomment_ajax.js" type="text/javascript"></script>

<div class="span-15" >
<?php
if(count($this->template->all_updates))
{

	foreach($this->template->updates as $row)
	{ 
                $this->row=$row;
		$this->row->u_id=$row->u_id; 
		$this->row->name=$row->name;
		$this->row->action_desc=$row->action_desc;
		$this->row->action_id=$row->action_id;
		$this->row->typeid=$row->type_id;
		$this->row->fdate=$row->fdate; 
		$this->row->date=$row->date; 
		$this->row->desc=$row->description;
		$this->row->name=$row->name;  
		$this->row->photo_count=$row->photo_count; 
	        $this->user_id = $user_id;
                echo new View("upd_update_comments");
        }       
		/* For Pagination  */
		  echo $this->template->pagination;  
}
else
{
         echo UI::nodata_();
} ?>
 
 </div>




