<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_Model extends Model
 {

         public function __construct()
	 {
		
                parent::__construct();
		$db=new Database();
		$this->session = Session::instance();
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
                
                /*User response messages*/
	         $mes=Kohana::config('users_config.session_message');
                 $this->add_role=$mes["add_role"];
                 $this->role_exist=$mes["role_exist"];
                         
		
	}
	//get the modules permission
	public function get_module_permission($module_id='')
	{
	        $result = $this->db->query("select * from ".$this->prefix."members_permission left join ".$this->prefix."members_role on ".$this->prefix."members_permission.members_role=".$this->prefix."members_role.id where module_id='$module_id'");
	        return $result;
	}
	
	//set the empty values to all add permission
	public function set_add_empty($val='')
	{
	        //echo "update ".$this->prefix."members_permission set action_".$val."='0' where members_role!='1'"; exit; 
	        $this->db->query("update ".$this->prefix."members_permission set action_".$val."='0' where members_role!='1'");
	}
	
	//getting the moderator permission
	public function get_moderator_permission()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_permission where id=4");
	        return $result;
	}
	
	//get the modules list
	public function get_modules()
	{
	        $result=$this->db->query("select * from ".$this->prefix."modules");
	        return $result;
	}
	
	//make moderator
	public function make_moderator($user_type,$id)
	{
	        $this->db->query("update ".$this->usertable." set user_type='$user_type' where id='$id' ");
	
	}
	
	//set the permission
	public function set_add_permission($value)
	{
	        $this->db->query("update ".$this->prefix."members_permission set action_add='1' where members_role='$value'");
	}
	
	//get only the add permission 
	public function get_add_permission()
	{
	        $result=$this->db->query("select action_add from ".$this->prefix."members_permission");
	        return $result;
	}
	
	//set the permission
	public function set_edit_permission($value)
	{
	        $this->db->query("update ".$this->prefix."members_permission set action_edit='1' where members_role='$value'");
	}
	
	//set the permission
	public function set_delete_permission($value)
	{
	        $this->db->query("update ".$this->prefix."members_permission set action_delete='1' where members_role='$value'");
	}
	
	//set the permission
	public function set_block_permission($value)
	{
	        $this->db->query("update ".$this->prefix."members_permission set action_block='1' where members_role='$value'");
	}
	
	//get the permission lists
	public function get_permission()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_permission left join ".$this->prefix."members_role on ".$this->prefix."members_permission.members_role=".$this->prefix."members_role.id ");
	        return $result;
	}
	//get the role lists
	public function get_roles()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_role ");
	        return $result;
	}
	
	//delete category
	public function delete_role($id)
	{
	        $this->db->query("delete from ".$this->prefix."members_permission where members_role='$id'");
	        $result=$this->db->query("delete from ".$this->prefix."members_role where id='$id'");
	        return $result;
	}
	
	//update category
	public function update_role($id,$name='')
	{
	
	        $name=html::specialchars($name);
	        $result=$this->db->query("update ".$this->prefix."members_role set members_type='$name' where id='$id'");
	}
	
	//insert category
	public function insert_role($name,$module_name)
	{
	        $name=html::specialchars($name);
	        $result=$this->db->query("select count(*) as total_count from ".$this->prefix."members_role where members_type='$name'");
		        if($result["mysql_fetch_array"]->total_count==0)
		        {
				        if($name!='')
				        {
				                $result = $this->db->query("insert into ".$this->prefix."members_role(members_type)values('$name')");
				                $last_id = $result->insert_id();
				                
				                //insert into permissions
				                $this->db->query("insert into ".$this->prefix."members_permission(members_role,action_add,action_edit,action_delete,action_block,status,module_id)values('$last_id','0','0','0','0','1','$module_name')");
				                
				                Nauth::setMessage(1,$this->add_role);
				        }
		        }
		        else
		        {
			        Nauth::setMessage(-1,$this->role_exist);
		        }
	}
	
	//update user
	public function update_user($userid,$first_name,$last_name,$email,$street,$city,$country,$postcode,$phone,$mobile,$dob,$gender)
	{
	        $this->db->query("update ".$this->usertable." set name='$first_name',email='$email' where id='$userid'");
	        $this->db->query("update ".$this->prefix."users_profile set last_name='$last_name',country='$country',city='$city',street='$street',post_code='$postcode',city='$city',phone='$phone',mobile='$mobile',dob='$dob',gender='$gender' where user_id='$userid'");
	}

	//get country
	public function get_country()
	{
	        $result=$this->db->query("select * from ".$this->prefix."country");
	        return $result;
	}
	//get user email
	public function get_toid($toid)
	{
	        $result=$this->db->query("select * from ".$this->usertable." where id='$toid'");
	        return $result;
	}

	//get the user list
	public function getuser($offset='',$noofpage='')
	{ 
	           $result=$this->db->query("select *,".$this->usertable.".".$this->uidfield." as id,".$this->usertable.".".$this->unamefield." as name,".$this->usertable.".".$this->uemail." as email  from ".$this->usertable." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id 
			   order by ".$this->usertable.".".$this->uidfield." DESC limit $offset,$noofpage");
	        return $result;
	}
	
	//count the user list
	public function getuser_count()
	{
	        $result=$this->db->query("select * from ".$this->usertable." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id ");
	        return count($result);
	}
	
	//get the user list
	public function search_user($key='',$offset='',$noofpage='')
	{
	        $result=$this->db->query("select *,".$this->usertable.".".$this->uemail." as email,".$this->usertable.".".$this->unamefield." as name, ".$this->usertable.".".$this->uidfield." as id from ".$this->usertable." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id   where ".$this->usertable.".".$this->unamefield." like '%".$key."%' or last_name like '%".$key."%' or ".$this->usertable.".".$this->uemail." like '%".$key."%' limit $offset,$noofpage");
	        return $result;
	}
	
	//count the user list
	public function search_user_count($key)
	{
     $result=$this->db->query("select * from ".$this->usertable." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id where ".$this->usertable.".".$this->unamefield." like '%".$key."%' or last_name like '%".$key."%' or ".$this->usertable.".".$this->uemail." like '%".$key."%' ");
	        return count($result);
	}
	
	//set user access
	public function set_user_access($status,$id)
	{
	        $result=$this->db->query("update ".$this->usertable." set user_status='$status' where id='$id'");
	        return $result;
	}
	//delete user
	public function delete_user($id)
	{
	        $this->db->query("delete from ".$this->usertable." where id='$id' ");
	        $this->db->query("delete from ".$this->prefix."users_profile where user_id='$id' ");
	}

	 //update general settings
	 public function update_general_setting($title='',$meta_keywords='',$meta_desc='',$logo='')
	 {
	         $title=html::specialchars($title);
	         $meta_keywords=html::specialchars($meta_keywords);
	         $result=$this->db->query("update ".$this->prefix."general_settings set title='$title', meta_keywords='$meta_keywords', meta_desc='$meta_desc', logo_path='$logo' where id=1");
	            //save the logo
		        if($logo!='')
		        {
		        
	            	upload::save('logo');

		        }
		
	 }
	 
	 //general settings
	 public function general_settings()
	 {
	         $result=$this->db->query("select * from ".$this->prefix."general_settings limit 0,1");
	         return $result;
	 }
	 //modules settings
	 public function module_settings()
	 {
	         $result=$this->db->query("select * from ".$this->prefix."menus");
	         return $result;
	 }
	 //send the email to all
	 public function email_all()
	 {
	        $result=$this->db->query("select ".$this->uidfield." as user_id,".$this->unamefield." as name, ". $this->uemail." as email from ".$this->usertable." where user_type!=-1");
	        return $result;
	
	 }
         //set the theme
	 public function set_theme($theme='')
	 {
	         $result=$this->db->query("update ".$this->prefix."general_settings set theme='$theme' where id='1'");
	         return $result;
	 }
	 //modules activation
	 public function module_activate($id,$status)
	 {
	 		$result=$this->db->query("update ".$this->prefix."menus set status='$status' where id='$id' ");
	        $this->session->delete('enable_module');
	        return $result;
	 }
	 //get modules to write in config
	public function get_module()
        {
        $result=$this->db->query("select * from ".$this->prefix."menus ");
        return $result;
        }
		
	//GET SITE ANALYTICS DETAILS
	
	public function get_analytics()
	{
		$analytics["users"] = $this->db->count_records("users");
		$modules = $this->db->select("name")
							->from("menus")
							->where(array("system_module" => 0 , "status" => 0))
							->get();
		foreach($modules as $row){

			if($row->name == "answers"){
				$analytics[$row->name] = $this->db->count_records("answer");
			}
			else{
				$analytics[$row->name] = $this->db->count_records($row->name);
			}
		}

		return $analytics;
	}
	
	/** UPDATE USERS PERMISSION (USER, MODERATOR, ADMIN) **/
	
	public function update_user_status($uid,$user, $moderator, $admin)
	{
		if($user){
			$type = $user;
		}
		elseif($moderator){
			$type = $moderator;
		}
		else{
			$type = $admin;
		}
		$this->db->update("users", array("user_type" => $type),array("id" => $uid));
		return;
	}
	
	/** GET ENABLED MODULE**/
	
	public function get_enable_module()
	{
		$module = $this->db->select("id","name")->from("menus")
								->where(array("system_module" => 0 , "status" => 0))
								->get();
		return $module;	
							
	}
	public function get_user_role()
	{
	        $result = $this->db->query("select *,".$this->prefix."members_role.id from ".$this->prefix."members_role left join ".$this->prefix."members_permission on ".$this->prefix."members_role.id = ".$this->prefix."members_permission.members_role where role_type !=-1 ");
	        return $result; 
	}
	
	/** CHANGE MODULE PERMISSION **/
	
	public function change_module_permission($modules,$user_id)
	{
		$this->db->update("users",array("module_id" => $modules,"user_type" => -2),array("id" => $user_id));
		return;
	}
	
	// to find weather module already installed
	public function module_find($mod_name)
	{
	$result=$this->db->query("select * from ".$this->prefix."menus where name='$mod_name'");
	if($result->count() > 0)
	{
	        return -1;
	        
	}
	else
	{
	         return 1;
	}
        }
        public function insert_module($mod_name)
        {
        $link="/".$mod_name;
        $result=$this->db->query("insert into ".$this->prefix."menus(name,link,status,description,system_module)values('$mod_name','$link','0','','0')");
                return $result;
        }

	public function module_login($id,$login)
	{
		$result = $this->db->update("menus",array("login" => $login ),array("id" => $id));
		return $result->count();
	}
}
