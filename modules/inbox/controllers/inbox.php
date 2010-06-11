<?php 

class Inbox_Controller extends Website_Controller
{ 
	public $template = 'template/template';
	public $Objecttype = '-1';
	public $response;
	public function __construct()
	{
		parent::__construct();
		Nauth::is_login();
		$this->data = new Inbox_Data_Model();
		$this->model = new Profile_Model();
		
		 $mes = Kohana::config('users_config.session_message');
     	         $this->mail_sent = $mes["mail_sent"];
		 $this->mail_delete = $mes["mail_delete"];
		 $this->mail_archive = $mes["mail_archive"];
		 $this->searchvalue = '';
		 $this->module = "inbox";
	
	}
	public $toids;
	
	public function index()
	{
		url::redirect($this->docroot.'inbox/inboxshow');
		$userid = $this->session->get('userid');
		
		$userid='1';
		
		$this->gF = new Globalfunctions();
		$this->template->title='Inbox';
		
		$this->unread=$this->data->unread_count($userid);
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_mail($userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'base_url'    => 'inbox/inboxshow/page', 
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,
		'total_items' => $this->data->get_inbox_count($userid) 
		));
		$this->uid=$this->session->get('userid');
		//$this->template->title = "Inbox";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("inboxall");
		$this->title_content = "Inbox (".count($this->unread)." )";
		$this->template->content=new View("/template/template2");
		
		
	}

	public function autoname()
	{	
		$userid=$this->session->get('userid');
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		$this->friend = $this->data->get_friends($userid);
		foreach ($this->friend as $key) {
		
			if (strpos(strtolower($key->name), $q) !== false) {
				
				echo "<a style='display:none'>$key->id</a>$key->name\n";
			}
		}
	exit;
	}
	
	public function compose()
	{
		$this->subject = "";
		$this->message = "";
		$this->name = "";
		$this->fid = "";
		if(isset($_GET['name']))
			$this->name =  htmlentities(urlencode($this->input->get('name')));
		if(isset($_GET['subject']))
			$this->subject =  htmlentities(urlencode($this->input->get('subject')));
		if(isset($_GET['url']))
		{
			$this->message = $this->input->get('url');
		}
			
		if(isset($_GET['message']))
			$this->message =  htmlentities(urlencode($this->input->get('message')));
		if(isset($_GET['fid']))
			$this->fid =  htmlentities(urlencode($this->input->get('fid')));
		$this->subject = urldecode($this->subject);
		$this->message = urldecode($this->message);
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->template->title='Compose Mail';
		//
		$this->unread=$this->data->unread_count($userid);
		//$this->template->title = "Compose Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("compose");
		$this->title_content = "Compose Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function sent_reply()
	{	
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->unread=$this->data->unread_count($userid);
		
		$replyid=$this->input->get('mailid');
		$this->replydata=$this->data->getsentreply_data($userid,$replyid);
		$this->template->profile_info = $this->model->profile_info($this->replydata["mysql_fetch_array"]->id);
		//$this->template->title='sent_mails';
		$this->back='Sent Mails';
		$this->template->title = "sent_mails";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("reply_content");
		$this->title_content = "Reply Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function reply()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->unread=$this->data->unread_count($userid);
		
		$replyid=$this->input->get('mailid');
		$this->replydata=$this->data->getreply_data($replyid);
		//echo $this->replydata["mysql_fetch_array"]->id;exit;
		$this->template->profile_info = $this->model->profile_info($this->replydata["mysql_fetch_array"]->id);
		$this->template->title='inboxshow';
		$this->back='Inbox';
		//$this->template->title = "inboxshow";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("reply_content");
		$this->title_content = "Reply Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function archive_reply()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		 
		$this->data=new Inbox_Data_Model();
		
		$this->unread=$this->data->unread_count($userid);
		
		$replyid=$this->input->get('mailid');
		$this->replydata=$this->data->getreply_data($replyid);
		$this->template->profile_info = $this->model->profile_info($this->replydata["mysql_fetch_array"]->id);
		$this->template->title='archive_mails';
		$this->back='Archive';
		//$this->template->title = "Archive";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("reply_content");
		$this->title_content = "Archive Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function inboxshow()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->template->title='Inbox';
		
		$this->unread=$this->data->unread_count($userid);
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_mail($userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'base_url'    => 'inbox/inboxshow/page', 
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,
		'total_items' => $this->data->get_inbox_count($userid) 
		));
		
		$this->uid=$this->session->get('userid');
		
		//$this->response=$this->session->get('result');
		
		//$this->template->title = "Inbox Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("inboxall");
		$this->title_content = "Inbox (".count($this->unread)." )";
		$this->template->content=new View("/template/template2");
	}
	
	public function invitations()
	{
		$userid=$this->session->get('userid');
		$this->template->title='Invitations';
		$this->countval = count($this->data->get_invitations_count($userid)); 
	
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_invitations($userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'base_url'    => 'inbox/invitations/page', 
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,
		'total_items' => $this->countval
		));
		$this->uid=$this->session->get('userid');
		//$this->response=$this->session->get('result');
		
		//$this->template->title = "Inbox Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("invitations");
		$this->title_content = "Invitations (".$this->countval." )";
		$this->template->content=new View("/template/template2");
	}
	
	public function insert_invitaions()
	{
		
		$userid=$this->session->get('userid');
		$name = 'chandru';
		$email = 'ssc@gmail.com';
		//common::insert_invitations($userid,$name,$email);
		$this->data->insert_invitations($userid,$name,$email);
		echo 'Inserted';
		exit;
	}
	public function commonsearch()
	{
		$search_key = $this->input->get('search_value');
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->template->title='INBOX';
		//
		//$this->unread=$this->data->unread_count($userid);
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_search_mail($search_key,$userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,
		'total_items' => $this->data->get_search_inbox_count($search_key,$userid) 
		));
		$this->uid=$this->session->get('userid');
		//$this->response=$this->session->get('result');
		$this->searchvalue = 1;
		//$this->template->title = "Inbox Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("searchresult");
		$this->title_content = "Search Result";
		$this->template->content=new View("/template/template2");
	}

	
	public function insertmail()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->Objecttype = '-1';
		$session=Session::instance();
		$subject=$this->input->post('mail_subject');
		$msg_body = $this->input->post('mail_message');
		

		$mailid=$this->data->insert_mail($userid,$subject,$msg_body,$this->Objecttype);
		$toidnames=$this->input->post('toid');
		$toname=((explode(',', $toidnames)));
		//print_r($toname);exit;
		
		foreach($toname as $touserid)
		{
			if($touserid=='toall')
			{
				$this->friend=$this->data->get_friends(trim($userid));
				foreach($this->friend as $toall)
				{
					$this->toids = $this->data->get_id($toall->name);
					$this->toid = $this->toids["mysql_fetch_object"]->id;
					$this->data->sent_mail($userid,$mailid,$this->toid);
				}
			}
			else
			{
				//$this->toids = $this->data->get_id(trim($touserid));
				//$this->toid = $this->toids["mysql_fetch_object"]->id;
				$this->data->sent_mail($userid,$mailid,$touserid);
			}
		}
		$ccidnames=$this->input->post('ccid');
		if(empty($ccidnames))
		{
		}
		else
		{
			$ccname=((explode(',', $ccidnames)));
			
			foreach($ccname as $ccuserid)
			{
				if($ccuserid=='toall')
				{
					$this->friend=$this->data->get_friends($userid);
					foreach($this->friend as $toall)
					{
						$this->ccids=$this->data->get_id($toall->name);
						$this->ccid=$this->ccids["mysql_fetch_object"]->id;
						$this->data->sent_mail($userid,$mailid,$this->ccid);
					}
				}
				else
				{
					$this->ccids=$this->data->get_id(trim($ccuserid));
					$ccid=$this->ccids["mysql_fetch_object"]->id;
					$this->data->sent_mail($userid,$mailid,$ccid,$ccid);
				}
			}
		}
		//$this->session->set('Msg','Message has been sent.');
		
		Nauth::setMessage(1,$this->mail_sent);

		$navi=$_GET['mainpage'];
		
		url::redirect($this->docroot.'inbox/'.$navi.'');
	}
	
	public function sent_mails()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->template->title='Sent Mail';
		
		$this->unread=$this->data->unread_count($userid);
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_sentmail($userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'base_url'    => 'inbox/sent_mails/page', 
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,	
		'total_items' => $this->data->get_sentmail_count($userid) 
		));
		//$this->response=$this->session->get('result');
		$this->uid=$this->session->get('userid');

		$this->template->title = "Sent Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("sentmailall");
		$this->title_content = "Sent Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function detelemail()
	{
		$mail_id=$_GET['mid'];
		//echo $mail_id;
	}
	public function archive_mails()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$this->template->title='Archive Mail';
		
		$this->unread=$this->data->unread_count($userid);
		$page_no=$this->uri->last_segment();
		if (0 == $page_no || 'inbox'==$page_no)
		$page_no = 1;
		$offset=18*($page_no-1);
		$this->inboxdata=$this->data->get_archivemail($userid,$offset, 18);
		$this->pagination = new Pagination(array(
		'base_url'    => 'inbox/archive_mails/page', 
		'uri_segment' => 'page', 
		'items_per_page' => 18,
		'auto_hide' => TRUE,	
		'total_items' => $this->data->get_archive_count($userid) 
		));
		$this->uid=$this->session->get('userid');
		//$this->response=$this->session->get('result');
		
		//$this->template->title = "Inbox Mail";
		$this->left = new View("template/left_menu");	   
		$this->right=new View("archivemailall");
		$this->title_content = "Archive Mail";
		$this->template->content=new View("/template/template2");
	}
	
	public function delete_mail()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$mailid=$_GET['mailid'];
		$currentpage=$_GET['page'];
		$this->data=new Inbox_Data_Model();
		$deletemail=$this->data->delete_mail($mailid,$userid);
		//$this->session->set('result','The conversation has been deleted.'); 
		Nauth::setMessage(1,$this->mail_delete);
		url::redirect($this->docroot.''.$currentpage.'');
	}
	
	public function moveto_archive()
	{
		$userid=$this->session->get('userid');
		$this->gF = new Globalfunctions();
		$mailid=$_GET['mailid'];
		$this->data=new Inbox_Data_Model();
		$archivemailmail=$this->data->archive_mail($mailid,$userid);
		$currentpage=$_GET['page'];
		//$this->session->set('result','The conversation has been archived.'); 
		Nauth::setMessage(1,$this->mail_archive);
		url::redirect($this->docroot.''.$currentpage.'');
	}
}
