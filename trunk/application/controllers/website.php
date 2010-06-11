<?php defined('SYSPATH') or die('No direct script access.');
 class Website_Controller extends Template_Controller {

	 //Template view name
	public  $template = 'template';
	public $left = '';
	public $center = '';
	public $right = '';
	public $title_content = '';
	public $metatag = '';
	public $metadesc = '';
	
	// Default to do auto-rendering
	public $auto_render = TRUE;
		
	/**
	 *  Template loading and setup routine.
	 */
	public function __construct()
	{
	        
		parent::__construct();
		//GET DOCROOT
		$pageURL = 'http';
		$pageURL .= "://";
 		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		$pageURL .= "/";	
		$this->docroot = $pageURL.substr(kohana::config("config.site_domain"),1); 
		
		$this->title_content = Kohana::config("english.hometitle");
		$this->metatag = Kohana::config("english.metatag");
		$this->metadesc = Kohana::config("english.metadesc");
		//
		$this->session = Session::instance();
		$userid = cookie::get('userid');
		if($userid){
			$this->session->set('userid',$userid);
			cookie::delete('userid');
		}
		$this->userid = $this->session->get('userid');
		$this->username = $this->session->get('username');
		$this->usertype = $this->session->get('usertype');
		$this->template = new View($this->template);
                $this->model = new Menu_Model();
                
                /*GET NOTES */
                
                if($this->userid != '')
                {
                        $url = $_SERVER['REQUEST_URI'];
                        $this->get_notes = ""; //$this->model->get_notes($this->userid,$url);
                        
                }
                
		
		/** GET THEME NAME **/
		$this->get_theme = $this->model->get_theme();
	        if($this->get_theme==""){
	           $this->get_theme = "default";     
	        }
		/** GET ENABLE MODULE **/
		
		if(!$this->session->get("enable_module")){
			 $en_module = $this->model->get_module();
			 if(count($en_module) > 0 ){
				 foreach($en_module as $row){
					 $this->get_module[$row->display_name] = $row->name;
				 }
				 $_SESSION["enable_module"] = $this->get_module;
			}
			else{
				$this->get_module = array();
				$_SESSION["enable_module"] = $this->get_module;
			}
		}
		else{
			  $this->get_module = $this->session->get("enable_module"); 
			  $this->e_module = $this->session->get("mod_id");
		}
		



		/** LOGIN MODULE **/
		
		if(!$this->session->get("no_login_module")){
			$no_login =  $this->model->get_no_login_module();
			if(count($no_login) > 0){
				 foreach($no_login as $row){
					 $this->login_moule[] = $row->name;
				 }
				 $_SESSION["no_login_module"] = $this->login_moule;
			}
			else{
				$this->login_moule = array();
				$_SESSION["no_login_module"] = $this->login_moule;
			}
		}
		else{
			$this->login_moule = $this->session->get("no_login_module");
		}

		/** GET MODERATOR PERMISSION  **/
		
		if(!$this->session->get("moderator_permission")){
			$this->get_moderator_permission = $this->model->get_moderator_permission();
			if(count($this->get_moderator_permission) > 0){
				foreach($this->get_moderator_permission as $row){
					$permission = array($row->action_add, $row->action_edit, $row->action_delete, $row->action_block);
				}
				$_SESSION["moderator_permission"] = $permission;
			}
			else{
				$permission = array(0,0,0,0);
			}
		}
		else{
			$permission = $this->session->get("moderator_permission");
		}
		$this->moderator_add = $permission[0]; $this->moderator_edit = $permission[1];
		$this->moderator_delete = $permission[2];$this->moderator_block = $permission[3];
		
		/**  GET GENERAL SETTINGS [ META TAGS, TITLE, DESC, LOGO PATH] **/
		
		if(!$this->session->get("general_setting_info")){
			$g_info = $this->model->get_general_settings();
			if(count($g_info) > 0){
				foreach($g_info as $row){
					$this->general_setting_info = array("title" => $row->title,"meta_keywords" =>$row->meta_keywords,"meta_desc" =>$row->meta_desc, "logo_path" =>$row->logo_path);
				}
			}
			else{
				$this->general_setting_info = array("title" => "","meta_keywords" => "","meta_desc" => "" , "logo_path" => "");
			}
			$_SESSION["general_setting_info"] = $this->general_setting_info;
		}
		else{
			$this->general_setting_info = $this->session->get("general_setting_info");
		}
		
		//
		$this->response = $this->session->get('Msg');
		$this->session->delete('Msg');
		$this->error_response=$this->session->get('Emsg');
		$this->session->delete('Emsg');
		$this->docroot = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
		
		$this->file_docroot = $_SERVER['DOCUMENT_ROOT'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
		
		$this->model = new Profile_Model();
		$this->profile_info = $this->model->profile_info($this->userid);
                
		}
		
	
	//
	public function _render()
	{
		if($this->auto_render == TRUE){
			$this->template->render(TRUE);
		}
	}

} // End Template_Controller
