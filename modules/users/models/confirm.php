<?php 
class Confirm_Model extends Model 
{
	public function __construct()
	{
		parent::__construct();
		$db=new Database();
		$this->config=Kohana::config('database.default');
		$this->prefix = $this->config['table_prefix'];
	}

	public function insert_mail($userid='',$mailsubject='',$mailmessage='',$from_id = '')
	{
		$mailsubject=html::specialchars($mailsubject);
		$mailmessage=html::specialchars($mailmessage);
		$objecttype = -1;
		$query=$this->db->query("insert into ".$this->prefix."inbox (user_id,subject,message,mail_date,type) values ('".$userid."','".$mailsubject."','".$mailmessage."',now(),'$objecttype')");
		if($query)
		{
			$mailid=$query->insert_id();
			return $mailid;
		}
	}
}

?>
