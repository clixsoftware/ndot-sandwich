<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin blogs
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_blogs_Model extends Model
 {

    	 public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
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
		
		
	}
	
	//category list
	public function all_category()
	{
	$result=$this->db->query("select * from ".$this->prefix."blog_category");
	return $result;
	}
	//update category
	public function update_category($category_id,$category_name='')
	{
	$category_name=html::specialchars($category_name);
	$result=$this->db->query("update ".$this->prefix."blog_category set category_name='$category_name' where category_id='$category_id'");
	}
	//insert category
	public function insert_category($category_name)
	{
	$category_name=html::specialchars($category_name);
	$result=$this->db->query("insert into ".$this->prefix."blog_category(category_name)values('$category_name')");
	}

	//blog category list
	public function get_blog_category($offset='',$noofpage='')
	{
	$result=$this->db->query("select * from ".$this->prefix."blog_category limit $offset,$noofpage");
	return $result;
	}	
	//count the blog category
	public function blog_category_count()
	{
	$result=$this->db->query("select * from ".$this->prefix."blog_category");
	return count($result);
	}

	//delete category
	public function delete_category($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."blog_category where category_id='$id'");
	
	return $result;
	}

	//update blog
	public function update_blog($bid,$title,$desc,$category)
   	{

	 $title=html::specialchars($title);
	 $desc=html::specialchars($desc);
		
		if($desc!="" && $title!="" )
		{ 

			$this->db->query( "update ".$this->prefix."blog set blog_title='$title',blog_desc='$desc', blog_category='$category', blog_date=SYSDATE() where blog_id='$bid'");
		 }
	 }

	//my blogs
        public function get_blog($offset='',$noofpage='')
        {
	   $result=$this->db->query("select *,DATEDIFF(now(),blog_date)AS DATE,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id order by ".$this->prefix."blog.blog_id desc limit $offset,$noofpage " );
	   return $result;
        }
        //Get  blog matches search keyword
        public function get_search_blog($search_value,$offset='',$noofpage='')
        {
	   $result=$this->db->query("SELECT ".$this->prefix."blog.*,".$this->prefix."blog_category.category_name,".$this->usertable.".".$this->unamefield." as name FROM ".$this->prefix."blog left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category = ".$this->prefix."blog_category.category_id left join ".$this->usertable." on ".$this->prefix."blog.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `blog_desc` like '%$search_value%' or   `blog_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%'  order by ".$this->prefix."blog.blog_id desc limit $offset,$noofpage " );
	   return $result;
        }
        //total blog count
	public function get_blog_count()
	{
	   $count =$this->db->count_records('blog');
	   return $count;
	}
	// total search blog count
        public function get_search_blog_count($search_value = '')
        {
          $result =$this->db->query("SELECT count(".$this->prefix."blog.blog_id) FROM ".$this->prefix."blog left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category = ".$this->prefix."blog_category.category_id left join ".$this->usertable." on ".$this->prefix."blog.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `blog_desc` like '%$search_value%' or   `blog_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%' ");
	   return count($result);
        }
        
	//delete blogs
        public function delete_blog($blogid)
	{
	  $this->db->query( "delete from ".$this->prefix."blog where blog_id='$blogid'");
        common::delete_update($blogid,17);
        common::delete_update($blogid,19);
        common::delete_update($blogid,18);
        }

 public function change_status($status,$blog_id)
 {
 	$query = "update ".$this->prefix."blog set status = '$status' where blog_id = '$blog_id'";
	$result = $this->db->query($query);
	return 1;
 }
	 
 }
 

/* 

SELECT count(".$this->prefix."blog.blog_id) FROM ".$this->prefix."blog left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category = ".$this->prefix."blog_category.category_id left join ".$this->usertable." on ".$this->prefix."blog.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `blog_desc` like '%$search_value%' or   `blog_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%'  */
