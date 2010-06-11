<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Defines the user management,question and answer and general setting.
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */


class Admin_Events_Controller extends Website_Controller 
{
	
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		if(!in_array("events", $this->session->get("enable_module"))) {
			url::redirect($this->docroot."admin");
			die();
		}
		$this->module="events";
		permission::check($this->module);
		$this->model=new Admin_Events_Model();
		$this->model1 = new Admin_Model();

		$this->get_module_permission = $this->model1->get_module_permission(7);
		
		if(count($this->get_module_permission) > 0){
			$this->add_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_add;
			$this->edit_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_edit;
			$this->delete_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_delete;
			$this->block_permission =  $this->get_module_permission["mysql_fetch_arrray"]->action_block;
		}	
	}

	 public function index()
	 {
		//$this->template->get_allevents = $this->model->get_allevents($eid ='');
		 $this->template->title="Events";
		//pagination

		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'eventlist'==$page_no)
		$page_no = 1;
		$offset=1*($page_no-1);
		$this->template->get_allevents = $this->model->get_allevents($eid ='',$offset,8,$this->userid);
		$this->template->get_category = $this->model->get_category();
		$this->pagination = new Pagination(array(
		'base_url'    => "admin_events", 
		'uri_segment' => 'index', 
		'items_per_page' => 8,
		'style' => 'digg',
		'total_items' =>count($this->model->get_totalevents())
		));
		 // template code
		 $this->left=new View("general/left");
		 $this->right=new View("events/events");
		 $this->title_content = "Events";
		 $this->template->content=new View("template/template2");
	 }
	 
	 public function event_search()
	 {
			if($this->userid != '' && $this->usertype == -1)
			{
					$search_value = $this->input->get('search_value');
					$this->template->title = 'Event Search';
					$page_no=$this->uri->last_segment();
				if (0 == $page_no || 'eventlist'==$page_no)
				$page_no = 1;
				$offset=1*($page_no-1);
				$this->template->get_allevents = $this->model->event_search($search_value,$offset,8,$this->userid);
				$this->template->get_category = $this->model->get_category();
				$this->pagination = new Pagination(array(
				'base_url'    => "admin_events", 
				'uri_segment' => 'event_search', 
				'items_per_page' => 8,
				'style' => 'digg',
			'total_items' =>count($this->model->get_totalsearch($search_value))
				));
					$this->left=new View("general/left");
				$this->right=new View("events/events");
				$this->title_content = "Events";
				$this->template->content=new View("template/template2");
			}
			else
			{
					url::redirect($this->docroot);
			}
	 }
	 
	 public function add_category()
	 {
			if($this->userid != '' && $this->usertype == -1)
			{
					$this->template->title = 'Add Category';
					if($_POST)
					{
							$category_name = $this->input->post('category');
							if($category_name)
							{
									$this->template->add_category = $this->model->add_category($category_name);
									if($this->template->add_category == 1)
									{
											$this->session->set('Msg','New category has been Added');
											url::redirect($this->docroot.'admin_events');
									}
									elseif($this->template->add_category == -1)
									{
											$this->session->set('Emsg','This Category Already Exists.');
											url::redirect($this->docroot.'admin_events/add_category');
									}
							}
							else
							{
									$this->session->set('Emsg','Category name Required.');
									url::redirect($this->docroot.'admin_events/add_category');
							}
					}
					$this->template->get_category = $this->model->get_category();
					$this->left=new View("general/left");
				$this->right=new View("events/add_category");
				$this->title_content = "Add Category";
				$this->template->content=new View("template/template2");
			}
			else
			{
					url::redirect($this->docroot);
			}
	 }
	 
	 public function delete_category()
	 {
			if($this->userid != '' && $this->usertype == -1)
			{
					$cat_id = $this->input->get('cid');
					if($cat_id != '')
					{
							$this->delete_category = $this->model->delete_category($cat_id);
							if($this->delete_category == 1)
							{
									$this->session->set('Msg','Category has been Deleted.');
							}
					}
					else
					{
							$this->session->set('Emsg','Invalid Operation.');
					}
					url::redirect($this->docroot.'admin_events/add_category');
			}
			else
			{
					url::redirect($this->docroot);
			}
	 }
	 
	 public function category_search()
	 {
			if($this->userid != '' && $this->usertype == -1)
			{
					$cat_id = $this->input->get('cat_id');
					$this->template->title = 'Event Search';
					$page_no=$this->uri->last_segment();
				if (0 == $page_no || 'eventlist'==$page_no)
				$page_no = 1;
				$offset=1*($page_no-1);
				$this->template->get_allevents = $this->model->category_search($cat_id,$offset,8,$this->userid);
				$this->template->get_category = $this->model->get_category();
				$this->pagination = new Pagination(array(
				'base_url'    => "admin_events", 
				'uri_segment' => 'event_search', 
				'items_per_page' => 8,
				'style' => 'digg',
			'total_items' =>count($this->model->get_categorysearch($cat_id,$this->userid))
				));
					$this->left=new View("general/left");
				$this->right=new View("events/events");
				$this->title_content = "Events";
				$this->template->content=new View("template/template2");
			}
			else
			{
					url::redirect($this->docroot);
			}
	 }
	 
	 
	 public function event()
	 {	
		$this->template->title="Add Events";
		if($_POST)
		{
			$title=$this->input->post('title');
			$place=$this->input->post('place');
			$description=$this->input->post('event_description');
			$date=$this->input->post('datevalue');
			$stime=$this->input->post('stime');
			$etime=$this->input->post('etime');
			$address=$this->input->post('address');
			$contacts=$this->input->post('contacts');
			$contact_email=$this->input->post('contact_email');
			$category=$this->input->post('category');
			$userid=$this->input->post('userid');
			$this->template->insert_event = $this->model->insert_event($title,$place,$description,$date,$stime,$etime,$address,$contacts,$userid,$contact_email,$category);
			
			if($this->template->insert_event == 1)
			{
				$this->session->set('Msg','Event has been created.');
				url::redirect($this->docroot.'admin_events/');
			}
			elseif($this->template->insert_event == -1)
			{
				$this->session->set('Emsg',''.$title.' Event Already Exists.');
				url::redirect($this->docroot.'admin_events');
			}
			elseif($this->template->insert_event == -2)
			{
				$this->session->set('Emsg','Error in Database.');
				url::redirect($this->docroot.'admin_events');
			}
		}
		// template code
		$this->template->get_allevents = $this->model->get_allevents($eid ='');
		$this->left=new View("general/left");
		$this->right=new View("events/events");
		$this->title_content = "Add Events";
		$this->template->content=new View("template/template2");
	}
	public function delete_event()
	{
		if($this->userid != '' && $this->usertype == -1)
		{
			$this->template->title="Delete Events";
			if($_GET)
			{
				$e_id = $_GET['e_id'];
				//$e_name = $_GET['e_name'];
				$this->template->delete_event = $this->model->delete_event($e_id);
				if($this->template->delete_event == 1)
				{
					$this->session->set('Msg','Successfully deleted.');
					url::redirect($this->docroot.'admin_events');
				}
				else
				{
					$this->session->set('Emsg','Some Fiels are Missing.');
					url::redirect($this->docroot.'admin_events');
				}
			}
		}
		else
		{
			url::redirect($this->docroot);	
		}
	}
	public function editevent()
	{
		if($this->userid != '' && $this->usertype == -1)
		{
				$this->template->get_category = $this->model->get_category();
			if($_GET)
			{
				$eid = $_GET['eid'];
				$this->template->title = 'Edit Events';
				$this->template->get_allevents = $this->model->get_editdata($eid);
				$this->left=new View("general/left");
				$this->right=new View("events/edit_events");
				$this->title_content = "Edit Events";
				$this->template->content=new View("template/template2");
			}
			elseif($_POST)
			{
				$title=$this->input->post('title');
				$place=$this->input->post('place');
				$description=$this->input->post('event_description');
				$date=$this->input->post('datevalue');
				$stime=$this->input->post('stime');
				$etime=$this->input->post('etime');
				$address=$this->input->post('address');
				$contacts=$this->input->post('contacts');
				$category=$this->input->post('category');
				$contact_email=$this->input->post('contact_email');
				$eid=$this->input->post('eid');
				

				$this->template->updateevent = $this->model->updateevent($title,$place,$description,$date,$stime,$etime,$address,$contacts,$eid,$contact_email,$category);
				if($this->template->updateevent == 1)
				{
					$this->session->set('Msg','Successfull Updated.');
					url::redirect($this->docroot.'admin_events/');
				}
				else
				{
					$this->session->set('Emsg','Some Fiels are Missing.');
					url::redirect($this->docroot."admin_events/editevent/?eid=$eid");
				}
			}
			else
			{
				url::redirect($this->docroot.'admin_events');
			}
			
			
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
	
	public function event_photos()
	{
			if($this->userid != '' && $this->usertype == '-1')
			{
					$event_id = $this->input->get('eid');
					if($event_id)
					{
							$this->template->event_photos = $this->model->event_photos($event_id);
						}
						else
						{
								$this->template->event_photos = array();
						}
						$this->left=new View("general/left");
				$this->right=new View("events/event_photos");
				$this->title_content = "Events Photos";
				$this->template->title = 'Event Photos';
				$this->template->content=new View("template/template2");
						//$this->template->conent = new View('admin/event_photos');
					
			}
			else
			{
					url::redirect($this->docroot);
			}
	}
	
	//delet event photos
	public function delete_event_photo()
	{
		if($this->userid != '' && $this->usertype == -1)
		{
			if($_GET)
			{
				$photo_id = $this->input->get('photo_id');
				$event_id = $this->input->get('event_id');
				$this->template->delete_photo = $this->model->delete_event_photo($photo_id);
				if($this->template->delete_photo == 1)
				{
					$this->session->set('Msg','Event Photo has been deleted.');
					url::redirect($this->docroot.'admin_events/event_photos/?eid='.$event_id.'');
				}
				elseif($this->template->delete_photo == -1)
				{
					$this->session->set('Emsg','Delete Process failed.');
					url::redirect($this->docroot.'admin_events/event_photos/?eid='.$event_id.'');
				}
			}
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
	
	public function block_unblock()
	{
		if($this->userid != '' && ($this->usertype == -1 || $this->usertype == -2))
		{
			if($_GET)
			{
				$status = $this->input->get('status');
				$id = $this->input->get('event_id');
				$this->insert_status = $this->model->block_unblock($status,$id);
				if($this->insert_status == 1)
				{
					$this->session->set('Msg','Events status has been Changed.');
					url::redirect($this->docroot.'admin_events');
				}
				elseif($this->insert_status == -1)
				{
					$this->session->set('Emsg','Events status Changes Failed.');
					url::redirect($this->docroot.'admin_events');
				}
			}
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
	
	
	//the end
}
?>
