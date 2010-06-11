<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */


class Admin_cms_Controller extends Website_Controller 
{
		public $template = 'template/template';
		public function __construct()
		{
			parent::__construct();
			Nauth::is_login();
			if($this->usertype != -1){
				url::redirect($this->docroot."admin");
			}
			$this->model = new Admin_cms_Model();
			$this->user_id = $this->session->get('userid');
			$this->profile = new Profile_Model();
			
			$mes = Kohana::config('users_config.session_message');
			$this->delete_page = $mes["delete_page"];
			$this->create_page = $mes["create_page"];
			$this->edit_page = $mes["edit_page"];
			$this->exists_page = $mes["exists_page"];
			$this->module = "cms";
		}

		 public function index()
		 {
		        if(!empty($this->user_id))
		         {     
		                $this->template->profile_info=$this->profile->profile_info($this->userid);
			        $this->get_moderator_permission=$this->model->get_moderator_permission();
			        foreach($this->get_moderator_permission as $row)
			        {
			        $this->moderator_add=$row->action_add; 
			        $this->moderator_edit=$row->action_edit;
			        $this->moderator_delete=$row->action_delete;
			        $this->moderator_block=$row->action_block;
			
			        }

			        //pagging
			        $page_no=$this->uri->last_segment();
			        if($page_no==0 || $page_no=='index')
			        $page_no = 1;
			        $offset=10*($page_no-1); 
                		$this->template->get_pages=$this->model->get_pages($offset,10);
			        $this->total_cms_pages=$this->model->count_pages(); 
			        $this->template->pagination = new Pagination(array
			         (
			         'base_url'       => 'admin_cms',
			         'uri_segment'    => 'index',
			         'items_per_page' => 10,
			         'total_items'    => count($this->total_cms_pages),
			         'style'         => 'classic' )
			         ); 

			        // template code
			        $this->template->title = "CMS Pages";
			        $this->left=new View("general/left");
			        $this->center=new View("cms/manage_pages");
	        		$this->right=new View("cms/cms_submenu_right");
			        $this->title_content = "Manage Pages";
			        $this->template->content=new View("/template/template3");
			}
			else
			{
                      		url::redirect($this->docroot);			
			}
				 

		 }
		
			 
	 	//edit pages
	  	public function edit_cms()
	   	{       
	   	        if(!empty($this->user_id))
		  {
	   	$cms_id=$this->input->get("id");  
	   	$this->template->profile_info=$this->profile->profile_info($this->userid);
	   	$this->total_cms_pages=$this->model->count_pages($cms_id); 
			if($_POST)
			{
			$title =html::specialchars( trim($this->input->post("title")));
			$desc=html::specialchars($this->input->post("markItUp"));
			$meta=html::specialchars($this->input->post("meta")); 
			$meta_desc=html::specialchars($this->input->post("meta_desc"));
			$cms_id=$this->input->post("cms_id"); 
			$this->template->edit_pages=$this->model->edit_pages($title,$desc,$meta,$cms_id,$meta_desc);
			Nauth::setMessage(1,$this->edit_page);
			url::redirect($this->docroot.'admin_cms');
			
			}
		// template code
		$this->template->title = $this->total_cms_pages["mysql_fetch_array"]->cms_title;
		$this->left=new View("general/left");
		$this->center=new View("cms/edit_pages");
		$this->right=new View("cms/cms_submenu_right");		
		$this->title_content = $this->total_cms_pages["mysql_fetch_array"]->cms_title;
		$this->template->content=new View("/template/template3");
		}
		else
		{
      		url::redirect($this->docroot);			
		}
		   
	 	} 
	 	//create pages
	  	public function create_pages()
	   	{  
                        if(!empty($this->user_id))
                        { 
        	   	$this->template->profile_info=$this->profile->profile_info($this->userid);
       			if($_POST)
			{ 
			$title = html::specialchars($this->input->post("title"));
			$desc=html::specialchars($this->input->post("markItUp"));
			$meta=html::specialchars($this->input->post("meta"));
			$meta_desc=html::specialchars($this->input->post("meta_desc"));
			$cms_id=$this->input->post("cms_id"); 
			$this->template->edit_pages=$this->model->create_pages($title,$desc,$meta,$cms_id,$meta_desc);
		         }
		// template code
		$this->template->title = "Create Pages";
		$this->left=new View("general/left");
		$this->center=new View("cms/create_pages"); 
		$this->right=new View("cms/cms_submenu_right");
		$this->title_content = "Create Pages";
		$this->template->content=new View("/template/template3");
		}
		else
		{
      		url::redirect($this->docroot);			
		}
		   
	 	} 
	  	//Delete Videos
	 	public function delete_page()
	   	{   
                        if(!empty($this->user_id))
                        {

                                $id=$this->input->get("id");
                                $this->delete=$this->model->delete_page($id);
                                Nauth::setMessage(1,$this->delete_page);
                                url::redirect($this->docroot."admin_cms/");
                        }
                        else
                        {
                                 url::redirect($this->docroot);			
                        }
			
		   
	 	} 
	 	/*//Block/unblock Videos
	  	public function video_access()
	   	{   
			$id=$this->input->get("id");
			$status=$this->input->get("status");
			$this->delete=$this->model->block_video($id,$status);
			if($id)
			 {
				$this->session->set("Msg","Video has been Unblocked");
			 } 
			 else
			 {	
				$this->session->set("Msg","Video has been Blocked");
			 }
			url::redirect($this->docroot."admin_videos/");
			
		   
	 	}  */
			
}
