<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 * @package    Core
 * @author     ndot vignesh
 * @copyright  (c) 2007-2008 ndot Team
 * @license    http://ndot.in/license.html
 */
 
class Track_Core {

	/*public function make_log($log="",$usr_name="",$extra="")
	{
		if($log)
		{
			switch ($log) {
			case "convey":
				$log = $usr_name." added message in conveyor";
				break;
			case "convey_delete":
				$log = $usr_name." deleted message in conveyor";
				break;
			case "status":
				$log = $usr_name." updated their status";
				break;
			case "photo_add":
				$log = $usr_name." added photo";
				break;
			case "photo_edit":
				$log = $usr_name." edited his photo";
				break;
			case "profile_edit":
				$log = $usr_name." updated profile";
				break;
			case "bookmark_add":
				$log = $usr_name." added bookmark";
				break;
			case "bookmark_edit":
				$log = $usr_name." edited bookmark";
				break;
			case "bookmark_delete":
				$log = $usr_name." deleted bookmark";
				break;
			case "bookmark_comment":
				$log = $usr_name." commented bookmark";
				break;
			case "bookmark_comment_delete":
				$log = $usr_name." deleted bookmark comment";
				break;
			case "site_report":
				$log = $usr_name." reported about site";
				break;
			}
			return $log;

		}
	}
	
	
 	public function track_all($usr_id="",$log="")
	{
		$db = new Database;
		$query = $db->query("insert into log_details(userid,log_message,cd) values('".$usr_id."','".$log."',now())");
		return $query;
	}
	public function track_user($usr_id="")
	{
		if($usr_id)
		{
			$db = new Database;
			$query = $db->query("select * from log_details where userid = '".$usr_id."' order by id desc limit 5");
			return $query;
		}
	}*/
	
	public function make_log($userid="",$obj_type="",$obj_id="",$obj_subid="",$action_id="-1",$db=""){
	
		if($db=="")
		{
			$db = new Database();
		}
		$queryString = "insert into log (userid,object_type,object_id,object_subid,action_id,cd) values('$userid','$obj_type','$obj_id','$obj_subid','$action_id',now())";
		$result = $db->query($queryString);
		return $result;
	}
	
	public function get_log($obj_type="",$obj_id="",$db="",$offset='0',$end='10'){ 
		if($db=="")
		{
			$db = new Database();
		}
		$queryString = "select name,users.id as uid, action_id,DATE_FORMAT(log.cd,'%b %d ,%Y')as dat,groups.id as gid,blog.blog_id as bid,title,blog_title from log left join groups on groups.id = object_id left join users on users.id = log.userid left join blog on blog.blog_id = log.object_subid  where 1=1 ";
		if($obj_type){
			$queryString .= " and object_type = '$obj_type'";
		}if($obj_id){
			$queryString .= " and object_id = '$obj_id'";		
		}
		if($end){
			$queryString .= " limit $offset,$end";		
		}
		//echo $queryString;
		$result = $db->query($queryString);
		return $result;
	}
}
?>