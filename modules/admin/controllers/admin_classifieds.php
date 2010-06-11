<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     Ashokkumar.c
 * @copyright  (c) 2010 Ndot.in 
 */
class Admin_classifieds_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		if(!in_array("classifieds", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."admin");
			die();
		}
		$this->module = "classifieds";
		permission::check($this->module);
		$this->model = new Admin_classifieds_Model();
		
		$mes = Kohana::config('users_config.session_message');
		$this->add_cat = $mes["add_category"];
		$this->user_id = $this->session->get('userid');
		
		//get the answers modules permission
		$this->admin_model = new Admin_Model();
		$this->get_module_permission = $this->admin_model->get_module_permission(6);
		
		if(count($this->get_module_permission) > 0){
			$this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}
	}

	 public function index()
	 {
			
		$this->template->category = $this->model->get_category();
		$this->template->title="Add Classifieds";
			$del=$this->input->get("del");
		$id=$this->input->get("id");
		if($del)
		{
				$this->delete=$this->model->delete_classifieds($id);
				$this->session->set("Msg","Classifieds has been Deleted");
				url::redirect($this->docroot."admin_classifieds");
		}
		if($_POST)
		{
				$name = $this->input->post('uname');
				$city = $this->input->post('city');
		
				$mobile = $this->input->post('mobile');
				$type = $this->input->post('type');					
				$category = $this->input->post('category');					
				$email = $this->input->post('email');
				$title = $this->input->post('title');
				$desc = $this->input->post('desc');
				$price = $this->input->post('price');
				$userid = $this->input->post('userid'); 
				$this->template->post_ads = $this->model->post_ads($name,$city,$mobile,$type,$category,$email,$title,$desc,$price,$userid);
				$this->session->set('Msg');
				url::redirect($this->docroot.'admin_classifieds/index');
		}
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 0 to 10 
		$offset=10*($page_no-1); 
		$this->template->get_allclassifieds=$this->model->get_allclassifieds();
		//all records are stored in this variable
		$this->template->get_classifieds=$this->model->get_classifieds($offset,10);
		//no of records count
		$this->template->pagination1 = new Pagination(array
		 (					
		 'base_url'       => 'admin_classifieds', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->template->get_allclassifieds),
		 'style'         => 'classic' )
		 );
		// template code
		 $this->left=new View("general/left");
		 $this->center=new View("classifieds/classifieds");
		 $this->right=new View("classifieds/classifieds_right");
		 $this->title_content = "Classifieds Management";
		 $this->template->content=new View("template/template3");	 
	 }
	
	public function search()
	{
		
		$search=html::specialchars($this->input->get('csearch'));
		
		$this->get_category=$this->model->get_category();
		
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commonsearch')
		$page_no = 1;
		$offset=10*($page_no-1);
		if($search)
		{
				$this->template->classifieds_search=$this->model->search_classifieds_advanced($search,$offset,10);
				$this->total=$this->model->get_search_count($search);
			}
			else
			{
					$this->template->classifieds_search = array();
					$this->total = array();
			}
		
		$this->template->pagination1 = new Pagination(array
		(
		'base_url'       => 'classifieds',
		'uri_segment'    =>'search',
		'items_per_page' => 10,
		'auto_hide'     => true,
		'total_items'    => $this->total,
		'style'         => 'classic' )
		 );	 
		//template code
		$this->template->title="Classifieds Search Results";
		$this->left=new View("general/left");	   
		$this->right=new View("classifieds/search");
		$this->title_content = "Search Results";
		$this->template->content=new View("/template/template2");
	}	 
	//edit Classifieds
	public function edit_classifieds()
	{   
	$id=$this->input->post("id");
	$name=$this->input->post("name");
	$mobile=$this->input->post("mobile");
	$email=$this->input->post("email");
	$price=$this->input->post("price");	
	
	$title=$this->input->post('title');
	$desc=$this->input->post('desc');
	//$user_id=$this->session->get('userid');
	$category=$this->input->post('category');
	$this->template->classifieds=$this->model->edit_classifieds($title,$desc,$category,$name,$mobile,$email,$price,$id);
	Nauth::setMessage(1,$this->add_cat);
	url::redirect($this->docroot.'admin_classifieds/index');
	} 
	
	public function addcat()
	{
	if($_POST)
	{ 
	$category = html::specialchars($this->input->post('category'));
	$cat = $this->input->post('caty');
	
	if($cat=="subcat")
	{
	$main = $this->input->post('main_category');
	$parent_id=$main;
	}
	else
	{
	$parent_id='0';
	}
	$this->template->addcat=$this->model->addcat($category,$parent_id);
	Nauth::setMessage(1,$this->add_cat);
	url::redirect($this->docroot.'admin_classifieds/addcat');
	}
	$del=$this->input->get("del"); 
	$id=$this->input->get("id");
	if($del)
	{
		$this->delete=$this->model->delete_category($id);
		$this->session->set("Msg","category has been Deleted");
		url::redirect($this->docroot."admin_classifieds/addcat");
	}		
	$this->category=$this->model->get_category();
	$this->template->title="Edit Classifieds Category";
	$this->left=new View("general/left");
	$this->center=new View("/classifieds/edit_category");
	$this->right=new View("classifieds/classifieds_right");
	$this->title_content = "Classifieds Management";
	$this->template->content=new View("template/template3");
	   
	} 
	public function editcat()
	{   
	$id=$this->input->post("cat_id");
	$category=html::specialchars($this->input->post('category'));
	$this->template->editcat=$this->model->editcat($category,$id);
	$this->session->set("Msg","Category has been Updated");
	url::redirect($this->docroot.'admin_classifieds/addcat');  
	} 
	
	public function block_unblock()
	{
	
		if($this->userid != '' && ($this->usertype == -1 || $this->usertype == -2))
		{
			if($_GET)
			{
				$status = $this->input->get('status');
				$id = $this->input->get('id');
				$this->insert_status = $this->model->block_unblock($status,$id);
				if($this->insert_status == 1)
				{
					$this->session->set('Msg','Classifieds status has been changed.');
					url::redirect($this->docroot.'admin_classifieds');
				}
				elseif($this->insert_status == -1)
				{
					$this->session->set('Emsg','Classifieds status changes Failed.');
					url::redirect($this->docroot.'admin_classifieds');
				}
			}
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
}
