<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_mailtemplates_Model extends Model
 {

     public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
		$this->session=Session::instance();
		include Kohana::find_file('../modules/admin/views/videos/','simple_html_dom',TRUE,'php');
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$this->unamefield = $config['unamefield'];
		$this->uidfield = $config['uidfield'];
	        $this->upass = $config['upass'];
	        $this->uemail = $config['uemail'];
	        $this->ustatus = $config['ustatus'];
	        $this->utype = $config['utype'];
		
	}
	
    	 //get all templates
	 public function get_alltemplates()
	 {
	 $result=$this->db->query("select * from ".$this->prefix."mail_template ");
	 return $result;
	 }
    	 //get templates for pagination
	 public function get_templates($offset='',$noofpage='')
	 {
	 $result=$this->db->query("select * from ".$this->prefix."mail_template  limit $offset,$noofpage");
	 return $result;
	 }
	//delete template
	public function delete_temp($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."mail_template where mail_temp_id='$id'");
	return $result;
	}
	//view template
	public function view_temp($id)
	{
	$result=$this->db->query("select * from ".$this->prefix."mail_template  where mail_temp_id='$id'");
	return $result;
	}
	//Edit Template
	public function edit_temp($id,$title,$code) 
	{ 
	$result=$this->db->query("update ".$this->prefix."mail_template set mail_temp_title='$title' , mail_temp_code='$code'  where mail_temp_id='$id'");
	return $result;
	}  
	//Create Template
	public function create_temp($title,$code) 
	{ 	
	$dupli_check=$this->db->query("select * from ".$this->prefix."mail_template where `mail_temp_title`='$title'");
	if(count($dupli_check))
	{
	$this->session->set("Msg","Template already Exists");
	url::redirect($this->docroot."admin_mailtemplates/");
	}
	else
	{
	$result=$this->db->query("INSERT INTO ".$this->prefix."mail_template (`mail_temp_title`, `mail_temp_code`) VALUES ( '$title', '$code')");
	return $result;
	}
	}

	
	 
 }
