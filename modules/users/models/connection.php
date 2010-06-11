<?php 
/**
 * It cointains the facebook registration,facebook login,openid registration and openid login database functions.
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/

class Connection_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
		//getting the response message
		$mes=Kohana::config('users_config.session_message');
		$this->config=Kohana::config('database.default');

		$this->prefix = $this->config['table_prefix'];
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->usertable = $config['usertable'];

		$this->login=$mes["login"];
		$this->db=new Database();
		$this->session=Session::instance();
		$this->docroot = $this->session->get('DOCROOT');
	}

        //registration for facebook users
        public function facebook_registration($facebook_user_id,$facebook_user_name,$last_name='',$facebook_photo='')
	{

          $facebook_result=$this->db->query("select id,name,count(*) as total_count from ".$this->usertable." where third_id='$facebook_user_id'");
         
		 if($facebook_result['mysql_fetch_array']->total_count==1)
		 {
			 $this->session->set("userid",$facebook_result['mysql_fetch_array']->id);
			 $this->session->set("username",$facebook_result['mysql_fetch_array']->name);
			 $this->session->set("usertype",'3');
		
			 Nauth::setMessage(1,$this->login); //call the library function to set the session type
                         url::redirect($this->docroot.'profile/updateprofile');
			 
		 }
		 else
		 {
		        
		  	//generating default password to facebook users
			 $default_password=md5('$facebook_user_name');
			 
			 $result=$this->db->query("insert into ".$this->usertable."(name,password,user_type,user_status,third_id)values('$facebook_user_name','$default_password','3','1','$facebook_user_id')");
			 
			         $user_id = $result->insert_id();
			       
				//put the entry in users profile table
                                 $this->db->query("update ".$this->prefix."users_profile set last_name='$last_name',user_photo='$facebook_photo' where user_id = '$user_id'");
                                 
				//put the entry for privacy settings
                      		//$insert_exec_2 = $this->db->query("insert into ".$this->prefix."profile_settings(user_id) values('$user_id')");

				 if(isset($user_id))
				 {
				 $this->session->set("userid",$user_id);
				 $this->session->set("username",$facebook_user_name);
				 $this->session->set("usertype",'3');
				 Nauth::setMessage(1,$this->login); //call the library function to set the session type
				 
				 url::redirect($this->docroot.'profile/updateprofile');
				 }

		}
         
	}

        //checking existing user with open id
        public function get_openid_user($openid_url)
	{
		$result=$this->db->query("select count(*) as total_count from ".$this->usertable." where open_id='$openid_url'");
		return $result["mysql_fetch_array"]->total_count;
	}
        
       //open id registration

       public function openid_registration($username='',$email='',$openid_url='')
       {
           
         $openid_result=$this->db->query("select id,name,count(*) as total_count from ".$this->usertable." where open_id='$openid_url'");
		 
		 if($openid_result['mysql_fetch_array']->total_count==1)
		 {
		 $this->session->set("userid",$openid_result['mysql_fetch_array']->id);
		 $this->session->set("username",$openid_result['mysql_fetch_array']->name);
		 $this->session->set("usertype",'4');
		 Nauth::setMessage(1,$this->login); //call the library function to set the session type
		 url::redirect($this->docroot.'profile/updateprofile/');
		 }
		 else
		 {
		 //generating default password to openid users
		 $default_password=md5('openid');
		 $result=$this->db->query("insert into ".$this->usertable." (name,password,user_type,user_status,open_id)values('$username','$default_password','4','1','$openid_url')");
		 
		 $user_id=$result->insert_id();
		 
		 //put the entry in users profile table
                 //$this->db->query("insert into ".$this->prefix."users_profile(user_id)values('$user_id')");
                 
		 //put the entry for privacy settings
                 //$insert_exec_2 = $this->db->query("insert into ".$this->prefix."profile_settings(user_id) values('$user_id')");

			 if(isset($user_id))
			 {
			 $this->session->set("userid",$user_id);
			 $this->session->set("username",$username);
			 $this->session->set("usertype",'4');
			 Nauth::setMessage(1,$this->login); //call the library function to set the session type
			 url::redirect($this->docroot.'profile/updateprofile/');
			 }

		}

       }
}

?>

