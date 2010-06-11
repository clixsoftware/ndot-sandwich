<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_mailtemplates_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		if($this->usertype != -1){
			url::redirect($this->docroot."admin");
		}
		$this->model=new Admin_mailtemplates_Model();
		$this->profile=new Profile_Model();
		$mes = Kohana::config('users_config.session_message');
		$this->module = "mail_template";
	}
	  
	  public function index()
	 {
		$this->template->profile_info=$this->profile->profile_info($this->userid);
		//manage all templates
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 0 to 10 
		$offset=10*($page_no-1); 
		$this->template->get_alltemplates=$this->model->get_alltemplates();
		//all records are stored in this variable
		$this->template->get_templates=$this->model->get_templates($offset,10);
		//no of records count
		$this->template->pagination1 = new Pagination(array
		 (					
		 'base_url'       => 'admin_mailtemplates', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->template->get_alltemplates),
		 'style'         => 'digg' )
		 );
		// template code
		$this->template->title = "Mail Templates";
		$this->left=new View("general/left");
		$this->right=new View("mail_template/mail_templates");
		$this->title_content = "Manage Mail Templates";
		$this->template->content=new View("/template/template2");	 

	 }
	

	//Delete Template
	public function delete_template()
	{   
		$id=$this->input->get("id");
		$this->delete=$this->model->delete_temp($id);
		$this->session->set("Msg","Template has been Deleted");
		url::redirect($this->docroot."admin_mailtemplates/");
		   
	}


	//View Template
	public function view_temp()
	{   
		$id=$this->input->get("id");
		$this->view_temp=$this->model->view_temp($id);
		// template code
		$this->template->title = "View Templates";
		$this->left=new View("general/left");
		$this->right=new View("mail_template/view_mail_templates");
		$this->title_content = "View Mail Templates";
		$this->template->content=new View("/template/template2");
		//$this->session->set("Msg","Template has been Deleted");
		//url::redirect($this->docroot."admin_mailtemplates/");
		   
	}


	//Edit Template
	public function edit_temp()
	{   
		$id=$this->input->post("id");
		$title=html::specialchars($this->input->post("title"));
		$code=html::specialchars($this->input->post("markItUp"));
		//$code = text::censor($code,array("http://n.social/","http://n.social","http://n.social/n.social"),$this->docroot);	
		//$code = text::censor($code,array("https://n.social/","https://n.social"),$this->docroot);
		$code = text::censor($code,array("http://n.social/","http://n.social"),$this->docroot);
		$code = str_replace("/n.social","",$code);
		//$code = str_replace("http://192.168.1.2:1154/admin_mailtemplates/www.ndot.in","http://www.ndot.in",$code);	
		$code = str_replace("http://test",$this->docroot,$code);
		//echo $code;exit;
		$this->edit_temp=$this->model->edit_temp($id,$title,$code);
		$this->session->set("Msg","Template has been Edited");
		url::redirect($this->docroot."admin_mailtemplates/");
		   
	}

	//create template	 
	public function create_temp()
	{   
		// template code
		$this->template->title = "Create Mail Templates";
		$this->left=new View("general/left");
		$this->right=new View("mail_template/create_template");
		$this->title_content = "Create Mail Templates";
		$this->template->content=new View("/template/template2");
		
		if($_POST)
		{
			$title=html::specialchars($this->input->post("title"));
			$code=html::specialchars($this->input->post("markItUp"));			
			$this->edit_temp=$this->model->create_temp($title,$code);
			$this->session->set("Msg","Template has been Created");
			url::redirect($this->docroot."admin_mailtemplates/");
		}
		   
	}
		
}
