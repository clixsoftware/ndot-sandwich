<?php defined('SYSPATH') OR die('No direct access allowed.'); 
class Users_Controller extends Website_Controller
{
	public $template = 'template/template';

		public function __construct()
		{ 
			parent::__construct();
			$this->model=new Users_Model();
			$this->profile=new Profile_Model();
			$this->from="admin@ndot.in";
			
			$mes = Kohana::config('users_config.session_message');
			$this->login = $mes["login"];
			$this->login_error = $mes["login_error"]; 
			$this->status_message = $mes["status_message"];
			$this->logout = $mes["logout"];
			$this->registration = $mes["registration"];
			$this->fields_missing = $mes["fields_missing"];
			$this->email_exist = $mes["email_exist"];
			$this->access_denied = $mes["access_denied"];
			$this->change_pass = $mes["change_pass"];
			$this->invalid_operation = $mes["invalid_operation"];
			$this->old_pass = $mes["old_pass"];
			$this->photo_change = $mes["photo_change"];
			$this->user_delete = $mes["user_delete"];
			$this->invitation_sent = $mes["invitation_sent"];
			$this->already_requested = $mes["already_requested"];
			$this->request = $mes["request"];
			$this->friend_added = $mes["friend_added"];
			$this->request_reject = $mes["request_reject"];
			$this->friend_removed = $mes["friend_removed"];
			$this->module = "users";	
			
		}
		 public function index($url = ''){      
		    $this->city = new Classifieds_Model();
			Nauth::is_login("/profile/updateprofile", '');
			$this->get_city = $this->city->get_city();
			$this->template->title = "Welcome to Ndot";
			$this->template->redirect=$url;
			$this->template->content = new View('home');
		 }
		 
		 //Admin Login
		 public function login()
		 {
		 	$this->template->title = "Welcome to Ndot";
		 	if($_POST){ 
				$url = $this->input->get('url');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$this->template->title="Admin Login";
				$login_status = $this->model->login($username,$password,$url);
				
				if($login_status == 1)
				{
					if($this->session->get("reffer_url")){
						url::redirect($this->docroot.$this->session->get("reffer_url"));
					}
					else{
						url::redirect($this->docroot."profile");
					}
				}
				elseif($login_status == -1){
					//Nauth::setMessage(-1,$this->login_error);
					
					$this->session->set('Emsg','Invalid Username / Password.');
					url::redirect($this->docroot);
				}
				elseif($login_status == 0){
					Nauth::setMessage(-1,'Invalid Username / Password.');
					//$this->session->set('Emsg','Invalid Username / Password.');
					url::redirect($this->docroot);
				}
				/** 
				  *MEDIAWIKI AUTHENDICATION
				
			    $key = md5($_SERVER['HTTP_HOST'].$_SERVER['REMOTE_ADDR']);
				echo '<div style="display:none">
					<form name="userlogin" method="post" action="/mediawiki/index.php?title=Special:UserLogin&action=submitlogin&type=login">
						<input type="text" name="wpName" value="nandhu29" />
						<input type="password" name="wpPassword" value="thambi1" />
						<input type="hidden" name="wpLoginToken" value="'.$key.'" />
						<input type="submit" name="Login" value="login"  />
					</form></div>
					<script type="text/javascript"> document.userlogin.submit(); </script>';
				exit;
				//
				*/
			}
			else{
				url::redirect($this->docroot);
			}
		 }
		 
		//Admin Logout
		
		public function logout()
		{ 
			$this->loginCheck = $this->model->logout();
			Nauth::setMessage(1,$this->logout); //call the librarary function to set the session type
			$user_model = new Users_Model();
			$root = $user_model->redirect($type = 2);
			if(empty($root))
			{
				url::redirect($this->docroot);
				die();
			}
			else{
				url::redirect($root);
			}
		} 

		//forgot password
		
		public function forgot_password()
                {       
			$this->captcha=new Captcha;
		        //get the email id from user to reset the password
		        if($_POST){
		            $email=$this->input->post("email_id"); 
			        if(Captcha::valid($this->input->post('captcha_code'))){
				        $this->model->forgot_password($email);
				        url::redirect($this->docroot);
			        }
			        else{
				        $this->session->set('Emsg','Check Security Code');
				        url::redirect($this->docroot."users/forgot_password");		
			        }
		        }
                        $this->template->title="Forgot Password";
			        $this->template->content=new View('forgot_password');
                }
                
                public function block()
                {
                        $this->template->title = 'Blocked User';
                        if($_POST)
                        {
                                $username = $this->input->post('username');
                                $email = $this->input->post('email');
                                $message = $this->input->post('message');
                                if($username != '' && $email != '' && $message != '')
                                {
                                        $u = trim(strlen($username));
                                        $m = trim(strlen($message));
                                        $user = ($u >= 6 && $u <=40);
                                        $mess = ($m >= 50 && $m <= 500);
                                        if($user && $mess)
                                        {
                                                $this->template->block = $this->model->block($username,$email,$message);
                                                if($this->template->block == 1)
                                                {
                                                        $this->session->set('Msg','Your Request has been sent. Please wait for few days to activate your Account.');
                                                        url::redirect($this->docroot);
                                                }
                                                elseif($this->template->block == -1)
                                                {
                                                        $this->session->set('Emsg','Invalid Email.');
                                                         url::redirect($this->docroot.'users/block');
                                                }
                                        }
                                        else
                                        {
                                                $this->session->set('Emsg','Username should be 6-40 <br />Message should be 50-500');
                                                url::redirect($this->docroot.'users/block');
                                        }
                                }
                                else
                                {
                                        $this->session->set('Emsg','All Fields are Mandatory.');
                                        $this->template->content = new View('block');
                                }
                        }
                        $this->template->content = new View('block');
                }
		 
		 public function manageusers()
		 {
		 	Nauth::is_login();
		 	if($this->userid != '' && $this->usertype == 0){
		 		$this->template->title = 'Manage Users';
				$this->template->get_users = $this->model->getusers();
		 		$this->template->content = new View('/users/manageusers');
			}
			else{
				url::redirect($this->docroot);
			}
		 }
		  //Getting edit iser Details
		 public function edituser()
		 {
		 	Nauth::is_login();
		 	if($this->userid != ''){
				$this->template->title = 'Edit User';
				$this->template->get_country = $this->model->getcountry();
				$user_id = $this->input->get('user_id');
				$this->template->get_users = $this->model->editusers($user_id);
				$this->template->content = new View('/users/edituser');
			}
			else{
				url::redirect($this->docroot);
			}
		 }
		//Add Users
		 public function adduser()
		 { 
		 	$this->template->title = 'Add user';
			$this->template->get_country = $this->model->getcountry();
			if($_POST){
				$adduser = $this->input->post('adduser');
				$f_name = $this->input->post('f_name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$userid = $this->input->post('userid');
				//adding new users
				if($adduser == 'adduser' && $this->userid == ''){
					$this->template->existuser = $this->model->existuser($email);
					if(count($this->template->existuser) == 0){
						if($f_name !='' && $email !='' && $password !=''){
							$this->template->adduser = $this->model->adduser($f_name,$email,$password);
							Nauth::setMessage(1,$this->registration);
							if($this->userid == ''){
								url::redirect($this->docroot);
							}
							else{
								url::redirect($this->docroot.'users/manageusers');
							}
						}
						else{
							Nauth::setMessage(1,$this->fields_missing);
							$this->template->content = new View('/users/adduser');
						}
					}
					else{
						Nauth::setMessage(1,$this->email_exist);
						$this->template->content = new View('/users/adduser');
					}
				}
			}
		 	$this->template->content = new View('/users/adduser');
		 }		 
		 
		 
		 //users profile
		 
		 public function profile()
		 {
		 	if($this->username != ''){
		 		$this->template->title = $this->username .' Profile';
			}
			else{
				$this->template->title = '';
			}
		 	if($this->userid != '' && $this->usertype == 1){
				$this->template->get_usersprofile = $this->model->profile($this->userid);
				$this->template->content = new View('/users/profile');
			}
			else{
				Nauth::setMessage(-1,$this->access_denied); //call the librarary function to set the session type
				url::redirect($this->docroot);
			}
		 }
		 
		 public function settings()
		 {
		 	Nauth::is_login();
            $this->template->title="Change Password";
		 	if($this->userid != ''){
				if($_POST){
					$old_pass = $this->input->post('old_password');
					$new_pass = $this->input->post('new_password');
					$this->template->settings = $this->model->settings($this->userid,$old_pass,$new_pass);
					if($this->template->settings == 1){
						Nauth::setMessage(1,$this->change_pass); //call the librarary function to set the session type
						url::redirect($this->docroot.'profile');
					}
					elseif($this->template->settings == -1){
						Nauth::setMessage(1,$this->invalid_operation); //call the librarary function to set the session type
						url::redirect($this->docroot.'users/settings');
					}
					elseif($this->template->settings == -2){			
						Nauth::setMessage(1,$this->old_pass); //call the librarary function to set the session type
						url::redirect($this->docroot.'users/settings');
					}
				}
				// template code
				$this->left=new View("template/left_menu");
				$this->right=new View("users/change_password");
				$this->title_content = "Change Password";
				$this->template->content = new View('/template/template2');
			}
			else{
				Nauth::setMessage(-1,$this->access_denied); //call the librarary function to set the session type
				url::redirect($this->docroot);
			}
		 }

		 //change the profile photo
        public function changephoto()
		{
			Nauth::is_login();
			$this->template->title="Change Profile Photo";
			if($_POST){
			//get the photo name
				$photo_name=$_FILES['user_image']['name'];
				$this->model->change_photo($this->userid,$photo_name);
				url::redirect($this->docroot.'profile');
				die();
			}
			// template code
			$this->left=new View("template/left_menu");
			$this->right=new View("users/change_photo");
			$this->title_content = "Change Profile Photo";
			$this->template->content=new View("/template/template2");
		}

		 //delete users
		 
		 public function deleteuser()
		 {
		 	Nauth::is_login();
		 	if($this->userid != ''){
				$userid = $this->input->get('userid');
				if($userid){
					$this->template->deleteuser = $this->model->deleteuser($userid);
					Nauth::setMessage(1,$this->user_delete); //call the librarary function to set the session type
					url::redirect($this->docroot.'users/manageusers');
				}
			}
		 }
		 
		
		/**
 		* Genral Invite
 		*/
        public function general_invite()
		{
			Nauth::is_login();
			if($_POST)
			{ 
				$invite_type=$this->input->post("invite_type");
				if($invite_type=="normal")
				{
					$to=$this->input->post("to");
					$subject=$this->input->post("subject");
					$message=$this->username." is Inviting you to join in N.Sandwich features"."<br>";
					$message=$message.$this->input->post("message");
					$type="Invite friends";
					$email_ids=explode(',',$to);
					foreach($email_ids as $to)
					{
						if($to!='')
						{
							Nauth::send_mail($to,$this->from,$subject,$message,$type);
							$this->model->friends_referral($to,$this->userid,$message);
						}
					}
					Nauth::setMessage(1,$this->invitation_sent); //call the library function to set the session type
					url::redirect($this->docroot."profile/invite");
				}
			}
		}
		/**
 		* Open Id
		*/
		public function openids()
		{
			require_once Kohana::find_file('../modules/users/models/openid/','openidvalidate',TRUE,'php');
			exit;
		}

		/*Users Search*/
		public function search()
		{
			Nauth::is_login();
			$this->template->profile_info = $this->profile->profile_info($this->userid);
			//checking for users login
			if($this->userid != ''){
				$this->template->title = 'Users Search';
				//checking for post values
				if($_GET){
					$search = html::specialchars($this->input->get('search_value'));
					//checking for input values
					if($search != ''){
						$this->template->search = $this->model->search($search,$this->userid);
						$this->template->content = new View('/users/search');
					}
					else{
						$search = 0;
						$this->template->search = array();
						$this->template->content = new View('/users/search');
					}
				}
				if($_POST){
					$friends_id = $this->input->post('friends_id');
					$search = $this->input->post('search');
					$friends_comment = $this->input->post('friend_comment');
					$this->template->title = 'Add Friends';
					$this->profile_model=new Profile_Model();
					$this->template->friends_request = $this->profile_model->friends_request($friends_id,$this->userid,$friends_comment,0);
					if($this->template->friends_request == -1){	
						Nauth::setMessage(1,$this->already_requested); //set session message using library
						$this->template->search = $this->model->search($search,$this->userid);
						url::redirect($this->docroot.'users/search?search_value='.$search.'');
					}
					else
					{
						Nauth::setMessage(1,$this->request); //set session message using library
						$this->template->search = $this->model->search($search,$this->userid);
						url::redirect($this->docroot.'users/search?search_value='.$search.'');
					}
				}
				// template code
				$this->left=new View("profile/profile_left");
				$this->right=new View("/users/search");
				$this->title_content = "Search Friends";
				$this->template->content=new View("/template/template2");
			}
			else{
				url::redirect($this->docroot);
			}
		}
		
	        public function facebook()
	        {
	                $this->template->title = "Facebook Connect";
	                $this->template->content =  new View("facebook/fb_button_1");
	        }
	        public function facebook_receiver()
	        {
	                $this->template->title = "Facebook Connection Receiver";
	                $this->template->content =  new View("facebook/xd_receiver");
	        }
}
?>


