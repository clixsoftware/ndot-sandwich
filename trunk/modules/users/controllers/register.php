<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php 
class Register_Controller extends Website_Controller
{
	public $template = 'template/template';
	public function __construct()
		 {
			 parent::__construct();
			 $this->model=new Register_Model();
			 
					  
		 }
		 public function index($url = '')
		 {
			$this->template->title = "Welcome to Ndot";
			$this->template->redirect=$url;
			$this->template->content = new View('user_login');
		 }
		 
 
		 public function manageusers()
		 {
		 	if($this->userid != '' && $this->usertype == 0)
			{
		 		$this->template->title = 'Manage Users';
				$this->template->get_users = $this->model->getusers();
		 		$this->template->content = new View('/users/manageusers');
			}
			else
			{
				url::redirect($this->docroot);
			}
			
		 }
		 
		 
		  // User activity Started
		  
		  //Getting edit iser Details
		 public function edituser()
		 {
		 	if($this->userid != '')
			{
				$this->template->title = 'Edit User';
				$user_id = $this->input->get('user_id');
				$this->template->get_users = $this->model->editusers($user_id);
				$this->template->content = new View('/users/edituser');
			}
			else
			{
				url::redirect($this->docroot.'users');
			}
		 }
		 
		 
		 //add users
		 public function adduser()
		 {
		 	$this->template->title = 'Add user';
			if($_POST)
			{
				$adduser = $this->input->post('adduser');
				$f_name = $this->input->post('f_name');
				$l_name = $this->input->post('l_name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$userid = $this->input->post('userid');
				$dob = $this->input->post('dob');
				$gender = $this->input->post('gender');
				$city = $this->input->post('city');
				
				//adding new users
				

   			    if($adduser == 'adduser')
				{
					$this->template->existuser = $this->model->existuser($email);
					if(count($this->template->existuser) == 0)
					{
					        
						if($f_name !='' && $l_name !='' && $email !='' && $password !='' && $city != '' && $dob != '' && $gender != '')
						{
						        $fname  = trim(strlen($f_name));
						        $lname = trim(strlen($l_name));
						        $pass = trim(strlen($password));
						        $f = ($fname >=6 && $fname <=40);
						        $l = ($lname >=6 && $lname <=40);
						        $p = ($pass >=6 && $pass <=14);
						        if($f && $l && $p)
						        {
							        $this->template->adduser = $this->model->adduser($f_name,$l_name,$email,$password,$city,$gender,$dob,$this->docroot);
							        if($this->template->adduser == -1)
							        {
							                $this->session->set('Emsg','Invalid Email.');
							        }
							        else
							        {
							                $this->session->set('Msg','Registration Completed.');
						            }
							
							        if($this->userid == '')
							        {
								        url::redirect($this->docroot.'');
							        }
							}
							else
							{
							        
							        $this->session->set('Emsg','First Name & Last Name should be 6-40.<br />Password should be 6-14');
							        url::redirect($this->docroot);
							}
						}
						else
						{
							$this->session->set('Emsg','All Fields are Mandatory');
							url::redirect($this->docroot);
						}
					}
					else
					{
						$this->session->set('Emsg','This email already exists');
						url::redirect($this->docroot);
					}
				}

			}
			
		 }
		 
		 //users profile
		 
		 public function profile()
		 {
		 	if($this->username != '')
			{
		 		$this->template->title = $this->username .' Profile';
			}
			else
			{
				$this->template->title = '';
			}
		 	if($this->userid != '' && $this->usertype == 1)
			{
				$this->template->get_usersprofile = $this->model->profile($this->userid);
				$this->template->content = new View('/users/profile');
			}
			else
			{
				$this->session->set('Msg','Access Denied.');
				url::redirect($this->docroot.'users');
			}
		 }
		 
		 public function settings()
		 {
		 	if($this->userid != '')
			{
				if($_POST)
				{
					$old_pass = $this->input->post('old_password');
					$new_pass = $this->input->post('new_password');
					$this->template->settings = $this->model->settings($this->userid,$old_pass,$new_pass);
					if($this->template->settings == 1)
					{
						$this->session->set('Msg','Password changed successfully');
						url::redirect($this->docroot.'users/profile');
					}
					elseif($this->template->settings == -1)
					{
						$this->session->set('Msg','Invalid operation');
						url::redirect($this->docroot.'users/settings');
					}
					elseif($this->template->settings == -2)
					{
						$this->session->set("Msg","Old Password doesn't match.");
						url::redirect($this->docroot.'users/settings');
					}
				}
				$this->template->title = 'Change password';
				$this->template->content = new View('/users/change_password');
			}
			else
			{
				$this->session->set('Msg','Access Denied.');
				url::redirect($this->docroot.'users/');
			}
		 }
		 
		 //delete users
		 
		 public function deleteuser()
		 {
		 	if($this->userid != '')
			{
				$userid = $this->input->get('userid');
				if($userid)
				{
					$this->template->deleteuser = $this->model->deleteuser($userid);
					$this->session->set('Msg','Successfully deleted');
					url::redirect($this->docroot.'users/manageusers');
				}
			}
		 }
		 
		 
		
		 
}

?>
