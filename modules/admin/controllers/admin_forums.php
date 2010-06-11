<?php defined('SYSPATH') or die('No direct script access.');

class Admin_forums_Controller extends Website_Controller 
{

	 public $template = 'template/template';
	 public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		if(!in_array("forum", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."admin");
			die();
		}
		$this->module="forums";
		permission::check("forum");
		
		$this->model = new Admin_forums_Model();
		$mes = Kohana::config('users_config.session_message');
		$this->delete_category = $mes["delete_category"];
		$this->add_category = $mes["add_category"];             		 
		$this->update_category = $mes["update_category"];
		$this->delete_forum = $mes["delete_forum"];
		$this->update_forum = $mes["update_forum"];
		$this->admin_model = new Admin_Model();
		$this->get_module_permission = $this->admin_model->get_module_permission(8);
		
		if(count($this->get_module_permission) > 0){
			$this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}
	}

	 public function index()
	 {
		if($_POST)
		{
		$forum_id=$this->input->post("forum_id");
		$topic=$this->input->post("topic");
		$category=$this->input->post("category");
		$topic_desc=$this->input->post("topic_desc");
		$this->model->update_forum($forum_id,$topic,$category,$topic_desc);
		Nauth::setMessage(1,$this->update_forum);
		url::redirect($this->docroot."admin_forums/index/");
		}
		$this->all_category=$this->model->all_category();
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->cout=$this->model->count_forums(); 
		//all records are stored in this variable
		$this->result=$this->model->get_forums($offset,15);

		//no of records count
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'admin_forums', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => $this->cout,
		 'style'         => 'classic' )
		 );

		$this->template->title = "Recent Discussion";

		// template code
		$this->left=new View("general/left");
		$this->center=new View("forums/manage_forums");
		$this->right=new View("forums/submenu");
		$this->title_content = "Discussion Forum Management";
		$this->template->content=new View("/template/template3");	 
	 }
	//delete forum
	public function delete_forum()
	{

		$id=$this->input->get("id");
		
		$this->result=$this->model->delete_forum($id);
		if($this->result)			
		{
		Nauth::setMessage(1,$this->delete_forum);
		}
		url::redirect($this->docroot.'admin_forums/index/');
		
	}
		 
	//edit news
	public function edit()
	{   
	
	$newsid = $this->input->get('nid');
	$this->template->editnews=$this->model->editnews($newsid);
	$view=new View("/admin_news");
	$this->template->content=$view;
	   
	} 

	public function manage_category()
	{   
		if($_POST)
		{
		$category_id=$this->input->post("category_id");
		$category_name=$this->input->post("category_name");
		$category_description=$this->input->post("category_description");
		if($category_id)
		{
			$this->model->update_category($category_id,$category_name,$category_description);
			Nauth::setMessage(1,$this->update_category);
		}
		else
		{
			$this->model->insert_category($category_name,$category_description);
			Nauth::setMessage(1,$this->add_category);
		}
		url::redirect($this->docroot.'admin_forums/manage_category/');
		}
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 3 to 6 
		$offset=25*($page_no-1); 
		$this->forum_category_count=$this->model->forums_category_count();
		//all records are stored in this variable
		$this->result=$this->model->get_forums_category($offset,25);
		//no of records count

		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'admin_forums', //our controller/function(page)
		 'uri_segment'    => 'manage_category', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => $this->forum_category_count,
		 'style'         => 'classic' )
		 );

		$this->template->title = "Manage Forum Category";

		// template code
		$this->left=new View("general/left");
		$this->center=new View("forums/manage_category");
		$this->right=new View("forums/submenu");
		$this->title_content = "Discussion Forum Management";
		$this->template->content=new View("/template/template3");	 	
	} 
	//delete cateogory
	public function delete_category()
	{

		$id=$this->input->get("id");
		
		$this->result=$this->model->delete_category($id);
		if($this->result)			
		{
		Nauth::setMessage(1,$this->delete_category);
		}
		url::redirect($this->docroot.'admin_forums/manage_category/');
		
	}
	
	public function search()
	{
		
		$search=html::specialchars($this->input->get('csearch'));
		
		$this->get_category=$this->model->all_category();
		
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commonsearch')
		$page_no = 1;
		$offset=10*($page_no-1);
		if($search)
		{
				$this->template->forum_search=$this->model->search_forum_advanced($search,$offset,10);
				$this->total=$this->model->get_search_count($search);
			}
			else
			{
					$this->template->forum_search = array();
					$this->total = array();
			}
		
		$this->template->pagination1 = new Pagination(array
		(
		'base_url'       => 'admin_forums',
		'uri_segment'    =>'search',
		'items_per_page' => 10,
		'auto_hide'     => true,
		'total_items'    => $this->total,
		'style'         => 'classic' )
		 );	 
		//template code
		$this->template->title="Forum Search Results";
		$this->left=new View("general/left");	   
		$this->right=new View("forums/search");
		$this->title_content = "Search Results";
		$this->template->content=new View("/template/template2");
	}

}
