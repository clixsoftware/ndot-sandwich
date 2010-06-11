<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all Blog controls
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */ 

class Blog_Controller extends Website_Controller
{
 public $template = 'template/template';
 
		public $blogtype = '-1';
		public function __construct()
		{
			parent::__construct();
			$this->module = 'blog';
			Nauth::module_login($this->module);
			
			$this->model = new Blog_Model();
			if(!in_array("blog", $this->session->get("enable_module"))) {
				url::redirect($this->docroot."profile");
				die();
			}
			$this->template->name1 = $this->model->topblogers();
			$this->popular_category = $this->model->popular_category();
		        $mes = Kohana::config('users_config.session_message');
			$this->add_blog = $mes["add_blog"];
			$this->update_blog = $mes["update_blog"];
			$this->delete_blog = $mes["delete_blog"];
			$this->add_comment = $mes["add_comment"];
			$this->delete_comment = $mes["delete_comment"];
			$this->not_authro = $mes["noacces"];
			$this->page_notfound = $mes["notfound"];		
	 }
	 
	 
	 
	 public function index()
     {   

        
	   	$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='blog')
		$page_no = 1;
		$offset=15*($page_no-1);

		$this->template->get_blog=$this->model->showblog($offset,$page_no, 15);

		$this->total=$this->model->get_blog_count();
	
		$this->template->pagination = new Pagination(array
		 (
		 'base_url'       => 'blog',
		 'uri_segment'    =>'index',
		 'items_per_page' => 15,
		 'total_items'    => $this->total,
		 'style'         => 'classic' )
		 );	 
 	  	

		// template code
		$this->template->title = "Recent Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->center=new View("blog_content");
		$this->right=new View("topblog");
		$this->title_content = "Recent Blogs";

		$this->template->content=new View("template/template3");

	 
	 }
	 
	 //popular
   	public function popular()
	{   
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='blog')
		$page_no = 1;
		$offset=15*($page_no-1);
	
		$this->template->get_blog=$this->model->popular_blog($offset,$page_no, 15);
		$this->total=$this->model->get_blog_count();
	
		$this->template->pagination = new Pagination(array
		 (
		 'base_url'       => 'blog',
		 'uri_segment'    =>'index',
		 'items_per_page' => 15,
		 'total_items'    => $this->total,
		 'style'         => 'classic' )
		 );	 
	
	
		// template code
		$this->template->title = "Popular Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->center=new View("blog_content");
		$this->right=new View("topblog");
		$this->title_content = "Popular Blogs";
		$this->template->content=new View("template/template3");

	 
	 }
	  //popular
   	public function friends()
	{   
		Nauth::is_login();
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='friends')
		$page_no = 1;
		$offset=15*($page_no-1);
	
		$this->template->get_blog=$this->model->friends_blog($offset,15);
		$this->total=$this->model->get_friends_blog_count();
	
		$this->template->pagination = new Pagination(array
		 (
		 'base_url'       => 'blog',
		 'uri_segment'    =>'friends',
		 'items_per_page' => 15,
		 'total_items'    => $this->total,
		 'style'         => 'classic' )
		 );	 
	
	
		// template code
		$this->template->title = "Friends Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->center=new View("blog_content");
		$this->right=new View("topblog");
		$this->title_content = "Friends Blogs";
		$this->template->content=new View("template/template3");

	 
	 }
	
	//get the my blogs
   
   	public function myblog()
   	{
       Nauth::is_login();
	   $page_no=$this->uri->last_segment();
	   if($page_no==0 || $page_no=='myblog')
	   $page_no = 1;
	   $offset=15*($page_no-1);
	   
	   $this->template->get_blog=$this->model->myblog($this->userid,$offset,$page_no, 15);
	   $this->total=$this->model->get_myblog_count($this->userid);
	   $this->template->pagination = new Pagination(array
	   (
		 'base_url'       => 'blog',
		 'uri_segment'    =>'myblog',
		 'items_per_page' => 15,
		 'total_items'    => $this->total,
		 'style'         => 'classic' )
	   );	 

	   

	// template code
	$this->template->title = "My Blogs"; 
	$this->left=new View("blog_leftmenu");
	$this->right=new View("myblog");
	$this->title_content = "My Blogs";
	$this->template->content=new View("template/template2");
	 
  	}

	 //create blog
	 public function add()
	 {   
      
	  
	    Nauth::is_login();
	    //get the category list	  
	    $this->category=$this->model->get_blog_category(); 
	    if($_POST)
	    {
 
			$title= html::specialchars($this->input->post('title'));
			$desc= html::specialchars($this->input->post('desc'));	
			$category=$this->input->post('category');
			$this->template->name=$this->model->createblog($this->userid,$title,$desc,$category,$this->blogtype);
			
			
			
	    }	 
	   
		// template code
		$this->template->title = "Create New Blog"; 
		$this->left=new View("blog_leftmenu");
		$this->right=new View("createblog");
		$this->title_content = "Create New Blog";
		$this->template->content=new View("template/template2"); 
	  
	  
   	}

   	//get the blog category wise
    	public function category()
   	{
   	       // $category = $id;
		$category=$this->input->get('id');
		  
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='category')
		$page_no = 1;
		$offset=15*($page_no-1);
	
		 $this->template->get_blog=$this->model->categoryblog($category,$offset,$page_no, 15);
		 $this->total=$this->model->get_category_count($category);
		 $this->template->pagination = new Pagination(array
		 (
			 'base_url'       => 'blog',
			 'uri_segment'    =>'category',
			 'items_per_page' => 15,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );	
	 
	if(count($this->template->get_blog))
	{
	// template code
		$this->template->title = "Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->center = new View("blog_content");
		$this->right=new View("topblog");
		$this->title_content = "Blogs - ".$this->template->get_blog["mysql_fetch_array"]->category_name;
		$this->template->content=new View("template/template3"); 

	}
	else
	{
	         Nauth::setMessage(-1,$this->page_notfound);
		 url::redirect($this->docroot.'blog/');  
	}
		
	}
	
    //get the blog category wise
    public function commonsearch()
   	{ echo '';exit;
		$key=html::specialchars($this->input->get('search_value'));  
		 $this->value = $key; 
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commansearch')
		$page_no = 1;
		$offset=10*($page_no-1);
	
		 $this->template->get_blog=$this->model->get_common_search($key,'category',$offset,10);
		 $this->total=$this->model->count_common_search($key,'category');
		
		 $this->template->pagination = new Pagination(array
		 (
			 'base_url'       => 'blog',
			 'uri_segment'    =>'commonsearch',
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );	
	 
	
		// template code
		$this->template->title = "Search Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->right=new View("manage_blogs");
		$this->title_content = "Search Blogs";
		$this->template->content=new View("template/template2"); 

	} 
	//search
	public function search()
	{
	         //get the category list	  
	        $this->category = $this->model->get_blog_category();  
	        
                $key=html::specialchars($this->input->get('search_text'));
		$this->value = $key;  
                $search_category = $this->input->get("search_category");
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commansearch')
		$page_no = 1;
		$offset=10*($page_no-1);
	
		 $this->template->get_blog=$this->model->get_common_search($key,$search_category,$offset,10);
		 $this->total=$this->model->count_common_search($key,$search_category);
		
		 $this->template->pagination = new Pagination(array
		 (
			 'base_url'       => 'blog',
			 'uri_segment'    =>'commonsearch',
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );	
	 
	 
	        // template code
		$this->template->title = "Search Blogs"; 
		$this->left=new View("blog_leftmenu");
		$this->right=new View("search_blog");
		$this->title_content = "Search Blogs";
		$this->template->content=new View("template/template2"); 
	}
	
        //display the full blog information with comments
   	public function view()
	{
		 //$blogid = $id;
                 //$blogid=$this->input->get('bid');
                 $title = $this->uri->last_segment();
	         $blogid = end(explode('_',$title));
		   
		 $this->template->name=$this->model->viewblog($blogid);
		   
		 //pagination blog comments
		 $page_no=$this->uri->last_segment();
		 if($page_no==0 || $page_no=='view')
		 $page_no = 1;
		 $offset=15*($page_no-1);

		 //post the comments
		 if($_POST)
		 {
			 $type_id = $this->input->post('type_id');
			 $redirect_url = $this->input->post('redirect_url');
			 $desc= html::specialchars($this->input->post('desc'));
			 common::post_comments($this->module."_comments",$blogid,$desc); //post the comments using common function 
			 url::redirect($redirect_url);
		 }
		 
		
                if(count($this->template->name))
                {
                        // template code
	                $this->template->title = "Blogs:".$this->template->name["mysql_fetch_array"]->blog_title; 
	                $this->left=new View("blog_leftmenu");
	                $this->right=new View("blog_view");
	                
	                //$this->right=new View("topblog");
	                $this->title_content = $this->template->name["mysql_fetch_array"]->blog_title;
	                $this->template->content=new View("template/template2"); 
                }
                else
                {
                         Nauth::setMessage(-1,$this->page_notfound);
	                 url::redirect($this->docroot.'blog/');                       
                }


	}
	
   	//edit the blog
  	public function edit()
   	{
	 Nauth::is_login();  
	 $this->category=$this->model->get_blog_category();  

         $blogid =$this->input->get('bid');
	
	 $this->template->edits=$this->model->editblog($blogid);
         if($_POST)
	 {
		 $bid=$this->input->post("bid");
		 $title=$this->input->post('title');
		 $desc=$this->input->post('desc');
		 $category=$this->input->post('category');
		 $this->model->update_blog($bid,$title,$desc,$category);
		 Nauth::setMessage(1,$this->update_blog);
		 url::redirect($this->docroot.'blog/myblog/');
	 }
	
		// template code
		$this->template->title = "Edit Blog"; 
		$this->left=new View("blog_leftmenu");
		$this->right=new View("editblog");
		$this->title_content = "Edit Blog";
		$this->template->content=new View("/template/template2"); 
 
	
	} 
	
	//delete forum
   	public function delete()
   	{
	    
		Nauth::is_login();
	    $blogid=$this->input->get('bid');
	    $this->template->delete = $this->model->delete_blog($blogid);
	    
	    if($this->template->delete)
	    {
	            Nauth::setMessage(1,$this->delete_blog);
	            url::redirect($this->docroot.'blog/myblog/');
	    }
	    else
	    {
	            Nauth::setMessage(-1,$this->not_authro);
	            url::redirect($this->docroot.'blog/myblog/');
	    }
	    
	}
	
        //delete forum
   	public function delete_comment()
   	{
	    Nauth::is_login();
	    $cid=$this->input->get('cid');
	    $type_id=$this->input->get('type_id');
	    $url = $this->input->get('url');
            common::delete_comment($this->module."_comments",$type_id,$cid);
            url::redirect($this->docroot.$url);	    
	}
	
	public function total_blogs()
	{
		if($this->userid != '')
		{
			$userid = $this->input->get('uid');
			if($userid)
			{
				//$this->template->name1 = $this->model->total_blogs($userid);
				$page_no=$this->uri->last_segment();
				if($page_no==0 || $page_no=='commansearch')
				$page_no = 1;
				$offset=10*($page_no-1);
			
				$this->template->total_blogs = $this->model->total_blogs($userid,$offset,10);
				$this->total=$this->model->count_total_blogs($userid);
				
				$this->template->pagination = new Pagination(array
				(
					 'base_url'       => 'blog',
					 'uri_segment'    =>'total_blogs',
					 'items_per_page' => 10,
					 'total_items'    => $this->total,
					 'style'         => 'classic' )
				);
				if(count($this->template->name1) > 0)
				{
					$name = $this->template->name1['mysql_fetch_array']->name;
				}
				else
				{
					$name = '';
				}
				$this->template->title = $name." Blogs";
				$this->left=new View("blog_leftmenu");
				$this->right=new View("top_bloggers");
				$this->title_content = $name." Blogs";
				$this->template->content=new View("/template/template2"); 
			}
			else
			{
				url::redirect($this->docroot.'blog');
			}
			
 
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
	
	public function top_bloggers_list()
	 {
	 	if($this->userid != '')
		{
			$this->template->name1 = $this->model->topblogers();
			$this->template->title = "Bloggers";
			$this->left=new View("blog_leftmenu");
			$this->right=new View("bloggers_list");
			$this->title_content = "Bloggers";
			$this->template->content=new View("/template/template2"); 
		}
		else
		{
			url::redirect($this->docroot);
		}
	 }
}
