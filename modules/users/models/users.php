<?php
class Users_Model extends Model
{
	public function __construct()
	{

		include Kohana::find_file('../application/config','database',TRUE,'php'); 
		$mes=Kohana::config('users_config.session_message');
		$this->update=new update_model_Model();
		$this->invalid_photo=$mes["invalid_photo"];
		$this->config = $config['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->photo_change=$mes["photo_change"];
		$this->usertable = $config['usertable'];
		$this->uidfield = $config['uidfield'];
		$this->unamefield = $config['unamefield'];
		$this->upass = $config['upass'];
		$this->uemail = $config['uemail'];
		$this->ustatus = $config['ustatus'];
		$this->utype = $config['utype'];
		$this->tempath = $config['tempath'];
		$this->session=Session::instance();
		$this->docroot =$this->session->get('DOCROOT');

	   parent::__construct();
	   $db=new Database();
	   $this->session=Session::instance();
	}
	
	//users Login
	public function login($username,$password,$url = '')
	{
		$password1 = md5($password);
		$query = "select * from ".$this->usertable." where ".$this->uemail." = '$username' and ".$this->upass." = '$password1'";
		$result = $this->db->query($query);
		if($result->count()>0){
			$ustatus = $this->ustatus;
			$id = $this->uidfield;
			$user_type = $this->utype;
			$email = $this->uemail;
			$name = $this->unamefield;
		
			$USERSTATUS = $result['mysql_fetch_array']->$ustatus;
			if($USERSTATUS == 1){
				$USERID = $result['mysql_fetch_array']->$id;
				$USERTYPE = $result['mysql_fetch_array']->$user_type;
				$EMAIL = $result['mysql_fetch_array']->$email;
				$USERNAME = $result['mysql_fetch_array']->$name;
				
				$MODPER = $result['mysql_fetch_array']->module_id;
				
				//SESSION
					$_SESSION["userid"] = $USERID;
					$_SESSION["username"] = $USERNAME;
					$_SESSION["usertype"] = $USERTYPE;
					$_SESSION["email"] = $EMAIL;
					$_SESSION['user_status'] = $USERSTATUS;
					$_SESSION['u_mod'] = explode(",",$MODPER);
				//
				return 1;
			}
			else{
				return -1;
			}
		}
		else{
			return 0;
		}
	}

	public function logout()
	{
		$this->session->destroy();
	}
	
	//Get user's details
	public function getusers()
	{
		$query = "select * from ".$this->usertable." left join ".$this->prefix."users_profile on id=user_id  where user_type = '1'";
		$result = $this->db->query($query);
		return $result;
	}
	//forgot password
	public function forgot_password($email)
	{ 			 
	                $email = html::specialchars($email);
                        $queryString = "select count(*) as total_count from ".$this->usertable." where email='$email'";
                       
			$query=$this->db->query($queryString);
				//checking the user exists
		                if(count($query)>0)
				{
				        foreach($query as $row)
				        {
				        $total_count=$row->total_count;
				        } 
				}
				//generating random password
				$pass=text::random($type = 'alnum', $length = 10);
				$password=md5($pass); 

				if($query['mysql_fetch_array']->total_count>0)
				{ 
                                  //update in password field
                                $this->db->query("update ".$this->usertable." set password='$password' where email='$email'");
	                        $result=$this->db->query("select id from ".$this->usertable." where email='$email'");
                                $usrid=$result["mysql_fetch_array"]->id;
                                $type="forget password";
                                $description=$pass; 
	                        Nauth::send_mail_id($usrid,'',$type,$description); 

							  //email to user
                                  $this->session->set("Msg","Password has been sent to your Email account");

				} else {
                                $this->session->set("Msg","Your Email not exist with Us.Please signup");
                                url::redirect($this->docroot."users/forgot_password");				
				}
	}
	
	//change the profile photo
	
	public function change_photo($userid,$photo_name)
	{
	
		 $photos_size = Kohana::config('application.photos');
	 	 $thumb_size = Kohana::config('application.thumb');
		 $_FILES = Validation::factory($_FILES)
			->add_rules('user_image', 'upload::valid', 'upload::type[gif,jpg,png,jpeg]', 'upload::size[1M]');
		
		if ($_FILES->validate()){
			$filename = upload::save('user_image'); 
			$file_path=end(explode('.',$filename)); 
			$userDoc=$userDoc=DOCROOT."upload/$photo_name";
			$userDoc=str_replace("'","",$userDoc);
			if($filename){
				list($width, $height) = getimagesize($filename);
				$widthadjust  = $photos_size["profile"]["width"];
				$heightadjust  = $photos_size["profile"]["height"];
				
				if($width > $widthadjust ){
					$heightadjust = $height * ( $widthadjust / $width);
				}
				else{
					$widthadjust = $width;
				}
				
				if($heightadjust < $height ){
					Image::factory($filename)
						->resize($widthadjust,$heightadjust, Image::NONE)->crop($widthadjust, $photos_size["profile"]["height"], 'top')
						->save(DOCROOT.'public/user_photo/'.$userid.'.jpg');
				}
				else{
					Image::factory($filename)
						->resize($widthadjust,$heightadjust, Image::WIDTH)
						->save(DOCROOT.'public/user_photo/'.$userid.'.jpg');
				}
				
				$widthadjust  = $thumb_size["profile"]["width"];
				$heightadjust  = $thumb_size["profile"]["width"];
				if( $width > $height){
					$widthadjust  = $width * $widthadjust / $height;
				}
				else{
					 $heightadjust  = $height * $heightadjust / $width;
				}
				Image::factory($filename)
					->resize($widthadjust,$heightadjust, Image::NONE)->crop($thumb_size["profile"]["width"], $thumb_size["profile"]["width"], 'top')
					->save(DOCROOT.'public/user_photo/50/'.$userid.'.jpg');
				unlink($filename);	
				$this->db->query("update ".$this->prefix."users_profile set user_photo='$userid.jpg' where user_id='$userid'");
				$this->update->updates_insert($userid,$userid,37,'changed profile photo');
				Nauth::setMessage(1,$this->photo_change);	 
				
				
			}
		}
		else{  
			Nauth::setMessage(1,$this->invalid_photo);
			url::redirect($this->docroot.'/users/changephoto');
		}
	}
	//friends referral
	public function friends_referral($to,$userid,$message)
	{
		$message=html::specialchars($message);
		$this->db->query("insert into ".$this->prefix."freinds_referral(email_id,userid,cdate,message,status)values('$to','$userid',now(),'$message',0)");
	}

	//Get Country
	public function getcountry()
	{
		$query = "select * from ".$this->prefix."country";
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
	
	public function adduser($f_name,$email,$password)
	{ 
		
		if($f_name !='' && $email !='' && $password !='')
		{
			$pass = md5($password);
			$insert_query = "insert into ".$this->usertable."(name,email,password,user_type,user_status) values('$f_name','$email','$pass','1','1')";
			$insert_exec = $this->db->query($insert_query);
			//insert profile
			$insert_query_1 = "insert into ".$this->prefix."users_profile(user_id) values('".mysql_insert_id()."')";
			$insert_exec_1 = $this->db->query($insert_query_1);
			$to = $email;
			$subject = 'Registration Details';
			$message = '
			<p><strong>Dear&nbsp;&nbsp;'.$f_name.'</strong></p>
			<p>Your Registration completed successfully. Your registration details are below</p>
			<p><strong>Username&nbsp;:</strong>'.$email.'</p>
			<p><strong>Password&nbsp;:</strong>'.$password.'</p>
			<p>Regards</p>
			<p>Ndot Team.</p>';


   			$headers  = 'MIME-Version: 1.0' . "\r\n";
		        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  		        $headers .= 'From: admin@ndot.in'. "\r\n";
   			
			@mail($to,$subject,$message,$headers);
			return $insert_exec;
		}
		else
		{
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
			//$select = "select * from users left join country on users.country = country.id where users.id = '$userid'";
			//$result = $this->db->query($select);
			//return $result;
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

	public function search($search = '' , $userid = '')
	{
		$query = "select ".$this->uidfield." as id,".$this->unamefield." as name,last_name,user_photo,".$this->prefix."country.cdesc as cdesc,city,gender,street,".$this->usertable.".".$this->uidfield." as uid,(select friend_id from ".$this->prefix."user_friend_list where user_id=".$this->usertable.".".$this->uidfield." and friend_id='$userid' and status=1) as fid,(select friend_id from ".$this->prefix."user_friend_list where user_id='$userid' and friend_id=".$this->usertable.".".$this->uidfield." and status=1) as zid from ".$this->usertable." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."country on ".$this->prefix."users_profile.country = ".$this->prefix."country.cid where ".$this->utype." = '1' and ".$this->usertable.".".$this->uidfield." != '$userid' and ".$this->usertable.".".$this->ustatus."=1 ";
		
		if($search)
		{
			$query .= "and (MATCH (name,cdesc,last_name,city) AGAINST ('".$search."' IN BOOLEAN MODE))";
		}
		
		$result = $this->db->query($query);
		return $result;
	}
	//delete users
	public function deleteuser($userid)
	{
		$delete = "delete from ".$this->usertable." where ".$this->usertable.".".$this->uidfield." = '$userid'";
		$result = $this->db->query($delete);
		return $result;
	}
	//get the mail templates
	public function get_mail_template($title)
	{
	        
		$result=$this->db->query("select * from ".$this->prefix."mail_template where mail_temp_title='$title'");
		return $result;
	}
	//get the mail address for a user
	public function get_mail_addr($id = "")
	{ 
		
			$result = $this->db->query("select ".$this->uemail.",".$this->unamefield." from ".$this->usertable." where ".$this->uidfield." = '$id'");
			return $result;
	} 
	//get the mail address for a user
	public function get_admin_mail_addr()
	{ 			
$result=$this->db->query("select ".$this->uemail." from ".$this->usertable." where ".$this->utype." = '-1'");		
		
			return $result;
		
	}  
	//get the  user name
	public function get_name($id = "")
	{ 
		$result=$this->db->query("select name from ".$this->usertable." where ".$this->uidfield." = '$id'");	
		return $result;
	}
       /* to get name and image (Nauth) */
	        public function nameimage($user_id)
	        { 
		        $result=$this->db->query("SELECT ".$this->uidfield.",name FROM ".$this->usertable."  WHERE ".$this->uidfield." = $user_id");
		        return $result;
	        }
	        
//REDIRECT URL
	public function redirect($type = '')
	{
		$url = $this->db->select("url")
						->from("url")
						->where(array("url_type" => $type))
						->get();
		if($url->count() > 0){
			$redirect_url = $url->current()->url; 
		}
		else{
			$redirect_url = $this->docroot;
		}
		return $redirect_url;
	}
	
	public function block($username,$email,$message)
	{
	        $status = valid::email($email);
	        
	        if($status == 1)
	        {
	                $username = html::specialchars($username);
	                $email = html::specialchars($email);
	                $message = html::specialchars($message);
	                $query = "insert into ".$this->prefix."block_users(username,email,message) values('$username','$email','$message')";
	                $result = $this->db->query($query);
	                return 1;
	        }
	        else
	        {
	                return -1;
	        }
	}
}
?>
