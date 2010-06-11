<?php defined('SYSPATH') or die('No direct script access.');
class News_Model extends Model
 {
        public function __construct()
	{
		parent::__construct();
		$this->update=new update_model_Model();
		$this->db=new Database();
		include Kohana::find_file('../application/config','database',TRUE,'php'); 
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$this->uidfield = $config['uidfield'];
	        $this->upass = $config['upass'];
	        $this->uemail = $config['uemail'];
	        $this->ustatus = $config['ustatus'];
	        $this->utype = $config['utype'];
	}
	
	//get category
	 public function get_category()
	 {
		 $result=$this->db->query("select * from ".$this->prefix."news_category" );
		 return $result;
	 }
	 
	 //full news query
	 public function full_news($nid)
	 {
		 $result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id where ".$this->prefix."news.news_id='$nid'" );
		 return $result;
		
	 }
	 
	 //get news
	 public function get_news($offset='',$page_no='',$noofpage='')
	 {
	 	$result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id order by news_id desc limit $offset,$noofpage " );
		return $result;
		
	 }
	 
	 //news count
	 public function get_news_count()
	 {
		 $result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id order by news_id desc" );
		return count($result);
	 }
	 
	//news category
	  public function news_catearticles($category,$offset='',$page_no='',$noofpage='')
	  {

	  	$result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id having ".$this->prefix."news_category.category_id='$category' order by news_id desc limit $offset,$noofpage " );
		return $result;
	  }
	  
	  //category count
	  public function get_category_count($category)
	  {
		  $result =$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id having ".$this->prefix."news_category.category_id='$category'" );
       $count=count( $result);
       return $count;
	
	}
		
	 //search news
	  public function search_news($key,$offset='',$noofpage='')
	  {
	  
	  	$result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id where ".$this->prefix."news.news_title like '%$key%' limit $offset,$noofpage " );
		return $result;
	  }
	  //search count
	public function get_advance_search_news_count($key,$category)
	{
	        if($key!="" || $category!="")
	        {
	        
	       $query = "select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id where  " ;
	  	
	  	 if($key!='' && $category!='')
	         {
	                $query .= "".$this->prefix."news.news_title like '%$key%' || ".$this->prefix."news.news_desc like '%$key%' || ".$this->prefix."news.news_category='$category'";
	         }
	         else if($key!='')
	         {
	                 $query .= "".$this->prefix."news.news_title like '%$key%' || ".$this->prefix."news.news_desc like '%$key%' ";
	                 
	         }
	         else if($category!='')
	         {
	                 $query .= "".$this->prefix."news.news_category='$category'";
	         }
	         else 
	         {
	                $query.="1=1";
	         }
	 
	  //	$query .= "limit $offset,$noofpage ";
	  	$result = $this->db->query($query);
		return count($result);
		
		}
	}
	
	 //search news
	  public function advance_search_news($key,$category,$offset='',$noofpage='')
	  {
	         if($key!="" || $category!="")
	        {
	        
	  	$query = "select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id where " ;
	  	
	  	 if($key!='' && $category!='')
	         {
	                $query .= "".$this->prefix."news.news_title like '%$key%' || ".$this->prefix."news.news_desc like '%$key%' || ".$this->prefix."news.news_category='$category'";
	         }
	         else if($key!='')
	         {
	                 $query .= "".$this->prefix."news.news_title like '%$key%' || ".$this->prefix."news.news_desc like '%$key%' ";
	                 
	         }
	         else if($category!='')
	         {
	                 $query .= "".$this->prefix."news.news_category='$category'";
	         }
	         else 
	         {
	                $query.="1=1";
	         }
	 
	  	$query .= " limit $offset,$noofpage ";
	  	$result = $this->db->query($query);
		return $result;
		
		}
	  }
	  //search count
	public function get_search_news_count($key)
	{
	          $result =$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id where ".$this->prefix."news.news_title like '%$key%'" );
	        $count=count( $result);
         return $count;
	}
	
	
	//news comment
	public function get_news_comment($nid)
	{
	
		$result1=$this->db->query("select *,".$this->prefix."news_comments.user_id as user_id,date from ".$this->prefix."news_comments left join ".$this->usertable." on ".$this->prefix."news_comments.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id where ".$this->prefix."news_comments.news_id='$nid'");	
		return $result1;
	}
	
	public function comment_child($comment_id)
	{
		$res=$this->db->query("select t1.*,date,t2.name from ".$this->prefix."news_comments as t1,".$this->usertable." as t2 where t1.parent_id='$comment_id'  and t2.id=t1.user_id");
		return $res;
	}
	
	
	 //popular news
	 public function get_pop_news($offset='',$page_no='',$noofpage='')
	 {
	 	$result=$this->db->query("select *,news_date from ".$this->prefix."news LEFT JOIN ".$this->prefix."news_category on ".$this->prefix."news.news_category=".$this->prefix."news_category.category_id order by comment_count desc limit $offset,$noofpage " );
		return $result;
		
	 }



}

?>
