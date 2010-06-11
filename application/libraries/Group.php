<?php defined('SYSPATH') or die('No direct script access.');

class Group_Core extends Entity{
	public $group_id;
	public $group_name;
	public $groupObject;
	     
	public function __construct($Object)
	{
        	parent::__construct('');
		$db = new Database;
		$db->select("*")->from('groups');
		if($Object){
		$db->where("id = '".$Object."'");
		}
		$this->groupObject = $db->get();
		if($this->groupObject->count()>0)
		{
			$this->group_id = $this->userObject["mysql_fetch_object"]->id;
			$this->group_name = $this->userObject["mysql_fetch_object"]->title;
			$this->group_desc = $this->userObject["mysql_fetch_object"]->description;
			$this->group_member_count = $this->userObject["mysql_fetch_object"]->cd;
		}
		$this->Objecttype = 6;
		return $this;		
	}
	
	public function Object_add($obj_name,$obj_type,$obj_owner,$obj_master,$obj_user_det_id)
	{ 
		//parent::Object_add();
		$this->db = new Database;
		$insertObject = $this->db->query("insert into objects (object_type,object_owner,object_master,object_created) values ('".$this->Objecttype."','".$obj_owner."','".$obj_master."',now()) ");
		return $insertObject->insert_id();
	}
}//End of object
