<?php
/**
 * Default Kohana controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * @package    Core
 * @author     M.Balamurugan 
 * @copyright  (c) 2009-2010 Ndot
 * @license    http://ndot.in
 */
	class Thirdparty_Model extends Model
	{

		public function __construct()
		{
			$this->session=Session::instance();
			$this->user_id=$this->session->get('userid');
                        //calling database configuration settings
			include Kohana::find_file('../application/config','database',TRUE,'php'); 
			$this->config = $config ['default'];
			$this->prefix = $this->config['table_prefix'];
			$this->usertable = $config['usertable'];
			$this->uidfield = $config['uidfield'];
			$this->unamefield = $config['unamefield'];
			$this->upass = $config['upass'];
			$this->uemail = $config['uemail'];
			$this->ustatus = $config['ustatus'];
			$this->utype = $config['utype'];
			$this->tempath = $config['tempath'];
			parent::__construct();
			$db=new Database();
		}

		//third party updates
        public function set_third_party_updates($user_id='',$type_id='',$action_id='',$session_id='',$description='',$url='')
        {
	    $description = substr($description,0,145);
            $description=html::specialchars($description);
				
	    if(!empty($description)){			
            $result=$this->db->query("INSERT INTO ".$this->prefix."updates (`user_id`,  `date`,`third_party_url`,`description`) VALUES ( '$user_id',now(),'$url','$description')");
            $update_id = $result->insert_id();
            $result=$this->db->query("INSERT INTO ".$this->prefix."update_comments (`upd_id`, `user_id`, `desc`, `date`) VALUES ( '$update_id','$user_id','$description',now())");
	   }
		   					  
        }
		public function get_third_party_updates($url)
		{
			$querystring = "select $this->usertable.$this->uidfield as user_id,$this->usertable.$this->unamefield as username,".$this->prefix."update_comments.desc as comment,DATE_FORMAT(".$this->prefix."update_comments.date,'%D %b %y') as dateofpost from ".$this->prefix."updates left join ".$this->prefix."update_comments on ".$this->prefix."updates.id=upd_id left join  $this->usertable on $this->usertable.$this->uidfield=".$this->prefix."update_comments.user_id  where third_party_url='$url' order by ".$this->prefix."update_comments.id desc";
			   $result=$this->db->query($querystring);
			
		return $result;
		}
		
		
		public function set_fan($url='',$user_id='')
		{
			//$url = html::specialchars($url);
			$querystring = "insert into ".$this->prefix."fans(userId,uniqueValue,dateofjoining) values ('$user_id','$url',now())";
			$result=$this->db->query($querystring);
		}
		
		public function getfans($url ='')
		{
			$querystring = "select $this->usertable.$this->uidfield as user_id,$this->usertable.$this->unamefield as username from $this->usertable left join  ".$this->prefix."fans  on $this->usertable.$this->uidfield=".$this->prefix."fans.userId where uniquevalue='$url' ";
			
			$result=$this->db->query($querystring);
			return $result;
		}
		public function checkfans($user_id = '',$uniqueId='')
		{
			$querystring = "select userId from ".$this->prefix."fans where userId='$user_id' and uniquevalue='$uniqueId'";
			$result=$this->db->query($querystring);
			return count($result);
		}
		
		public function getallfans($url)
		{
		        $querystring = "select *,$this->usertable.$this->uidfield as user_id,$this->usertable.$this->unamefield as username from $this->usertable left join  ".$this->prefix."fans  on $this->usertable.$this->uidfield=".$this->prefix."fans.userId left join ".$this->prefix."users_profile on $this->usertable.$this->uidfield = ".$this->prefix."users_profile.user_id where uniquevalue='$url' ";
			
			$result=$this->db->query($querystring);
			return $result;
		}
	}	
?>
