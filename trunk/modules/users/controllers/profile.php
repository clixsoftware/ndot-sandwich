<?php defined('SYSPATH') OR die('No direct access allowed.'); 
class Profile_Controller extends Website_Controller
{
	public $template = 'template/template';
	public function __construct()
	{ 
		parent::__construct();
		Nauth::is_login();
		$this->session = Session::instance();
		$this->user_id = $this->session->get('userid');		
		//
		$this->model=new Profile_Model();
		$this->update = new update_model_Model();
		//	
		$mes = Kohana::config('users_config.session_message');
		$this->status_update = $mes["status_update"];
		$this->profile_update = $mes["profile_update"];
		$this->update_fail = $mes["update_fail"];
		$this->fields_missing = $mes["fields_missing"];
		$this->already_requested = $mes["already_requested"];
		$this->request = $mes["request"];
		$this->friend_added = $mes["friend_added"];
		$this->request_reject = $mes["request_reject"];
		$this->friend_removed = $mes["friend_removed"];
		$this->post_wall = $mes["post_wall"];
		$this->delete_wall = $mes["delete_wall"];
		$this->wall_error = $mes["wall_error"];
		$this->notfound = $mes["notfound"];
		$this->module = "profile";
	} 

	 
	 public function index($id='',$request_id='')
	 {		
			$this->template->title = 'Welcome To Ndot';
			$this->template->id=$this->userid;
			if($id==''){
				$id =$this->session->get('userid');
			}
		
			$this->status_message = $this->model->get_users_status_message($id);
			/*Getting Friends Request*/
			$this->template->request = $this->model->friends_request('',$this->userid,'',0);
			/*Getting My friends list */ 
			$this->template->my_friends = $this->model->my_friends($id,1);
			/*Getting Mutual Friends List*/
			$this->template->mutual_friends = $this->model->mutual_friends($this->userid,$id,1);
			/*Getting Friends Suggestion List*/
			$this->template->suggest_friends = $this->model->suggest_friends($this->userid,1);
			
			$this->template->check_profile = $this->model->check_profile($id);
			
			$this->template->view_update="true";					
			$this->template->profile_info=$this->model->profile_info($this->userid);

			//$this->template->profile_info=$this->model->profile_info($id);
			$this->friends_updates();
			
			if($_POST){
				$form_type=$this->input->post("form_type");
				if($form_type=="user_message"){
					$user_message=$this->input->post("user_message");
					$this->model->user_message($user_message,$this->userid);
					Nauth::setMessage(1,$this->status_update); //set session message using library
					url::redirect($this->docroot."profile");
				}
			}

			$this->left=new View("template/left_menu");
			$this->center=new View("profile/home");
			
			$this->script_jquery=1;
			$this->script_facebox=1;
			
			$this->title_content = "Welcome ".$this->username;
			
			$this->friend_suggestions($id);
			$this->template->content=new View("template/template3");
	 }
	
	public function friend_suggestions($user_id)
	{
		$this->template->suggest_friends = $this->model->suggest_friends($this->userid,1);
		$this->right=new View("profile/profile_right");
	}
	
	public function friend_suggestion($user_id)
	{
			$this->template->suggest_friends = $this->model->suggest_friends($this->userid,1);
		
		$this->template->title="Suggested Friends";
		 
		
		$this->left=new View("template/left_menu");
		$this->right=new View("/friends/all_suggested_friends");
		$this->title_content = "Suggested Friends(".count($this->template->suggest_friends).")";
		$this->template->content=new View("/template/template2");
	}
	
	public function friends_updates($id = '')
	{
			 $this->template->id = $this->userid;
			/*Getting Friends Suggestion List*/
			$this->template->suggest_friends = $this->model->suggest_friends($this->userid,1);
			/*Getting My friends list*/
			$this->template->my_friends = $this->model->my_friends($this->userid,1);
			/*Getting Friends Request*/
			$this->template->request = $this->model->friends_request('',$this->userid,'',0);
			/*Getting Mutual Friends List*/
			$this->template->mutual_friends = $this->model->mutual_friends($this->userid,$id,1);
			

			$this->template->view_update="true";					
			$this->template->profile_info=$this->model->profile_info($this->userid);
			//$this->template->view_update="true";
			
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='profile')
			$page_no = 1;
			//offset value from 1 to 10 
			$offset=10*($page_no-1);
			$this->template->all_updates=$this->update->all_updates_list();
			//all records are stored in this variable
			$this->template->updates=$this->update->updates_list($offset,10);
			//no of records count
			$this->total_updates=count($this->template->updates);
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'profile',//our controller/function(page)
			 'uri_segment'    => 'friends_updates', //page(function)
			 'items_per_page' => 10,
			 'auto_hide'     => true,
			 'total_items'    => count($this->template->all_updates),
			 'style'         => 'classic' )
			 ); 

			//template codes	
			$this->template->title="Friends Updates";
			$this->left=new View("template/left_menu");
			$this->center=new View("profile/home");
			$this->right=new View("profile/profile_right");
			$this->title_content = "Welcome ".$this->username;
			$this->template->content=new View("template/template3");
	}

	//friends profile
	 public function view($id = "", $request_id = "")
	 {	
			$this->template->id=$this->input->get("uid");
			
			$this->status_message = $this->model->get_users_status_message($this->template->id);
			$this->profile_info = $this->model->profile_info($this->template->id);
				if(count($this->profile_info))
				{
									// end of updates
					$this->template->title = $this->profile_info["mysql_fetch_array"]->name." ".$this->profile_info["mysql_fetch_array"]->last_name." Profile";
	
					if($id==''){
						$id = $this->session->get('userid');
					}
					$this->get_friend_id = $this->model->find_frnd_not($this->template->id,$this->userid,1);
					//get the info permission settings dob, email, phone 
					$this->template->info_permission = $this->model->info_permission($this->template->id);
					
					$this->template->module_permission = $this->model->get_mod_permission($this->template->id);
					//get the wall message 
					$this->template->request = $this->model->friends_request('',$this->userid,'',0);
					
	
					/*Getting My friends list*/
					$this->template->my_friends = $this->model->my_friends($this->template->id,1);
	
					/*Getting Mutual Friends List*/
					$this->template->mutual_friends = $this->model->mutual_friends($this->userid,$id,1);
	
					/*Check whether Friends*/
					$this->template->check_friends = $this->model->check_friends($this->userid,$id,1);
	
					/*Check Profile settings*/
					$this->template->check_profile = $this->model->check_profile($id);
	   
					$this->find_frnd_not = $this->model->find_frnd_not($this->template->id,$this->userid,0);	
					//pagination
					$page_no=$this->uri->last_segment();
					if($page_no==0 || $page_no=='view')
					$page_no = 1;
					//offset value from 1 to 10
					$offset=15*($page_no-1); 
	
					//action type
					$this->c_wall = "";$this->c_info = "";$this->c_photos = ""; $this->c_update = "";
					$action=$this->input->get("action");
					if($action=="wall"){
						$this->c_wall = 'profile_vscurr';
						$this->profile_wall = $this->model->get_profile_wall($this->template->id);
					}
					else if($action=="info"){
						$this->c_info = 'profile_vscurr';
					}
					else if($action=="photos")
					{
						$this->c_photos = 'profile_vscurr';
						$this->photos=new Photos_Model();
						if($this->template->id == ''){
							$id = $this->userid;
						}
						else{
							$id = $this->template->id;
						}
						
						$this->template->display_album = $this->photos->display_album($id,$offset,$page_no,15,count($this->find_frnd_not));
				  
						$this->total =  $this->photos->get_count_album($id,count($this->find_frnd_not));
					
						$this->template->pagination = new Pagination(array
						(
						'base_url'       => 'profile',
						'uri_segment'    =>'view',
						'items_per_page' => 15,
						'total_items'    => $this->total,
						'style'         => 'classic' )
						);
					}
					else{
						$this->c_update = 'profile_vscurr';
						$this->updates=new Update_model_Model();
						//user updates
						$this->template->all_myupdates=$this->updates->all_myupdates_list($this->template->id);
	
						//all records are stored in this variable
						$this->template->myupdates=$this->updates->myupdates_list($offset,15,$this->template->id);
						//no of records count
						$this->total_myupdates=count($this->template->myupdates);
		
						$this->template->pagination = new Pagination(array
						 (					
							 'base_url'       => 'profile',//our controller/function(page)
							 'uri_segment'    => 'view', //page(function)
							 'items_per_page' => 15,
							 'total_items'    => count($this->template->all_myupdates),
							 'style'         => 'classic' )
						 ); 
					}
				// template code
				$this->left=new View("template/left_menu");  
				$this->center=new View("profile/profile_view");
				$this->right=new View("profile/profile_right");
				$this->title_content = $this->profile_info["mysql_fetch_array"]->name." ".$this->profile_info["mysql_fetch_array"]->last_name;
				$this->template->content=new View("template/template3");
			}
			else{
				url::redirect($this->docroot."profile");
			}
				/*User Status Message*/
				if($_POST){
					$form_type=$this->input->post("form_type");
					if($form_type=="user_message"){
						$user_message=$this->input->post("user_message");
						$this->model->user_message($user_message,$this->userid);
						Nauth::setMessage(1,$this->status_update); //set session message using library
						url::redirect($this->docroot."profile");
					}
				}
				/*End Status Message*/
	 }		
	 
	 /**
	* This Helps you to Invite Your Friends from Other Site
	*/
	public function invite_friends()
	{
		$this->template->profile_info=$this->model->profile_info($this->userid);
		$this->template->title = 'Invite Friends';
		$this->template->invite_friend =include($this->file_docroot."/modules/openInviter/friends_invite.php");
		
		$this->left=new View("template/left_menu");
		$this->right=new View("/invite/invitefriends");
		$this->title_content = "Import Contacts";
		$this->template->content=new View("/template/template2");
	}
	
	public function invite()
	{
		$this->template->profile_info=$this->model->profile_info($this->userid);
		$this->template->title = 'Invite Friends';
		
		$this->left=new View("template/left_menu");
		$this->right=new View("invite/general_invite");
		$this->title_content = "Invite Friends";
		$this->template->content=new View("/template/template2");
	}
	
	/**  ACCEPT OR CANCEL FRIEND REQUEST **/
	
	public function add_friend($request_id = "",$status = "", $friend_id = "")
	{
		if($this->userid != ""){
			$this->template->title = 'Add Friend';
			
			$result = $this->model->request_status($request_id,$status,$friend_id,$this->userid);
			if($result == 1){	
				Nauth::setMessage(1,$this->friend_added); 
				url::redirect($this->docroot.'profile/view/?uid='.$friend_id);
			}
			elseif($result == 0){
				Nauth::setMessage(1,$this->request_reject); 
			}
			else{
				Nauth::setMessage(-1,$this->notfound); 
			}
			url::redirect($this->docroot.'profile');
			
		}
		else{
			url::redirect($this->docroot.'users');
		}	
	}
	
	/** Open Invites **/
	
	public function openinvites()
	{
		$page_no = $this->uri->last_segment();
		if($page_no == 0 || $page_no == 'openinvites')
		$page_no = 1;
		$offset=10*($page_no-1); 
		//
			$this->invities = $this->model->openinvites_count($this->userid);
			$this->template->pagination = new Pagination(array(					
				'base_url'       => 'profile',
				'uri_segment'    => 'openinvites', 
				'items_per_page' => 10,
				'auto_hide'     => TRUE,
				'total_items'    =>  $this->invities,
				'style'         => 'classic' 
			));
		 // 
		$this->openinvites = $this->model->openinvites($this->userid,$offset,10);
		$this->template->title = "Open Friends Invite ";
		$this->left = new View("template/left_menu");
		$this->right = new View("/friends/openinvites");
		$this->title_content = "Open Invites(".$this->invities.")";
		$this->template->content = new View("/template/template2");
	}
	
	/** DELETE OPEN INVITES **/
	
	public function deleteinvites($request_id = "", $friend_id = "")
	{
		$this->deleteinvites = $this->model->deleteinvites($request_id,$friend_id,$this->user_id);
		if($this->deleteinvites == 1){
			Nauth::setMessage(1,$this->friend_removed); 
		}
		else{
			Nauth::setMessage(-1, $this->notfound); 
		}
		$this->template->title = "Remove Invites";
		url::redirect($this->docroot."profile/openinvites");
	}
	
	public function openrequest()
	{
		$this->template->request = $this->model->friends_request('',$this->userid,'',0);
		$this->template->title = "Requested Friends";
		$this->left = new View("template/left_menu");
		$this->right = new View("/friends/all_requests");
		$this->title_content = "Requested Friends(".count($this->template->request).")";
		$this->template->content=new View("/template/template2");
	}
	 
	 public function add_friend_left()
	 {
			$this->id = $this->input->get("uid");
			 $this->friends_request_check = $this->model->friends_request_check($this->id,$this->userid,0);
			 if($this->friends_request_check == -1){	
				Nauth::setMessage(1,$this->already_requested); //set session message using library
				url::redirect($this->docroot.'profile/view/?uid='.$this->id.'');
			}
			else{
				Nauth::setMessage(1,$this->request); //set session message using library
				url::redirect($this->docroot.'profile/view/?uid='.$this->id.'');
			}
			$this->template->title="add friend";
			$this->template->content=new View("/template/template3");
			
	 } 
	/**
	* reply the wall
	*/ 
	public function reply_wall()
	{
		if($_POST){
			$poster_id=$this->input->post("poster_id");
			
			$userid=$this->input->post("receiver_id");
			if(!empty($poster_id) && !empty($userid))
			{
					$wall= html::specialchars($this->input->post("reply_message"));
					$this->model->post_wall($poster_id,$userid,$wall);
					$this->reply_wall=$this->update->updates_insert($poster_id,$userid,7,'wall',$wall);
					
			}
			url::redirect($this->docroot.'profile/view/?uid='.$userid.'&action=wall');
			
		}
	}

	 /**
	* post the wall
	*/ 
	public function post_wall()
	{
		if($_POST){
			$poster_id = $this->userid; 
			$userid = $this->input->post("userid");
			$wall = html::specialchars($this->input->post("wall_message")); 
			$post_id = $this->model->post_wall($poster_id,$userid,$wall); 
			$this->add_wall=$this->update->updates_insert($poster_id,$userid,7,'wall',$wall,$post_id); 
			url::redirect($this->docroot.'profile/view/?uid='.$userid.'&action=wall'); 
		}
	}
	//show the walls
	public function wall()
	{
		$userid=$this->input->get("id");
		
		
		$this->template->find_frnd_not = $this->model->find_frnd_not($userid,$this->userid,0);
		$this->template->profile_info = $this->model->profile_info($userid);
		//pagging
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='wall')
		$page_no = 1;
		$offset=10*($page_no-1);

		$this->wall=$this->model->get_wall($userid,$offset,10);
		$this->total_wall= $this->model->count_wall($userid);
		$this->template->pagination = new Pagination(array
			 (
		 'base_url'       => '/profile/wall/',
		 'uri_segment'    => 'wall',
		 'items_per_page' => 10,
		 'total_items'    =>$this->total_wall,
		 'style'         => 'classic' )
			 ); 

		$this->template->title="Wall";
		// template code
		$this->left = new View("template/left_menu");
		$this->right=new View("profile/wall");
		$this->title_content = "Wall (".$this->total_wall.")";
		$this->template->content=new View("/template/template2");

	}
	//delete wall
	public function delete_wall()
	{ 
		$wall_id  = $this->input->get("id");
		$uid = $this->input->get("uid");
		$this->model->delete_wall($wall_id);
		common::delete_update("",7,$wall_id);
		Nauth::setMessage(1,$this->delete_wall); 
		url::redirect($this->docroot.'profile/view/?uid='.$uid.'&action=wall');
	}
	
	
	
	/**
	* Update Users profile
	*/
	public function updateprofile()
	{
		if($this->userid != ''){
			//$this->model=new Profile_Model();
			$this->template->title = 'Update Profile';
			$this->template->profile_info=$this->model->profile_info($this->userid);  
				$this->template->profile_fname=$this->model->profile_fname($this->userid); 
			$this->template->get_country = $this->model->get_country();
			$this->template->get_city = $this->model->get_city();
			$this->template->get_interest = $this->model->get_interest();
			$this->template->get_user_interest = $this->model->get_user_interest($this->userid);
			$this->template->get_user_privacy = $this->model->get_user_privacy($this->userid);
			if($_POST){
				$fname = $this->input->post('f_name');
				$lname = $this->input->post('l_name');
				$aboutme = $this->input->post('aboutme');
				$dob = $this->input->post('dob');
				$sex = $this->input->post('gender');
				$street = $this->input->post('street');
				$city = $this->input->post('city');
				$country = $this->input->post('country');
				$code = $this->input->post('code');
				$phone = $this->input->post('phone');
				$mobile = $this->input->post('mobile');
				$news = $this->input->post('news');
				$email = $this->input->post('email');
				$userid = $this->input->post('userid');
				$friends = $this->input->post('Friends');
				$activity = $this->input->post('Partners');
				$games = $this->input->post('Games');
				$dating = $this->input->post('Dating');
				$birthdayprivacy = $this->input->post('birthdayprivacy');
				$phoneprivacy = $this->input->post('phoneprivacy');
				$mobileprivacy = $this->input->post('mobileprivacy');
				$emailprivacy = $this->input->post('emailprivacy');
				$wallprivacy = $this->input->post('wallprivacy');
				$videoprivacy = $this->input->post('videoprivacy');

				if($fname!= '' && $dob != ''   && $city != ''&& $code != ''  && $email != '' && $news != '' && $userid){ 		
					$this->template->updateprofile = $this->model->updateprofile($fname,$lname,$aboutme,$dob,$sex,$street,$city,$country,$code,$phone,$mobile,$news,$email,$userid,$friends,$activity,$games,$dating);
					$this->template->updateprivacy = $this->model->updateprivacy($userid,$birthdayprivacy,$phoneprivacy,$mobileprivacy,$emailprivacy,$wallprivacy,$videoprivacy);
					if($this->template->updateprofile == 1){
						Nauth::setMessage(1,$this->profile_update); //set session message using library
						url::redirect($this->docroot.'profile/updateprofile');
					}
					elseif($this->template->updateprofile == -1){
						Nauth::setMessage(1,$this->update_fail); //set session message using library
					}
					elseif($this->template->updateprofile == -2){
						Nauth::setMessage(1,$this->fields_missing); //set session message using library
					}
				}
				else{ 		
					Nauth::setMessage(1,$this->fields_missing); //set session message using library
					$this->template->content = new View('profile/profile');
				}
			}
		// template code
		$this->left=new View("template/left_menu");
		$this->right=new View("profile/profile");
		$this->title_content = "Edit Profile";

		$this->template->content=new View("/template/template2");
		}
		else{
			url::redirect($this->docroot.'users');
		}
	}
	/**
	* editing Users module permission
	*/
	public function privacy_setting()
	{
		if($this->userid != ''){
			$this->template->title = 'Privacy Settings';
			$this->template->profile_info=$this->model->profile_info($this->userid);
			$this->template->get_mod_permission = $this->model->get_mod_permission($this->userid);
			if($_POST){
				$wall_mod = $this->input->post('wall');
				$update_mod = $this->input->post('updates');
				$profile_mod = $this->input->post('profile');
									$video_mod = $this->input->post('video');
									$photo_mod = $this->input->post('photo');
				$this->template->update_mod_permission = $this->model->update_mod_permission($this->userid,$wall_mod,$update_mod,$profile_mod,$video_mod,$photo_mod);
				$this->template->get_mod_permission = $this->model->get_mod_permission($this->userid);			
			}
		// template code
		$this->left=new View("template/left_menu");
		$this->right=new View("profile/mod_permission");
		$this->title_content = "Privacy Settings";
		$this->template->content=new View("/template/template2");
	}
		else{
			url::redirect($this->docroot.'users');
		}
}
	/**
	* Send friends request
	*/
	public function send_request()
	{
		$friends_id = $this->input->post('friends_id');
		$text = $this->input->post('fri_message');
		$comment = $this->input->post('friend_comment');
		 
				$friends_comment = $text.' '.$comment;
				
			
		$this->template->title = 'Add Friends';
		$this->template->friends_request = $this->model->friends_request($friends_id,$this->userid,$friends_comment,0);
		if($this->template->friends_request == -1){	
			Nauth::setMessage(1,$this->already_requested); //set session message using library
		}
		else{
			Nauth::setMessage(1,$this->request); //set session message using library
		}
		url::redirect($this->docroot.'profile');
	}
	
	/**
	* Send friends request in profile list
	*/
	public function send_request_profile()
	{
		$friends_id = $this->input->post('friends_id');
		$friends_comment = 'Dear'.'&nbsp;'.$this->input->post('user_name').','.'<br>'.$this->input->post('friend_comment');
		$this->template->title = 'Add Friends';
		$this->template->friends_request = $this->model->friends_request($friends_id,$this->userid,$friends_comment,0);
		if($this->template->friends_request == -1){	
			Nauth::setMessage(1,$this->already_requested); //set session message using library
		}
		else{
			Nauth::setMessage(1,$this->request); //set session message using library
		}
		url::redirect($this->docroot.'profile/index/'.$friends_id);
	}
	/**
		* List all My Friends
	*/
	public function friends()
	{
		$userid = $this->input->get("uid");
		if(empty($userid)){
			$userid = $this->userid;
		}
		$this->find_frnd_not = $this->model->find_frnd_not($userid,$this->userid,0);	
		$this->profile_info = $this->model->profile_info($userid);
		$this->total = $this->model->my_friends_count($userid,1);
		//
		$page_no = $this->uri->last_segment();
		if($page_no == 0 || $page_no == "friends")
		$page_no = 1;
		$offset = 10*($page_no-1);

		$this->template->pagination = new Pagination(array(
			 'base_url'       => '/profile/friends/',
			 'uri_segment'    => 'page',
			 'items_per_page' => 10,
			 'total_items'    => $this->total,
			 'style'         => 'classic'
		 )); 
		$this->template->list_friends = $this->model->my_friends($userid,1,$offset,10);
		//
		$this->template->user_id = $userid;
		$this->template->title = 'My Friends';
		$this->left = new View("template/left_menu");
		$this->right = new View("/friends/list_friends");
		$this->title_content = "Friends(".$this->total.")";
		$this->template->content = new View("/template/template2");
	} 
	
	public function search_my_frend()
	{
	        if($this->userid != '')
	        {
	                $search_value = $this->input->get('friend_search');
	                $userid = $this->input->get("uid");
	                if($search_value)
	                {
	                        $this->template->list_friends = $this->model->search_my_friends($userid,1,$search_value);
	                        $this->total = $this->model->search_my_friends_count($userid,1,$search_value);
                        }
                        else
                        {
                                $this->template->list_friends = array();
                                $this->total = 0;
                        }
		        //
		        
		        $this->template->user_id = $userid;
		        $this->template->title = 'My Friends';
		        $this->left = new View("template/left_menu");
		        $this->right = new View("/friends/list_friends");
		        $this->title_content = "Friends(".$this->total.")";
		        $this->template->content = new View("/template/template2");
	        }
	        else
	        {
	                url::redirect($this->docroot);
	        }
	}
	
	/**
	* Remove Friends
	*/
	public function remove_friends($request_id = "", $friend_id = "", $name = "")
	{
			$request_id = $this->input->get("frid");
			$friend_id = $this->input->get("fid");
			$name = $this->input->get("name");
			
		$this->delete_friend = $this->model->delete_friend($request_id,$friend_id,$name,$this->user_id);
		if($this->delete_friend == 1){
			Nauth::setMessage(1,$this->friend_removed); 
		}
		else{
			Nauth::setMessage(-1, $this->notfound); 
		}
		$this->template->title = 'Remove Friend';
		url::redirect($this->docroot.'profile/friends?uid='.$this->user_id);
	
	}
	//my profile here
	public function myprofile()
	{
		$id = $this->session->get('userid');
		$this->template->profile_info=$this->model->profile_info($id);
		$this->template->get_interest = $this->model->get_interest();
		// end of updates
		$this->template->title = 'Welcome To Ndot';
			/*Check whether Friends*/
		$this->template->check_friends = $this->model->check_friends($this->userid,$id,1);

		/*Check Profile settings*/
		$this->template->check_profile = $this->model->check_profile($id);
		
		/*User Status Message*/
			if($_POST){
				$form_type = $this->input->post("form_type");
				if($form_type == "user_message"){
					$user_message = $this->input->post("user_message");
					$this->model->user_message($user_message,$this->userid);
					Nauth::setMessage(1,$this->status_update); //set session message using library
					url::redirect($this->docroot."profile");
				}
			}
			/*End Status Message*/
			$this->left = new View("profile/profile_left");
			//$this->center=new View("profile/profile_view");
			$this->right = new View("profile/myprofile_right");
			$this->title_content = "My Profile";
			$this->template->content = new View("template/template2");
			}
	//users search

	public function commonsearch()
	{
	       
		$this->profile=new Profile_Model();
		$this->template->profile_info=$this->profile->profile_info($this->userid);
		$check_key = $this->input->get('search_value');
		if(empty($check_key))
		{
		        Nauth::setMessage(-1,"Enter the Search keywords"); 
		        url::redirect($this->docroot."profile");
		}
		//checking for users login
		if($this->userid != ''){
			$this->template->title = 'People Search';
			//checking for post values
			if($_GET){
				$search = html::specialchars($this->input->get('search_value'));
				//checking for input values
				if(strlen(trim($search)) > 2){
					//
					$this->user_search_count = $this->model->search_count($search,$this->userid);
					$page_no = $this->uri->last_segment();
					if($page_no == 0 || $page_no == "friends")
					$page_no = 1;
					$offset = 10*($page_no-1);
				
					$this->template->pagination = new Pagination(array(
						 'base_url'       => 'profile/commonsearch',
						 'uri_segment'    => 'page',
						 'items_per_page' => 10,
						 'total_items'    => $this->user_search_count,
						 'style'         => 'classic'
					 )); 
					$this->template->search = $this->model->search($search,$this->userid,$offset,10);
					//
					
					$this->template->content = new View('/users/search');
				}
				else{
					$search = 0;
					$this->template->search = array();
					$this->template->content = new View('/users/search');
				}
			}
			if($_POST){
					$friends_id = $this->input->post('friends_id');
					$search = html::specialchars($this->input->post('search'));
					$friends_comment = $this->input->post('friend_comment');
					$this->template->title = 'Add Friends';
					$this->profile_model=new Profile_Model();
					$this->template->friends_request = $this->profile_model->friends_request($friends_id,$this->userid,$friends_comment,0);
					if($this->template->friends_request == -1){	
						Nauth::setMessage(1,$this->already_requested); //set session message using library
						$this->template->search = $this->model->search($search,$this->userid);
						url::redirect($this->docroot.'users/search?search_value='.$search.'');
					}
					else{
						Nauth::setMessage(1,$this->request); //set session message using library
						$this->template->search = $this->model->search($search,$this->userid);
						url::redirect($this->docroot.'users/search?search_value='.$search.'');
					}
			}
			
			// template code
			$this->left=new View("template/left_menu");
			$this->right=new View("/users/search");
			$this->title_content = "People Search";
			$this->template->content=new View("/template/template2");
			
		}
		else{
			url::redirect($this->docroot);
		}
	}
	
	public function add_as_friend()
	{
		if($this->userid != ''){
			$fid = $this->input->get('uid');
			$this->template->friend_name = $this->model->friend_name($fid);
		   // echo $this->template->friend_name['mysql_fetch_array']->name;exit;
			$this->template->title = 'Add as Friend';
			$this->left=new View("template/left_menu");
			$this->right=new View("friends/add_friend");
			$this->title_content = "Add as Friend";
			$this->template->content=new View("/template/template2");
		}
		else{
				url::redirect($this->docroot);
		}
	}
	
		//my favorites 
	public function favourites()
	{
	        $this->template->title = "My Favourites";
	        $this->title_content = "My Favourites";
                $this->favorites = $this->model->my_favourites($this->userid);
	        
		$this->left = new View("template/left_menu");
		$this->right = new View("/profile/favourites");
		$this->template->content = new View("/template/template2");
	}
	
	/** Add/Delete Favourite **/
	
	public function favourite($operation = "", $type = "")
	{
		$url = $this->input->get("url");
		if($url && $operation && $type){
			$this->model->add_favourite($url, $operation, $type, $this->userid);
		}
		url::redirect(substr($this->docroot,0,-1).$url);

	}
}
?>
