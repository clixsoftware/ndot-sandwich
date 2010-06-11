<?php defined('SYSPATH') or die('No direct script access.');

class Photos_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		$this->module = "photos";
		Nauth::is_login("photos");
		if(!in_array("photos", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."profile");
			die();
		}
		$this->profile = new Profile_Model();
		$this->uid = $this->input->get("uid");
		if(empty($this->uid)){
			$this->uid=$this->userid;
		}
		$this->model = new Photos_Model();
		$mes = Kohana::config('users_config.session_message');
		$this->upload_photo = $mes["upload_photo"];
		$this->add_comment = $mes["add_comment"];
		$this->delete_album = $mes["delete_album"];
		$this->delete_comment = $mes["delete_comment"];
		$this->update_change = $mes["update_change"];
		$this->delete_photo = $mes["delete_photo"];
		$this->not_authro = $mes["noacces"];
		$this->page_notfound = $mes["notfound"];
	}

	/** LIST OF ALL ALBUM **/
	
	public function index()
	{
		$this->profile_info = $this->profile->profile_info($this->uid);
		$this->find_frnd_not =  $this->profile->find_frnd_not($this->uid,$this->userid,0);
		//
		$page_no = $this->uri->last_segment();
		if($page_no == 0 || $page_no == 'index')
		$page_no = 1;
		$offset = 10*($page_no-1);
		$this->template->display_album = $this->model->display_album($this->uid,$offset,$page_no,10,count($this->find_frnd_not));		
		$this->total = $this->model->get_count_album($this->uid,count($this->find_frnd_not));
		$this->template->id = $this->input->get('uid');
		$this->get_friend_id = $this->profile->find_frnd_not($this->template->id,$this->userid,1);
					//get the info permission settings dob, email, phone 
					$this->template->info_permission = $this->profile->info_permission($this->template->id);
					
					$this->template->module_permission = $this->profile->get_mod_permission($this->template->id);
		
		$this->template->pagination = new Pagination(array(
			'base_url'       => 'photos',
			'uri_segment'    =>'index',
			'items_per_page' => 10,
			'total_items'    => $this->total,
			'style'         => 'classic' 
		));
		$this->template->title = 'Album';
		$this->left = new View("template/left_menu");
		$this->right = new View("photos_content");
		$this->title_content = "Photos";
		$this->template->content = new View("template/template2");
	}
	
	/** GET ALL FRIEDS ALBUM **/
	
	public function friendsalbum()
	{
		$page_no = $this->uri->last_segment();
		$this->template->id = $this->input->get('uid');
		
					//get the info permission settings dob, email, phone 
					$this->template->info_permission = $this->profile->info_permission($this->template->id);
					
					$this->template->module_permission = $this->profile->get_mod_permission($this->template->id);
		if($page_no == 0 || $page_no == 'index')
		$page_no = 1;
		$offset = 10*($page_no-1);

		$friends_id = $this->model->get_friends_id($this->userid , 1);
		$this->template->display_album = $this->model->friends_album($this->userid,$offset,$page_no,10,1,$friends_id);
		$this->total = $this->model->friends_count_album($this->userid,1,$friends_id);
		$this->template->pagination = new Pagination(array
		(
			'base_url'       => '/photos/friendsalbum',
			'uri_segment'    =>'index',
			'items_per_page' => 10,
			'total_items'    => $this->total,
			'style'         => 'classic' )
		);
		$this->template->title = 'Photos';
		$this->left=new View("template/left_menu");
		$this->right=new View("photos_content");
		$this->title_content = "Photos";
		$this->template->content=new View("template/template2");
	}
	
	/** CREATE ALBUM **/
	
	public function create_album()
	{
		$this->template->title = 'Create New Album';
		if($_POST){
			$title = $this->input->post('title');
			$share = $this->input->post('share');
			$desc = $this->input->post('description');
			$this->template->photos = $this->model->createalbum($this->userid,$title,$desc,$share);
			url::redirect($this->docroot.'photos/?uid='.$this->userid.'');
			die();
		}
	}
	
	/** EDIT ALBUM **/
	
	public function editalbum($album_id = "")
	{
		if($_POST){
			$this->template->title = 'Edit Album';
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$albumid = $this->input->post('albumid');
			$share = $this->input->post('share');
			$title = html::specialchars($title);
			//
			$this->edit_album = $this->model->edit_album($albumid,$title,$description,$share);
			Nauth::setMessage(1,$this->update_change);
			url::redirect($this->docroot.'photos/?uid='. $this->userid.'');
		}
		$album_id = $this->input->get("album_id");
		$this->album_get_data = $this->model->view_albumphoto($album_id);
		if($this->album_get_data->count() == 0){
			Nauth::setMessage(-1,"Album does not Exist");
			url::redirect($this->docroot.'photos/?uid='. $this->userid.'');
		}
		if($this->album_get_data->current()->user_id !== $this->userid){
			Nauth::setMessage(-1,"Album does not Exist");
			url::redirect($this->docroot.'photos/?uid='. $this->userid.'');
		}
		$this->template->title = "Edit Album";
		$this->title_content = " Edit Album ";
		$this->left=new View("template/left_menu");
		$this->right= new View("create_album");
		$this->template->content = new View("template/template2");
	}
	
	/** UPLOAD PHOTO **/
	
	public function upload()
	{    
		if($_POST){
			$album_id = $this->input->post('album_id');
			$userid = $this->input->post('userid');
			if($userid == $this->userid)
			{

                          
				$upload_title = $_POST["photo_title"];
				$photo_name = $_FILES['upload_photo']['name']; 
				$this->template->insert_photo = $this->model->insert_photo($this->userid,$album_id,$upload_title,$photo_name);        
				
				$this->template->album_photo = $this->model->album_photo($album_id);
				if(count($this->template->album_photo) > 0){
					foreach($this->template->album_photo as $row)
					{
						$photo_id = $row->photo_id;
					}
					$this->tempalte->album_cover = $this->model->album_cover($album_id,$photo_id);
				}
			}
			else{
				Nauth::setMessage(-1,"Album Owner only Upload Photos");
			}
			url::redirect($this->docroot."photos/view/?album_id=".$album_id);
		}
		$album_id = $this->input->get("album_id");
		$this->album_get_data = $this->model->view_albumphoto($album_id);
		if(count($this->album_get_data) == 0){
			url::redirect($this->docroot."photos/");
		}
		$this->template->title = 'Upload the Photos';
		$this->left=new View("template/left_menu");
		$this->right=new View("upload_photos");
		$this->title_content = "Upload photos";
		$this->template->content=new View("template/template2");
	}
	
	/**  LIST OF ALBUM PHOTOS **/
	
	public function view()
	{	
		$album_id = $this->input->get('album_id');
		$view_albumphoto = $this->model->view_albumphoto($album_id);
		if($view_albumphoto->count() == 0){
			url::redirect($this->docroot.'photos/');
		}
		$uid = $view_albumphoto->current()->user_id;
		if($uid !== $this->userid){
			$this->profile_info = $this->profile->profile_info($uid);
			$this->find_frnd_not =  $this->profile->find_frnd_not($uid, $this->userid, 0);
			$album_per = $view_albumphoto->current()->album_permision;
			
			if($album_per == -1){
				Nauth::setMessage(-1,"Only Friends View Album");
				url::redirect($this->docroot.'photos/');
			}
			elseif($album_per == 1){
				if(count($this->find_frnd_not) == 0){
					Nauth::setMessage(-1,"Only Friends View Album");
					url::redirect($this->docroot.'photos/');
				}
			}
		}
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='view_albumphoto')
		$page_no = 1;
		$offset=15*($page_no-1);
		$this->template->show_photo = $this->model->show_photo($album_id,$offset,$page_no, 15);
		$this->photo_total = $this->model->get_count_show($album_id); 
		$this->template->pagination = new Pagination(array(
			'base_url'       => 'photos',
			'uri_segment'    =>'view',
			'items_per_page' => 15,
			'total_items'    => $this->photo_total,
			'style'         => 'classic' 
		));

		$this->template->view_albumphoto =  $view_albumphoto;
		$this->template->title = 'Album Photos: '.$view_albumphoto->current()->album_title;
		$this->left = new View("template/left_menu");
		$this->right = new View("view_albumphoto");
		$this->title_content = "Album Photos: ".$view_albumphoto->current()->album_title."(".$this->photo_total.")";
		$this->template->content = new View("template/template2");
	}
	
	/** VIEW ALBUM PHOTO ZOOM **/
	
	public function zoom($photo_index = 0, $album_id = "", $photo_id = "")
	{
		$this->album_zoom_data = $this->model->album_photo_count($album_id, $photo_id, $photo_index);
		$this->album_photo_count = count($this->album_zoom_data);
		
		if($this->album_photo_count == 0)
		{
			 Nauth::setMessage(-1,$this->page_notfound);
			 url::redirect($this->docroot.'photos');
		}
		else{
		        $this->profile_info = $this->profile->profile_info($this->album_zoom_data->current()->user_id);
		}
		
		echo $this->album_zoom_data->current()->user_id;exit;
		$this->zomm_view = $this->model->full_photo($album_id, $photo_id);
		if($this->zomm_view->count() == 0)
		{
			 url::redirect($this->docroot."photos/view/?album_id".$album_id);
		}
		if($this->album_photo_count < $photo_index || $photo_index < 1){
			 url::redirect($this->docroot."photos/view/?album_id=".$album_id);
		}
		if($photo_index < $this->album_photo_count){
			$this->next_img = $this->model->album_photo_pre_next($photo_index, $album_id);
		}
		if($photo_index > 1){
			$this->previous_img = $this->model->album_photo_pre_next($photo_index -2, $album_id);
		}
		
		//post the comment
		if($_POST)
		{
		         $type_id = $this->input->post('type_id');
		         $redirect_url = $this->input->post('redirect_url');
			 $desc= html::specialchars($this->input->post('desc'));
			 common::post_comments($this->module."_comments",$type_id,$desc); //post the comments using common function 		
		         url::redirect(''.$redirect_url.'');
		
		}
		
		$this->photo_index = $photo_index;
		$this->template->title = "Photos:".$this->zomm_view->current()->photo_title;
		$this->left=new View("template/left_menu");
		$this->right=new View("full_photo");
		$this->title_content = $this->zomm_view->current()->photo_title;
		$this->template->content=new View("template/template2");
	}
	
	//Delete album
	public function delete_album()
	{ 	
	 	$this->template->title = 'Delete the Album';
		$album_id = $this->input->get('album_id');
		$this->template->delete_album=$this->model->delete_album($album_id,$this->userid);
		if($this->template->delete_album){
			Nauth::setMessage(1,$this->delete_album);
			url::redirect($this->docroot.'photos/?uid='.$this->userid.'');
		}
		else{
			Nauth::setMessage(-1,$this->not_authro);
			url::redirect($this->docroot.'photos/');
		}
	}
	
	//Delete comment for photo
	public function delete_photocomment()
	{
		
		$comment_id=$this->input->get('comment_id');
		$photo_id=$this->input->get('photo_id');
		$this->template->delete_comment=$this->model->delete_photocomment($comment_id);
			if($this->template->delete_comment)
                        {
                                Nauth::setMessage(1,$this->delete_comment);
                                url::redirect($this->docroot.'photos');
                        }
                        else
                        {
                                Nauth::setMessage(-1,$this->not_authro);
                                url::redirect($this->docroot.'photos');
                        }
		
	}

	//Show comment
	public function show_comment()
	{
		$this->template->title = 'Show-Comment';
		$photo_id=$this->input->get('photo_id');
		$album_id=$this->input->get('album_id');
		require_once Kohana::find_file('models','photos',TRUE,'php');
		$this->model= new Photos_Model();
		$session=Session::instance();
		$userid = $session->get('userid');
		if( !empty($userid)){
			$this->template->show_comment=$this->model->show_comment($photo_id);
			$view=new View("show_comment");
		}
		else{
			url::redirect($this->docroot.'users/login');
		}
		$this->template->content=$view;
	}
	
	//Create Album
	public function create_newalbum()
	{
		$this->template->title = 'Create New Album';
		$this->session=Session::instance();
		
		$userid = $this->session->get('userid');
		if(!empty($userid)){
			//$view = ;
		}
		else{
			url::redirect($this->docroot.'users/login');
		}
		//url::redirect($this->docroot.'photos/view/?album_id='.$album_id.'');
		$this->title_content = " Create New Album ";
		$this->left=new View("template/left_menu");
		$this->right= new View("create_album");
		$this->template->content = new View("template/template2");
	}
	
	//Edit photo
	public function edit_photo()
	{
		$this->template->title = 'Edit-Photo';
		$photo_id=$this->input->get('photo_id');
		$album_id=$this->input->get('album_id');
		$photo_title=$this->input->post('photo_name11');
		$album_cover=$this->input->post('album_cover');
		require_once Kohana::find_file('models','photos',TRUE,'php');
		$this->model= new Photos_Model();
		$this->session=Session::instance();
		$userid = $this->session->get('userid');
		if(!empty($userid)){
			$this->template->edit_photo=$this->model->edit_photo($photo_id,$photo_title);
			$this->session->set('Msg','Photo changes has been updated');
			$this->tempalte->album_cover=$this->model->album_cover($album_id,$album_cover);
			$view=new View("photos_content");
		}
		else{
			url::redirect($this->docroot.'users/login');
		}
		url::redirect($this->docroot.'photos/view/?album_id='.$album_id.'');
		$this->template->content=$view;
	}
	
	//Delete photo
	public function delete_photo()
	{
	
		 Nauth::is_login('',$this->docroot);
		 $this->template->title = 'Delete-Photo';
		 $photo_id = $this->input->get('photo_id');
		 $album_id = $this->input->get('album_id');
		 $delete_album = $this->model->delete_photo($photo_id, $album_id, $this->userid);
		 if($delete_album == 1){
		 	 Nauth::setMessage(1,$this->delete_photo);
		 }
		 else{
		 	 Nauth::setMessage(-1,"Photo not found");
		 }
		 url::redirect($this->docroot.'photos/view/?album_id='.$album_id.'');
	}
	
	
	//get the album search
        public function commonsearch()
   	{
		$key=html::specialchars($this->input->get('search_value'));
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='commonsearch')
		$page_no = 1;
		$offset=10*($page_no-1);
	
		$this->template->display_album=$this->model->search_album($key,$this->userid,$offset,$page_no,10);
		$this->total=$this->model->search_album_count($key,$this->userid);
		
		 $this->template->pagination = new Pagination(array
		 (
			 'base_url'       => 'photos',
			 'uri_segment'    =>'commonsearch',
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic' )
			 );	
	 
	
		// template code
		$this->template->title = 'Photos';
		$this->left=new View("template/left_menu");
		$this->right=new View("photos_content");
		$this->title_content = "Photos";
		$this->template->content=new View("template/template2");

	} 
	 //delete photo comment
   	public function delete_comment()
   	{
	    $cid = $this->input->get('cid');
	    $type_id = $this->input->get('type_id');
	    $url = $this->input->get('url');
            common::delete_comment($this->module."_comments",$type_id,$cid);
            url::redirect(''.$url.'');
	    
	}
}
?>
