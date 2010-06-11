<?php defined('SYSPATH') OR die('No direct access allowed.');
 class Updates_Controller extends Website_Controller {

	const ALLOW_PRODUCTION = FALSE;
	
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		$this->profile = new Profile_Model();
		$this->model = new update_model_Model();
		$mes = Kohana::config('users_config.session_message');
		$user_id = $this->session->get('userid');
		$this->add_comment = $mes["add_comment"];
		$this->delete_comment = $mes["delete_comment"];
		$this->module = "updates";
	}

	// function to display update 
	public function index()
	{ 

			$this->template->profile_info = $this->profile->profile_info($this->userid);
				
			//pagination
			$page_no=$this->uri->last_segment();
			if($page_no==0 || $page_no=='index')
			$page_no = 1;
			//offset value from 1 to 10 
			$offset=10*($page_no-1); 
			$this->template->all_updates=$this->model->all_updates_list();
			//all records are stored in this variable
			$this->template->updates=$this->model->updates_list($offset,10);
			//no of records count
			$this->total_updates=count($this->template->updates);
			$this->template->pagination = new Pagination(array
			 (					
			 'base_url'       => 'updates/',//our controller/function(page)
			 'uri_segment'    => 'index', //page(function)
			 'items_per_page' => 10,
			 'audo_hide' => TRUE,
			 'total_items'    => count($this->template->all_updates),
			 'style'         => 'classic' )
			 );  
				$this->template->title = "Friends Updates"; 
				// template code 
				$this->left=new View("template/left_menu");
				$this->right=new View("profile/profile_view");
				$this->title_content = "Friends Updates";

				$this->template->content=new View("/template/template2");
	}

	// function to display My update 
	public function myupdate()
	{ 
		$this->current_usr_id=$this->input->get('id'); 
		$this->template->id=$this->current_usr_id;
		$this->template->profile_info=$this->profile->profile_info($this->current_usr_id);
		/*Getting My friends list*/ 
		$this->template->my_friends =  $this->profile->my_friends($this->userid,1);
		/*Getting Friends Suggestion List*/
		$this->template->suggest_friends = $this->profile->suggest_friends($this->userid,1);
		
		//pagination
		$page_no=$this->uri->last_segment();
		if($page_no==0 || $page_no=='index')
		$page_no = 1;
		//offset value from 1 to 10
		$offset=10*($page_no-1); 
		$this->template->all_myupdates=$this->model->all_myupdates_list($this->current_usr_id);
		//all records are stored in this variable
		$this->template->myupdates=$this->model->myupdates_list($offset,10,$this->current_usr_id);
		//no of records count
		$this->total_myupdates=count($this->template->myupdates);
		$this->template->pagination = new Pagination(array
		 (					
			 'base_url'       => 'updates/',//our controller/function(page)
			 'uri_segment'    => 'myupdate', //page(function)
			 'items_per_page' => 10,
			 'auto_hide'     => true,
			 'total_items'    => count($this->template->all_myupdates),
			 'style'         => 'classic' )
		 ); 
		$this->template->title = "My Updates"; 
		// template code
		$this->left=new View("template/left_menu");
		$this->center=new View("upd_myupdates");
		$this->right=new View("profile/profile_right");
		$this->title_content = "My Updates";
		$this->template->content=new View("/template/template3");
	}
	
	public function third_party()
	{
		$usrid=$this->input->post('$userid');
		$url=$this->input->post('$url');
		$content=$this->input->post('$content');
		$this->updates=$this->model->updates_insert_third_party($usrid,'',36,$content,$url);
	}

	//function to Add and delete comment
	public function adddeletecomment()
	{ 
		$user_id=$this->session->get('userid');
		if(isset($_GET['id'])!="")		
			{  
				$id=$_GET['id'];
				$upd_id=$_GET['upd_id'];
				/*delete updates comment*/
				$this->template->del_com=$this->model->adddelete_comment($id);
				//Nauth::setMessage(1,$this->delete_comment); //call the librarary function to set the session type
				/* for getting posted updates comments */
					$this->com=$this->model->show_upd($upd_id); ?>
					<?php 
					foreach($this->com as $com) 
					{  ?><div class="m0 span-11  box border_bottom" >
					<!-- display user photo -->
						<div class="span-2 mr_fl_l text-align">
						<?php	Nauth::getPhoto($com->user_id);	?>
								</div>
								
						<div class="span-9 last">
						<!-- display description -->
						<p><?php Nauth::print_name($com->user_id, $com->name); ?> <span class="quiet">says</span> <?php echo htmlspecialchars_decode($com->desc);?> </p>
						<?php  
						/* DATE FORMATE */
                				 echo " <span class='quiet'> ". common::getdatediff($com->date); 
                                 echo " - </span>&nbsp;";				
						//if($com->fdate==0) { echo "Posted on Today"; } else { echo "Posted on ".$com->fdate."day ago..";} echo "&nbsp;";
						/* FUNCTION CHECK DELETE PERMISSION */
						if($user_id==$com->user_id || $user_id==$com->owner_id )
						{  ?>
						<a href="javascript:;" id="delete_form<?php echo $com->id;?>" onclick="javascript:$('#delete_form_show<?php echo $com->id;?>').toggle();" class="less_link" title="delete"  >Delete</a>

						<div id="delete_form_show<?php echo $com->id;?>" class="width300 delete_alert clear ml-10 mb-10">
<h3 class="delete_alert_head">Delete Comment</h3><span class="fr">
                    <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $com->id;?>" onclick="javascript:$('#delete_form_show<?php echo $com->id;?>').hide();" ></span>
					<div class="clear fl">Are you sure you want to delete this comment? </div>
					<div class="clear fl mt-10"> 
      <?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:del_comment(".$com->id.",".$upd_id.")", "delete_com","");?>
      <?php  echo UI::btn_("button", "cancel", "Cancel", "", "javascript:$('#delete_form_show$com->id').hide();", "cancel$com->id","");?>
	
							</div>
						</div>
						<?php }?>
						</div>
						</div>
						<?php
					 }
				/* Ajax Exit */
				exit;
			}	
		else
		{
		$coment=html::specialchars($_GET['coment']);
		$id=$_GET['upd_id'];
		/*insert updates comment*/
		$this->template->comment=$this->model->adddelete_comment($id,$coment);
		//Nauth::setMessage(1,$this->add_comment); //call the librarary function to set the session type
			/* for getting posted updates comments */
			$this->com=$this->model->show_upd($id);?>
			<?php 
			 
			foreach($this->com as $com) 
			{ ?> <div class="m0 span-11  box border_bottom" >
					<!-- display user photo -->
						<div class="span-2 mr_fl_l text-align">
						<?php	Nauth::getPhoto($com->user_id);	?>
								</div>
								
						<div class="span-9 last">
						<!-- display description -->
						<p><?php Nauth::print_name($com->user_id, $com->name); ?> <span class="quiet">says</span> <?php echo htmlspecialchars_decode($com->desc);?> </p>
						<?php  
						/* DATE FORMATE */
                				 echo " <span class='quiet'> ". common::getdatediff($com->date); 
                                 echo " - </span>&nbsp;";
				/* FUNCTION CHECK DELETE PERMISSION */
				if($user_id==$com->user_id || $user_id==$com->owner_id )
				{ ?>
				<a href="javascript:;" id="delete_form<?php echo $com->id;?>" onclick="javascript:$('#delete_form_show<?php echo $com->id;?>').toggle();" class="less_link" title="delete"  >Delete</a>
				
				
				<div id="delete_form_show<?php echo $com->id;?>" class="width300 delete_alert clear ml-10 mb-10">
			        <h3 class="delete_alert_head" >Delete Comment</h3><span class="fr">
                                <img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $com->id;?>" onclick="javascript:$('#delete_form_show<?php echo $com->id;?>').hide();" ></span>
			<div class="clear fl">Are you sure you want to delete this comment? </div>
			<div class="clear fl mt-10"> 
     <?php  echo UI::btn_("button", "delete_com", "Delete", "", "javascript:del_comment(".$com->id.",".$id.")", "delete_com","");?>
      <?php  echo UI::btn_("button", "cancel", "Cancel", "", "javascript:$('#delete_form_show$com->id').hide();", "cancel$com->id","");?>
			</div>
				</div>
	

			<?php }?>
				</div></div>
				 <?php
			 }
			 
			/* Ajax Exit */
			exit;
		}

	}
	
	// AJAX Function for LIKE update
	public function update_like()
	{
	$upd_id=$_GET['upd_id'];
	$user_id=$_GET['user_id'];
	$like=$_GET['like'];
	$names = ''; 
	$this->template->like_name=$this->model->like_update($upd_id,$user_id,$like);
	if(count($this->template->like_name)<=5)
	{
		if(count($this->template->like_name))
		{
			foreach($this->template->like_name as $row)
			{
			$names.= ucfirst($row->name).",";
			}
			$names=substr($names,0,-1);
			echo $names;
			if(count($this->template->like_name) >1)
			echo  " are likes this";
			else
			echo  " likes this";
		}
		
	}
	else
	{
		echo  "you and ".(count($this->template->like_name)-1)." People like this";
	}
	exit;	
	}

	//for Show More (Pagination)
	public function show_more()
	{		
		if($_GET['upd']=="frd_upd")	
			{
			$this->noofrecord=$_GET['noofrecord']+10;
			$this->template->all_updates=$this->model->all_updates_list();
			$this->total_count=count($this->template->all_updates);
			//echo "total count".$this->total_count."no of rec".$this->noofrecord; 
				if($this->total_count<$this->noofrecord)
				{
				$this->noofrecord=$this->noofrecord-($this->noofrecord-$this->total_count);
				}
		
			$this->template->updates=$this->model->updates_list(0,$this->noofrecord);
			 echo new View("upd_updates");exit;
			}
		else
			{
			$this->noofrecord=$_GET['noofrecord']+5;
			$this->template->all_myupdates=$this->model->all_myupdates_list();
			$this->total_count=count($this->template->all_myupdates);
			//echo "total count".$this->total_count."no of rec".$this->noofrecord; 
				if($this->total_count<$this->noofrecord)
				{
				$this->noofrecord=$this->noofrecord-($this->noofrecord-$this->total_count);
				}
			$this->template->myupdates=$this->model->myupdates_list(0,$this->noofrecord);
			 echo new View("upd_myupdates");exit;
			}
		
	}
	
	/**
		USER  NOTIFICATION COMMENTS AND LIKE
	**/	
	
	public function notifications()
	{

		$this->template->id = $this->userid;
		$this->template->my_friends =  $this->profile->my_friends($this->userid,1);
		$this->template->suggest_friends = $this->profile->suggest_friends($this->userid,1);
		//
		$this->note_comments = $this->model->get_notisfiction($this->userid);
		$this->note_like = $this->model->get_note_like($this->userid);
		//		
		$this->template->title = "Notifications"; 
		$this->left = new View("template/left_menu");
		$this->center = new View("profile/note");
		$this->right = new View("profile/profile_right");
		$this->title_content = "Notifications";
		$this->template->content = new View("/template/template3");
	}
	
	/**
		Get Notifiction updates 
	**/
	
	public function notification($not_id = "")
	{
		
		$this->template->id = $this->userid;
		$this->template->my_friends =  $this->profile->my_friends($this->userid,1);
		$this->template->suggest_friends = $this->profile->suggest_friends($this->userid,1);

		$this->template->myupdates = $this->model->my_note($not_id,$this->userid);
 
		$this->template->pagination = "";
		$this->template->title = "Notifications"; 
		//
		$this->left = new View("template/left_menu");
		$this->center = new View("upd_myupdates");
		$this->right = new View("profile/profile_right");
		$this->title_content = "Notifications";
		$this->template->content = new View("/template/template3");
	}


	public function __call($method, $arguments)
	{
		// Disable auto-rendering
		$this->auto_render = FALSE;
		// By defining a __call method, all pages routed to this controller
		// that result in 404 errors will be handled by this method, instead of
		// being displayed as "Page Not Found" errors.
		echo 'This text is generated by __call. If you expected the index page, you need to use: forum/index/'.substr(Router::$current_uri, 8);
	}

} // End Welcome Controller



