<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the groups management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
class Admin_groups_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		$this->model=new Admin_groups_Model();
		if(!in_array("groups", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."admin");
			die();
		}
		$this->module="groups";
		permission::check($this->module);

		$mes = Kohana::config('users_config.session_message');
		$this->delete_category = $mes["delete_category"];
		$this->add_category = $mes["add_category"];             		 
		$this->update_category = $mes["update_category"];
		$this->delete_group = $mes["delete_group"];
		$this->update_group = $mes["update_group"];
		$this->module = "groups";

		$this->admin_model = new Admin_Model();
		$this->get_module_permission = $this->admin_model->get_module_permission(9);
		
		if(count($this->get_module_permission) > 0){
			$this->add_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}
	}
	 //group management front page
	 public function index()
	 {
		if($_POST)
		{ 
			$group_id = $this->input->post("group_id");
			$title = $this->input->post('title');
			$group_image=$_FILES['group_image']['name'];
			$category = $this->input->post('category');					
			$access = $this->input->post('access');	
			$desc = $this->input->post('desc');
			$website = $this->input->post('website');
			$company = $this->input->post('company');
			$userid = $this->session->get('userid');	
			$this->model->update_group($group_id,$title,$group_image,$category,$access,$website,$desc,$userid);
			Nauth::setMessage(1,$this->update_group);
			url::redirect($this->docroot."admin_groups/index/");
		}

		$this->all_category=$this->model->all_category();
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->total=$this->model->get_groups_count();
		//all records are stored in this variable
		$this->template->get_groups = $this->model->get_groups($offset,15);
		//no of records count
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'admin_groups', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => $this->total,
		 'style'         => 'classic' )
		 );

		$this->template->title = "Recent groups";

		// template code
		$this->left=new View("general/left");
		$this->center = new View("groups/manage_groups");
		$this->right = new View("groups/groups_submenu");
		$this->title_content = "Groups Management";
		$this->template->content=new View("/template/template3");	 
	 }
			//search groups
		public function commonsearch() 
		{   
			$key=html::specialchars($this->input->get("search_value"));
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='commonsearch')
			$page_no = 1;
			$offset=15*($page_no-1);
					$this->all_category=$this->model->all_category();
					
			$this->template->get_groups = $this->model->get_search_groups_list($key,$offset,15);

			$this->total=$this->model->get_search_groups_count($key);

			$this->template->pagination = new Pagination(array
			 (
			 'base_url'       => 'groups',
			 'uri_segment'    =>'commonsearch',
			 'items_per_page' => 15,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );

					$this->template->title = "Search groups";
			// template code
		$this->left=new View("general/left");
		$this->center = new View("groups/manage_groups");
		$this->right = new View("groups/groups_submenu");
		$this->title_content = "Search Groups";
		$this->template->content=new View("/template/template3");
		}
		//edit the group
		public function edit()
		{
			$gid=$this->input->get("gid");
			$this->edit_group=$this->model->edit_group($gid);
			
			if($_POST){
				$title = $this->input->post('title');
				$gid=$this->input->post("gid");
				$group_image=$_FILES['group_image']['name'];
				$location = $this->input->post('location');
				$country = $this->input->post('country');
				$category = $this->input->post('category');					
				$access = $this->input->post('access');	
				$desc = $this->input->post('desc');
				$website = $this->input->post('website');
				$company = $this->input->post('company');
				$member='';
				$this->update_group_info = $this->model->update_group($title,$group_image,$country,$category,$access,$website,$desc,$company,$this->userid,$member,$location,$gid);
				Nauth::setMessage(1,$this->update_group);
				url::redirect($this->docroot.'admin_groups');
			}
			//template code
			
			$this->template->title="Edit Groups";
			$this->get_city = $this->model->get_city();
			$this->template->get_category = $this->model->all_category();
			$this->left=new View("general/left");
			$this->right=new View("groups/admin_edit_group");
			$this->title_content = "Edit Group Information";
			$this->template->content=new View("/template/template2");	
			
		}

	//delete forum
	public function delete_group()
	{

		$id=$this->input->get("id");
		
		$this->result=$this->model->delete_group($id);
		Nauth::setMessage(1,$this->delete_group);
		url::redirect($this->docroot.'admin_groups/index/');
		
	}

	//manage category
	public function manage_category()
	{   
		if($_POST)
		{
		$category_id=$this->input->post("category_id");
		$category_name=$this->input->post("category_name");
		$type=$this->input->post("type");
		
		if($type=='update')
		{
			$this->model->update_category($category_id,$category_name);
			Nauth::setMessage(1,$this->update_category);
		}
		elseif($type=='add')
		{
			$this->model->insert_category($category_name);
			Nauth::setMessage(1,$this->add_category);
		}
		url::redirect($this->docroot.'admin_groups/manage_category/');
		}

		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->category_count=$this->model->category_count();
		//all records are stored in this variable
		$this->result=$this->model->get_groups_category($offset,15);
		//no of records count

		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'admin_groups', //our controller/function(page)
		 'uri_segment'    => 'manage_category', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => $this->category_count,
		 'style'         => 'classic' )
		 );

		$this->template->title = "group Category Management";

		// template code
		$this->left = new View("general/left");
		$this->center = new View("groups/manage_category");
		$this->right = new View("groups/groups_submenu");
		$this->title_content = "Group Category Management";
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
		url::redirect($this->docroot.'admin_groups/manage_category/');	
	}
	public function block_group()
	{
		$id=$this->input->get("id");
		$opr=$this->input->get("status");
		$this->result=$this->model->block_group($id,$opr);
		url::redirect($this->docroot.'admin_groups/index/');	
	}
}