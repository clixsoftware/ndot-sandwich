<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
	*  helper use check user type, admin or user or moderator  
**/

class Permission{
	public  function check($module = "")
	{
		if($this->usertype == -1 || $this->usertype == -2 ){
				if($this->usertype == -2){
					$m_id  = '';
					foreach($this->session->get("enable_module") as $key => $row){
						if($row == $module){
							$m_id = $key;
						}
					}
					$user_module = $this->session->get("u_mod");
					if(!in_array($m_id, $user_module)){
						url::redirect($this->docroot."admin");
						die();
					}
				}
			}
			else{
				url::redirect($this->docroot."profile");
				die();
			}

		return;
	}
}