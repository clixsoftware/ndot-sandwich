<?php defined('SYSPATH') or die('No direct script access.');

/**
 *  @Author : NDOT Tech Team
 *	@Purpose : To Create core Object & link with Other Objects
 *  
 **/
class Entity_Core extends ORM{
  
  	public $Object;
	public $Objectid;
	public $Objectname;
	public $Objecttype ;
	public $Objectowner;
	public $Objectmaster;
	public $userid;
	public $db;
	
	public function __construct($Object,$Objecttype='')
	{
		return $this;		
	}
	
	/**
	 * Create New Object
	 **/
	public function Object_add()
	{
		$this->db = new Database;
		$insertObject = $this->db->query("insert into objects (object_type,object_owner,object_master,object_created) values ('".$this->Objecttype."','".$this->Objectowner."','".$this->Objectmaster."',now()) ");
		$this->Objectid = $insertObject->insert_id();
		return $insertObject->insert_id();
	}
	public function Object_delete(){
		$queryString = " delete from objects where id = ".$this->Objectid;
		$this->db->query($queryString);
		return true;
	}
	public function Object_load(){
		$queryString = " select * from objects where id = ".$this->Objectid;
		$resultSet = $this->db->query($queryString);
		$this->Objectowner = $resultSet["mysql_fetch_object"]->object_owner;
		$this->Objecttype =  $resultSet["mysql_fetch_object"]->object_type;
		$this->userid =  $resultSet["mysql_fetch_object"]->object_owner;
	}
	/**
	 * Check whether userId is owner for this object.
	 **/
	public function checkOwnerShip($userId=-1){
		$queryString = " select * from objects where object_owner = $userId and id = ".$this->Objectid;
		$resultSet = $this->db->query($queryString);
		if(count($resultSet)> 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Find Object owner & details
	 **/
	public function findOwnerShip(){
		$queryString = " select users.id as user_id,name as user_name,object_created from objects left join users on users.id = object_owner where objects.id = ".$this->Objectid;
		$resultSet = $this->db->query($queryString);
		return $resultSet;
	}
	
	/**
	 * Find Object Status
	 **/
	public function isObject(){
		$queryString = " select * from objects where id = ".$this->Objectid;
		$resultSet = $this->db->query($queryString);
		if(count($resultSet)> 0){
			return true;
		}else{
			return false; // Invalid Object
		}
	}
	
	/**
	 *	Send Messages to Objects
	 **/
	public function sendMessage(){
	}
	
	/**
	 *	Object & User Tracking
	 **/
	public function trackActions(){
		
	}

	/**
	 *	Object public View
	 **/
	public function publicView(){
		
	}

	/**
	 *	Object public View
	 **/
	public function privateView(){
		
	}

}//End of object

		/*
		$thisdb->select("*")->from('objects');
		if($Object){
		$db->where("id = '".$Object."'");
		}elseif($Objecttype){
		$db->where("object_type = '".$Object."'");
		}
		$this->Object = $db->get();
		*/
