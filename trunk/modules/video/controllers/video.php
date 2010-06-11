<?php defined('SYSPATH') OR die('No direct access allowed.');
	class Video_Controller extends Website_Controller {
	 
		const ALLOW_PRODUCTION = FALSE;
		public $template = 'template/template';
		public function __construct()
		{
			parent::__construct();
			$this->module = "video";
			Nauth::is_login("video");
			if(!in_array($this->module, $this->session->get("enable_module"))) {
				url::redirect($this->docroot."profile");
				die();
			}
			$this->profile = new Profile_Model();
			$this->model = new video_Model();
			$this->user_id = $this->session->get('userid');
			$mes = Kohana::config('users_config.session_message');
			$user_id = $this->session->get('userid');
			$this->add_comment = $mes["add_comment"];
			$this->page_notfound = $mes["notfound"];
			$this->delete_comment = $mes["delete_comment"];
			$this->not_authro = $mes["noacces"];
		}
		public function index()
		{ 
		    $user_id = $this->input->get("uid");
			if(empty($user_id)){
				$user_id = $this->user_id;
			}
			$this->profile_info = $this->profile->profile_info($user_id);
			$this->find_frnd_not =  $this->profile->find_frnd_not($user_id,$this->userid,0);
			
			$this->template->get_pop_videos = $this->model->get_popular_videos(0,3);
			$this->get_category = $this->model->get_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no ==0 || $page_no == 'index')
			$page_no = 1;
			$offset = 10*($page_no-1); 
			$this->template->get_allvideos = $this->model->get_allvideos(); 
			$this->template->get_videos = $this->model->get_videos($offset,10);
			$this->template->pagination1 = new Pagination(array
			 (					
				 'base_url'       => 'video', //our controller/function(page)
				 'uri_segment'    => 'index', //page(function)
				 'items_per_page' => 10,
				 'total_items'    => count($this->template->get_allvideos),
				 'style'         => 'classic' 
			 ));
			$this->template->title = "Recent Videos";
			$this->left = new View("template/left_menu");
			$this->right = new View("video_rightmenu");
			$this->center = new View("video");
			$this->title_content = "Recent Videos";
			$this->template->content=new View("/template/template3");
			
		}
		//category
        public function category()
        {
			$this->get_category=$this->model->get_category();
        		$this->template->get_pop_videos=$this->model->get_popular_videos(0,3);
			$category_id= $this->input->get('cat'); 
			$category_name= urldecode($this->input->get('cat_name')); 			
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='category')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->get_videos=$this->model->video_cat($category_id,$offset,10);
			$this->template->get_allvideos=$this->model->get_category_count($category_id);

			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'category', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );   

			//template codes
			$this->template->title = "Videos";
                        $this->left=new View("template/left_menu");
			$this->right=new View("video_rightmenu");
			$this->center=new View("video");
			$this->title_content = $category_name;
			$this->template->content=new View("/template/template3");
			
        }

  		 public function myvideo()
   		 {
   		        if(!empty($this->user_id))
		        {
       			$this->get_category=$this->model->get_category();
 				$this->template->get_pop_videos=$this->model->get_popular_videos(0,3);
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 0 to 10 
			$offset=10*($page_no-1); 
			$this->template->get_allvideos=$this->model->get_allvideos($this->user_id);
			//all records are stored in this variable
			$this->template->get_videos=$this->model->get_videos($offset,10,$this->user_id);
			//no of records count
			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'myvideo', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );

			// template code
			$this->template->title = "My Videos";
			$this->left=new View("template/left_menu");
			$this->center=new View("video");
			$this->right=new View("video_rightmenu");
			$this->title_content = "My Videos";
			$this->template->content=new View("/template/template3");
			}
			else
			{
              		url::redirect($this->docroot);			
			}
	  	 }


	 public function popularvideos()
   	 {
   	                if(!empty($this->user_id))
		        {
       			$this->get_category=$this->model->get_category();
   			$this->template->get_pop_videos=$this->model->get_popular_videos(0,3);
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 0 to 10 
			$offset=10*($page_no-1); 
			$this->template->get_allvideos=$this->model->get_allvideos();
			//all records are stored in this variable
			$this->template->get_videos=$this->model->get_popular_videos($offset,10);
			//no of records count
			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'popularvideos', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );

			// template code
			$this->template->title = "Popular Videos";
			$this->left=new View("template/left_menu");
			$this->center=new View("video");
			$this->right=new View("video_rightmenu");
			$this->title_content = "Popular Videos";
			$this->template->content=new View("/template/template3");
			}
			else
			{
              		url::redirect($this->docroot);			
			}
  	 }

	// Commen Search
	public function commonsearch()
	{ 
	                if(!empty($this->user_id))
		        {
			$search_value=html::specialchars($this->input->get("search_value"));
			$search_type=html::specialchars($this->input->get("search_type"));
			$this->value = $search_value;
			if($search_value == '')
			{
                		$this->session->set("Emsg","Search Field is empty......");
                		url::redirect($this->docroot.'video/');				
			}
       			$this->get_category=$this->model->get_category();
			$this->template->get_pop_videos=$this->model->get_popular_videos(0,3);
			$this->template->profile_info=$this->profile->profile_info($this->userid);
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='commonsearch')
			$page_no = 1;
			//offset value from 0 to 10 
			$offset=10*($page_no-1); 
			$this->template->get_allvideos=$this->model->get_allsearchvideos($search_value,$search_type,$this->userid); 
			//all records are stored in this variable
			$this->template->get_videos=$this->model->get_searchvideos($offset,10,$search_value,$search_type);
			//no of records count
			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'commonsearch', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );
			// template code
			$this->template->title = "Videos";
			$this->left=new View("template/left_menu");
			$this->center=new View("video");
			$this->right=new View("video_rightmenu");
			$this->title_content = "Videos Search Result";
			$this->template->content=new View("/template/template3");
			}
			else
			{
              		url::redirect($this->docroot);			
			}
		
	}
 	  public function createvideo()
  	 {  		
  	                if(!empty($this->user_id))
		        {
			if($_POST)
			{
			        $url=$this->input->post("url");
			        $category = $this->input->post("category");
			        $check_url = explode('?',$url);
			                if($check_url[0] != 'http://www.youtube.com/watch' ) 
			                { 
                        		$this->session->set("Emsg","Invalid Video Url.. Enter Valid Url");
                        		url::redirect($this->docroot.'video/createvideo');			
			                } 
			        $this->template->add_video=$this->model->add_video($url,$category);
			  }
			  $this->template->get_category = $this->model->get_category();
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 0 to 10 
			$offset=10*($page_no-1); 
			$this->template->get_allvideos=$this->model->get_allvideos(); 
			//all records are stored in this variable
			$this->template->get_videos=$this->model->get_videos($offset,10);
			//no of records count
			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'createvideo', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );
			
			// template code
			$this->template->title = "Upload Videos";
			$this->left=new View("template/left_menu");
			$this->right=new View("createvideo");
			$this->title_content = "Upload Videos";
			$this->template->content=new View("/template/template2");
			}
			else
			{
              		url::redirect($this->docroot);			
			}
   	} 
	
		//edit Videos
	  	public function edit_video()
	   	{   
		if(!empty($this->user_id))
		{
		$title = html::specialchars( $this->input->post("video_title"));
		$desc=html::specialchars($this->input->post("desc"));
		//$emb_code=$this->input->post("emb_code");
		$video_id=$this->input->post("video_id"); 
		$this->template->edit_video=$this->model->edit_video($title,$desc,$video_id);
		$this->session->set("Msg","Video has been Edited");
		url::redirect($this->docroot.'video');
		}
			else
			{
              		url::redirect($this->docroot);			
			}
		   
	 	} 
	 	//Delete Videos
	  	public function delete_video()
	   	{   
	   	        if(!empty($this->user_id))
		        {
			$id=$this->input->get("id");
			$this->delete=$this->model->delete_video($id);
						
	                            if($this->delete)
	                            {
                                        $this->session->set("Msg","Video has been Deleted");
                                        url::redirect($this->docroot."video/myvideo");
	                            }
	                            else
	                            {
	                                    Nauth::setMessage(-1,$this->not_authro);
	                                    url::redirect($this->docroot.'video/');
	                            }
	                 }
			else
			{
              		url::redirect($this->docroot);			
			}
						   
	 	} 

                /* function for video viewed   */
                public function upd_video_view()
                {
                $video_id=$this->input->get("video_id"); 
                $this->upd_video_view=$this->model->upd_video_view($video_id);
                url::redirect('/video/view_video?video_id='.$video_id);
                }
                
                
		//Full view 
	  	public function view_video()
	   	{   
	   	        if(!empty($this->user_id))
		         {
		                //$video_id=$_REQUEST['video_id']; echo $video_id; exit;
                                $video_id=$this->input->get("video_id"); 
			        $this->show_video=$this->model->show_video($video_id);
      			         //pagination video comments
			         $page_no=$this->uri->last_segment();
			         if($page_no==0 || $page_no=='view_video')
			         $page_no = 1;
			         $offset=10*($page_no-1);
			        
			         //post the comments
			         if($_POST)
			         {
				         $type_id = $this->input->post('type_id');
		                         $redirect_url = $this->input->post('redirect_url');
			                 $desc= html::specialchars($this->input->post('desc'));
			                 common::post_comments($this->module."_comments",$type_id,$desc); //post the comments using common function 
		                         url::redirect(''.$redirect_url.'');
			         }

			         if(count($this->show_video))
			         { 
			                 $this->related_videos = $this->model->relatedvideos($this->show_video['mysql_fetch_object']->cat_id,$video_id);
			                // template code
			                $this->template->title = htmlspecialchars_decode($this->show_video['mysql_fetch_object']->video_title);
			                $this->left=new View("template/left_menu");
			                $this->right=new View("video_view");
			                $this->title_content = htmlspecialchars_decode($this->show_video['mysql_fetch_object']->video_title);
			                $this->template->content=new View("/template/template2");
			         }
			         else
			         {
                                          Nauth::setMessage(-1,$this->page_notfound);
                        		 url::redirect($this->docroot.'video/'); 
			         }
			 }
			else
			{
              		url::redirect($this->docroot);			
			}

   
	 	}  
	 	
                  public function friends_videos()
        	 {
   	                if(!empty($this->user_id))
		        {
		        $this->get_category=$this->model->get_category();
			$this->template->get_pop_videos=$this->model->get_popular_videos(0,3);
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 0 to 10 
			$offset=10*($page_no-1); 
			$this->template->get_allvideos=$this->model->get_allfriendsvideos();
			//all records are stored in this variable
			$this->template->get_videos=$this->model->get_friends_videos($offset,10);
			//no of records count
			$this->template->pagination1 = new Pagination(array
			 (					
			 'base_url'       => 'video', //our controller/function(page)
			 'uri_segment'    => 'friends_videos', //page(function)
			 'items_per_page' => 10,
			 'total_items'    => count($this->template->get_allvideos),
			 'style'         => 'classic' )
			 );

			// template code
			$this->template->title = "Friends Videos";
			$this->left=new View("template/left_menu");
			$this->center=new View("video");
			$this->right=new View("video_rightmenu");
			$this->title_content = "Friends Videos";
			$this->template->content=new View("/template/template3");
			}
			else
			{
              		url::redirect($this->docroot);			
			}
  	 }

	 	
	 	
	public function send_mail()
	{  
	        if(!empty($this->user_id))
		  {
		        $to=$this->input->post('to');
		        $msg=$this->input->post('msg');
		        $video_id=$this->input->post('video_id');
		        //$video_url=$this->input->post('video_url');
		        $this->get_mail = $this->model->getmail($this->user_id);
		        $from = $this->get_mail["mysql_fetch_array"]->email;
		        $subject = $this->get_mail["mysql_fetch_array"]->name." Shared video for u..!";
		
		        // To send HTML mail, the Content-type header must be set
		        $headers  = 'MIME-Version: 1.0' . "\r\n";
		        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		        // Additional headers
		        $headers .= 'From:'.$from.'' . "\r\n";
		        $headers .= 'Cc: '.$from.'' . "\r\n";
		        $headers .= 'Bcc: '.$from.'' . "\r\n";
		        if(mail($to, $subject,$msg, $headers))
		        { 
                                $this->session->set("Msg","Mail Send Successfully");
                                url::redirect($this->docroot.'video/view_video/?video_id='.$video_id.'');
		        }
		        else
		        {
                                $this->session->set("Emsg","Mail Sendind Failed");
                                url::redirect($this->docroot.'video/view_video/?video_id='.$video_id);
		        } 
		   }
			else
			{
              		url::redirect($this->docroot);			
			}
				
	}
	public function delete_comment()
	{
		$cid = $this->input->get('cid');
		$type_id = $this->input->get('type_id');
		$url = $this->input->get('url');
		common::delete_comment($this->module."_comments",$type_id,$cid);
		url::redirect(''.$url.'');
	}
	public function __call($method, $arguments)
	{
		$this->auto_render = FALSE;
		echo 'This text is generated by __call. If you expected the index page, you need to use: forum/index/'.substr(Router::$current_uri, 8);
	}
}
