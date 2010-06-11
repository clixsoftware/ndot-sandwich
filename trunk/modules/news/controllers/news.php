 <?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Core
 * @author     Ashoke
 * @copyright  (c) 2010 Ndot.in
 */
class News_Controller extends Website_Controller 
{
		public $template = 'template/template';
		public function __construct()
		{
			parent::__construct();
			$this->module = "news";
			Nauth::module_login($this->module);
			
			$this->model = new News_Model();
			$mes = Kohana::config('users_config.session_message');
			$this->template->title = "News";
			$this->add_comment = $mes["add_comment"];
			$this->delete_comment = $mes["delete_comment"];  
			$this->news_notfound = $mes["news_not_found"]; 
			$this->user_id = $this->session->get('userid');
		}

		public function index($id='',$request_id='')
		{
			$this->template->id=$id;
			if($id==''){
				$id=$this->session->get('userid');
			}
		 	$this->get_category=$this->model->get_category();
			
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->news=$this->model->get_news($offset,$page_no, 10);
			$this->total=$this->model->get_news_count();
			$this->template->pagination = new Pagination(array
			 (
				'base_url'       => 'news',
				'uri_segment'    =>'index',
				'items_per_page' => 10,
				'total_items'    => $this->model->get_news_count(),
				'style'         => 'digg' )
			 );	 
			
			//template codes
			$this->left=new View("news_leftmenu");	   
			$this->right=new View("news_widgets");
			$this->center=new View("news_main");
			$this->title_content = "Recent News";
			$this->template->content=new View("/template/template3");
	 
		}
		
		//show the popular news
		public function popular($id='',$request_id='')
		{
			$this->template->id=$id;
			if($id=='')
			{
				$id=$this->session->get('userid');
			}
			 
			$this->get_category=$this->model->get_category();
	
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->news=$this->model->get_pop_news($offset,$page_no, 10);
			$this->total=$this->model->get_news_count();
			$this->template->pagination = new Pagination(array
			 (
			'base_url'       => 'news',
			'uri_segment'    =>'popular',
			'items_per_page' => 10,
			'total_items'    => $this->total,
			'style'         => 'digg' )
			 );	 
			 
		
			//template codes
				$this->left=new View("news_leftmenu");	   
				$this->right=new View("news_widgets");
        		        $this->center=new View("news_main");
				$this->title_content = "Popular News";
				$this->template->content=new View("/template/template3");
	 
		}
		
		//category
			public function category()
			{
			$this->get_category=$this->model->get_category();
			$category= $this->input->get('cate');
			
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='category')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->news=$this->model->news_catearticles($category,$offset,$page_no, 10);
			$this->total=$this->model->get_category_count($category);
			
			$this->template->pagination1 = new Pagination(array
			 (
			'base_url'       => 'news',
			 'uri_segment'    =>'category',
			'items_per_page' => 10,
			'total_items'    =>$this->total,
			'style'         => 'classic' )
			 );     
                        
                        if(count($this->template->news))
                        {
			//template codes
			$this->left=new View("news_leftmenu");	   
			$this->center=new View("news_main");
			$this->right=new View("news_widgets");
			$this->title_content = $this->template->news["mysql_fetch_array"]->category_name;
			$this->template->content=new View("/template/template3");
			}
			else
			{
			Nauth::setMessage(1,$this->news_notfound);
			url::redirect($this->docroot.'news/');
			}
        }
		
		//search news

        public function commonsearch()
        {
			$this->get_category=$this->model->get_category();
			$key= $this->input->get('search_value');
			$key=html::specialchars($key);
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='commonsearch')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->news=$this->model->search_news($key,$offset,10);
			$this->total=$this->model->get_search_news_count($key);
			
			$this->template->pagination = new Pagination(array
			 (
			'base_url'       => 'news',
			 'uri_segment'   => 'commonsearch',
			'items_per_page' => 10,
			'total_items'    => $this->total,
			'style'          => 'classic' )
			 );     
	 
			//template codes
			$this->left=new View("news_leftmenu");	   
			$this->right=new View("news_main");
			$this->title_content = "Search News";
			$this->template->content=new View("/template/template2");
        }
        //advance search news

        public function search()
        {
			$this->get_category=$this->model->get_category();
			
			$key = $this->input->get('search_text');
			$key = html::specialchars($key);
			$category = $this->input->get('search_category');
			
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='search')
			$page_no = 1;
			$offset=10*($page_no-1);
			$this->template->news=$this->model->advance_search_news($key,$category,$offset,10);
			$this->total=$this->model->get_advance_search_news_count($key,$category);
			
			$this->template->pagination = new Pagination(array
			 (
			'base_url'       => 'news',
			'uri_segment'   => 'common',
			'items_per_page' => 10,
			'total_items'    => $this->total,
			'style'          => 'classic' )
			 );     
	 
			//template codes
			$this->left=new View("news_leftmenu");	   
			$this->right=new View("search_news");
			$this->title_content = "Search News";
			$this->template->content=new View("/template/template2");
        }
        
	//full news
     	public function view()
	{
			if($_POST)
			{	
				$type_id = $this->input->post('type_id');
				Nauth::is_login($this->docroot.'news');
				$comment = $this->input->post("desc"); 
				$redirect_url = $this->input->post('redirect_url');
				
				common::post_comments($this->module."_comments",$type_id,$comment); //post the comments using common function 
				url::redirect($this->docroot.substr($redirect_url,1));
			}
			
			$news_title = $this->uri->last_segment();
			$this->nid =end(explode('_',$news_title));
			 
//			$this->nid = $this->input->get('nid');
			$this->template->full_news = $this->model->full_news($this->nid);
			//$this->template->get_news_comment=$this->model->get_news_comment($this->nid);
			
			//template codes
			 $this->template->title=$this->template->full_news["mysql_fetch_array"]->news_title;
			$this->left=new View("news_leftmenu");	   
			$this->right=new View("fullnews");
			$this->title_content = $this->template->full_news["mysql_fetch_array"]->news_title;
			$this->template->content=new View("/template/template2");
	 }
	 
	//add reply to the comments
	public function addreply()
	{    
		Nauth::is_login();
		$type_id = $this->input->post('type_id');
		$user_id=$this->user_id;
	 	$parent_id = $_GET['pid'];
		$news_id = $_GET['nid'];
		$comment=html::specialchars($this->input->post("r_comment")); 
		$this->template->repp=$this->model->news_comment($comment,$news_id,$user_id,$parent_id);
		url::redirect($this->docroot.'news/view/?nid='.$news_id);
		
	 }
	 
	 //delete news comment
   	public function delete_comment()
   	{
		Nauth::is_login();
		$cid=$this->input->get('cid');
		$type_id=$this->input->get('type_id');
		common::delete_comment($this->module."_comments",$type_id,$cid);
		url::redirect($this->docroot.'news/view/?nid='.$type_id.'');
	}
}
