<?php
/**
 * Default Kohana controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * @package    Core
 * @author     M.Balamurugan 
 * @copyright  (c) 2009-2010 Ndot
 * @license    http://ndot.in
 */
	class Update_model_Model extends Model
	{

		public function __construct()
		{
			$this->session=Session::instance();
			$this->user_id=$this->session->get('userid');
                        //calling database configuration settings
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
			parent::__construct();
			$db=new Database();
		}

		// function to insert update from various module
		//function to insert updates 	
		public function updates_insert($user_id='',$type_id='',$action_id='',$description='', $post_id = '' ,$photo_count = '')
		{
			//$description=html::specialchars($description);
			//$result=$this->db->query("INSERT INTO ".$this->prefix."updates (`user_id`, `type_id`, `action_id`, `session_id`, `description`) VALUES ( '$user_id','$type_id','$action_id','$session_id','$description')");
			$result=$this->db->query("INSERT INTO ".$this->prefix."updates (`user_id`, `type_id`, `action_id`, `description`,`photo_count`, `post_id`) VALUES ( '$user_id','$type_id','$action_id','$description','$photo_count','$post_id')");
			return $result;
		} 
		/* function to insert updates 	
		public function updates_insert_photo($user_id='',$type_id='',$action_id='',$description='', $post_id = '' ,$photo_count = '')
		{
			//$description=html::specialchars($description);
			$result=$this->db->query("INSERT INTO ".$this->prefix."updates (`user_id`, `type_id`, `action_id`, `description`,`photo_count`, `post_id`) VALUES ( '$user_id','$type_id','$action_id','$description','$photo_count','$post_id')");
			return $result;
		}  */
		//third party updates
		public function updates_insert_third_party($user_id='',$type_id='',$action_id='',$description='',$url='')
		{
			//$description=html::specialchars($description);
			$result=$this->db->query("INSERT INTO ".$this->prefix."updates (`user_id`, `type_id`, `action_id`, `third_party_url`, `desc`) VALUES ( '$user_id','$user_id','$action_id','$url','$description')");
			return $result;
		}

		//to get question title from answer id 
		public function get_question_title($id)
		{	
			$result=$this->db->query("select question from ".$this->prefix."question where id=$id");
			return $result;
		}

		//function for all updates 
		public function all_updates_list()
		{  //print_r(($_SESSION["enable_module"]); exit;
			/* $sql = "select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id in (SELECT user_id FROM  ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id having fdate <= 3  order by date desc ";  
*/
                        $modules = '';
						
						
		        foreach($_SESSION["enable_module"] as $row)
		        {
		        	$modules = $modules."'".ucfirst($row)."',";
		        }
				
		        $modules = $modules."'Inbox','News','Photos','Friends','User Status','Profile','Wall','Video'";  

                        $sql = "select t1.*,dms.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 left join ".$this->prefix."module_settings as dms on dms.user_id = t4.".$this->uidfield." where updates in(1,-1) and  t1.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id and t3.mod_name in ($modules) order by date desc " ; 
			$result = $this->db->query($sql);
			return $result; 
		}

		//function to display 10(pagination) updates 
		public function updates_list($offset='',$noofpage='')
		{
			/*	$sql = "select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id in (SELECT user_id FROM  ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id  having fdate <= 3 order by date desc limit $offset,$noofpage ";  */
			$sql = "select t1.*,dms.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 left join ".$this->prefix."module_settings as dms on dms.user_id = t4.".$this->uidfield." where updates in(1,-1) and  t1.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id  order by date desc  limit $offset,$noofpage" ; 
			$result = $this->db->query($sql);
			return $result;
		}

		//function to display 10(pagination) my updates 
		public function myupdates_list($offset='',$noofpage='',$id='')
		{ 
		        /* Modules Setting (if any module disable then update wont show for disabled module)*/ 
		        $modules = '';
		        foreach($_SESSION["enable_module"] as $row)
		        {
		        $modules = $modules."'".ucfirst($row)."',";
		        }
		        $modules = $modules."'Inbox','News','Photos','Friends','User Status','Profile','Wall','Video'"; 
		        
		        /* Privacy Checking */
		         $privacy_check=$this->db->query("select updates from ".$this->prefix."module_settings where user_id = '$id' ");
		         if(count($privacy_check) > 0)
		         {
		                $privacy_setting = $privacy_check['mysql_fetch_object']->updates;
		         }
		         else
		         {
		                 $privacy_setting = '1';
		         }
		         if($privacy_setting == "1")
		         { /* having fdate <= 5 */ 
		          $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id and t3.mod_name in ($modules)  order by date desc limit $offset,$noofpage ");
		        return $result;
		         }
		         else if($privacy_setting == "-1")
		         {
		         $friend_check = $this->db->query("SELECT user_id  FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND  user_id = '$id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND friend_id ='$id' AND STATUS =1 )  ");
                                  if(count($friend_check))      		 
                                  {
                     		 $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id  and t3.mod_name in ($modules) order by date desc limit $offset,$noofpage ");
                		return $result;
                                  }
                                  else
                                  {
                                          if($this->user_id == $id )
		                         { 
		                       $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id and t3.mod_name in ($modules)  order by date desc limit $offset,$noofpage ");
                        	       return $result;
		                         
		                         }
		                         else
		                         {
                                                return -1;                          
                                        }
                                  }
		         
		         }
		         else
		         { 
		                      if($this->user_id == $id )
		                      { 
		                       $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id  and t3.mod_name in ($modules) order by date desc limit $offset,$noofpage ");
                        	       return $result;
		                     }
		                      else
		                      {
		                      return -2;	
		                      }
                                               	 
		        }
		               
			
		}
		
		
		public function my_note($updateid = 12776, $id = "")
		{
			 
		        /* Modules Setting (if any module disable then update wont show for disabled module)*/ 
		        $modules = '';
		        foreach($_SESSION["enable_module"] as $row)
		        {
		        $modules = $modules."'".ucfirst($row)."',";
		        }
		        $modules = $modules."'Inbox','News','Photos','Friends','User Status','Profile','Wall','Video'"; 
		        
		        /* Privacy Checking */
		         $privacy_check=$this->db->query("select updates from ".$this->prefix."module_settings where user_id = '$id' ");
		         if(count($privacy_check) > 0)
		         {
		                $privacy_setting = $privacy_check['mysql_fetch_object']->updates;
		         }
		         else
		         {
		                 $privacy_setting = '1';
		         }
		         if($privacy_setting == "1")
		         { /* having fdate <= 5 */ 
		          $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where t1.id = '".$updateid."' and  user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id and t3.mod_name in ($modules)  ");
		        return $result;
		         }
		         else if($privacy_setting == "-1")
		         {
		         $friend_check = $this->db->query("SELECT user_id  FROM ".$this->prefix."user_friend_list WHERE  t1.id = '".$updateid."' and (friend_id ='$this->user_id' AND  user_id = '$id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND friend_id ='$id' AND STATUS =1 )  ");
                                  if(count($friend_check))      		 
                                  {
                     		 $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where t1.id = '".$updateid."' and  user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id  and t3.mod_name in ($modules)  ");
                		return $result;
                                  }
                                  else
                                  {
                                          if($this->user_id == $id )
		                         { 
		                       $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where t1.id = '".$updateid."' and user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id and t3.mod_name in ($modules)  ");
                        	       return $result;
		                         
		                         }
		                         else
		                         {
                                                return -1;                          
                                        }
                                  }
		         
		         }
		         else
		         { 
		                      if($this->user_id == $id )
		                      { 
		                       $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where t1.id = '".$updateid."' and user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id  and t3.mod_name in ($modules) ");
                        	       return $result;
		                     }
		                      else
		                      {
		                      return -2;	
		                      }
                                               	 
		        }
		               
			
		
		}

		//function to count all my updates 
		public function all_myupdates_list($id='')
		{
		         $privacy_check=$this->db->query("select updates from ".$this->prefix."module_settings where user_id = '$id' ");
		         if(count($privacy_check) > 0)
		         {
		                $privacy_setting = $privacy_check['mysql_fetch_object']->updates;
		         }
		         else
		         {
		                 $privacy_setting = '1';
		         }
		         if($privacy_setting == "1")
		         {
		           
		         $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id   order by date desc ");
		        return $result;
		         }
		         else if($privacy_setting == "-1")
		         {
		                
		         $friend_check = $this->db->query("SELECT user_id  FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND  user_id = '$id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND friend_id ='$id' AND STATUS =1 )  ");
                                  if(count($friend_check))      		 
                                  {
                              
                     		 $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id   order by date desc  ");
                		return $result;
                                  }
                                  else
                                  {
                                      
                                        return -1;                          
                                  }
		         
		         }
		         else
		         { 
		              if($this->user_id == $id )
		              { 
		               $result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->unamefield.",t4.".$this->uidfield." as u_id  from ".$this->prefix."updates as t1,".$this->prefix."action as t2,".$this->prefix."modules as t3,".$this->usertable." as t4 where user_id='$id' and t2.id=t1.action_id and t3.mod_id=t2.mod_id  and t4.".$this->uidfield."=t1.user_id   order by date desc  ");
                	       return $result;
		             }
		              else
		              {
		              return -2;	
		              }
                                       	 
		         }
		
		}

		//function to add and delete comments
		public function adddelete_comment($id='',$coment='')
		{		
			if($coment)
			{
			$user_id=$this->session->get('userid');
			$result=$this->db->query("INSERT INTO ".$this->prefix."update_comments (`upd_id` ,`user_id` ,`desc`)VALUES ('$id', '$user_id', '$coment')");
			return $result;
			}
			else
			{ 
			$result=$this->db->query("delete from ".$this->prefix."update_comments where id='$id' ");
			return $result;
			}
			
		}


		//function to display posted comments 
		public function show_upd($id)
		{	
			$result=$this->db->query("select t1.*,datediff(now(),t1.date) as fdate,t2.".$this->unamefield.",t3.user_id as owner_id from ".$this->prefix."update_comments as t1,".$this->usertable." as t2,".$this->prefix."updates as t3  where t1.upd_id=$id and t2.id=t1.user_id and t3.id=t1.upd_id order by date asc");
			return $result;
		}

		//function to count comment
		public function comment_count($id)
		{
			$result=$this->db->query("select id  from ".$this->prefix."update_comments  where upd_id=$id ");
			return $result;
		}

		//to fetch type_id (friends details)
		public function upd_friend($id)
		{
			$result=$this->db->query("select ".$this->unamefield.",id from ".$this->usertable." where id=$id");
			return $result;
		} 
		
		//to delete update when we delete answer,blog,video......
		public function delete_upd($typeid = '',$actionid = '', $post_id = '' )
		{ 
			 if($post_id != "" && $typeid != '' ) 
			{
        		        $result= $this->db->query( "delete from ".$this->prefix."updates where type_id='$typeid' and action_id = '$actionid' and post_id = '$post_id'"); 
			}
			else if($post_id != "")
			{
			       $result= $this->db->query( "delete from ".$this->prefix."updates where  action_id = '$actionid' and post_id = '$post_id'"); 
			}
			else if($typeid != '')
			{
			       $result= $this->db->query( "delete from ".$this->prefix."updates where type_id='$typeid' and action_id = '$actionid'"); 
			}
		}  
		
		
		public function like_update($upd_id,$user_id,$like)
		{
			
			if($like=='Like')
			{
			$res=$this->db->query("INSERT INTO ".$this->prefix."update_like (`user_id`,`update_id` ,`upd_like` )VALUES ('$user_id','$upd_id',  '1')");
			}
			else
			{	
			$res=$this->db->query("DELETE FROM ".$this->prefix."update_like WHERE update_id='$upd_id'and user_id='$user_id' ");
			}
			$result=$this->db->query("select ".$this->unamefield." from ".$this->usertable." where id in (SELECT `user_id` FROM ".$this->prefix."update_like WHERE `update_id`=$upd_id and `upd_like`=1 ) ");
			return $result;
		}
		/* Function for show names like (updates) */ 
		public function show_like($upd_id)
		{
			$result=$this->db->query("select ".$this->unamefield.",id from ".$this->usertable." where id in (SELECT `user_id` FROM ".$this->prefix."update_like WHERE `update_id`=$upd_id and `upd_like`=1)");
			return $result;
		}
		/* Function for  like (updates) */ 
		public function up_like($upd_id,$user_id)
		{
			$result=$this->db->query("SELECT `user_id` FROM ".$this->prefix."update_like WHERE `update_id`=$upd_id and user_id=$user_id and `upd_like`=1");
			return $result;
		}
		/* to get gender to display His or Her */
		public function get_gender($user_id)
		{
			$result=$this->db->query("SELECT gender FROM ".$this->prefix."users_profile WHERE user_id=$user_id");
			return $result;
		}


	/* to get alumb id */
		public function get_album($photo_id)
		{
			$result=$this->db->query("SELECT album_id FROM ".$this->prefix."photos WHERE photo_id=$photo_id");
			return $result;
		}
	/* to get forum id */
		public function get_forum($topic_id)
		{
			$result=$this->db->query("SELECT group_id FROM ".$this->prefix."forum  WHERE topic_id=$topic_id");
			return $result;
		}
		/*  to get privacy setting */
		public function get_privacy($user_id)
		{
			$result=$this->db->query("SELECT updates FROM ".$this->prefix."module_settings  WHERE user_id = '$user_id' ");
			return $result;
		}
		/* Is Friend (friend check) */
		public function is_friend($id)
		{
		        if($id == $this->user_id )
		        {
		                 return  1;
		        }
		        else
		        {
                		$friend_check = $this->db->query("SELECT user_id  FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND  user_id = '$id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND friend_id ='$id' AND STATUS =1 )  ");
                                 return  count($friend_check);
                         }
                                  
                }

 
 
 
 	public function get_notisfiction($userid = "")
	{
		$result = $this->db->query("SELECT ".$this->prefix."update_comments.user_id as uid, ".$this->prefix."update_comments.desc, ".$this->prefix."updates.id , ".$this->prefix."update_comments.date, ".$this->prefix."updates.description, ".$this->prefix."updates.action_id, ".$this->usertable.".".$this->unamefield." as uname 
		FROM ".$this->prefix."update_comments 
		LEFT JOIN ".$this->prefix."updates on ".$this->prefix."updates.id = ".$this->prefix."update_comments.upd_id
		LEFT JOIN ".$this->usertable." on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."update_comments.user_id
		WHERE  ".$this->prefix."updates.user_id=".$userid."
		ORDER BY ".$this->prefix."update_comments.id DESC
		LIMIT 0,5");
		
		return $result;
		
	}
	
	public function get_note_like($userid = "")
	{
		$result = $this->db->query("SELECT ".$this->prefix."update_like.user_id as uid,  ".$this->prefix."update_like.date, ".$this->prefix."updates.id , ".$this->prefix."updates.description, ".$this->prefix."updates.action_id, ".$this->usertable.".".$this->unamefield." as uname 
		FROM ".$this->prefix."update_like 
		LEFT JOIN ".$this->prefix."updates on ".$this->prefix."updates.id = ".$this->prefix."update_like.update_id
		LEFT JOIN ".$this->usertable." on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."update_like.user_id
		WHERE  ".$this->prefix."updates.user_id=".$userid." and  ".$this->prefix."update_like.upd_like = 1
		ORDER BY ".$this->prefix."update_like.like_id DESC
		LIMIT 0,5");
		
		return $result;
	}
 
 
 }
 
 
/* query to fetch name id photo SELECT t2.user_photo,t1.id,t1.name FROM `users` as t1 , users_profile as t2 WHERE id=$user_id and user_id=$user_id */
/* select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->usertable.",t4.".$this->uidfield." as u_id,t5.name as typeid_name,t5.id as typeid_id from updates as t1,action as t2,modules as t3,users as t4,users as t5 where user_id in (SELECT user_id FROM user_friend_list WHERE (friend_id ='6' AND STATUS =1 ) UNION SELECT friend_id FROM user_friend_list WHERE ( user_id ='6' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id and t5.id=t1.type_id order by date desc */
/* select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->usertable.",t4.".$this->uidfield." as u_id,t5.last_name as typeid_name,t5.user_id as typeid_id,t5.user_photo as photo from updates as t1,action as t2,modules as t3,users as t4,users_profile as t5 where t5.user_id in (SELECT user_id FROM user_friend_list WHERE (friend_id ='6' AND STATUS =1 ) UNION SELECT friend_id FROM user_friend_list WHERE ( user_id ='6' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id and t5.user_id=t1.type_id order by date desc */ 
/* query for user photo
select t1.*,datediff(now(),t1.date) as fdate,t2.mod_id,t2.action_desc,t3.mod_name,t4.".$this->usertable.",t4.".$this->uidfield." as u_id,t5.last_name as typeid_name,t5.user_id as typeid_id,t5.user_photo as photo from updates as t1,action as t2,modules as t3,users as t4,users_profile as t5 where t5.user_id in (SELECT user_id FROM user_friend_list WHERE (friend_id ='6' AND STATUS =1 ) UNION SELECT friend_id FROM user_friend_list WHERE ( user_id ='6' AND STATUS =1 )) and t2.id=t1.action_id and t3.mod_id=t2.mod_id and t4.".$this->uidfield."=t1.user_id and t5.user_id=t1.type_id order by date desc

SELECT user_id FROM demo_user_friend_list WHERE (friend_id ='    123460' AND STATUS =1 ) UNION SELECT friend_id FROM demo_user_friend_list WHERE ( user_id ='123460' AND STATUS =1) 

 */
?>
