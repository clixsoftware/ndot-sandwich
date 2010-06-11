<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_news_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{ 
		Nauth::is_login();
		parent::__construct();
		 if($this->usertype == -1 || $this->usertype == -2 ){ 
			if($this->usertype == -2){
				$user_module = $this->session->get("u_mod");
				if(!in_array(11, $user_module)){
					url::redirect($this->docroot."admin");
					die();
				}
			}
		}
		else{
			url::redirect($this->docroot."profile");
			die();
		}
		$this->module="news";
		
		$this->model=new Admin_news_Model();
		
		$mes = Kohana::config('users_config.session_message');
		$this->add_news = $mes["add_news"];
		$this->add_cat = $mes["add_category"]; 
		$this->del_news = $mes["delete_news"];
		$this->user_id = $this->session->get('userid');
		
		$this->admin_model = new Admin_Model();
		$this->get_module_permission = $this->admin_model->get_module_permission(11);
		
		if(count($this->get_module_permission) > 0){
			$this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}

	}

	 public function index()
	 { 
		$this->template->title="Add News";
		$del=$this->input->get("del");
		$id=$this->input->get("id");

		if($del)
		{
			$this->delete=$this->model->delete_news($id);
			Nauth::setMessage(1,$this->del_news);
			url::redirect($this->docroot."admin_news");
		}
		
		$this->category=$this->model->get_category();
		//manage all news
		$this->get_news=$this->model->get_news();
		if($_POST)
		{ 
			$id=$this->input->post("news_id");
			$type=$this->input->post("type");
			$title=$this->input->post('title');
			$desc=$this->input->post('desc');
			$photo_name=$_FILES['news_image']['name'];
			$user_id=$this->session->get('userid');
			$category=$this->input->post('category');
			$this->template->news=$this->model->addnews($title,$desc,$category,$type,$id,$photo_name,$user_id);
			url::redirect($this->docroot.'admin_news/index');
		}

		//pagging
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		$offset=10*($page_no-1); 

		$this->template->get_allnews=$this->model->get_allnews();
		//all records are stored in this variable
		$this->template->get_news=$this->model->get_newsp($offset,10);
		
		$this->template->pagination = new Pagination(array
		 (
		 'base_url'       => 'admin_news',
		 'uri_segment'    => 'index',
		 'items_per_page' => 10,
		 'total_items'    => count($this->template->get_allnews),
		 'style'         => 'classic' )
		 ); 

		// template code
		 $this->left=new View("general/left");
		 $this->center=new View("news/news"); 
		 $this->right=new View("news/news_submenu_right");
		 $this->title_content = "News Management";

		 $this->template->content=new View("template/template3");	 
	 }
	
		 
	//edit news
	public function editnews()
	{   
		$id=$this->input->post("news_id");
		$type=$this->input->post("type");
		$title=$this->input->post('title');
		$desc=$this->input->post('desc');
		$photo_name=$_FILES['news_image']['name'];
		$user_id=$this->session->get('userid');
		$category=$this->input->post('category');
		$this->template->editnews=$this->model->editnews($title,$desc,$category,$type,$id,$photo_name,$user_id);
		url::redirect($this->docroot.'admin_news/index');
	} 
	//add category
	public function addcat()
	{
		if($_POST)
		{
			$category = html::specialchars($this->input->post('category'));
			$this->template->addcat=$this->model->addcat($category);
			Nauth::setMessage(1,$this->add_cat);
			url::redirect($this->docroot.'admin_news/addcat');
		}
		
		$del=$this->input->get("del"); 
		$id=$this->input->get("id");
		
		if($del)
		{
			$this->delete=$this->model->delete_category($id);
			$this->session->set("Msg","category has been Deleted");
			url::redirect($this->docroot."admin_news/addcat");
		}	
			
		$this->category=$this->model->get_category();
		$this->template->title="Edit News Category";
		$this->left=new View("general/left");
		$this->center=new View("/news/edit_category");
		 $this->right=new View("news/news_submenu_right");			
		$this->title_content = "News Management";
		$this->template->content=new View("template/template3");
	   
	} 
	
	//edit category
	public function editcat()
	{   
		$id=$this->input->post("category_id");
		$category=html::specialchars($this->input->post('category'));
		$this->template->editcat=$this->model->editcat($category,$id);
		url::redirect($this->docroot.'admin_news/addcat');  
	} 
}
