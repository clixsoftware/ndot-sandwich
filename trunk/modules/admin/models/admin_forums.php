<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_forums_Model extends Model
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
	//update forum
	public function update_forum($forum_id,$topic,$category,$topic_desc)
	{
		$topic=html::specialchars($topic);
		$topic_desc=html::specialchars($topic_desc);
		$this->db->query("update ".$this->prefix."forum set topic='$topic',category_id='$category',topic_desc='$topic_desc' where topic_id='$forum_id'");
	}
	public function all_category()
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category");
		return $result;
	}
	//update category
	public function update_category($category_id,$category_name='',$category_description='')
	{
		$category_name=html::specialchars($category_name);
		$category_description=html::specialchars($category_description);
		$result=$this->db->query("update ".$this->prefix."forum_category set forum_category='$category_name',category_description='$category_description' where category_id='$category_id'");
	}
	//insert category
	public function insert_category($category_name,$category_description)
	{
		$category_name=html::specialchars($category_name);
		$category_description=html::specialchars($category_description);
		$result=$this->db->query("insert into ".$this->prefix."forum_category(forum_category,category_description)values('$category_name','$category_description')");
	}
	//forum category list
	public function get_forums_category($offset='',$noofpage='')
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category limit $offset,$noofpage");
		return $result;
	}	
	//count the forum category
	public function forums_category_count()
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category");
		return count($result);
	}

	//delete category
	public function delete_category($id)
	{
		$result=$this->db->query("delete from ".$this->prefix."forum_category where category_id='$id'");
		
		return $result;
	}

	//my forum page pagenation
	public function count_forums()
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,topic_desc,author_id,posts,hit,datediff(now(),lpost) as lpost,topic,forum_category,name from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield."  where object_type=1");
		return count($result);
	}

	//get forum page
	public function get_forums($offset='',$noofpage='')
	{
	
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,topic_desc,author_id,posts,hit,datediff(now(),lpost) as lpost,topic,forum_category,name from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield."  where object_type=1 order by topic_id desc limit $offset,$noofpage ");
		return $result;
	}
	//delete forum by admin
	public function delete_forum($id)
	{
                $cat_id=$this->db->query("select category_id from ".$this->prefix."forum where topic_id='$id' " );
                $catid=$cat_id['mysql_fetch_array']->category_id;
                $result=$this->db->query("delete from ".$this->prefix."forum where topic_id='$id'");
                $res=$this->db->query("update ".$this->prefix."forum_category set total_discussion = total_discussion-1 where category_id='$catid'");
                common::delete_update($id,14);
                common::delete_update($id,15);
                return $result;
	}
        public function search_forum_advanced($key,$offset='',$noofpage='')
	  {
	  
	  $query = "select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."forum.topic_id as class_id,lpost as DATE,datediff(now(),lpost) as dat from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id = ".$this->prefix."forum_category.category_id left join ".$this->prefix."users on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."forum.author_id where 1=1";
	  
	  if($key)
	  {
	        $query .= " and ".$this->prefix."forum.topic_desc like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."forum.topic like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."forum_category.forum_category like '%$key%'";
	  }
	  
	  $query .= " limit $offset,$noofpage ";
	  $result = $this->db->query($query);
	  
		return $result;
	  }
	  public function get_search_count($key)
	  {
                $query = "select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."forum.topic_id as class_id,lpost as DATE,datediff(now(),lpost) as dat from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id = ".$this->prefix."forum_category.category_id left join ".$this->prefix."users on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."forum.author_id where 1=1";
	  
	  if($key)
	  {
	        $query .= " and ".$this->prefix."forum.topic_desc like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."forum.topic like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."forum_category.forum_category like '%$key%'";
	  }
	  
	  
	  $result = $this->db->query($query);
	  
	
       $count=count($result);
       return $count;
	  }
	 
 }
