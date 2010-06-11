<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the article management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */


class Admin_article_Controller extends Website_Controller 
{

		 public $template = 'template/template';
		 public function __construct()
		 {
			parent::__construct();
			Nauth::is_login();
			if(!in_array("article", $this->session->get("enable_module"))) {
				url::redirect($this->docroot."admin");
				die();
			}
			
			permission::check("article");
			$this->module="article";
			$this->model=new Admin_article_Model();
			
			/*User response messages*/
			$mes=Kohana::config('users_config.session_message');
			$this->delete_category=$mes["delete_category"];
			$this->add_category=$mes["add_category"];             		 
			$this->update_category=$mes["update_category"];
			$this->delete_article=$mes["delete_article"];
			$this->update_article=$mes["update_article"];
			
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

		 //article management front page
		 public function index()
		 {
			if($_POST)
			{
				$article_id=$this->input->post("article_id");
				$title=$this->input->post("title");
				$category=$this->input->post("category");
				$desc=$this->input->post("description");
				$this->model->update_article($article_id,$title,$desc,$category);
				Nauth::setMessage(1,$this->update_article);
				url::redirect($this->docroot."admin_article/index/");
			}

			$this->all_category=$this->model->all_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=15*($page_no-1); 
			$this->total=$this->model->get_article_count();
			//all records are stored in this variable
			$this->template->get_article=$this->model->get_article($offset,15);
			//no of records count
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_article', //our controller/function(page)
			 'uri_segment'    => 'index', //page(function)
			 'items_per_page' => 15,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );

			$this->template->title = "Recent article";

			// template code
			$this->left=new View("general/left");
			$this->center=new View("article/manage_article"); 
			$this->right=new View("article/article_submenu_right");			
			$this->title_content = "article Management";
			$this->template->content=new View("/template/template3");	 
		 }

		//delete forum
		public function delete_article()
		{

			$id=$this->input->get("id");
			
			$this->result=$this->model->delete_article($id);
			Nauth::setMessage(1,$this->delete_article);
			url::redirect($this->docroot.'admin_article/index/');
			
		}
	        // Search article
	        public function commonsearch()
		{
                        
		        $search_value=html::specialchars($this->input->get("search_value"));
			if($search_value == '')
			{
                		$this->session->set("Emsg","Search Field is empty......");
                		url::redirect($this->docroot.'admin_article/');				
			}
			$this->all_category=$this->model->all_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=10*($page_no-1); 
			$this->total=$this->model->get_search_article_count($search_value); 
			//all records are stored in this variable
			$this->template->get_article=$this->model->get_search_article($search_value,$offset,10);
			//no of records count
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_article', //our controller/function(page)
			 'uri_segment'    => 'commonsearch', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );

 			// template code
        		$this->template->title = "Search Result";
			$this->left=new View("general/left");
			$this->center=new View("article/manage_article"); 
			$this->right=new View("article/article_submenu_right");			
			$this->title_content = "article Search Result";
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
			url::redirect($this->docroot.'admin_article/manage_category/');
			}

			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=15*($page_no-1); 
			$this->article_category_count=$this->model->article_category_count();
			//all records are stored in this variable
			$this->result=$this->model->get_article_category($offset,15);
			//no of records count

			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_article', //our controller/function(page)
			 'uri_segment'    => 'manage_category', //page(function)
			 'items_per_page' => 15,
			 'total_items'    => $this->article_category_count,
			 'style'         => 'classic' )
			 );

			$this->template->title = "article Category Management";

			// template code
			$this->left=new View("general/left");
			$this->center=new View("article/manage_article_category");
			$this->right=new View("article/article_submenu_right");			
			$this->title_content = "article Category Management";
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
			url::redirect($this->docroot.'admin_article/manage_category/');
			
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
					
					url::redirect($this->docroot.'admin_article');
				}
			}
			else
			{
				url::redirect($this->docroot);
			}
		}


}
