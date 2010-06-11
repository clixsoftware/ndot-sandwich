<?php //defined('SYSPATH') OR die('No direct access allowed.'); 
class Ndot 
{
	public function __construct()
	{
	}
	// Login 
	function login($userid = "1", $username = "nandha", $email = "nandhu29@gmail.com",$usertype="") 
	{ 
		
			
			/*$param = array("userid" => $userid, "username" => $username, "email" => $email, "user-type" => $usertype );
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,"http://".$_SERVER['HTTP_HOST']."/ndot/comments/set_session/");
			curl_setopt($ch,CURLOPT_POST,3);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
			
			$result = curl_exec($ch);  
			curl_close($ch); 
			header("location:/ndot/profile/");
			die();*/
			
		$_SESSION["userid"] = $userid;
		$_SESSION["username"] = $username;
		$_SESSION["usertype"] = $usertype;
		setcookie("userid",$userid,time()+150,"/");
		header("location:/");
		die();
	}
	//
	
	function logout()
	{ 
		foreach($_COOKIE as $key=>$value){
			unset($_COOKIE[$key]); 
			setcookie($key,"",time()-3600);
		}
		print_r($_COOKIE); 
		header("location:/");
		exit;
	}
	
	/**
		This function is used to set comments form Third Party   	
	*/
	
	function set_updates($user_id = '',$uniqueId = '',$content = '')
	{ 
	
	
			$param = array("userid" => $user_id, "url" => $uniqueId, "content" => $content );
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,"http://".$_SERVER['HTTP_HOST']."/ndot/comments/third_party_set_updates/");
			curl_setopt($ch,CURLOPT_POST,3);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
			
			$result = curl_exec($ch); 
			curl_close($ch); 
			//return 0;
			//header('location:'.$url);
			
	}
	
	/**
		This function is used to get comments form Third Party   
		Response Type 1==XML,2==HTML	
		
		Unique ID - URL, Integer Or String
	*/
	function get_updates($uniqueId = '',$width='500',$height='400') 
	{ 
		
		echo "<iframe src=\"http://".$_SERVER['HTTP_HOST']."/comments/third_party_get_updates/?uniqueId=".$uniqueId."\" frameborder=\"0\" width='$width' scrolling=\"no\" height='$height' style=\"overflow:hidden;\" ></iframe>";
		?>
      

        <?php
		return 1;
	}

	/**
		This function is used to get comments form Third Party   
		Response Type 1==XML,2==HTML	
		
		Unique ID - URL, Integer Or String
	*/
	function get_fans($uniqueId = '',$width='500',$height='400') 
	{ 
		echo "<iframe src=\"http://".$_SERVER['HTTP_HOST']."/comments/third_party_get_fans/?uniqueId=".$uniqueId."\" frameborder=\"0\" width=".$width." scrolling=\"no\" height=".$height." ></iframe>";
	}

 }
?>
