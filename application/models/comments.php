<?php defined('SYSPATH') or die('No direct script access.');
 /**
 * Defines all Blog database activity
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

 class Comments_Model extends Model
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
	 //show the comments
	 public function get_comments($table_name='',$type_id='')
	 {
		   $queryString = "select *,cdate as DATE,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix.$table_name." left join ".$this->usertable." ON  ".$this->prefix.$table_name.".user_id=".$this->usertable.".".$this->uidfield."  left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id having  ".$this->prefix.$table_name.".type_id='$type_id' order by ".$this->prefix.$table_name.".comment_id desc";
		   
		   $result = $this->db->query($queryString);
		   return $result;
	 }

	 //count the comments
	public function get_comments_count($table_name='',$type_id='')
	{
		   $queryString = "select *,cdate as DATE,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix.$table_name." left join ".$this->usertable." ON  ".$this->prefix.$table_name.".user_id=".$this->usertable.".".$this->uidfield."  left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id having  ".$this->prefix.$table_name.".type_id='$type_id' order by ".$this->prefix.$table_name.".comment_id desc";

		   $result = $this->db->query($queryString);
		   return count($result);
	
	}
	
	
	//add the comment to blogs
	public function post_comments($table_name='',$type_id='',$desc='',$user_id='',$type='')
	{
	   if($desc!="")
	   {
	        $desc = html::specialchars($desc);
      		$post_result = $this->db->query( "insert into ".$this->prefix.$table_name."(type_id,user_id,comments,cdate) VALUES ('$type_id','$user_id','$desc',SYSDATE() )");
      		 
      		
      		if($table_name == "blog_comments")
      		{
      		        $this->db->query("update ".$this->prefix."blog set counts=counts+1 where blog_id='$type_id'");
      		        
              		$post_id = $post_result->insert_id();
              		
		        $result1=$this->db->query("select blog_title from ".$this->prefix."blog where blog_id='$type_id'");
	                $title=$result1["mysql_fetch_object"]->blog_title; 
	
		        $this->update->updates_insert($user_id,$type_id,19,$title,$post_id);
		        
                	$result=$this->db->query("SELECT user_id, blog_title FROM ".$this->prefix."blog WHERE blog_id = '$type_id' ");
                        $usrid=$result["mysql_fetch_array"]->user_id;
                        $friend_id=$user_id;
                        $type_name="Blog reply";
                        $description='<a href='.$this->docroot.'blog/view/?bid='.$type_id.'>'.htmlspecialchars_decode($result["mysql_fetch_array"]->blog_title).'</a>'; 
		        Nauth::send_mail_id($usrid,$friend_id,$type_name,$description); 
		
		}
		else if($table_name == "article_comments")
      		{
      		        $this->db->query("update ".$this->prefix."article set counts=counts+1 where article_id='$type_id'");
      		        
              		$post_id = $post_result->insert_id();
              		
		        $result1=$this->db->query("select subject from ".$this->prefix."article where article_id='$type_id'");
	                $title=$result1["mysql_fetch_object"]->subject; 
	
		        $this->update->updates_insert($user_id,$type_id,41,$title,$post_id);
		        
                	$result=$this->db->query("SELECT uid, subject FROM ".$this->prefix."article WHERE article_id = '$type_id' ");
                        $usrid=$result["mysql_fetch_array"]->uid;
                        $friend_id=$user_id;
                        $type_name="Comment posted on Article";
                        $description='<a href='.$this->docroot.'article/view/?id='.$type_id.'>'.htmlspecialchars_decode($result["mysql_fetch_array"]->subject).'</a>'; 
		        Nauth::send_mail_id($usrid,$friend_id,$type_name,$description); 
		
		}
		else if($table_name == "news_comments")
		{
		        $result1=$this->db->query("select news_title from ".$this->prefix."news where news_id='$type_id'");
		        $news_title=$result1["mysql_fetch_object"]->news_title; 
		        $this->update->updates_insert($user_id,$type_id,10,$news_title);
		        $result=$this->db->query("UPDATE ".$this->prefix."news SET comment_count=comment_count+1 WHERE news_id='$type_id'");

		}
		else if($table_name == "photos_comments")
		{
		        $this->db->query("update ".$this->prefix."photos set count_comment=count_comment+1 where photo_id='$type_id'");
		        $post_id = $post_result->insert_id();
			$result1=$this->db->query("select photo_title from ".$this->prefix."photos where photo_id='$type_id'");
			$phototitle=htmlspecialchars_decode($result1["mysql_fetch_object"]->photo_title); 
			
			if($type == "groups")
			{
			        $this->update->updates_insert($user_id,$type_id,31,$phototitle,$post_id);
			}
			else
			{
			        $this->update->updates_insert($user_id,$type_id,25,$phototitle,$post_id);
			}
		}
		else if($table_name == "classifieds_comments")
		{
		        $result2=$this->db->query("UPDATE ".$this->prefix."classifieds SET count_comments=count_comments+1 WHERE id='$type_id'");
		
		        $result1=$this->db->query("select title,user_id from ".$this->prefix."classifieds where id='$type_id'");
		        
		        $title = $result1["mysql_fetch_object"]->title; 
		        $usrid = $result1["mysql_fetch_object"]->user_id; 
		        
		        $this->update->updates_insert($user_id,$type_id,12,$title);
		
		        $friend_id=$user_id;
                        $type_name="Commented on ads";
                        $description='<a href='.$this->docroot.'classifieds/view?cid='.$type_id.'>'.htmlspecialchars_decode($result1["mysql_fetch_array"]->title).'</a>'; 
                        
                        Nauth::send_mail_id($usrid,$friend_id,$type_name,$description);
		}
		else if($table_name == "video_comments")
		{
		        $this->db->query("update ".$this->prefix."video set comment_count=comment_count+1 where video_id='$type_id'");
		        
		        $post_id = $post_result->insert_id();
		        $result1=$this->db->query("select video_title from ".$this->prefix."video where video_id='$type_id'");
		        $videotitle=htmlspecialchars_decode($result1["mysql_fetch_object"]->video_title); 
		        $this->update->updates_insert($user_id,$type_id,21,$videotitle,$post_id);
		        $result=$this->db->query(" SELECT user_id, video_title FROM `".$this->prefix."video` WHERE video_id = '$type_id' ");


                        $usrid=$result["mysql_fetch_array"]->user_id;
                        $friend_id=$user_id;
                        $type="Commented on video";
                        $description='<a href='.$this->docroot.'video/view_video?video_id='.$type_id.'>'.htmlspecialchars_decode($result["mysql_fetch_array"]->video_title).'</a>'; 
                        Nauth::send_mail_id($usrid,$friend_id,$type,$description); 
                
		}
		else if($table_name == "events_comments")
		{
		        $this->db->query("select comment_count from ".$this->prefix."events where ".$this->prefix."events.event_id = '$type_id'");
		  
		}
		return $post_result;

	   }
   	}
   	
    	 //delete comments
         public function delete_comment($table_name,$type_id,$comment_id,$user_id,$type='')
         {

                $delete_result = $this->db->query( "delete from ".$this->prefix.$table_name." where comment_id='$comment_id' AND type_id='$type_id' ");
                
                if($table_name == "blog_comments")
      		{
                        common::delete_update($type_id,19,$comment_id);
                        $this->db->query("update ".$this->prefix."blog set counts=counts-1 where blog_id='$type_id'");
                }
                else if($table_name == "article_comments")
      		{
                        common::delete_update($type_id,41,$comment_id);
                        $this->db->query("update ".$this->prefix."article set counts=counts-1 where article_id='$type_id'");
                }

                else if($table_name == "news_comments")
                {
                        common::delete_update($type_id,10,$comment_id);
                        $this->db->query("update ".$this->prefix."news set comment_count=comment_count-1 where news_id='$type_id'");
               
                }
                else if($table_name == "photos_comments")
                {
                        if($type == "groups")
			{
			        common::delete_update($type_id,31,$comment_id);
			}
			else
			{
			        common::delete_update($type_id,25,$comment_id);
			}
			
                        
                        $this->db->query("update ".$this->prefix."photos set count_comment=count_comment-1 where photo_id='$type_id'");
                }
                else if($table_name == "classifieds_comments")
		{
		        common::delete_update($type_id,12,$comment_id);
                        $this->db->query("update ".$this->prefix."classifieds set count_comments=count_comments-1 where id='$type_id'");
		}
                else if($table_name == "video_comments")
		{
		         common::delete_update($type_id,21,$comment_id);
                         $this->db->query("UPDATE ".$this->prefix."video SET comment_count = comment_count-1 WHERE video_id = $type_id" );
		}
		else if($table_name == "events_comments")
		{
		         $this->db->query("update ".$this->prefix."events set comment_count = comment_count-1 where event_id = '$type_id'");
		}
		
                return $delete_result;
         }
  }
  
	
