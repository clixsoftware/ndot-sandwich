<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the question and answers management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 N dot.in
 */


class Admin_answers_Controller extends Website_Controller 
{

		public $template = 'template/template';
		public function __construct()
		{
			parent::__construct();
			$this->module = "answers";
			Nauth::is_login();
			if(!in_array($this->module, $this->session->get("enable_module"))) {
			
				url::redirect($this->docroot."admin");
				die();
			}
			 permission::check($this->module);
			 $this->model=new Admin_answers_Model();
			 /*User response messages*/
  			 $mes=Kohana::config('users_config.session_message');
			 $this->answer_delete=$mes["answer_delete"];
			 $this->question_delete=$mes["question_delete"];
			 $this->update_change=$mes["update_change"];
			 $this->delete_category=$mes["delete_category"];
			 $this->add_category=$mes["add_category"];             		 
			 $this->update_category=$mes["update_category"];
			 
			 //get the answers modules permission
			 $this->admin_model = new Admin_Model();
			 $this->get_module_permission = $this->admin_model->get_module_permission(2);
                        
			 if(count($this->get_module_permission) > 0)
			 {
			       $this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			       $this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			       $this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			       $this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
			 }
			

		 }

		 //Answers management front page
		 public function index()
		 {
			
			$this->template->title="Manage Answer";

			//pagging
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			$offset=10*($page_no-1); 
			$this->template->manage_answer=$this->model->manage_answer($offset,10);
			
			$this->total_admin_answer = $this->model->count_answer();

			$this->template->pagination = new Pagination(array
			 (
			 'base_url'       => 'admin_answers',
			 'uri_segment'    => 'index',
			 'items_per_page' => 10,
			 'total_items'    => $this->model->count_answer(),
			 'style'         => 'classic' )
			 ); 

	  		 // template code
			 $this->left=new View("general/left");
			 $this->center = new View("answers/manage_answer");
			 $this->right = new View("answers/answers_submenu");
			 $this->title_content = "Manage Answers";
			 $this->template->content=new View("template/template3");
 
		 }

		//manage question
		public function manage_question()
		{
	
			$this->template->title="Manage Question";
	
			//pagging
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			$offset=10*($page_no-1); 
			$this->template->manage_question=$this->model->manage_question($offset,10);
			$this->total_admin_question=$this->model->count_question();
			$this->template->pagination = new Pagination(array
			 (
			 'base_url'       => 'admin_answers',
			 'uri_segment'    => 'manage_question',
			 'items_per_page' => 10,
			 'total_items'    => $this->model->count_question(),
			 'style'         => 'classic' )
			 ); 
		 // template code
		 $this->left = new View("general/left");
		 $this->center = new View("answers/manage_question");
		 $this->right = new View("answers/answers_submenu");
		 $this->title_content = "Manage Questions";
		 $this->template->content=new View("template/template3");

		}
	
		//delete answer
		public function delete_question()
		{
		
		        $id=$this->input->get("id");
		        $this->template->title="Delete Question";
		        $this->template->delete_answer=$this->model->delete_question($id);
		        Nauth::setMessage(1,$this->question_delete);
		        url::redirect($this->docroot.'admin_answers/manage_question/');
		}

		//question access
		public function question_access()
		{
		
		        $this->template->title="Question Access";
		        $status=$this->input->get('status');
		        $id=$this->input->get('id');

		        $this->model->set_question_access($status,$id);
		        Nauth::setMessage(1,$this->update_change);
		        url::redirect($this->docroot.'admin_answers/manage_question');
		}

		//answer access
		public function answer_access()
		{
		        $this->index();
		        $this->template->title="Answer Access";
		        $status=$this->input->get('status');
		        $id=$this->input->get('id');
		        $this->model->set_answer_access($status,$id);
		        Nauth::setMessage(1,$this->update_change);
		        url::redirect($this->docroot.'admin_answers/');
		}

		//delete answer
		public function delete_answer()
		{
		        $aid=$this->input->get("aid");
		        $qid=$this->input->get("qid");
		        
		        $this->template->title="Delete Answer";
		        $this->template->delete_answer=$this->model->delete_answer($aid,$qid);
		        Nauth::setMessage(1,$this->answer_delete);
		        url::redirect($this->docroot.'admin_answers/');
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
			url::redirect($this->docroot.'admin_answers/manage_category/');
			}
			

			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 3 to 6 
			$offset=15*($page_no-1); 
			$this->blog_category_count=$this->model->answers_category_count();
			//all records are stored in this variable
			$this->result=$this->model->get_answers_category($offset,15);
			//no of records count

			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'admin_answers', //our controller/function(page)
			 'uri_segment'    => 'manage_category', //page(function)
			 'items_per_page' => 15,
			 'total_items'    => $this->blog_category_count,
			 'style'         => 'classic' )
			 );

			$this->template->title = "Answers Category Management";

			// template code
			$this->left = new View("general/left");
			$this->center = new View("answers/manage_category");
			$this->right = new View("answers/answers_submenu");
			$this->title_content = "Answers Category Management";
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
			url::redirect($this->docroot.'admin_answers/manage_category/');
			
		}
                
		public function commonsearch()
		{
			$this->categories=$this->model->all_category();
			$search_value=html::specialchars($this->input->get('search_value'));
			//pagging
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='commansearch')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->total=$this->model->get_search_operation_count($search_value,'','');
			$this->template->manage_answer=$this->model->search_operation($search_value,'',$offset,$page_no, 10,'');
				
			$this->template->pagination = new Pagination(array
			(
			 'base_url'       => 'answers_admin',
			 'uri_segment'    =>'commonsearch',
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			);
	
			$this->template->title = "Search Results";
			// template code
			$this->left = new View("general/left");
			
			$this->center=new View("answers/view_search");
			$this->right = new View("answers/answers_submenu");
	
			$this->title_content = "Search Results (".$this->total.")";
	
			$this->template->content=new View("/template/template3");
		}	 

}
