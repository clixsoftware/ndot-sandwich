<?php defined('SYSPATH') OR die('No direct access allowed.'); 
/**
 * The user controller will provide the information about user settings,login,logout,manage users,invite friends and oped_id login.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

?>

<?php 
class Comments_Controller extends Website_Controller
{
	public $template = 'template/plaintemplate';

		 public function __construct()
		 {
			 parent::__construct();
			 $this->model=new thirdparty_Model();
			 $this->profile=new Profile_Model();
			 $this->update = new update_model_Model();
			 	
			 $this->from="admin@ndot.in";
             		//user response messages
  			 $mes=Kohana::config('users_config.session_message');
			 $this->thirdparty = Kohana::config('application.thirdparty');
			 if(!empty($this->thirdparty))
			 $this->thirdparty = '/'.$this->thirdparty;
			 else
			 $this->thirdparty = '';
             		$this->login=$mes["login"];
             		$this->login_error=$mes["login_error"]; 
			 $this->status_message=$mes["status_message"];
			 $this->logout=$mes["logout"];
			 $this->registration=$mes["registration"];
			 $this->fields_missing=$mes["fields_missing"];
			 $this->email_exist=$mes["email_exist"];
			 $this->access_denied=$mes["access_denied"];
			 $this->change_pass=$mes["change_pass"];
			 $this->invalid_operation=$mes["invalid_operation"];
			 $this->old_pass=$mes["old_pass"];
			 $this->photo_change=$mes["photo_change"];
			 $this->user_delete=$mes["user_delete"];
			 $this->invitation_sent=$mes["invitation_sent"];
			 $this->already_requested=$mes["already_requested"];
			 $this->request=$mes["request"];
			 $this->friend_added=$mes["friend_added"];
			 $this->request_reject=$mes["request_reject"];
			 $this->friend_removed=$mes["friend_removed"];
			$this->module="users";
			$this->session=Session::instance();
			$this->user_id = $this->session->get('userid');
			//$this->user_id = 1;
			//$this->ndot = new Ndot();

		 }
		/* public function index($url = '')
		 {    

           		Nauth::is_login('/profile/updateprofile','');
			$this->template->title = "Welcome to Ndot";
			$this->template->redirect=$url;
			$this->template->content = new View('home');
      		  }*/	
		
		
		public function set_session() 
		{
			$userid = $this->input->post('userid');
			$username = $this->input->post('username');
			$usertype = $this->input->post('usertype');
			$_SESSION["userid"] = $userid;
			$_SESSION["username"] = $username;
			$_SESSION["usertype"] = $usertype;
			setcookie("userid",$userid,time()+150);
			die();
		}
		//THird Party Updates

		 public function third_party_get_updates()
    		{
			   			
			   $this->url = $this->input->get('uniqueId');
			   $this->url = url::title($this->url);
			   $this->updates = $this->model->get_third_party_updates($this->url);	
			   $this->template->title='Comments';	   
			   $this->right =new View("comments");
			   $this->title_content = "Comments";
			   $this->template->content=new View("/template/template2");		
			  // die();
			  
   		 }
		
		public function third_party_set_updates()
    		{
			if($_POST)
			{
				
				$user_id = $this->input->post('userid'); 	
			    	$url = $this->input->post('url');
			   	$content = $this->input->post('comment_data');
				$url = url::title($url);
			   	$this->updates = $this->model->set_third_party_updates($user_id,'',37,'',$content,$url);	
				url::redirect("$this->thirdparty/comments/third_party_get_updates?uniqueId=".$url);	
				die();
			}
   		 }
		 
		
		 
		  public function third_party_get_fans()
    		{
			
		           $this->url = $this->input->get('uniqueId');
			   $this->url = url::title($this->url);
			  // echo $this->url;exit;	
			   $this->check_fans = $this->model->checkfans($this->user_id,$this->url);
			   $this->fans = $this->model->getfans($this->url);
			   $this->template->title='Fanbox';	   
			   $this->right =new View("fanbox");
			   $this->title_content = "Fanbox";
			   $this->template->content=new View("/template/template2");	
			  	
   		 }
		 
		public function set_fan()
    		{
		           $url = $this->input->get('u_value');
			   $url = url::title($url);	
			   $this->updates = $this->model->set_fan($url,$this->user_id);	
		           url::redirect("$this->thirdparty/comments/third_party_get_fans?uniqueId=".$url);		 
			   die();
		} 
		 public function getallfans($url = '')
		 {
		    	$this->template->title = 'Get all fans';
		 	$url = "http://192.168.1.2:1147/uncategorized/hello-world/";
		 	$this->getallfans = $this->model->getallfans($url);
		 	$this->template->content = new View('getallfans');
		 }
		 
		 
		
}

?>
