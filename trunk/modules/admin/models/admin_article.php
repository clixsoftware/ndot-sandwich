<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin article
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_article_Model extends Model
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
	        $result=$this->db->query("select * from ".$this->prefix."article_category");
	        return $result;
	}

	//update category
	public function update_category($category_id,$category_name='')
	{
	        $category_name=html::specialchars($category_name);
	        $result=$this->db->query("update ".$this->prefix."article_category set category_name='$category_name' where category_id='$category_id'");
	}

	//insert category
	public function insert_category($category_name)
	{
	        $category_name=html::specialchars($category_name);
	        $result=$this->db->query("insert into ".$this->prefix."article_category(category_name)values('$category_name')");
	}

	//article category list
	public function get_article_category($offset='',$noofpage='')
	{
	        $result=$this->db->query("select * from ".$this->prefix."article_category limit $offset,$noofpage");
	        return $result;
	}	

	//count the article category
	public function article_category_count()
	{
	        $result=$this->db->query("select * from ".$this->prefix."article_category");
	        return count($result);
	}

	//delete category
	public function delete_category($id)
	{
	        $result=$this->db->query("delete from ".$this->prefix."article_category where category_id='$id'");	
	        return $result;
	}

	//update article
	public function update_article($bid,$title,$desc,$category)
   	{

	 $title=html::specialchars($title);
	 $desc=html::specialchars($desc);
		
		if($desc!="" && $title!="" )
		{ 

			$this->db->query( "update ".$this->prefix."article set subject='$title',description='$desc', category='$category' where article_id='$bid'");
			
		 }
	 }

	//my article
        public function get_article($offset='',$noofpage='')
        {
	   $result=$this->db->query("select *,cdate AS DATE,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."article LEFT JOIN ".$this->usertable." ON ".$this->prefix."article.uid=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."article_category on ".$this->prefix."article.category=".$this->prefix."article_category.category_id order by ".$this->prefix."article.article_id desc limit $offset,$noofpage " );
	   return $result;
        }
        
        //Get  article matches search keyword
        public function get_search_article($search_value,$offset='',$noofpage='')
        {
	   $result=$this->db->query("SELECT ".$this->prefix."article.*,".$this->prefix."article_category.category_name,".$this->usertable.".".$this->unamefield." as name FROM ".$this->prefix."article left join ".$this->prefix."article_category on ".$this->prefix."article.article_category = ".$this->prefix."article_category.category_id left join ".$this->usertable." on ".$this->prefix."article.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `article_desc` like '%$search_value%' or   `article_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%'  order by ".$this->prefix."article.article_id desc limit $offset,$noofpage " );
	   return $result;
        }
        
        //total article count
	public function get_article_count()
	{
	   $count =$this->db->count_records('article');
	   return $count;
	}
	
	// total search article count
        public function get_search_article_count($search_value = '')
        {
          $result =$this->db->query("SELECT count(".$this->prefix."article.article_id) FROM ".$this->prefix."article left join ".$this->prefix."article_category on ".$this->prefix."article.article_category = ".$this->prefix."article_category.category_id left join ".$this->usertable." on ".$this->prefix."article.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `article_desc` like '%$search_value%' or   `article_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%' ");
	   return count($result);
        }
        
	//delete article
        public function delete_article($articleid)
	{
	  $this->db->query( "delete from ".$this->prefix."article where article_id='$articleid'");
        common::delete_update($articleid,17);
        common::delete_update($articleid,19);
        common::delete_update($articleid,18);
        }
        
        public function change_status($status,$blog_id)
        {
         	$query = "update ".$this->prefix."article set block = '$status' where article_id = '$blog_id'";
	        $result = $this->db->query($query);
	        return 1;
        }


	 
 }
/* 

SELECT count(".$this->prefix."article.article_id) FROM ".$this->prefix."article left join ".$this->prefix."article_category on ".$this->prefix."article.article_category = ".$this->prefix."article_category.category_id left join ".$this->usertable." on ".$this->prefix."article.user_id = ".$this->usertable.".".$this->uidfield." where category_name like '%$search_value%' or `article_desc` like '%$search_value%' or   `article_title` like '%$search_value%' or  ".$this->unamefield." like '%$search_value%'  */
