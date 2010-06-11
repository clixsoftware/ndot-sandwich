<?php  defined('SYSPATH') OR die('No direct access allowed.'); 

class Mail_Core {
			//funtion forgot password mail format
		public function mail_invite($user,$user_mailid,$friend_mailid,$friend_name)
		{
			$invite=implode("",file(DOCROOT.'/mail/invite.html'));		
			$invite=str_replace('$user_name$',$user,$invite);
			$invite=str_replace('$user_mailid$',$user_mailid,$invite);
			$invite=str_replace('$friend_mail$',$friend_mailid,$invite);
			$invite=str_replace('$friend_name$',$friend_name,$invite);
			return $invite;
		}	
			//funtion forgot password mail format
		public function	mail_forgot($user,$user_id,$user_pass)	
		{
			$forgot=implode("",file(DOCROOT.'public/mail/forgot.html'));		
			$forgot=str_replace('$user_name$',$user,$forgot);
			$forgot=str_replace('$user_id$',$user_id,$forgot);
			$forgot=str_replace('$user_pass$',$user_pass,$forgot);
			return $forgot;
		}
			//funtion forgot password mail format
		public function	mail_registration($user,$user_id,$user_pass)
		{
			$registration=implode("",file(DOCROOT.'mail/registration.html'));	
			$registration=str_replace('$user_name$',$user,$registration);
			$registration=str_replace('$user_id$',$user_id,$registration);
			$registration=str_replace('$user_pass$',$user_pass,$registration);
			return $registration;
		}
		}
?>		
	


