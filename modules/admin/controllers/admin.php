 <?php defined('SYSPATH') or die('No direct script access.');

class Admin_Controller extends Website_Controller 
{
		public $template = 'template/template';
		public function __construct()
		{
			parent::__construct();
			$this->model = new Admin_Model();
			$this->module = "admin";
			Nauth::is_login();
			/*User response messages*/
			$mes = Kohana::config('users_config.session_message');
			$this->delete_user = $mes["delete_user"];
			$this->user_access = $mes["user_access"];
			$this->update_user = $mes["update_user"]; 
			$this->set_permission = $mes["set_permission"];
			$this->answer_delete = $mes["answer_delete"];
			$this->question_delete = $mes["question_delete"];
			$this->update_change = $mes["update_change"];
			$this->change_theme = $mes["change_theme"];
			$this->access_denied = $mes["access_denied"];
			$this->module_exists = $mes["module_exists"];
			$this->module_installed = $mes["module_installed"];
			$this->module_login = $mes["module_login"];
			$this->email = $mes["email"];
			$this->module_change = $mes["module_change"];
			$this->update_role = $mes["update_role"];
			$this->delete_role = $mes["delete_role"];
		}
		
		/** SITE ANALYTICS **/
		
		 public function index()
		 {
		 	if($this->usertype == -1 || $this->usertype == -2 ){
				 $this->template->title = "Site Analytics";
				 $this->analytics = $this->model->get_analytics();
				 $this->title_content = "Site Analytics";
				 $this->left = new View("general/left");
				 $this->right = new View("admin/analytics");
				 $this->template->content = new View("template/template2");
			}
			else{
				url::redirect($this->docroot."profile");
				die();
			}
		 }
		
		/** GENERAL SETTINGS **/	
					
		public function general_settings()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			if($_POST){
				$title = html::specialchars($this->input->post("title"));
				$meta_keywords = html::specialchars($this->input->post("meta_keywords"));
				$meta_desc = html::specialchars($this->input->post("meta_description"));
				$logo = $_FILES["logo"]["name"];
				$this->model->update_general_setting($title,$meta_keywords,$meta_desc,$logo);
				$this->session->delete("general_setting_info");
				
			}
			$this->template->title="General Settings";
			$this->left = new View("general/left");
			$this->right = new View("general/admin_content");
			$this->title_content = "General Settings";
			$this->general_setting = $this->model->general_settings();
			$this->template->content = new View("template/template2");
		}
		
		/** MODULE PERMISSION **/
		
		public function module_permission()
		{
			if($_POST){
				$module = $this->input->post("permission");
				$userid = $this->input->post("usr_id");
				
				if(count($module) > 0 ){
					$module_permission = '';
					foreach($module as $row) {
						$module_permission.= $row.",";
					} 
					$modules = substr($module_permission,0,-1);
					$this->model->change_module_permission($modules,$userid);
				}
			}
			url::redirect($this->docroot."admin/manage_users");
			die();
		}
		
		//permission
		public function permission()
		{
			//declare the array to get initial values from db
			
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			
			$this->template->title="Permission Settings";
			$this->get_modules=$this->model->get_modules();
			$this->get_permission=$this->model->get_permission();
			
				if($_POST)
				{
				       
					$add=$this->input->post("add");
					$edit=$this->input->post("edit");
					$delete=$this->input->post("delete");
					$block=$this->input->post("block");
					
					//add permission for all moderator
					if(count($add)>0)
					{
					        //set the empty values to all add permission
					        $this->model->set_add_empty("add");
					        foreach($add as $row)
					        {
					               $this->model->set_add_permission($row);
					        }
					}
					
					if(count($edit)>0)
					{
					        //set the empty values to all add permission
					        $this->model->set_add_empty("edit");
					        
					        foreach($edit as $row1)
					        {
					               $this->model->set_edit_permission($row1);
					        }
					}
					
					if(count($delete)>0)
					{
					        //set the empty values to all add permission
					        $this->model->set_add_empty("delete");
					        
					        foreach($delete as $row2)
					        {
					               $this->model->set_delete_permission($row2);
					        }
					}
					
					if(count($block)>0)
					{
					        //set the empty values to all add permission
					        $this->model->set_add_empty("block");
					        
					        foreach($block as $row3)
					        {
					               $this->model->set_block_permission($row3);
					        }
					}
					
			
				Nauth::setMessage(1,$this->set_permission);
				url::redirect($this->docroot."admin/permission");
				}
				
			 // template code
		 $this->left=new View("general/left");
		 $this->right=new View("general/permission");

		 $this->title_content = "Permission Settings";

		 $this->template->content=new View("template/template2");

		}
		//make moderator
		public function make_moderator()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			$this->template->title="Make Moderator";
			$user_type=$this->input->get('user_type');
			$id=$this->input->get('id');
			$this->model->make_moderator($user_type,$id);
			Nauth::setMessage(1,$this->user_access);
			url::redirect($this->docroot.'admin/manage_users');
		}
		
		//manage users
		public function manage_users()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			 
			if($_POST){
				$uid = $this->input->post("user_id");
				$user = $this->input->post("user");
				$moderator = $this->input->post("moderator");
				$admin = $this->input->post("admin");
				$this->model->update_user_status($uid,$user, $moderator, $admin);
				url::redirect($this->docroot.'admin/manage_users');
			}
			
			$this->template->title = "Manage Users";
			$this->country_list=$this->model->get_country();
			
			$this->get_user_role = $this->model->get_user_role(); 
			
			//get the moderator permission
			$this->get_moderator_permission = $this->model->get_moderator_permission();
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
			$this->template->get_user=$this->model->getuser($offset,10);
			$this->total_admin_user=$this->model->getuser_count();
			$this->template->pagination = new Pagination(array
			 (
			 'base_url'       => '/admin',
			 'uri_segment'    => 'manage_users',
			 'items_per_page' => 10,
			 'total_items'    => $this->model->getuser_count(),
			 'style'         => 'classic' )
			 );

		 // template code
		 $this->left=new View("general/left");
		 $this->right=new View("general/manage_users");

		 $this->title_content = "Manage Users";

		 $this->template->content=new View("template/template2");
		}
		
		//manage users
		public function search_users()
		{
		        $key = $this->input->get("search_value");
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			if($_POST){
				$uid = $this->input->post("user_id");
				$user = $this->input->post("user");
				$moderator = $this->input->post("moderator");
				$admin = $this->input->post("admin");
				$this->model->update_user_status($uid,$user, $moderator, $admin);
				url::redirect($this->docroot.'admin/manage_users');
			}
			$this->template->title = "Manage Users";
			
			$this->country_list=$this->model->get_country(); //get country
			
			$this->get_module_enabled = $this->model->get_enable_module(); //get the enable modules 
			
			//get the moderator permission
			$this->get_moderator_permission = $this->model->get_moderator_permission(); //get the moderator permission
			
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
			
			$this->template->get_user=$this->model->search_user($key,$offset,10); 
			$this->get_user_role = $this->model->get_user_role(); 
			$this->total_admin_user=$this->model->search_user_count($key);
			
			$this->template->pagination = new Pagination(array
			 (
			 'base_url'       => '/admin',
			 'uri_segment'    => 'search_users',
			 'items_per_page' => 10,
			 'total_items'    => $this->model->getuser_count(),
			 'style'         => 'classic' )
			 );

		 // template code
		 $this->left=new View("general/left");
		 $this->right=new View("general/manage_users");

		 $this->title_content = "Manage Users";

		 $this->template->content=new View("template/template2");
		}
		
		public function edit_profile()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			if($_POST)
			{
				$userid=$this->input->post("userid");
				$first_name=$this->input->post("first_name");
				$last_name=$this->input->post("last_name");
				$email=$this->input->post("email");
				$street=$this->input->post("street");
				$city=$this->input->post("city");
				$country=$this->input->post("country");
				$postcode=$this->input->post("postcode");
				$phone=$this->input->post("phone");
				$mobile=$this->input->post("mobile");
				$dob=$this->input->post("dob");
				$gender=$this->input->post("gender");
				$this->update_user=$this->model->update_user($userid,$first_name,$last_name,$email,$street,$city,$country,$postcode,$phone,$mobile,$dob,$gender);
				
				Nauth::setMessage(1,$this->update_user); 
				url::redirect($this->docroot.'admin/manage_users/');
			}
		}
		//user access
		public function user_access()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			$this->template->title="Access";
			$status=$this->input->get('status');
			$id=$this->input->get('id');
			$this->model->set_user_access($status,$id);
			Nauth::setMessage(1,$this->user_access);
			url::redirect($this->docroot.'admin/manage_users');
		}

		//delete user
		public function delete_user()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			$id=$this->input->get("id");
			$this->template->title="Delete User";
			$this->template->delete_user=$this->model->delete_user($id);
			Nauth::setMessage(1,$this->delete_user); //set session message using library
			url::redirect($this->docroot.'admin/manage_users/');
		}
		
		//send the mail
		public function sentmail()
		{
		
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			if(request::is_ajax())
			{
				$userid = $this->input->get('uid');
				$toid = $this->input->get('toid');
				$message = $this->input->get('msg');
	 		    $subject = $this->input->get('sub');
				 
				if($userid && $toid && $message)
				{ 
			
				$this->toid=$this->model->get_toid($toid);
				$this->fromid=$this->model->get_toid($userid);
			
				$mail_toid=$this->toid["mysql_fetch_row"]->email;
				$mail_fromid=$this->fromid["mysql_fetch_row"]->email;
			
				$headers = 'From: $this->fromid ' . "\r\n" .
	    'Reply-To: $this->fromid ' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
		    
				mail($mail_toid, $subject, $message, $headers);

				echo "Mail sent successfully";	
				die();
				}
				else
				{
					
					echo "Cant able to access your request";
					die();
				}
			}
			else
			{
				$_SESSION["Msg"] =  "Invalid Call";
				die();
			}
		}

		 
		//modules settings
		public function modules()
		{	
			 if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			 $this->template->title="Modules Settings";
			 $this->module_setting=$this->model->module_settings();
 
			 // template code
			 $this->left=new View("general/left");
			 $this->center=new View("general/modules");
			 $this->right=new View("general/module_right");

			 $this->title_content = "Module Settings";

		 	 $this->template->content=new View("template/template3");
		 
		}
		//new module install to get the module name which is not yet installed
		public function modules_install()
		{	
			 if($this->usertype != -1)
			 {
			 	url::redirect($this->docroot."admin");
			 }
			 $this->template->title="Modules Settings";
			 $this->module_setting=$this->model->module_settings();
 
			 // template code
			 $this->left=new View("general/left");
			 $this->center=new View("general/new_modules");
			 $this->right=new View("general/module_right");

			 $this->title_content = "Modules Setting";

		 	 $this->template->content=new View("template/template3");
		 
		}
		// installing new module
		public function install()
		{	

                if($this->usertype != -1)
                {
                url::redirect($this->docroot."admin");
                }
                $mod_name=$this->input->get("mod");
                
                $this->module_setting=$this->model->module_find($mod_name);
                // If module already installed

                if($this->module_setting==-1)
                { 
                
                Nauth::setMessage(-1,$this->module_exists);
	        url::redirect($this->docroot.'admin/modules/');
                                        
                }
                elseif($this->module_setting==1)
                {
                        if(file_exists($this->file_docroot."/modules/".$mod_name."/install.php"))
                        {
                                include $this->file_docroot."/modules/".$mod_name."/install.php";
                                // module settings entry
                                
                                //$this->insert_module=$this->model->insert_module($mod_name);
                                
                                
                                // config file writting
                        
                        /*config file write starts*/
                        //getting the module details
                        $this->get_module=$this->model->get_module();
                        $r="";
                        $s="";
                        //print_r($this->get_module); 
                        
                        $r1='$'."config['search'] = array(  1 => \"answers\",\n 2 => \"blog\",\n
	                3 => \"classifieds\",\n
	                4 => \"events\",\n
	                5 => \"forum\",\n
	                6 => \"groups\",\n
	                7 => \"inbox\",\n
	                8 => \"news\",\n
	                9 => \"photos\",\n
	                10 => \"video\",\n
	                11 => \"profile\",);";      
                        

                        foreach($this->get_module as $module)
                        { 
                                
                                        $s=$s."MODPATH".".'".$module->name."',\n";
                                
                        }
                       $s1='$'."config['modules'] = array ( ".$s.");";
                       
                         echo $result = '<?php'."\n"." ".$r1."\n".$s1;
                        
                        exit;
                        
                        /*config file write ends*/
                                Nauth::setMessage(1,$this->module_installed);
                                url::redirect($this->docroot.'admin/modules/');
                        }
                        else
                        {     
                              
                        }
                        

                }	
                $this->template->title="Module Settings";

                // template code
                $this->left=new View("general/left");
                $this->center=new View("general/install_modules");
                $this->right=new View("general/module_right");

                $this->title_content = "Modules Setting";

                $this->template->content=new View("template/template3");
		 
		}
		//activate the modules
		public function activate()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			$id=$this->input->get("id");
			$status=$this->input->get("status");
			$this->template->title="Activate Modules";
			$this->template->activate=$this->model->module_activate($id,$status);
			$this->get_module=$this->model->get_module();
                          
			Nauth::setMessage(1,$this->module_change); 
			url::redirect($this->docroot.'admin/modules/');
		}


	//email
		 public function email()
		 {
		 	if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			 $this->template->title="Email";
			
			 $this->template->email_all=$this->model->email_all();
			
			 if($_POST)
			 {
				 $from=$this->input->post('from');
				 $to1=$this->input->post('to');
				
				 $to=substr($to1,0,strlen($to1)-2);
				// echo $to;
				 $subject=$this->input->post('subject');
				 $message=$this->input->post('message');
				 //email to all
			
					$headers = 'From: admin@bit.com' . "\r\n" .
				'Reply-To: admin@bit.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			
				mail($to, $subject, $message, $headers);
				Nauth::setMessage(1,$this->email);
				url::redirect($this->docroot.'admin/');
			
				// $file=$this->input->post('upload');
		
			}
			
			 // template code
			 $this->left=new View("general/left");
			 $this->right=new View("general/email_all");
	
			 $this->title_content = "Email";
	
			 $this->template->content=new View("template/template2");
  
	 }
	 //themes
	public function themes()
	{	
		if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
		}
		if($_POST)
		{
			$theme = $this->input->post('set_themes');
			
			$this->set_theme = $this->model->set_theme($theme);
			Nauth::setMessage(1,$this->change_theme);
			//$this->session->delete("theme_name");
			url::redirect($this->docroot.'admin/themes');
			die();
		}
		$this->template->title="Change theme";
		$this->left=new View("general/left");
		$this->right=new View("general/themes_right");
		$this->title_content = "Themes";
		$this->template->content=new View("template/template2");
	}	
	//manage roles
	public function manage_role()
   	{   
		if($_POST)
		{
		
		        $id=$this->input->post("id");
		        $name=$this->input->post("name");
		        $type=$this->input->post("type");
		
		        if($type=='update')
		        {
		               
			        $this->model->update_role($id,$name);
			        Nauth::setMessage(1,$this->update_role);
			        
		        }
		        elseif($type=='add')
		        {
		                $module_name = $this->input->post("module_name");
			        $this->model->insert_role($name,$module_name);
		        }
		        
		        url::redirect($this->docroot.'admin/manage_role');
		}
	        
		$this->result = $this->model->get_roles();
		$this->modules_name = $this->model->get_enable_module();
		$this->template->title = "Role Management";

		// template code
		$this->left = new View("general/left");
		$this->right = new View("general/role");
		
		$this->title_content = "Role Management";
		$this->template->content=new View("/template/template2");	 	
	} 	
	public function delete_role()
	{
	        $id = $this->input->get("id");
	        $this->model->delete_role($id);
	         Nauth::setMessage(1,$this->delete_role);
	        url::redirect($this->docroot.'admin/manage_role');
	}
	//login need for the modules
		public function login_need()
		{
			if($this->usertype != -1){
			 	url::redirect($this->docroot."admin");
			 }
			$id = $this->input->get("id");
			$login = $this->input->get("login");
			$this->template->title = "Login Module";
			$login = $this->model->module_login($id,$login);
			if($login == 1){
				$this->session->delete("no_login_module");
			}
			$this->get_module = $this->model->get_module();
                          
			Nauth::setMessage(1,$this->module_login); 
			url::redirect($this->docroot.'admin/modules/');
		}
}
