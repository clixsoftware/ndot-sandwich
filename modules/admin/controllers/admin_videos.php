<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     M.BalaMurugan
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_videos_Controller extends Website_Controller 
{
	 public $template = 'template/template';
	 public function __construct()
	 {
		parent::__construct();
		Nauth::is_login();
		if($this->usertype == -1 || $this->usertype == -2 ){
			if($this->usertype == -2){
				$user_module = $this->session->get("u_mod");
				if(!in_array(13, $user_module)){
					url::redirect($this->docroot."admin");
					die();
				}
			}
		}
		else{
			url::redirect($this->docroot."profile");
			die();
		}
		
		$this->model = new Admin_videos_Model();
		$this->profile = new Profile_Model();

		$mes = Kohana::config('users_config.session_message');
		$this->module = "videos";
		$this->admin_model = new Admin_Model();
		$this->get_module_permission = $this->admin_model->get_module_permission(13);
					
		if(count($this->get_module_permission) > 0){
			$this->add_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission = $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}
	}

	 public function index()
	 {
		$this->template->profile_info=$this->profile->profile_info($this->userid);
		//manage all videos
		//pagination
		$this->template->get_cat = $this->model->get_category(); 

		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 0 to 10 
		$offset=10*($page_no-1); 
		$this->template->get_allvideos = $this->model->get_allvideos();
		//all records are stored in this variable
		$this->template->get_videos=$this->model->get_videos($offset,10);
		//no of records count
		$this->template->pagination1 = new Pagination(array
		 (					
		 'base_url'       => 'admin_videos', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->template->get_allvideos),
		 'style'         => 'classic' )
		 );
		// template code
		$this->template->title = "Videos";
		$this->left=new View("general/left");
		$this->center=new View("videos/videos"); 
		$this->right=new View("videos/videos_submenu_right"); 
		$this->title_content = "Add Videos";
		$this->template->content=new View("/template/template3");	 
		if($_POST)
		{
			$url=$this->input->post("url"); 
				$category = $this->input->post("category");
			$check_url = explode('?',$url);
			if($check_url[0] != 'http://www.youtube.com/watch' ) 
			{ 
				$this->session->set("Emsg","Invalid Video Url.. Enter Valid Url");
				url::redirect($this->docroot.'admin_videos/');			
			} 
			$this->template->add_video=$this->model->add_video($url,$category);
			
		}
	 }

	//edit Videos
	public function edit_video()
	{   
		$title =html::specialchars( $this->input->post("video_title"));
		$desc=html::specialchars($this->input->post("desc"));
		//$emb_code=$this->input->post("emb_code");
		$video_id=$this->input->post("video_id"); 
		$this->template->edit_video=$this->model->edit_video($title,$desc,$video_id);
		$this->session->set("Msg","Video has been Edited");
		url::redirect($this->docroot.'admin_videos');
	   
	} 
	//Delete Videos
	public function delete_video()
	{   
		$id=$this->input->get("id");
		$this->delete=$this->model->delete_video($id);
		$this->session->set("Msg","Video has been Deleted");
		url::redirect($this->docroot."admin_videos/");
		
	   
	} 
	//Block/unblock Videos
	public function video_access()
	{   
		$id=$this->input->get("id");
		$status=$this->input->get("status");
		$this->block=$this->model->block_video($id,$status);
		if($status)
		 {
			$this->session->set("Msg","Video has been Blocked");
		 } 
		 else
		 {	
			$this->session->set("Msg","Video has been Unblocked");
		 }
		url::redirect($this->docroot."admin_videos/");
		
	   
	} 
	//manage Category
	public function category()
	{ 
		$this->template->get_cate = $this->model->get_category(); 
		if($_POST)	 	        
		{
		 $category = $this->input->post("category");
					$this->template->add_cat=$this->model->add_cat($category);			 
		}
		// template code
		$this->template->title = "Videos Category";
		$this->left=new View("general/left");
		$this->right=new View("videos/videos_submenu_right"); 			
		$this->center=new View("videos/category");
		$this->title_content = "Add Videos Category"; 
		$this->template->content=new View("/template/template3"); 
	
	}
	public function edit_category()
	{
			$category =html::specialchars( $this->input->post("category"));
		$id=html::specialchars($this->input->post("cat_id"));
		$this->template->edit_cat=$this->model->edit_cat($id,$category);
		$this->session->set("Msg","Video Category has been Edited Successfully");
		url::redirect($this->docroot.'admin_videos/category');
	
	}
			//Delete Category
	public function delete_cat()
	{   
		$id=$this->input->get("id");
		$this->delete=$this->model->delete_cat($id);
		$this->session->set("Msg","Video Category has been Deleted Successfully");
		url::redirect($this->docroot."admin_videos/category");
		
	   
	}
	// Commen Search
	public function commonsearch()
	{ 
		$search_value=html::specialchars($this->input->get("search_value")); 
		if($search_value == '')
		{
			$this->session->set("Emsg","Search Field is empty......");
			url::redirect($this->docroot.'admin_videos/');				
		}
		$this->template->get_cat=$this->model->get_category();
		$this->template->profile_info=$this->profile->profile_info($this->userid);
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commonsearch')
		$page_no = 1;
		//offset value from 0 to 10 
		$offset=10*($page_no-1); 
		$this->template->get_allvideos=$this->model->get_allsearchvideos($search_value); 
		//all records are stored in this variable
		$this->template->get_videos=$this->model->get_searchvideos($offset,10,$search_value);
		//no of records count
		$this->template->pagination1 = new Pagination(array
		 (					
			 'base_url'       => 'admin_videos', //our controller/function(page)
			 'uri_segment'    => 'commonsearch', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
		 ); 
		// template code
		$this->template->title = "Videos"; 
		$this->left=new View("general/left"); 
		$this->right=new View("videos/videos_submenu_right"); 			
		$this->center=new View("videos/videos"); 
		$this->title_content = "Videos Search Result";
		$this->template->content=new View("/template/template3");
	}		
}