<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the photos management
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_photos_Controller extends Website_Controller 
{
	public $template = 'template/template';
	public function __construct()
	{
		 parent::__construct();
		 $this->module="photos";
		 Nauth::is_login();
		 if($this->usertype == -1 || $this->usertype == -2 ){
				if($this->usertype == -2){
					$user_module = $this->session->get("u_mod");
					if(!in_array(12, $user_module)){
						url::redirect($this->docroot."admin");
						die();
					}
				}
			}
			else{
				url::redirect($this->docroot."profile");
				die();
			}
			
		 $this->model=new Admin_photos_Model();
		 $mes = Kohana::config('users_config.session_message');
		 $this->upload_photo = $mes["upload_photo"];
		 $this->delete_photo = $mes["delete_photo"];
		 $this->add_comment = $mes["add_comment"];
		 $this->delete_album = $mes["delete_album"];
		 $this->delete_comment = $mes["delete_comment"];
		 $this->update_change = $mes["update_change"];
		 
		  //get the answers modules permission
		 $this->admin_model = new Admin_Model();
		 $this->get_module_permission = $this->admin_model->get_module_permission(12);
                
		 if(count($this->get_module_permission) > 0){
		   $this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
		   $this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
		   $this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
		   $this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		 }
			 
	}

	//list the albums
	public function index()
	{

		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		$offset=10*($page_no-1);
		$this->template->display_album=$this->model->display_album($offset,$page_no,10);
		$this->total=$this->model->get_count_album();
		//
		$this->template->pagination = new Pagination(array(
		'base_url'       => 'admin_photos/index',
		'uri_segment'    =>'index',
		'items_per_page' => 10,
		'total_items'    => $this->total,
		'style'         => 'classic' ));
		//
		$this->template->title = 'Manage Photos';
		$this->left=new View("general/left");
		$this->right=new View("photos/photos_content");
		$this->title_content = "Manage Photos";
		$this->template->content=new View("template/template2");
	}

	//Create album
	public function create_album()
	{

		$this->template->title = 'New-Album';
		if($_POST)
		{
			$title=$this->input->post('title');
			$share=$this->input->post('share');
			$desc=$this->input->post('description');
			$this->template->photos=$this->model->createalbum($this->userid,$title,$desc,$share);
			url::redirect($this->docroot.'admin_photos/?id='.$this->userid.'');
		}
	
	}
	
	//Delete album
	public function delete_album()
	{ 	
		$this->template->title = 'Delete the Album';
		$album_id = $this->input->get('album_id');
		$this->template->delete_album = $this->model->delete_album($album_id);
		Nauth::setMessage(1,$this->delete_album);
		url::redirect($this->docroot.'admin_photos/?id='.$this->userid.'');


	}
	
	//update the album information
	public function edit()
	{
		if($_POST)
		{
			$this->template->title = 'Edit Album';
			$edit_title=$this->input->post('edit_title');
			$edit_description=$this->input->post('edit_description');
			$edit_description=html::specialchars($edit_description);
			$album_id=$this->input->get('album_id');
			$this->template->edit_album=$this->model->edit_album($album_id,$edit_title,$edit_description);
			Nauth::setMessage(1,$this->update_change);
			url::redirect($this->docroot.'admin_photos/?id='. $this->userid.'');
		}
		
	}
	
	//upload photo
	
	public function upload()
	{    
		if($_POST)
		{
			$upload_title = $this->input->post('photo_title');
			$upload_description = $this->input->post('photo_description');
			$photo_name = $_FILES['upload_photo']['name'];
			$album_id = $this->input->get('album_id');
			$this->template->insert_photo = $this->model->insert_photo($this->userid,$album_id,$upload_title,$upload_description,$photo_name);
			
				$this->template->album_photo = $this->model->album_photo($album_id);
				foreach($this->template->album_photo as $row)
				{
					$photo_id = $row->photo_id;
				}
				$this->tempalte->album_cover = $this->model->album_cover($album_id,$photo_id);
				Nauth::setMessage(1,$this->upload_photo);
				url::redirect($this->docroot.'admin_photos/upload/?album_id='.$album_id.'');

		}
		// template code
		$this->template->title = 'Upload the Photos';
		$this->left=new View("general/left");
		$this->right=new View("photos/upload_photos");
		$this->title_content = "Upload photos";
		$this->template->content=new View("template/template2");
	}
	
	//View Full Photo
	public function zoom()
	{
		
		$photo_id=$this->input->get('photo_id');
		$album_id=$this->input->get('album_id');
		$photo_text=$this->input->post('comenttext');
		
		//pagination 
		$page_no=$this->uri->last_segment();
		if($page_no == 0 || $page_no == 'zoom')
		$page_no = 1;
		$offset = 1*($page_no-1);
		$this->total = $this->model->get_count_show($album_id);
		if($this->total == 0){
			url::redirect($this->docroot.'admin_photos/view/?album_id='.$album_id);

		}
		
		$this->template->show_photo = $this->model->show_photo($album_id,$offset,$page_no, 1);
	   	$this->photoid = $this->template->show_photo["mysql_fetch_array"]->photo_id;
		
		$this->pagination = new Pagination(array
		(
		'base_url'       => 'admin_photos',
		'uri_segment'    =>'zoom',
		'items_per_page' => 1,
		'total_items'    => $this->total,
		'style'         => 'classic' )
		);
		//
		$this->template->full_photo=$this->model->full_photo($this->template->show_photo["mysql_fetch_array"]->photo_id,$album_id);
		$this->template->show_comment = $this->model->show_comment($this->template->show_photo["mysql_fetch_array"]->photo_id);
		//
		$this->template->title = "Photos:".$this->template->full_photo["mysql_fetch_array"]->photo_title;
		$this->left=new View("general/left");
		$this->right=new View("photos/full_photo");
		$this->title_content = $this->template->full_photo["mysql_fetch_array"]->photo_title;
		$this->template->content=new View("template/template2");
	}
	
	//Delete comment for photo
	public function delete_photocomment()
	{
		$comment_id=$this->input->get('comment_id');
		$photo_id=$this->input->get('photo_id');
		$this->template->delete_comment=$this->model->delete_photocomment($comment_id);
		Nauth::setMessage(1,$this->delete_comment);
		url::redirect($this->docroot.'admin_photos/zoom/?photo_id='.$photo_id.'&album_id='.$album_id.'');
	}
	
	//Post Comment
	public function post_comment()
	{

		$photo_id=$this->input->post('photo_id');
		$album_id=$this->input->post('album_id');
		$photo_text=$this->input->post('photo_comment');
		$this->template->photo_comment=$this->model->photo_comment($photo_id,$photo_text,$this->userid);
		Nauth::setMessage(1,$this->add_comment);
		url::redirect($this->docroot.'admin_photos/zoom/?album_id='.$album_id.'');
			
	}

	
	//Edit photo
	public function edit_photo()
	{
		$photo_id=$this->input->get('photo_id');
		$album_id=$this->input->get('album_id');
		$photo_title=$this->input->post('photo_name11');
		$album_cover=$this->input->post('album_cover');
	
		$this->template->edit_photo=$this->model->edit_photo($photo_id,$photo_title);

		$this->tempalte->album_cover=$this->model->album_cover($album_id,$album_cover);
		Nauth::setMessage(1,$this->update_change);
		url::redirect($this->docroot.'admin_photos/view/?album_id='.$album_id.'');

	}
	
	//Delete photo
	public function delete_photo()
	{

		 $this->template->title = 'Delete-Photo';
		 $photo_id=$this->input->get('photo_id');
		 $album_id=$this->input->get('album_id');
	 	 $this->template->delete_photo=$this->model->delete_photo($photo_id);
		 Nauth::setMessage(1,$this->delete_photo);

		 url::redirect($this->docroot.'admin_photos/view/?album_id='.$album_id.'');
	
	}
	
	//Display album photos
	public function view()
	{	
		$album_id = $this->input->get('album_id');
		$this->template->view_albumphoto = $this->model->view_albumphoto($album_id);
		
		if(count($this->template->view_albumphoto) == 0){
			Nauth::setMessage(-1,"Page Not Found .");
			url::redirect($this->docroot.'admin_photos/');
		}

		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no == 0 || $page_no == 'view_albumphoto')
		$page_no = 1;
		$offset = 9*($page_no-1);
		$this->template->show_photo = $this->model->show_photo($album_id,$offset,$page_no,9);
		$this->total = $this->model->get_count_show($album_id);
		$this->template->pagination = new Pagination(array
		(
		'base_url'       => 'admin_photos',
		'uri_segment'    =>'view',
		'items_per_page' => 9,
		'total_items'    => $this->total,
		'style'         => 'classic' )
		);
		
		// template code
		$this->template->title = 'Album Photos: '.$this->template->view_albumphoto["mysql_fetch_array"]->album_title;
		$this->left = new View("general/left");
		$this->right = new View("photos/view_albumphoto");
		$this->title_content = "Album Photos: ".$this->template->view_albumphoto["mysql_fetch_array"]->album_title."(".count($this->template->show_photo).")";
		$this->template->content = new View("template/template2");
	}

}
?>
