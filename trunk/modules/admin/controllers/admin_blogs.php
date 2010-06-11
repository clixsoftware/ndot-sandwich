<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the blog management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */


class Admin_blogs_Controller extends Website_Controller 
{

		 public $template = 'template/template';
		 public function __construct()
		 {
			parent::__construct();
			Nauth::is_login();
			if(!in_array("blog", $this->session->get("enable_module"))) {
				url::redirect($this->docroot."admin");
				die();
			}
			 permission::check("blog");
			$this->module="blogs";
			$this->model=new Admin_blogs_Model();
			/*User response messages*/
			$mes=Kohana::config('users_config.session_message');
			$this->delete_category=$mes["delete_category"];
			$this->add_category=$mes["add_category"];             		 
			$this->update_category=$mes["update_category"];
			$this->delete_blog=$mes["delete_blog"];
			$this->update_blog=$mes["update_blog"];
			
			 //get the answers modules permission
			 $this->admin_model = new Admin_Model();
			 $this->get_module_permission = $this->admin_model->get_module_permission(3);
                        
			 if(count($this->get_module_permission) > 0)
			 {
			       $this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			       $this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			       $this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			       $this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
			 }
			 
			
		 }

		 //blog management front page
		 public function index()
		 {
			if($_POST)
			{
				$blog_id=$this->input->post("blog_id");
				$title=$this->input->post("title");
				$category=$this->input->post("category");
				$desc=$this->input->post("description");
				$this->model->update_blog($blog_id,$title,$desc,$category);
				Nauth::setMessage(1,$this->update_blog);
				url::redirect($this->docroot."admin_blogs/index/");
			}

			$this->all_category=$this->model->all_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=15*($page_no-1); 
			$this->total=$this->model->get_blog_count();
			//all records are stored in this variable
			$this->template->get_blog=$this->model->get_blog($offset,15);
			//no of records count
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_blogs', //our controller/function(page)
			 'uri_segment'    => 'index', //page(function)
			 'items_per_page' => 15,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );

			$this->template->title = "Recent Blogs";

			// template code
			$this->left=new View("general/left");
			$this->center=new View("blogs/manage_blogs"); 
			$this->right=new View("blogs/blogs_submenu_right");			
			$this->title_content = "Blogs Management";
			$this->template->content=new View("/template/template3");	 
		 }

		//delete forum
		public function delete_blog()
		{

			$id=$this->input->get("id");
			
			$this->result=$this->model->delete_blog($id);
			Nauth::setMessage(1,$this->delete_blog);
			url::redirect($this->docroot.'admin_blogs/index/');
			
		}
	        // Search Blog
	        public function commonsearch()
		{
                        
		        $search_value=html::specialchars($this->input->get("search_value"));
			if($search_value == '')
			{
                		$this->session->set("Emsg","Search Field is empty......");
                		url::redirect($this->docroot.'admin_blogs/');				
			}
			$this->all_category=$this->model->all_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=10*($page_no-1); 
			$this->total=$this->model->get_search_blog_count($search_value); 
			//all records are stored in this variable
			$this->template->get_blog=$this->model->get_search_blog($search_value,$offset,10);
			//no of records count
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_blogs', //our controller/function(page)
			 'uri_segment'    => 'commonsearch', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );

 			// template code
        		$this->template->title = "Search Result";
			$this->left=new View("general/left");
			$this->center=new View("blogs/manage_blogs"); 
			$this->right=new View("blogs/blogs_submenu_right");			
			$this->title_content = "Blogs Search Result";
			$this->template->content=new View("/template/template3");
			
		}
		//manage category
		public function manage_category()
	   	{   
			if($_POST)
			{
			$category_id=$this->input->post("category_id");
			$category_name=$this->input->post("category_name");
			if($category_id)
			{
				$this->model->update_category($category_id,$category_name);
				Nauth::setMessage(1,$this->update_category);
			}
			else
			{
				$this->model->insert_category($category_name);
				Nauth::setMessage(1,$this->add_category);
			}
			url::redirect($this->docroot.'admin_blogs/manage_category/');
			}

			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=15*($page_no-1); 
			$this->blog_category_count=$this->model->blog_category_count();
			//all records are stored in this variable
			$this->result=$this->model->get_blog_category($offset,15);
			//no of records count

			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_blogs', //our controller/function(page)
			 'uri_segment'    => 'manage_category', //page(function)
			 'items_per_page' => 15,
			 'total_items'    => $this->blog_category_count,
			 'style'         => 'classic' )
			 );

			$this->template->title = "Blog Category Management";

			// template code
			$this->left=new View("general/left");
			$this->center=new View("blogs/manage_category");
			$this->right=new View("blogs/blogs_submenu_right");			
			$this->title_content = "Blog Category Management";
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
			url::redirect($this->docroot.'admin_blogs/manage_category/');
			
		}
		
		public function change_status()
		{
			if($this->userid != '' && $this->usertype == -1)
			{
				if($_GET)
				{
					$status = $this->input->get('status');
					$blog_id = $this->input->get('id');
					$this->template->change_status = $this->model->change_status($status,$blog_id);
					if($this->template->change_status == 1)
					{
						$this->session->set('Msg','Status has been changed.');
					}
					
					url::redirect($this->docroot.'admin_blogs');
				}
			}
			else
			{
				url::redirect($this->docroot);
			}
		}

}
