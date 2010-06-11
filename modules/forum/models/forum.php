<?php
/**
 * Defines all Forum database activity
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Forum_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
		$db=new Database();
		$this->update=new update_model_Model();
		$this->session = Session::instance();
		$this->user_id=$this->session->get('userid');
	        $mes=Kohana::config('users_config.session_message');
	       
		$this->add_forum = $mes["add_forum"];
	        $this->page_notfound= $mes["notfound"];
		$this->docroot=$this->session->get('DOCROOT');
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

	}
	//get one forum
	public function get_edit_forum($id)
	{
                $result=$this->db->query("select * from ".$this->prefix."forum where topic_id='$id'");
	        if($result["mysql_fetch_array"]->author_id == $this->user_id) 
	        {
          	  return $result;
          	}
          	else
          	{ 
              	     Nauth::setMessage(-1,$this->page_notfound);
          	 url::redirect($this->docroot."forum/");
          	}
/* 	
		$result=$this->db->query("select * from ".$this->prefix."forum where topic_id='$id'");
		return $result; */
	}

	//to display all category
	public function get_category()
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category order by forum_category");
		return $result;
	}
	//my forum page pagenation
	public function count_myforums($userid)
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ".$this->prefix."forum.author_id='$userid' AND object_type=1 ");
		return $result;
	}

	//get my forum page
	public function get_myforums($userid='',$offset='',$noofpage='')
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ".$this->prefix."forum.author_id='$userid' AND object_type=1 order by topic_id desc limit $offset,$noofpage ");
		return $result;
	}

	//popular forum page pagenation
	public function count_popular()
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where posts!=0 AND  object_type=1 ");
		return $result;
	}

	//get popular forum page
	public function get_popular($offset='',$noofpage='')
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where posts!=0 AND object_type=1 order by posts desc limit $offset,$noofpage ");
		return $result;
	}
	//popular forum page pagenation
	public function count_search($category_id)
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ".$this->prefix."forum.category_id='$category_id' AND  object_type=1 ");
		return $result;
	}

	//get popular forum page
	public function get_search($category_id='',$offset='',$noofpage='')
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ".$this->prefix."forum.category_id='$category_id' AND  object_type=1  order by topic_id desc limit $offset,$noofpage ");
		return $result;
	}
	
	//popular forum page pagenation
	public function count_common_search($search_value='',$search_category='')
	{ 
	        if($search_value!='' || $search_category!='')
	        {
	        
		$query = "select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ";
		
		 if($search_value!='' && $search_category!='')
	         {
	                $query .= "".$this->prefix."forum.topic like '%$search_value%' || ".$this->prefix."forum.topic_desc like '%$search_value%' || ".$this->prefix."forum.category_id = '$search_category' ";
	         }
	         else if($search_value!='')
	         {
	                 $query .= "".$this->prefix."forum.topic like '%$search_value%' || ".$this->prefix."forum.topic_desc like '%$search_value%' ";
	                 
	         }
	         else if($search_category!='')
	         {
	                 $query .= "".$this->prefix."forum.category_id = '$search_category'";
	         }
	         else 
	         {
	                $query.="1=1";
	         }
	         
	         $query .= " AND  object_type=1  order by topic_id desc ";
	        $result = $this->db->query($query);
		return count($result);
		
		}
	}

	//get popular forum page
	public function get_common_search($search_value='',$search_category='',$offset='',$noofpage='')
	{
	        if($search_value!='' || $search_category!='')
	        {
	        
		$query = "select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where ( ";
		
		 if($search_value!='' && $search_category!='')
	         {
	                $query .= "".$this->prefix."forum.topic like '%$search_value%' || ".$this->prefix."forum.topic_desc like '%$search_value%' || ".$this->prefix."forum.category_id = '$search_category' ";
	         }
	         else if($search_value!='')
	         {
	                 $query .= "".$this->prefix."forum.topic like '%$search_value%' || ".$this->prefix."forum.topic_desc like '%$search_value%' ";
	                 
	         }
	         else if($search_category!='')
	         {
	                 $query .= "".$this->prefix."forum.category_id = '$search_category'";
	         }
	         else 
	         {
	                $query.="1=1";
	         }
	         
	         $query .= " ) AND  object_type=1  order by topic_id desc limit $offset,$noofpage ";

	         $result = $this->db->query($query);
		return $result;
		}
	}

	//for forum page pagenation
	public function count_forums()
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield."  where object_type=1 ");
		return $result;
	}

	//get the home page forum
	public function get_forums($offset='',$noofpage='')
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield." from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." where object_type=1 order by topic_id desc limit $offset,$noofpage ");
		return $result;
	}
	//count the category
	public function count_all_category()
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category");
		return $result;
	}
	//get the category list
	public function get_all_category($offset='',$noofpage='')
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_category limit $offset,$noofpage ");
		return $result;
	}

	//create forum discussion
	public function create_forum($topic,$category,$topic_desc,$userid)
	{
	
		$this->db->query("update ".$this->prefix."forum_category set total_discussion=total_discussion+1 where category_id='$category'");
		
		$result=$this->db->query("INSERT INTO `".$this->prefix."forum` (`category_id` ,`author_id` ,`posts` ,`hit` ,`topic`,`topic_desc`)VALUES (
		'$category','$userid', '0', '0', '$topic','$topic_desc')");
		$forum_id=$result->insert_id();
		$this->update->updates_insert($userid,$forum_id,14,$topic);
		
		 //call google 
		$ping_url = 'forum/view/'.url::title($topic).'_'.$forum_id;
		Nauth::ping($topic,$ping_url);
		
		Nauth::setMessage(1,$this->add_forum);
	        url::redirect($this->docroot.'forum/view/'.url::title($topic).'_'.$forum_id);
		
		return $result;
	}
	//delete forum
	public function delete_forum($id)
        {
                $result=$this->db->query(" select category_id,author_id from ".$this->prefix."forum where topic_id='$id'");
                common::delete_update($id,14);
                common::delete_update($id,15);
                if($result["mysql_fetch_array"]->author_id == $this->user_id) 
	        {
                $catid=$result['mysql_fetch_array']->category_id;
                $res=$this->db->query("update ".$this->prefix."forum_category set total_discussion = total_discussion-1 where category_id='$catid' ");
		$result=$this->db->query("delete from ".$this->prefix."forum where topic_id='$id'");
		return 1;
		}
		else
		{
		return 0;
		}
	}
	//update forum
	public function update_forum($fid,$title,$category,$description)
	{
		$result=$this->db->query("update ".$this->prefix."forum set topic='$title',topic_desc='$description',category_id='$category' where topic_id='$fid'");
		return $result;
	}
	//update the hit count for forum
	public function update_hit($id)
	{
		
		$result=$this->db->query("UPDATE ".$this->prefix."forum SET hit=hit+1 WHERE topic_id='$id'");
		return $result;
	}

	//get the single forum information
	public function get_forum_information($id)
	{
		$result=$this->db->query("select ".$this->prefix."forum.category_id,topic_id,author_id,posts,hit,lpost as lpost,topic,forum_category,".$this->unamefield.",user_photo,topic_desc from ".$this->prefix."forum left join ".$this->prefix."forum_category on ".$this->prefix."forum.category_id=".$this->prefix."forum_category.category_id left join ".$this->usertable." on ".$this->prefix."forum.author_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id where topic_id='$id' AND object_type=1 ");
		return $result;

	}

	//for discussion page pagenation
	public function count_test2($id)
	{
		$result=$this->db->query("select * from ".$this->prefix."forum_discussion where topic_id='$id'");
		return $result;
	}
	
	//get the comments for forum			
	public function discuss($id,$offset='',$noofpage='')
	{
		$result=$this->db->query("select *,cdate as cdate from ".$this->prefix."forum_discussion left join ".$this->usertable." on ".$this->prefix."forum_discussion.commentor_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id where topic_id='$id' order by discuss_id desc limit $offset,$noofpage");
		return $result;
	}
	//post the comments for forum
	public function post_comment($subject='',$id='',$comments='',$userid='')
	{
		$result=$this->db->query("INSERT INTO ".$this->prefix."forum_discussion (`topic_id` ,`commentor_id` ,`subject` ,`desc` )VALUES ('$id', '$userid', '$subject', '$comments')");
		$post_id = $result->insert_id();
		$result1=$this->db->query("select topic from ".$this->prefix."forum where topic_id='$id'");
		$topic=$result1["mysql_fetch_object"]->topic; 
		$this->update->updates_insert($userid,$id,15,$topic,$post_id);
		$result=$this->db->query(" SELECT author_id, topic FROM `".$this->prefix."forum` WHERE topic_id = '$id' ");

                $usrid=$result["mysql_fetch_array"]->author_id;
                $friend_id=$userid;
                $type="Commented on forum";
                $description='<a href='.$this->docroot.'forum/view?id='.$id.'>'.htmlspecialchars_decode($result["mysql_fetch_array"]->topic).'</a>'; 
		Nauth::send_mail_id($usrid,$friend_id,$type,$description); 
		
		return $result;
	}
	//update the date to find last active date
	public function updatedate($id)
	{
	
		$result=$this->db->query("UPDATE ".$this->prefix."forum SET lpost=now() WHERE topic_id='$id'");
		return $result;
	}
        //delete comments { threads }
        public function delete_comment($cid,$fid)
        {
                $this->db->query("update ".$this->prefix."forum set posts=posts-1 where topic_id='$fid'");
                $result = $this->db->query( "delete from ".$this->prefix."forum_discussion where discuss_id='$cid' ");
                common::delete_update('',15,$cid);
                return $result;
        }
        
	//update the comments count to forum
	public function updatepost($id)
	{
		$result=$this->db->query("UPDATE ".$this->prefix."forum SET posts=posts+1 WHERE topic_id='$id'");
		return $result;
	}


}

/* for edited forum
$this->update->updates_insert($user_id,edited forum id,16,'',$title); */
?>


