<?php 
class Inbox_Data_Model extends Model 
{
	public function __construct()
	{
		parent::__construct();
		$db=new Database();
		
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->config=Kohana::config('database.default');
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$this->uidfield = $config['uidfield'];
		$this->unamefield = $config['unamefield'];
		$this->upass = $config['upass'];
		$this->uemail = $config['uemail'];
		$this->ustatus = $config['ustatus'];
		$this->utype = $config['utype'];
				$this->session=Session::instance();
		$this->docroot=$this->session->get('DOCROOT');
	}
	
	public function get_mail($userid='',$offset='',$noofpage='')
	{
		$queryString = "select ".$this->prefix."sent_mails.user_id as id,sentmail_id,read_status,$this->uemail as email,city,$this->unamefield as name,cdesc,subject,message,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->usertable." on ".$this->usertable.".$this->uidfield = ".$this->prefix."inbox.user_id left join ".$this->prefix."users_profile on ".$this->usertable.".$this->uidfield = ".$this->prefix."users_profile.user_id left join ".$this->prefix."country on ".$this->prefix."country.cid = ".$this->prefix."users_profile.country  where (mailto_id = '$userid' or cc_id='$userid') and (archive='0' and delete_status!='$userid')   order by sentmail_id desc limit $offset,$noofpage";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	
	public function get_invitations($userid='',$offset='',$noofpage='')
	{
		$queryString = "select * from ".$this->prefix."invitations order by id desc limit $offset,$noofpage";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	public function get_search_mail($searchkey='',$userid='',$offset='',$noofpage='')
	{
		$queryString = "select ".$this->prefix."sent_mails.user_id as id,sentmail_id,read_status,$this->uemail as email,city,$this->unamefield as name,cdesc,subject,message,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->usertable." on ".$this->usertable.".$this->uidfield  = ".$this->prefix."inbox.user_id left join ".$this->prefix."users_profile on ".$this->usertable.".$this->uidfield  = ".$this->prefix."users_profile.user_id left join ".$this->prefix."country on ".$this->prefix."country.cid = ".$this->prefix."users_profile.country  where (subject like '%$searchkey%' or message like '%$searchkey%')  and (mailto_id = '$userid' or cc_id='$userid') and (archive='0' and delete_status!='$userid')   order by sentmail_id desc limit $offset,$noofpage";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	
	public function get_sentmail($userid='',$offset='',$noofpage='')
	{
		$queryString = "select ".$this->prefix."sent_mails.mailto_id as id,sentmail_id,read_status,$this->uemail as email,city,$this->unamefield as name,cdesc,subject,message,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->usertable." on ".$this->usertable.".$this->uidfield  = ".$this->prefix."sent_mails.mailto_id left join ".$this->prefix."users_profile on ".$this->usertable.".$this->uidfield  = ".$this->prefix."users_profile.user_id left join ".$this->prefix."country on ".$this->prefix."country.cid = ".$this->prefix."users_profile.country where (".$this->prefix."sent_mails.user_id = '$userid' and ".$this->prefix."sent_mails.archive='0') and (delete_status!='$userid' or delete_status=-1 ) order by sentmail_id desc limit $offset,$noofpage";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	
	public function get_archivemail($userid='',$offset='',$noofpage='')
	{
		$queryString = "select ".$this->prefix."sent_mails.user_id as id,sentmail_id,read_status,$this->uemail as email,city,$this->unamefield as name,cdesc,subject,message,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->usertable." on ".$this->usertable.".$this->uidfield  = ".$this->prefix."sent_mails.user_id left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->prefix."users_profile on ".$this->usertable.".$this->uidfield  = ".$this->prefix."users_profile.user_id left join ".$this->prefix."country on ".$this->prefix."country.cid = ".$this->prefix."users_profile.country where (".$this->prefix."sent_mails.mailto_id = '$userid' or ".$this->prefix."sent_mails.user_id='$userid') and (".$this->prefix."sent_mails.archive='1' and ".$this->prefix."sent_mails.delete_status!='$userid') order by ".$this->prefix."sent_mails.sentmail_id desc limit $offset,$noofpage";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	
	public function getreply_data($reyid='')
	{
		$query=$this->db->query("select *,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->usertable." on ".$this->usertable.".$this->uidfield  = ".$this->prefix."sent_mails.user_id where sentmail_id='$reyid'");
		return $query;
	}
	
	public function getsentreply_data($userid='',$reyid='')
	{
			$query=$this->db->query("select *,".$this->usertable.".".$this->uidfield." as id,".$this->usertable.".".$this->unamefield." as name,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id left join ".$this->usertable." on ".$this->usertable.".$this->uidfield  = ".$this->prefix."sent_mails.mailto_id where ".$this->prefix."sent_mails.user_id = '$userid' and ".$this->prefix."sent_mails.sentmail_id='$reyid'");
		return $query;
		return $query;
	}
	
	public function insert_mail($userid='',$mailsubject='',$mailmessage='',$objecttype='')
	{
		$mailsubject=html::specialchars($mailsubject);
		$mailmessage=html::specialchars($mailmessage);
		$query=$this->db->query("insert into ".$this->prefix."inbox (user_id,subject,message,mail_date,mod_id) values ('".$userid."','".$mailsubject."','".$mailmessage."',now(),'$objecttype')");
		if($query)
		{
			$mailid=$query->insert_id();
			return $mailid;
		}
	}
	
	public function insert_invitations($userid='',$name='',$email='')
	{
		$query = "insert into ".$this->prefix."invitations (user_id,name,email) values ('$userid','$name','$email')";
		$this->db->query($query);
	}

	public function sent_mail($userid='',$mailid='',$toid='',$ccid='')
	{
		if($toid!='' && $mailid!='' && $ccid=='')
		{
			$query = $this->db->query("insert into ".$this->prefix."sent_mails(id,user_id,mailto_id) values ('".$mailid."','".$userid."','".$toid."')");
		}
		if($ccid!='' && $mailid!='')
		{
			$query = $this->db->query("insert into ".$this->prefix."sent_mails(id,user_id,mailto_id,cc_id) values ('".$mailid."','".$userid."','".$toid."','".$ccid."')");
		}
		return;
	}
	
	public function get_id($name='',$mail_id='')
	{
		
		if($name!='')
		{
			$querystring = "select * from ".$this->usertable." where $this->unamefield='$name'";
			$query=$this->db->query($querystring);
			
			return $query;
			
		}
		if($mail_id!='' && $name=='')
		{
			$query=$this->db->query("select user_id from ".$this->prefix."sent_mails where sentmail_id='$mail_id'");
			foreach($query as $row)
			{
			return $row->user_id;
			}
		}
	}
	
	public function getinbox_id($mailid='')
	{
		$query=$this->db->query("select mailto_id from ".$this->prefix."sent_mails where sentmail_id='$mailid'");
		foreach($query as $row)
		{
			return $row->mailto_id;
		}
	}
	
	public function delete_mail($mail_id='',$userid='')
	{
		$query=$this->db->query("select delete_status from ".$this->prefix."sent_mails where sentmail_id='$mail_id'");
		foreach($query as $row)
		{
			if($row->delete_status==-1)
			{
				$query=$this->db->query("update ".$this->prefix."sent_mails set delete_status='$userid' where sentmail_id='$mail_id'");
				//url::redirect('../inbox/inboxshow');
				return 1;
			}
			else
			{
				$query=$this->db->query("delete from ".$this->prefix."sent_mails where sentmail_id='$mail_id' and delete_status!='$userid'");
				//url::redirect('../inbox/sent_mails');
				return 2;
			}
		}
		/* if($query)
		{
			
		}
		else
		{
			echo 'error in deleting';
		}*/
	}
	
	public function readstatus_mail($mail_id='',$userid='')
	{
		//echo $mail_id.$userid;exit;
		$query=$this->db->query("select read_status from ".$this->prefix."sent_mails where sentmail_id='$mail_id'");
		foreach($query as $row)
		{
			if($row->read_status==-1 || $row->read_status==$userid)
			{
			$query=$this->db->query("update ".$this->prefix."sent_mails set read_status='$userid' where sentmail_id='$mail_id'");	
			}
			else
			{
			$query=$this->db->query("update ".$this->prefix."sent_mails set read_status='3'where sentmail_id='$mail_id'");
			}
		}
		if($query)
		{
			echo 'mail has been read';
		}
		else
		{
			echo 'error in read status ';
		}
		exit;
	}
	
	public function archive_mail($mailid='')
	{
		$query=$this->db->query("update ".$this->prefix."sent_mails set archive='1' where sentmail_id='$mailid'");	
		if($query)
		{
			echo 'The conversation has been archived.';
		}
		else
		{
			echo 'error in Archive';
		}
	}
	
	public function moveto_inbox($mailid='')
	{
		//echo $mailid.'Mail id  ';
		$query=$this->db->query("update ".$this->prefix."sent_mails set archive='0' where sentmail_id='$mailid'");	
		if($query)
		{
			echo 'The conversation has been archived.';
		}
		else
		{
			echo 'error in Archive';
		}
	}
	
	public function get_friends($user_id='',$status='1')
	{
		$sql="Select ".$this->uidfield." as id,tab.request_id,".$this->unamefield." as name,gender,city,$this->uemail as email,street from (SELECT user_id,request_id FROM ".$this->prefix."user_friend_list  where (friend_id='$user_id' and status='$status') union SELECT friend_id,request_id FROM ".$this->prefix."user_friend_list  where (user_id='$user_id' and status='$status')) as tab left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=tab.user_id left join  ".$this->prefix."users_profile on  ".$this->prefix."users_profile.user_id=tab.user_id where ".$this->usertable.".".$this->ustatus."=1 ";
		$exe=$this->db->query($sql);
		return $exe;
	}
	
	public function unread_count($userid='')
	{
		$query=$this->db->query("select id from ".$this->prefix."sent_mails where ((read_status='-1' || read_status!='$userid') and (mailto_id='$userid' and archive='0')) and (read_status!=3 and delete_status!='$userid')");
		return $query;
	}
	
	public function get_invitations_count($userid='')
	{
		$queryString = "select * from ".$this->prefix."invitations order by id desc";
		$query = $this->db->query($queryString);
		if($query)
		{
			return $query;
		}
		else
		{
			echo 'error in fetching';
		}
	}
	
	
	public function get_inbox_count($userid='')
	{
		$count =$this->db->query("select id from ".$this->prefix."sent_mails where mailto_id='$userid' and archive='0' and (delete_status!='$userid' or delete_status=-1 )");
		return count($count);
	}

	public function get_search_inbox_count($searchkey='',$userid='')
	{
		$count =$this->db->query("select ".$this->prefix."sent_mails.id,DATE_FORMAT(`mail_date`,'%D %b %y') as dat from ".$this->prefix."sent_mails left join ".$this->prefix."inbox on ".$this->prefix."inbox.mail_id = ".$this->prefix."sent_mails.id  where (subject like '%$searchkey%' or message like '%$searchkey%')  and (mailto_id = '$userid' or cc_id='$userid') and (archive='0' and delete_status!='$userid')");
		return count($count);
	}
	
	public function get_archive_count($userid='')
	{
		$count=$this->db->query("select id from ".$this->prefix."sent_mails where (mailto_id='$userid' or user_id='$userid') and archive='1' and (delete_status!='$userid' or delete_status=-1 )");
		return count($count);
	}
	
	public function get_sentmail_count($userid='')
	{
		$count=$this->db->query("select id from ".$this->prefix."sent_mails   where ".$this->prefix."sent_mails.user_id = '$userid' and ".$this->prefix."sent_mails.archive='0' and (delete_status!='$userid' or delete_status=-1 ) order by sentmail_id desc");
		return count($count);
	}

}
?>
