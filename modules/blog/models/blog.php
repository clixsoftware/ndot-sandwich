<?php defined('SYSPATH') or die('No direct script access.');
 /**
 * Defines all Blog database activity
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

 class Blog_Model extends Model
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
	         $mes = Kohana::config('users_config.session_message');
			$this->add_blog = $mes["add_blog"];
		$this->docroot = "http://".$_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],"index.php.");

   	}
	//get the category list to blog
	public function get_blog_category()
	{
		$result=$this->db->query("select * from ".$this->prefix."blog_category");
		return $result;
	}

	//get the blog list
 	public function showblog($offset='',$page_no='',$noofpage='',$type='-1')
   	{ 
		 $query = "select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."blog.user_id as uid  from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' and status = 1 order by ".$this->prefix."blog.blog_id desc  limit $offset,$noofpage";	
		 $result1=$this->db->query($query);

		return $result1;
	 
   	}
   	//popular blog
	public function popular_blog($offset='',$page_no='',$noofpage='',$type='-1')
	{
		$result1=$this->db->query("select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name ,".$this->prefix."blog.user_id as uid from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' and status = 1 order by ".$this->prefix."blog.counts desc  limit $offset,$noofpage");
		return $result1;

	}
	
	//popular blog
	public function friends_blog($offset='',$noofpage='',$type='-1')
	{
		$result1=$this->db->query("select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name ,".$this->prefix."blog.user_id as uid from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' AND uid IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='6' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='6' AND STATUS =1 )) and status = 1 order by ".$this->prefix."blog.counts desc  limit $offset,$noofpage");
		return $result1;

	}
	//get friends blog count
	public function get_friends_blog_count($type='-1')
	{
	       $result1=$this->db->query("select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name ,".$this->prefix."blog.user_id as uid from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' AND uid IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='6' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='6' AND STATUS =1 )) and status = 1 order by ".$this->prefix."blog.counts desc ");
		return count($result1);

	}
	//total blog count
	public function get_blog_count()
	{

	   $count =$this->db->query("select * from ".$this->prefix."blog where status = 1");

	   return count($count);
	}
  
 	//search count
	  public function get_search_count($search)
	  {
		   $result =$this->db->query("select *,blog_date as DATE,DATE_FORMAT(blog_date,'%d %b  %y') as dat, ".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield."  having  ".$this->prefix."blog.blog_title  like '$search%' and status = 1 order by ".$this->prefix."blog.blog_id desc");
		   $count=count($result);
		   return $count;
	  }
	  
	  public function total_blogs($userid,$offset = '',$noofpage = '',$type='-1')
	  {
	  	$query = "select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."blog.user_id as uid  from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' and status = 1 and ".$this->prefix."blog.user_id = '$userid' order by ".$this->prefix."blog.blog_id desc";
	  	$result=$this->db->query($query);
		return $result;
	  }
	  
	  public function count_total_blogs($userid,$type='-1')
	  {
	  	$query = "select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name ,".$this->prefix."blog.user_id as uid from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.type='$type' and status = 1 and ".$this->prefix."blog.user_id = '$userid' order by ".$this->prefix."blog.counts desc";
	  	$result1=$this->db->query($query);
		return count($result1);
	  }

    //TOP BLOG
	public function topblogers($type='-1')
	{
		$result1=$this->db->query("select ".$this->prefix."blog.user_id, count(".$this->prefix."blog.user_id) as total,".$this->unamefield.",city from ".$this->prefix."blog left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."blog.user_id left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id where status = '1'   group by  ".$this->prefix."blog.user_id  order by total desc");
		return $result1;	 
		   
	}
	
	public function blog_count($user_id)
	{
		$query = "select blog_id from ".$this->prefix."blog where user_id = '$user_id'";
		$result = $this->db->query($query);
		return count($result);
	}
   
   //my blogs
   public function myblog($userid,$offset='',$page_no='',$noofpage='',$type='-1')
   {
	   $result=$this->db->query("select *,blog_date as DATE,".$this->usertable.".".$this->unamefield."
		as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.user_id='$userid' and ".$this->prefix."blog.type='$type' and status = 1 order by ".$this->prefix."blog.blog_id desc limit $offset,$noofpage " );
	   return $result;
   }
   
   //get the my blog counts
   public function get_myblog_count($userid,$type='-1')
   {
	   $result =$this->db->query("select * from ".$this->prefix."blog where user_id='$userid' and type='$type' and status = 1");
	   $count=count($result);
	   return $count;
   }

   //create blog
   public function createblog($userid,$title,$desc,$category,$blogtype='-1',$type='-1')
   {
		
		if(($category !="0") && ($desc!="") && ($title!=""))
		{ 
			$result=$this->db->query( "insert into ".$this->prefix."blog(user_id,blog_title,blog_desc,blog_category,blog_date,type,status) VALUES ('$userid','$title','$desc','$category',SYSDATE(),'$blogtype','1' )");
			$_SESSION["insertid"] = $result->insert_id();
			$this->update->updates_insert($userid,$result->insert_id(),17,$title);
			
			//call google 
			$ping_url = 'blog/view/'.url::title($title).'_'.$result->insert_id();
			Nauth::ping($title,$ping_url);
			Nauth::setMessage(1,$this->add_blog);
			url::redirect($this->docroot.'blog/view/'.url::title($title).'_'.$result->insert_id());
	
		}
  }
   
   
   //category wise blogs
   public function categoryblog($category,$offset='',$page_no='',$noofpage='',$type='-1')
   {
 
	 $result= $this->db->query("select *,blog_date as DATE,DATE_FORMAT(blog_date,'%d %b  %y') as dat,".$this->usertable.".".$this->unamefield." as name ,".$this->prefix."blog.user_id as uid from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having  ".$this->prefix."blog.blog_category='$category' and ".$this->prefix."blog.type='$type' and status = 1 order by ".$this->prefix."blog.blog_id desc  limit $offset,$noofpage ");
	 return $result;
   }

  //count the category count
  public function get_category_count($category , $type='-1')
  {
   $result =$this->db->query("select * from ".$this->prefix."blog where blog_category='$category' and ".$this->prefix."blog.type='$type' and status = 1");
   $count=count($result);
   return $count;
  }
   
   
    public function searchblog($search,$type='-1')
    {
      
	   if($search!='')
	   {
			 $result= $this->db->query("select *,blog_date as DATE,DATE_FORMAT(blog_date,'%d %b  %y') as dat, ".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield."  having  ".$this->prefix."blog.type='$type' and ".$this->prefix."blog.blog_title  like '$search%' and status = 1 order by ".$this->prefix."blog.blog_id desc ");
			  return $result;
	   }	
    }
   
	 public function viewblog($blogid,$type='-1')
	 {
		  $result1=$this->db->query("select *,blog_date as DATE,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ".$this->prefix."blog.blog_id='$blogid' and ".$this->prefix."blog.type='$type' and status = 1");
	     return $result1;
	 }

	
	//add the comment to blogs
	public function addcomment($userid,$desc,$blogid)
	{
	  if($desc!="")
	   {
      		$cmd = $this->db->query( "insert into ".$this->prefix."blog_comment(user_id,blog_id,comments,date) VALUES ('$userid','$blogid','$desc',SYSDATE() )");
      		$post_id = $cmd->insert_id();
		$result1=$this->db->query("select blog_title from ".$this->prefix."blog where blog_id='$blogid'");
	$title=$result1["mysql_fetch_object"]->blog_title; 
			$this->update->updates_insert($userid,$blogid,19,$title,$post_id);
                	$result=$this->db->query(" SELECT user_id, blog_title FROM ".$this->prefix."blog WHERE blog_id = '$blogid' ");
                        $usrid=$result["mysql_fetch_array"]->user_id;
                        $friend_id=$userid;
                        $type="Blog reply";
                        $description='<a href='.$this->docroot.'blog/view/?bid='.$blogid.'>'.htmlspecialchars_decode($result["mysql_fetch_array"]->blog_title).'</a>'; 
			Nauth::send_mail_id($usrid,$friend_id,$type,$description); 

	   }
   	}
    	 //get the blog to update
	 public function editblog($blogid,$type='-1')
	 {
	  $result1= $this->db->query(" select * from ".$this->prefix."blog where blog_id='$blogid' and ".$this->prefix."blog.type='$type'");
	  return $result1;
	 }
	 
	 //update the blog information
	public function update_blog($bid,$title,$desc,$category)
   	{
		 $title=html::specialchars($title);
		 $desc=html::specialchars($desc);
		
		if(($desc!="") && ($title!="") )
		{ 
			$this->db->query( "update ".$this->prefix."blog set blog_title='$title',blog_desc='$desc', blog_category='$category', blog_date=SYSDATE() where blog_id='$bid'");
			$this->update->updates_insert($this->user_id,$bid,18,$title);
			
			Nauth::setMessage(1,'Blog has been updated');
			url::redirect($this->docroot.'blog/view/'.url::title($title).'_'.$bid);
			
		 }
	 }
   
   	//delete blogs
        public function delete_blog($blogid,$type='-1' )
	{ 
	        $check_user=$this->db->query("SELECT user_id from ".$this->prefix."blog where blog_id='$blogid'");
	        if($check_user["mysql_fetch_array"]->user_id == $this->user_id) 
	        {
	          $this->db->query( "delete from ".$this->prefix."blog where blog_id='$blogid' and ".$this->prefix."blog.type='$type'");
          	  
          	  $this->db->query( "delete from ".$this->prefix."blog_comments where type_id='$blogid' ");
          	  common::delete_update($blogid,17);
           	  common::delete_update($blogid,19);
           	  common::delete_update($blogid,18);
          	  return 1;
          	}
          	else
          	{
          	return 0;
          	}
        }
        
        //delete blog comment
        public function delete_comment_count($cid,$bid)
        {
                $this->db->query("update ".$this->prefix."blog set counts=counts-1 where blog_id='$bid'");
               //$result = $this->db->query( "delete from ".$this->prefix."blog_comment where comment_id='$cid' ");
                common::delete_update('',19,$cid);
                //return $result;
        }
    //popular category
	public function popular_category()
	{
		$popular_category=$this->db->query("SELECT category_id,".$this->prefix."blog_category.category_name as category_name, COUNT(".$this->prefix."blog.blog_category) as categ_count
		FROM ".$this->prefix."blog left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id where status = '1'  group by ".$this->prefix."blog.blog_category order by categ_count desc limit 0,5");
		return $popular_category;
	}
	
   //common search
   public function get_common_search($key,$search_category,$offset='',$noofpage='',$type='-1')
   {
        if(!empty($key) || !empty($search_category))
        {
	 $query= "select *,blog_date as DATE,DATE_FORMAT(blog_date,'%d %b  %y') as dat,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ";
	 
	 if($key!='' && $search_category!='')
	 {
	        $query .= "".$this->prefix."blog.blog_title like '%$key%' || ".$this->prefix."blog.blog_desc like '%$key%' || ".$this->prefix."blog.blog_category='$search_category'";
	 }
	 else if($key!='')
	 {
	         $query .= "".$this->prefix."blog.blog_title like '%$key%' || ".$this->prefix."blog.blog_desc like '%$key%' ";
	         
	 }
	 else if($search_category!='')
	 {
	         $query .= "".$this->prefix."blog.blog_category='$search_category'";
	 }
	 else 
	 {
	        $query.="1=1";
	 }
	 
	 $query .= " and ".$this->prefix."blog.type='$type' order by ".$this->prefix."blog.blog_id desc  limit $offset,$noofpage ";
	 
	 $result = $this->db->query($query);
	 return $result;
	}
   }
   //common search
   public function count_common_search($key,$search_category,$type='-1')
   {
        if(!empty($key) || !empty($search_category))
        {
	 $query= "select *,blog_date as DATE,DATE_FORMAT(blog_date,'%d %b  %y') as dat,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."blog LEFT JOIN ".$this->usertable." ON ".$this->prefix."blog.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."blog_category on ".$this->prefix."blog.blog_category=".$this->prefix."blog_category.category_id having ";
	 
	 if($key!='' && $search_category!='')
	 {
	        $query .= "".$this->prefix."blog.blog_title like '%$key%' || ".$this->prefix."blog.blog_desc like '%$key%' || ".$this->prefix."blog.blog_category='$search_category'";
	 }
	 else if($key!='')
	 {
	         $query .= "".$this->prefix."blog.blog_title like '%$key%' || ".$this->prefix."blog.blog_desc like '%$key%' ";
	         
	 }
	 else if($search_category!='')
	 {
	         $query .= "".$this->prefix."blog.blog_category='$search_category'";
	 }
	 else 
	 {
	        $query.="1=1";
	 }
	 
	 $query .= " and ".$this->prefix."blog.type='$type' and status = 1 order by ".$this->prefix."blog.blog_id desc ";
	 
	 $result = $this->db->query($query);
	 return count($result);
	}
   } 
  
  }
  
	
