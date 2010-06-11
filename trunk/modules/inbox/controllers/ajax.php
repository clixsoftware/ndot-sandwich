<?php
class Ajax_Controller extends Controller {
	public function __construct()
	{
		Nauth::is_login();
		$mes = Kohana::config('users_config.session_message');
		$this->mail_sent = $mes["mail_sent"];
		$this->mail_delete = $mes["mail_delete"];
		$this->mail_archive = $mes["mail_archive"];
	}
	public function deletemail()
	{
		require_once Kohana::find_file('models/','inbox_data',TRUE,'php');
		if(request::is_ajax())
		{
			$mailid=$_GET['mid'];
			$this->data=new Inbox_Data_Model();
			$userid=$this->data->get_id('',$mailid);
			$deletemail=$this->data->delete_mail($mailid,$userid);
			Nauth::setMessage(1,$this->mail_delete);
			
		} 
	}
	public function deletemailinbox()
	{
		
		require_once Kohana::find_file('models/','inbox_data',TRUE,'php');
		if(request::is_ajax())
		{
				$mailid=$_GET['mid'];
				$this->data=new Inbox_Data_Model();
				$userid=$this->data->getinbox_id($mailid);
				$deletemail=$this->data->delete_mail($mailid,$userid);
				Nauth::setMessage(1,"Select Mail has been deleted");
				exit;
		} 
	}
	
	public function readstatus()
	{
		if(request::is_ajax())
		{	
			$mailid=$_GET['mid'];
			$userid=$_GET['uid'];
			require_once Kohana::find_file('models/','inbox_data',TRUE,'php');
			$this->data=new Inbox_Data_Model();
			$readmailmail=$this->data->readstatus_mail($mailid,$userid);
			exit;
		}
	}
	
	public function movearchive()
	{
		if(request::is_ajax())
		{
			require_once Kohana::find_file('models/','inbox_data',TRUE,'php');
			$mailid=$_GET['mid'];
			$this->data=new Inbox_Data_Model();
			$archivemailmail=$this->data->archive_mail($mailid);
			Nauth::setMessage(1,$this->mail_archive);
			exit;
		}
	}
	
	public function movetoinbox()
	{
		if(request::is_ajax())
		{
			require_once Kohana::find_file('models/','inbox_data',TRUE,'php');
			$mailid=$_GET['mid'];
			$this->data=new Inbox_Data_Model();
			$archivemailmail=$this->data->moveto_inbox($mailid);
			exit;
		}
	}
	
	public function checkuser()
	{
		require_once Kohana::find_file('models','inbox_data',TRUE,'php');
		$miss='0';
		$this->data=new Inbox_Data_Model();
		$miss='sds';
		if(request::is_ajax())
		{ 
		
			$unames=$_GET['unames'];
			$toname=((explode(',', $unames)));
			if(count($toname)>1)
			{
			$removeone=array_pop($toname);
			}	
				foreach($toname as $touserid)
				{
					if($touserid=='toall')
					{
					}
					else
					{
					
						$this->toids = $this->data->get_id(trim($touserid));
						if(count($this->toids)!=0)
						{
						}
						else
						{
							$miss='0';}
					}
				}
		}
		if($miss=='0')
		{
			echo 'Entered friend was incorrect please verify';
		}
		else
		{
			echo 'correct';
		}
		exit;			
		}
		
	}
