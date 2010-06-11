<?php
class Register_Model extends Model
{
	public function __construct()
	{
		include Kohana::find_file('/config/','database',TRUE,'php');
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
	
	   parent::__construct();
	   $db = new Database();
	   $this->controller = new Confirm_Controller();
	   $this->session = Session::instance();
	   
	}

	//Get user's details
	public function getusers()
	{
		$query = "select * from ".$this->usertable." left join ".$this->prefix."users_profile on id=user_id  where user_type = '1'";
		$result = $this->db->query($query);
		return $result;
	}
 
	//getting existing user
	
	public function existuser($email)
	{
		$query = "select email from ".$this->usertable." where email = '$email'";
		$result = $this->db->query($query);
		return $result;
	}
	
	//Add new Users
	
	public function adduser($f_name,$l_name,$email,$password,$city,$gender,$dob,$docroot = "")
	{
		if($f_name !='' && $l_name !='' && $email !='' && $password !='' && $city != '' && $dob != '' && $gender != '')
		{
		        $f_name = html::specialchars($f_name);
		        $l_name = html::specialchars($l_name);
		        $email = html::specialchars($email);
		        $password = html::specialchars($password);
		        $city = html::specialchars($city);
		        $status = valid::email($email);
		        if($status == 1)
		        {

		        //$this->db->query("CREATE TRIGGER profileupdate AFTER INSERT ON ".$this->usertable." FOR EACH ROW BEGIN INSERT INTO ".$this->prefix."users_profile SET user_id = NEW.".$this->uidfield."; END");
				
				//$this->db->query("CREATE TRIGGER profilesetting AFTER INSERT ON ".$this->prefix."users_profile FOR EACH ROW BEGIN INSERT INTO ".$this->prefix."profile_settings SET user_id = NEW.user_id; END");
				
				//$this->db->query("CREATE TRIGGER modulesetting AFTER INSERT ON ".$this->prefix."profile_settings FOR EACH ROW BEGIN INSERT INTO ".$this->prefix."module_settings SET user_id = NEW.user_id; END");
				
  					$pass = md5($password);
			        $insert_query = "insert into ".$this->usertable."(name,email,password,user_type,user_status) values('$f_name','$email','$pass','1','1')";
			        $insert_exec = $this->db->query($insert_query);
			        $last_id = $insert_exec->insert_id();
					
					$this->db->insert("users_profile",array("user_id" => $last_id ,"city" => $city, "gender" => $gender, "last_name" => $l_name, "dob" => $dob ));
				
					$this->db->insert("profile_settings",array("user_id" => $last_id));
				
					$this->db->insert("module_settings",array("user_id" => $last_id));
					
					$admin = $this->db->query("select id from ".$this->usertable." where user_type = '-1'");
					if($admin->count() > 0)
					{
						$admin_id = $admin['mysql_fetch_array']->id;
						$usrid = $last_id;
						$type = "Registration";
						$description = ''; 
						//$reg_status = Nauth::send_mail_id($usrid, $admin_id, $type, $description, 1); 
						$reg_status = 1;
						if($reg_status == 1){
							$_SESSION["userid"] = $usrid;
							$_SESSION["username"] = $f_name;
							$_SESSION["usertype"] = 1;
							$_SESSION["email"] = $email;
							$_SESSION['user_status'] = 1;
							$_SESSION['u_mod'] = array();
							$this->session->set('Msg','Registration Completed.');
							url::redirect($docroot."profile/updateprofile");
						}
					}
		        }
		        else{
		                return -1;
		        }
		}
		else{
			$this->session->set('Msg','Some Fields are Missing');
		}
	}
	
	
	//getting users for edit details
	public function editusers($user_id)
	{
		$select = "select * from ".$this->usertable." where ".$this->usertable.".".$this->uidfield." = '$user_id'";
		$result = $this->db->query($select);
		return $result;
	}
	
	
	//updating user details
	public function updateuser($f_name,$l_name,$email,$dob,$gender,$street,$city,$country,$code,$phone,$mobile,$news,$user_status,$user_id)
	{
		$update = "UPDATE ".$this->usertable." SET name = '$f_name',last_name = '$l_name',email = '$email',street = '$street',city = '$city',country = '$country',post_code = '$code',phone = '$phone',mobile = '$mobile',news_letter = '$news',dob = '$dob',user_status = '$user_status' , gender = '$gender' WHERE user_id = '$user_id'";
		$result = $this->db->query($update);
		return $result;
	}
	
	//users profile
	
	public function profile($userid)
	{
		if($userid)
		{
			$select = "select * from ".$this->usertable." left join ".$this->prefix."country on ".$this->usertable.".country = ".$this->prefix."country.id where ".$this->usertable.".".$this->uidfield." = '$userid'";
			$result = $this->db->query($select);
			return $result;
		}
		else
		{
			$this->session->set('Msg','Invalid Operation.');
			return -1;
		}
	}
	
	//user settings for changing password
	
	public function settings($userid,$old_pass,$new_pass)
	{
		if($userid)
		{
			$pass = md5($old_pass);
			$new = md5($new_pass);
			$select = "select * from ".$this->usertable." where password = '$pass' and ".$this->usertable.".".$this->uidfield." = '$userid'";
			$result = $this->db->query($select);
			if($result->count() > 0)
			{
				$update = "update ".$this->usertable." set password = '$new' where ".$this->usertable.".".$this->uidfield." = '$userid'";
				$update_result = $this->db->query($update);
				return 1;
			}
			else
			{
				return -2;
			}
		}
		else
		{
			return -1;
		}
	}
	//delete users
	public function deleteuser($userid)
	{
		$delete = "delete from ".$this->usertable." where ".$this->usertable.".".$this->uidfield." = '$userid'";
		$result = $this->db->query($delete);
		return $result;
	}
 
	 
}
?>
