<?php defined('SYSPATH') or die('No direct script access.');

class Login_Profile_Controller extends Template_Controller {
	const ALLOW_PRODUCTION = FALSE;
	
	public $template = 'kohana/template';
 	public $Msg;
	public $userid;
	              
	public function index()
	{ 
	 	if(!$this->userid){
       	 	$this->userid = $session->get('userid');
		}
	 
		if($this->userid!="")
		{
			url::redirect($this->docroot.'inbox/inbox/inboxshow');
		}else{
			require_once Kohana::find_file('/models/inbox','loginvalid',TRUE,'php');
			$this->login = new Loginvalid_Model();
			$this->loginCheck = $this->login->login_check();
			$this->template->title = 'Login';
			$to_view = 'inbox_activity/login1_content';
			
		}
		$this->template->content = new View($to_view);
	}
	
	public function logout()
	{
		require_once Kohana::find_file('/models/inbox','loginvalid',TRUE,'php');
		$this->login = new Loginvalid_Model();
		$this->loginCheck = $this->login->login_logout();
		url::redirect($this->docroot.'inbox_activity/login_prifile');
	}
}