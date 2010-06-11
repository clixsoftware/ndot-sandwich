<?php defined('SYSPATH') OR die('No direct access allowed.');
class Forum_Controller extends Website_Controller {
	const ALLOW_PRODUCTION = FALSE;
	public $template = 'template/template';
	
	public function __construct()
	{
		parent::__construct();
		$this->module = "forum";
		Nauth::module_login($this->module);
		
		$this->model=new Forum_Model();
		if(!in_array("forum", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."profile");
			die();
		}
		$mes = Kohana::config('users_config.session_message');
		$this->add_forum = $mes["add_forum"];
		$this->delete_forum = $mes["delete_forum"];
		$this->update_forum = $mes["update_forum"];
		$this->add_comment = $mes["add_comment"];
		$this->delete_comment = $mes["delete_comment"];
		$this->add_reply = $mes["add_reply"];
		$this->delete_reply = $mes["delete_reply"];
		$this->not_authro = $mes["noacces"];
		$this->page_notfound = $mes["notfound"];
	}
	
	//Home page fro forums
	public function index()
	{ 
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
		$this->total_admin_user=count($this->cout);
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'index', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "Recent Discussions";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("forum_content");
		$this->title_content = "Recent Discussions";
		$this->template->content=new View("/template/template2");
	}
	//delete the forum
	public function delete()
	{
		Nauth::is_login();
		$id=$this->input->get("fid");
		$this->template->delete = $this->model->delete_forum($id);
		if($this->template->delete){
			Nauth::setMessage(1,$this->delete_forum);
			url::redirect($this->docroot.'forum/myforums/');
		}
		else{
			Nauth::setMessage(-1, $this->not_authro);
			url::redirect($this->docroot.'forum/myforums/');
		}
	}
    //delete forum
   	public function delete_discussion()
   	{
	    Nauth::is_login();
	    $cid=$this->input->get('cid');
	    $title = $this->input->get('title');
	    $fid = $this->input->get('fid');
	   
	    $this->delete = $this->model->delete_comment($cid,$fid);
	    if($this->delete){
			Nauth::setMessage(1,$this->delete_reply);
			url::redirect($this->docroot.'forum/view/'.url::title($title).'_'.$fid);
	    }	    
	}
	
	//edit forum discussion
	public function edit()
	{
		Nauth::is_login();
		$fid=$this->input->get("id");
		$this->edit_forum=$this->model->get_edit_forum($fid);
		$this->result=$this->model->get_category();
		//post
		if($_POST)
		{
			$fid=$this->input->post("id");
			$title=html::specialchars($this->input->post("topic"));
			$description=html::specialchars($this->input->post("topic_desc"));
			$category=$this->input->post("category");
			$this->result=$this->model->update_forum($fid,$title,$category,$description);
			Nauth::setMessage(1,$this->update_forum);
			url::redirect($this->docroot.'forum/view/'.url::title($title).'_'.$fid);
		}


		$this->template->title = "Create New Discussion";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("edit_forum");
		$this->title_content = "Edit Discussion";
		$this->template->content=new View("/template/template2");
	}

	//add new discussion

	public function add()
	{
		Nauth::is_login(); 
		$this->result=$this->model->get_category();
		if($_POST){
			$title=html::specialchars($this->input->post("topic"));
			$description=html::specialchars($this->input->post("topic_desc"));
			$category=$this->input->post("category");
			$this->result=$this->model->create_forum($title,$category,$description,$this->userid);
			
		}
		$this->template->title = "Create New Discussion";
		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("new_forum");
		$this->title_content = "Create New Discussion";
		$this->template->content=new View("/template/template2");
	}
	

	//function to update hit count
	public function updatehit()
	{
		$title = $this->uri->last_segment();
	        $id = end(explode('_',$title));
	
		$this->resul=$this->model->update_hit($id);
		
		url::redirect($this->docroot."forum/view/".$title);
	}
		
	//function to for forum discussion
	public function view()
	{
		//get the forum id
		$this->title = $this->uri->last_segment();
	        $this->forum_id =end(explode('_',$this->title));
 
 		$this->get_forum_info=$this->model->get_forum_information($this->forum_id);
		//pagenation
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
			
		//offset value from 3 to 6 
		$offset=10*($page_no-1); 
		$this->cout=$this->model->count_test2($this->forum_id);
		$this->get_comment=$this->model->discuss($this->forum_id,$offset,10);
		$this->template->pagination = new Pagination(array
		 (
		 'base_url'       => 'forum',//our controller/function(page)
		 'uri_segment'    => 'view', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 ); 
		 if(count($this->get_forum_info))
		 {
		 		// template code
		$this->template->title = "Discussion ".$this->get_forum_info["mysql_fetch_array"]->topic;
		$this->left=new View("forum_leftmenu");
		$this->right=new View("view");
		$this->title_content = $this->get_forum_info["mysql_fetch_array"]->topic;
		$this->template->content=new View("/template/template2");
		 }
		 else{
			Nauth::setMessage(-1,$this->page_notfound);
			url::redirect($this->docroot.'forum/');   
		}
	}
	
	//function to post comments
	public function postcomment()
	{
		$last_segment = $this->input->post("last_segment");
		$id = $this->input->post("id");
		Nauth::is_login("forum/view/".$last_segment);
		$subject=html::specialchars($this->input->post("subject"));
		$comments=html::specialchars($this->input->post("comments"));
		$this->result=$this->model->post_comment($subject,$id,$comments,$this->userid);
		$this->resul=$this->model->updatepost($id);
		$this->re=$this->model->updatedate($id);
		Nauth::setMessage(1,$this->add_reply);
		url::redirect($this->docroot."forum/view/".$last_segment);
	}
	
	//my forums
	public function myforums()
	{ 
		Nauth::is_login();
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='myforums')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->cout=$this->model->count_myforums($this->userid);

		//all records are stored in this variable
		$this->result=$this->model->get_myforums($this->userid,$offset,15);

		//no of records count
		$this->total_admin_user=count($this->cout);
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'myforums', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "My Discussions";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("myforum");
		$this->title_content = "My Discussions";
		$this->template->content=new View("/template/template2");
	}
	//popular forums
	public function popular()
	{ 
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='popular')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->cout=$this->model->count_popular();

		//all records are stored in this variable
		$this->result=$this->model->get_popular($offset,15);
		//no of records count
		$this->total_admin_user=count($this->cout);
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'popular', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "Popular Discussions";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("forum_content");
		$this->title_content = "Popular Discussions";
		$this->template->content=new View("/template/template2");
	}

	//search forums
	public function search()
	{ 
		$category_id=$this->input->get("id");
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='search')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=15*($page_no-1); 
		$this->cout=$this->model->count_search($category_id);

		//all records are stored in this variable
		$this->result=$this->model->get_search($category_id,$offset,15);

		
		
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'search', //page(function)
		 'items_per_page' => 15,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "Search Discussions";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("forum_content");
		$this->title_content = "Search Discussion Forums";
		$this->template->content=new View("/template/template2");
	}
	
	//forums category
	public function category()
	{ 
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='category')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=10*($page_no-1); 
		$this->cout=$this->model->count_all_category();

		//all records are stored in this variable
		$this->result=$this->model->get_all_category($offset,10);

		
		
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'category', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "Discussion Categories";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("forum_category");
		$this->title_content = "Discussion Categories";
		$this->template->content=new View("/template/template2");
	}
	//search forums
	public function commonsearch()
	{ 
	    $this->category = $this->model->get_category();
		$serach_value=html::specialchars($this->input->get("search_value"));
		$this->value = $serach_value;
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='search')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=10*($page_no-1); 
		$this->cout=$this->model->count_common_search($serach_value,"category");

		//all records are stored in this variable
		$this->result=$this->model->get_common_search($serach_value,"category",$offset,10);

		
		
		$this->template->pagination = new Pagination(array
		 (					
		 'base_url'       => 'forum', //our controller/function(page)
		 'uri_segment'    => 'commonsearch', //page(function)
		 'items_per_page' => 10,
		 'total_items'    => count($this->cout),
		 'style'         => 'classic' )
		 );

		$this->template->title = "Search Discussions";

		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("search_forum");
		$this->title_content = "Search Discussions";
		$this->template->content=new View("/template/template2");
	}
	//search 
	public function advanced()
	{ 
	    $this->category = $this->model->get_category();
		$serach_value = html::specialchars($this->input->get("search_text"));
		$this->value = $serach_value; 
		$search_category = $this->input->get("search_category");
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='search')
		$page_no = 1;

		//offset value from 3 to 6 
		$offset=10*($page_no-1); 
		$this->cout=$this->model->count_common_search($serach_value,$search_category);

		//all records are stored in this variable
		$this->result=$this->model->get_common_search($serach_value,$search_category,$offset,10);
		$this->template->pagination = new Pagination(array
		 (					
			 'base_url'       => 'forum', //our controller/function(page)
			 'uri_segment'    => 'commonsearch', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->cout),
			 'style'         => 'classic' )
		 );

		$this->template->title = "Search Discussions";
		// template code
		$this->left=new View("forum_leftmenu");
		$this->right=new View("search_forum");
		$this->title_content = "Search Discussions";
		$this->template->content=new View("/template/template2");
	}
}
