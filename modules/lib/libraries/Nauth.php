<?php defined('SYSPATH') OR die('No direct access allowed.'); 
class Nauth_Core {
	
	public function __construct()
	{
		parent::__construct();
		$this->docroot = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
		echo $this->docroot.'test';exit; 
		$this->users=new Users_Model();
	}
	
	
	 //checking login 
	public function module_login($module = "")
	{
		$session = Session::instance();
		if(!$session->get('userid')){
			if(in_array($module,$this->login_moule)){
				return;
			}
			else{
				Nauth::setMessage(-1,"Login to Access");
				$session->set("reffer_url" , substr($_SERVER['REQUEST_URI'],1));
				url::redirect($this->docroot);
			}
		}
		return;
	}
    //checking login 
	public function is_login($url = "")
	{
		$session = Session::instance();
		if(!$session->get('userid')){
			Nauth::setMessage(-1,"Login to Access");
			if($url){
				$session->set("reffer_url" , $url);
			}
			else{
				$session->set("reffer_url" , substr($_SERVER['REQUEST_URI'],1));
			}
			url::redirect($this->docroot);
		}
		return;
	}
	
	public function thirdpartylogin($userid='',$username='',$usertype='')
	{
		if($userid && $username && $usertype){
			$session = Session::instance();
			$session->set('userid',$userid);
			$session->set('username',$username);
			$session->set('usertype',$usertype);
			return TRUE; 
		}else{
			return FALSE;
		}
	}
	
	public function setpermission($add='',$edit='',$delete='')
	{
		$this->ADD = $this->EDIT = $this->DELETE = FALSE ;
		if($add){
			$this->ADD = TRUE;
		}
		if($edit){
			$this->EDIT = TRUE;
		}
		if($delete){
			$this->DELETE = TRUE;
		}
		return $this;
	}

	//set the session
	public function setMessage($type='',$msg='')
	{
		
		$session = Session::instance();
		if($type=='1'){
			$session->set('Msg',$msg);
		}elseif($type=='-1')
		{
			$session->set('Emsg',$msg);
		}
	}
	public function print_name($id,$name)
	{
		?>
			<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $id;?>" title="<?php echo $name;?>"><strong>
			<?php echo ucfirst($name);?></strong></a>
		<?php 
	}
	
 	//GET USER IMAGE 40x40
			
	public function getPhoto($id='',$name='',$photo='')
	{
		$img = "public/user_photo/50/".$id.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($id.$name)."?d=wavatar&s=40"; 
			$img_path = $img_url;
		}  
		
		?>
        	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $id ;?>" class="less_link">
   				 <img src="<?php echo $img_path; ?>" title="<?php echo ucfirst($name);?>" alt="<?php echo $name;?>" width="40" height="40" class="upd_photo" border="0" />  
    		</a>  
       <?php
	}   
	 
	 public function getPhotoTarget($id='',$name='',$photo='')
	{
		
		$img = "public/user_photo/50/".$id.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($id.$name)."?d=wavatar&s=40"; 
			$img_path = $img_url;
		}  
		?>
        	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $id ;?>"  class="less_link">
   				 <img src="<?php echo $img_path; ?>" title="<?php echo ucfirst($name);?>" alt="<?php echo $name;?>" class="upd_photo" border="0" />  
    		</a>  <br/>
            <a class="less_link" href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $id ;?>" title="<?php echo $name; ?>">
            <?php echo wordwrap($name, 8, "<br/>", true);  ?>
            </a>
       <?php
	}   
	      
	//GET USER IMAGE, NAME 40x40
	
	public function getPhotoName($id='',$name='',$photo='', $isFB = 0, $isTwitter =0)
	{
		$img = "public/user_photo/50/".$id.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($id.$name)."?d=wavatar&s=40"; 
			$img_path = $img_url;
		}  
		?>
        	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $id ;?>" class="less_link">
   				 <img src="<?php echo $img_path; ?>" title="<?php echo ucfirst($name);?>" alt="<?php echo $name;?>" class="upd_photo" border="0" />  
    		</a>  
		<br/> 
            <a class="less_link" href="<?php echo $this->docroot;?>profile/view/?uid=<?php echo $id ;?>" title="<?php echo $name; ?>">
            <?php echo wordwrap($name, 8, "<br/>", true);  ?>
            </a>
	<?php
	}
	
	//get user small image and name with single parameter "id"

	public function getNameImage($user_id='',$name='')
	{ 
		$img = "public/user_photo/50/".$user_id.".jpg";
		if(file_exists($img)){
			$img_path = $this->docroot.$img;
		}
		else{
			$img_url = "http://www.gravatar.com/avatar/".md5($user_id.$name)."?d=wavatar&s=40"; 
			$img_path = $img_url;
		}  
		?>
        	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $user_id ;?>" class="less_link">
   		<img src="<?php echo $img_path; ?>" title="<?php echo ucfirst($name);?>" alt="<?php echo $name;?>" class="upd_photo" border="0" />  
    		</a>  
     
    	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php echo $user_id; ?>" title="<?php echo $name; ?>" class="less_link">
	<?php  if(strlen($name)>8) {  echo substr(ucfirst($name),0,5)."..."; } else { echo ucfirst($name); } ?>
  	  </a>
	<?php 
	}	
        //get name alone with single parameter "id"

        public function get_Name($user_id='')
	{
	        $this->users=new Users_Model();
	        $this->Name_Image=$this->users->nameimage($user_id);  
	        if(count($this->Name_Image) > 0)
	        {
	        ?>
            	<a href="<?php echo $this->docroot ;?>profile/view/?uid=<?php if($this->Name_Image){ echo $this->Name_Image['mysql_fetch_row']->id; } else{} ?>" title="<?php if($this->Name_Image){ echo $this->Name_Image['mysql_fetch_row']->name; } else{} ?>" class="less_link">
	        <strong><?php if($this->Name_Image) { echo  ucfirst($this->Name_Image["mysql_fetch_row"]->name);  } else{} ?></strong>
          	  </a>
	        <?php 
	        }
	}
	
	//send the mail
	public function send_mail($to='',$from='',$subject='',$message='',$type='',$objecttype = '')
	{
		
	
		if(!empty($type))
		{
			$this->users=new Users_Model();
			$this->mail_template=$this->users->get_mail_template($type);
			$message=htmlspecialchars_decode($this->mail_template["mysql_fetch_array"]->mail_temp_code);
		}
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From:'.$from.'' . "\r\n";
		$headers .= 'Cc: '.$from.'' . "\r\n";
		$headers .= 'Bcc: '.$from.'' . "\r\n";

		mail($to, $subject,$message, $headers);
		
	}

	public function send_mail_id($user_id = "", $friend_id = "", $type = "", $description = "", $objecttype = "")
	{
                

		if(!empty($type))
		{
			$this->users=new Users_Model();
			$this->mail_template = $this->users->get_mail_template($type);
			$subject = htmlspecialchars_decode($this->mail_template["mysql_fetch_array"]->mail_subject);			       
			     
			$this->to_mail_id = $this->users->get_mail_addr($user_id);
			if(count($this->to_mail_id) > 0){
			
				$to = htmlspecialchars_decode($this->to_mail_id["mysql_fetch_array"]->email);
				
				$user_name = $this->to_mail_id["mysql_fetch_array"]->name;
		      
				$this->from_mail_id = $this->users->get_admin_mail_addr();
				if(count($this->from_mail_id)){
					$from = htmlspecialchars_decode($this->from_mail_id["mysql_fetch_array"]->email); 
				}
				else{
					$from  = "admin"; 
				}
	
				 /* fetch mail template code by using $type */	
				$message=htmlspecialchars_decode($this->mail_template["mysql_fetch_array"]->mail_temp_code);
				$x = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
									$this->theme = new Menu_Model();
									$theme  = $this->theme->get_theme();
					if($type == 'forget password' || $type == 'Registration' ){
					
						/* Replace username, friend name,messsage url,descrip from mail template  */	
						$message=str_replace('$user_name$',$user_name,$message); 
						$message=str_replace('$user_id$',$to,$message);
						$message=str_replace('$user_pass$',$description,$message);
						$message=str_replace('$x',$x,$message);
						$message=str_replace('$theme',$theme,$message);
					}
					else{
					/* fetch "user name and friend name "  by using $user_id  and $friend_id */	      
					$this->friend_name = $this->users->get_name($friend_id);
					if(count($this->friend_name) > 0){
						$friend_name = htmlspecialchars_decode($this->friend_name["mysql_fetch_array"]->name);
						$friend_name = '<a href='.$x.'profile/view/?uid='.$friend_id.'>'.$friend_name.'</a>';
					}
					else{
						$friend_name  = "";
					}
				/* Replace username, friend name,messsage url,descrip from mail template  */	
					$message=str_replace('#user_name#',$user_name,$message); 
					$message=str_replace('#friend_name#',$friend_name,$message);
					$message=str_replace('#description#',$description,$message);
					$message=str_replace('$x',$x,$message);
					$message=str_replace('$theme',$theme,$message);
					
					}
							
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
					// Additional headers
					$headers .= 'From:'.$from.'' . "\r\n";
					$headers .= 'Cc: '.$from.'' . "\r\n";
					$headers .= 'Bcc: '.$from.'' . "\r\n";
				   
					/* send mail function */
					if(empty($subject))
					$subject = $type;
					common::insert_mail($user_id,$friend_id,$subject,$message,$objecttype);	
					@mail($to, $subject,$message, $headers);
		   	} 
		}
		return 1;
	}

        //Function to check module is enable or not
	public function mod_status($mod_name){
	}

        //ping the urls to make index
        public function ping($title, $title_url) 
        {
                $this->docroot = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
		
                $url = $this->docroot.$title_url;
                set_time_limit(0);
                $message = '<?xml version="1.0"?>' . "\r\n";
                $message = $message . "<methodCall>\r\n";
                $message = $message . " <methodName>weblogUpdates.ping</methodName>\r\n";
                $message = $message . " <params>\r\n";
                $message = $message . "  <param>\r\n";
                $message = $message . "   <value>$title</value>\r\n";
                $message = $message . "  </param>\r\n";
                $message = $message . "  <param>\r\n";
                $message = $message . "   <value>$url</value>\r\n";
                $message = $message . "  </param>\r\n";
                $message = $message . " </params>\r\n";
                $message = $message . "</methodCall>";

                //Add your RPC PING URIs here:
                $urls = array(

                'http://api.my.yahoo.com/RPC2',

                'http://blogsearch.google.co.in/ping/RPC2',

                'http://blogsearch.google.com/ping/RPC2'
                );
                
                //DO NOT TOUCH THIS SHIT UNLESS YOU KNOW WHAT YOU'RE DOING---------------
                foreach($urls as $i => $url) 
                {
                        $c = curl_init();
                        curl_setopt($c, CURLOPT_URL, $url);
                        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($c, CURLOPT_POST, TRUE);
                        curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
                        curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                        $content = trim(curl_exec($c));
                       
                        curl_close($c);
                }
        }


}
?>
