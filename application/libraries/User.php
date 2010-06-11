<?php defined('SYSPATH') or die('No direct script access.');

class User_Core extends Entity{
	public $username;
	public $userid;
	public $email;
	public $userObject;
	    
	public function __construct($Object)
	{
		$this->userid = $Object;
        parent::__construct('');
		return $this;		
	}
	public function User_Add(){
		
	}	
	public function User_Delete(){
		
	}	
	public function loadInterests(){
		$queryString = " select * from profile_interests left join interests on interest_map_id = interest_id  where user_id = ".$this->userid;
		$resultSet = $this->db->query($queryString);
		return $resultSet;
	}
	public function addInterest( $interest ){
		$queryString = " select interest_id from interests  where interest like '$interest' ";
		$resultSet = $this->db->query($queryString);
		
		if(count($resultSet) > 0 ){
			$interestId = $resultSet["mysql_fetch_object"]->interest_id;
		}else{
			$queryString = " insert into interests (interest) values ('$interest')";
			$insertSet = $this->db->query($queryString);
			$interestId = $insertSet->insert_id();
		}

		$queryString = " insert into profile_interests (user_id , interest_map_id ) values ('$this->userid','".$interestId."' )";
		$this->db->query($queryString);
		
	}
	public function removeInterest( $interestId){
		$queryString = " delete from profile_interests where interest_map_id = $interestId and user_id = $this->userid ";
		$this->db->query($queryString);
	}
}//End of object

/*
		$this->db->select("*")->from('users');
		if($Object){
		$this->db->where("id = '".$Object."'");
		}
		$this->userObject = $this->db->get();
		if($this->userObject->count()>0)
		{
			$this->username = $this->userObject["mysql_fetch_object"]->name;
			$this->email = $this->userObject["mysql_fetch_object"]->email;
			$this->userid = $this->userObject["mysql_fetch_object"]->id;
		}
		$this->Objecttype = 2;

*/