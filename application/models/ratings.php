<?php defined('SYSPATH') or die('No direct script access.');
 /**
 * Defines all Blog database activity
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

 class Ratings_Model extends Model
 {
	
	public function __construct()
	{
		
		parent::__construct();
		$this->update=new update_model_Model();	
		$this->db=new Database();
		$this->session = Session::instance();
		$this->user_id=$this->session->get('userid');
		
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$this->unamefield = $config['unamefield'];
		$this->uidfield = $config['uidfield'];
	        $this->upass = $config['upass'];
	        $this->uemail = $config['uemail'];
	        $this->ustatus = $config['ustatus'];
	        $this->utype = $config['utype'];
		$this->docroot = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");
   	}
   	
   	public function ratings($url,$type,$type_id)
   	{
   	        $query = "select  * from ".$this->prefix."ratings where type='$type' and type_id = '$type_id' ";
   	        $result = $this->db->query($query);
   	        return $result;
   	}
   	
   	public function insert_rating($url,$type,$type_id,$ipadd,$rating)
   	{
   	        $s = "select * from ".$this->prefix."ratings where type='$type' and type_id = '$type_id' and ip = '$ipadd'";
   	        $select = $this->db->query($s);
   	        if($select->count() == 0)
   	        {
           	        $query = "insert into ".$this->prefix."ratings(ip,url,type,type_id,rate_val,date) values('$ipadd','$url','$type','$type_id','$rating',now())";
           	        $result = $this->db->query($query);
   	                return 1;
                }
                else
                {
                        return -1;
                }
   	}
	
  }
  
	
