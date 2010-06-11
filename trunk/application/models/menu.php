<?php defined('SYSPATH') or die('No direct script access.');
class Menu_Model extends Model
 {
     public function __construct()
	{
		
        parent::__construct();
		$this->db=new Database();
		$session=Session::instance();
		$USERID = $session->get('userid');
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$this->uidfield = $config['uidfield'];
		$this->unamefield = $config['unamefield'];
		$this->upass = $config['upass'];
		$this->uemail = $config['uemail'];
		$this->ustatus = $config['ustatus'];
		$this->utype = $config['utype'];
		$this->tempath = $config['tempath'];

   }
   //get menu list
   public function menu()
   {
   $result=$this->db->query("select * from ".$this->prefix."menus where status=0");
   return $result;
   }
   //general info
   public function get_general_settings()
   {
   $result=$this->db->query("select * from ".$this->prefix."general_settings limit 0,1");
   return $result;
   }
   public function get_theme()
   {
   $result1=$this->db->query("select theme from ".$this->prefix."general_settings where id='1'");
  if($result1->count() > 0){
        $result1=$result1["mysql_fetch_array"]->theme;
  }
  else{
        $result1 = '';
  }
  	return $result1;
   }
   // get my pages created from CMS
    public function get_pages()
   {
   $result=$this->db->query("select cms_title from ".$this->prefix."cms ");
   return $result;
   } 
   //get modules to write in config
	public function get_module()
	{ 
	$result = $this->db->query("select * from ".$this->prefix."menus where system_module='0' and status='0' ");

	return $result;
	
	}

	public function get_no_login_module()
	{
		$result = $this->db->select("name")->from("menus")
							->where(array("system_module" => 0, "status" => 0, "login" => 1))
							->get();
		return $result;
	}

	//getting the moderator permission
	public function get_moderator_permission()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_permission where id=4");
	        return $result;
	}
	
	public function get_city()
	{
		$select = "select * from ".$this->prefix."city";
		$result = $this->db->query($select);
		return $result;
	}	
	
	
	/*public function get_notes($userid,$url)
	{
	        $query = "select * from ".$this->prefix."notes where userid = '$userid'  and note_url = '$url' limit 0,5";
	        $result = $this->db->query($query);
	        return $result;
	}*/
	
	
}
