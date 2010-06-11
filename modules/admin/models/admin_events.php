<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for Events
 *
 * @package    Core
 * @author     Madhi
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_Events_Model extends Model
 {

     public function __construct()
	 {
		
        parent::__construct();
		$db=new Database();
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
		
	}
	public function index()
	{
		if($this->userid != '' && $this->usertype == -1)
		{
			url::redirect($this->docroot.'admin/events');
		}
		else
		{
			url::redirect($this->docroot);
		}
	}
	//getting all events
	public function get_allevents($eid,$offset='',$range='',$userid = '')
	{
		$query = "select *,".$this->usertable.".".$this->unamefield." as name,DATE_FORMAT(`event_date`,'%W , %M %d') as dat,DATEDIFF(now(),event_date) as date_diff,".$this->prefix."events.event_id as eid,datediff(event_date,now()) as diff,(select ".$this->prefix."event_members.userid from ".$this->prefix."event_members where ".$this->prefix."event_members.userid = '$userid' and ".$this->prefix."event_members.event_id = ".$this->prefix."events.event_id limit 0,1)as exis from ".$this->prefix."events  left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=".$this->prefix."events.user_id left join ".$this->prefix."event_category on ".$this->prefix."events.category_id = ".$this->prefix."event_category.category_id  order by event_date desc limit $offset,$range";
		$result = $this->db->query($query);
		return $result;
	}
	
	public function event_search($search_value,$offset='',$range='',$userid = '')
	{
	        $query = "select *,DATE_FORMAT(`event_date`,'%W , %M %d') as dat,DATEDIFF(now(),event_date) as date_diff,".$this->prefix."events.event_id as eid,datediff(now(),event_date) as diff,(select ".$this->prefix."event_members.userid from ".$this->prefix."event_members where ".$this->prefix."event_members.userid = '$userid' and ".$this->prefix."event_members.event_id = ".$this->prefix."events.event_id limit 0,1)as exis from ".$this->prefix."events  left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=".$this->prefix."events.user_id left join ".$this->prefix."event_category on ".$this->prefix."events.category_id = ".$this->prefix."event_category.category_id where 1=1";
	        
	        if($search_value != '')
	        {
	                $query .= " and ".$this->prefix."events.event_name like '%$search_value%'";
	        }
	        if($search_value != '')
	        {
	                $query .= " or ".$this->prefix."events.address = '%$search_value%'";
	        }
	        
	        $query .= " and datediff(now(),event_date) >= 0 order by event_date desc limit $offset,$range";
		$result = $this->db->query($query);
		return $result;
	}
	
	public function category_search($category_id,$offset,$range,$userid)
	{
	        $query = "select *,".$this->usertable.".".$this->unamefield." as name,DATE_FORMAT(`event_date`,'%W , %M %d') as dat,DATEDIFF(now(),event_date) as date_diff,".$this->prefix."events.event_id as eid,datediff(event_date,now()) as diff,(select ".$this->prefix."event_members.userid from ".$this->prefix."event_members where ".$this->prefix."event_members.userid = '$userid' and ".$this->prefix."event_members.event_id = ".$this->prefix."events.event_id limit 0,1)as exis from ".$this->prefix."events  left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=".$this->prefix."events.user_id left join ".$this->prefix."event_category on ".$this->prefix."events.category_id = ".$this->prefix."event_category.category_id where ".$this->prefix."events.category_id = '$category_id' group by ".$this->prefix."events.event_id limit $offset,$range";
	        $result = $this->db->query($query);
	        return $result;
	}
	
	public function get_categorysearch($category_id,$userid)
	{
	        $query = "select ".$this->prefix."events.event_id,DATE_FORMAT(`event_date`,'%W , %M %d') as dat,DATEDIFF(now(),event_date) as date_diff,".$this->prefix."events.event_id as eid,datediff(event_date,now()) as diff,(select ".$this->prefix."event_members.userid from ".$this->prefix."event_members where ".$this->prefix."event_members.userid = '$userid' and ".$this->prefix."event_members.event_id = ".$this->prefix."events.event_id limit 0,1)as exis from ".$this->prefix."events  left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=".$this->prefix."events.user_id left join ".$this->prefix."event_category on ".$this->prefix."events.category_id = ".$this->prefix."event_category.category_id where ".$this->prefix."events.category_id = '$category_id' group by ".$this->prefix."events.event_id";
	        $result = $this->db->query($query);
	        return $result;
	}
	
	public function get_totalsearch($search_value)
	{
	        $query = "select * from ".$this->prefix."events where 1=1";
	        
	        if($search_value != '')
	        {
	                $query .= " and ".$this->prefix."events.event_name = '$search_value'";
	        }
	        if($search_value != '')
	        {
	                $query .= " or ".$this->prefix."events.address = '$search_value'";
	        }
	        
	        $query .= " order by event_date desc";
		$result = $this->db->query($query);
		return $result;
	}

	public function get_editdata($eid)
	{
		if($eid)
		{
			$query = "select * from ".$this->prefix."events where event_id = '$eid' order by event_date desc";
			$result = $this->db->query($query);
			return $result;
		}
	}
	public function get_totalevents()
	{
		$query = "select event_id from ".$this->prefix."events order by event_date desc";
		$result = $this->db->query($query);
		return $result;
	}
	 
	 //create event
	 public function insert_event($title='',$place='',$description='',$date='',$stime='',$etime='',$address='',$contacts='',$userid='',$contact_email = '',$category = '')
	{
		$title=html::specialchars($title);
		$place=html::specialchars($place);
		$description=html::specialchars($description);
		$address=html::specialchars($address);
		$contacts=html::specialchars($contacts);
		$contact_email=html::specialchars($contact_email);
		$select = "select * from ".$this->prefix."events where event_name = '$title'";
		$result = $this->db->query($select);
		if($result->count() == 0)
		{
			$query = $this->db->query("insert into ".$this->prefix."events (event_name,event_place,event_description,event_date,start_time,end_time,address,contacts,user_id,contact_email,category_id) values ('".$title."','".$place."','".mysql_escape_string($description)."','".$date."','$stime','$etime','$address','$contacts','$userid','$contact_email','$category')");
			if($query)
			{
				echo 'ok';
				$event_id = $query->insert_id();
			        if($event_id)
			        {
			                $queryString =$this->db->query("insert into ".$this->prefix."event_members (event_id,userid,status) values('$event_id','$userid','1')");
		                }
				return 1;
			}
			else
			{
				echo 'error in database';
				return -2;
			}
		}
		else
		{
			return -1;
		}
	}

	public function updateevent($title,$place,$description,$date,$stime,$etime,$address,$contacts,$eid,$contact_email,$category)
	{
	
		if($title != '' && $place != '' && $description != '' && $date != '' && $stime != '' && $etime != '' && $address != '' && $contacts != '' && $category != '')
		{
			$description = mysql_escape_string($description);
			$title = mysql_escape_string($title);
			$address = mysql_escape_string($address);
			$place = mysql_escape_string($place);
			$contact_email = mysql_escape_string($contact_email);
			
			$query = "update ".$this->prefix."events set event_name = '$title',event_description = '$description',event_date = '$date',start_time = '$stime',end_time = '$etime',event_place = '$place',address = '$address',contacts = '$contacts',contact_email = '$contact_email',category_id = '$category' where event_id = '$eid'";
			$result = $this->db->query($query);

			return 1;
		}
		else
		{
			return -1;
		}
	}
	public function delete_event($e_id)
	{
		if($e_id != '')
		{
			$query = "delete from ".$this->prefix."events where event_id = '$e_id'";
			$result = $this->db->query($query);
	          	common::delete_update($e_id,35);
                	common::delete_update($e_id,36);
                	common::delete_update($e_id,38);
			return 1;
		}
		else
		{
			return -1;
		}
	}
	
	public function event_photos($event_id)
	{
	        $query = "select * from ".$this->prefix."event_photo where event_id = '$event_id'";
	        $result = $this->db->query($query);
	        return $result;
	}
	
	//delete event photo
	public function delete_event_photo($photo_id)
	{
		if($photo_id != '')
		{
			$query = "delete from ".$this->prefix."event_photo where photo_id = '$photo_id'";
			$result = $this->db->query($query);
			return 1;
		}
		else
		{
			return -1;
		}
	}
	
	public function get_category()
	{
	        $query = "select * from ".$this->prefix."event_category";
	        $result = $this->db->query($query);
	        return $result;
	}
	public function add_category($category_name)
	{
	        $category_name = mysql_escape_string($category_name);
	        $select = $this->db->query("select * from ".$this->prefix."event_category where category_name = '$category_name'");
	        if($select->count() == 0)
	        {
	                $query = "insert into ".$this->prefix."event_category(category_name) values('$category_name')";
	                $result = $this->db->query($query);
	                return 1;
                }
                else
                {
                        return -1;
                }
	}
	
	public function delete_category($cat_id)
	{
	        $query = "delete from ".$this->prefix."event_category where category_id = '$cat_id'";
	        $result = $this->db->query($query);
	        if($result)
	        {
	                $query = $this->db->query("delete from ".$this->prefix."events where category_id = '$cat_id'");
	        }
	        return 1;
	}
	
	public function block_unblock($status,$id)
	{
		if($status != '' && $id != '')
		{
			$query = "update ".$this->prefix."events set status = '$status' where event_id = '$id'";
			$result = $this->db->query($query);
			return 1;
		}
		else
		{
			return -1;
		}
	}
 
}
?>
