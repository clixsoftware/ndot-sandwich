<?php
/**
 * @package    Core
 * @author     M.Balamurugan 
 * @copyright  (c) 2009-2010 Ndot
 * @license    http://ndot.in
 */
	class Video_Model extends Model
	{

		public function __construct()
		{
			$this->session=Session::instance();
			$this->user_id=$this->session->get('userid');
                        //calling database configuration settings
			//include Kohana::find_file('../modules/video/views/','simple_html_dom',TRUE,'php');
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
			$this->update=new update_model_Model();
			$db=new Database();
			$this->docroot=$this->session->get('DOCROOT');
			
		}

	
	 //get videos
	 public function get_allvideos($uid='')
	 { 
		if($uid!='')
                {
	                 $result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id where user_id=$uid and status = '0' order by date desc");
	                 return $result;
	
		}
		else
		{ 
		         $result=$this->db->query("(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' ) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0')  order by date desc ");
		         return $result;
		}

	 }
     	//get my videos for pagination 
	 public function get_videos($offset='',$noofpage='',$uid='')
	 {
	 
	 	if($uid!='')
		{ 
	         $result=$this->db->query("select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.* from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where user_id=$uid and status = '0' order by date desc limit $offset,$noofpage");
	        return $result;	
		}
		else
		{ 
	         $result=$this->db->query(" (select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' ) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0')  order by date desc limit $offset,$noofpage");
	         return $result;	
		}
	 }
	 // for friends videos
	 public function get_allfriendsvideos()
	 { 
	 $result=$this->db->query("select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."module_settings.video  from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." left join ".$this->prefix."module_settings on ".$this->prefix."module_settings.user_id = ".$this->prefix."video.user_id where ".$this->prefix."video.user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and ".$this->prefix."module_settings.video in (1,-1) and  status = '0' order by date desc");
                 /*$result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id where user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )"); */ 
                 return $result;
	 } 
	 
	 
	 	 // for friends videos pagination
	 public function get_friends_videos($offset='',$noofpage='')
	 { 
	 /* "select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield."  where user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and status = '0' order by date desc limit $offset,$noofpage"*/
                 $result=$this->db->query("select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."module_settings.video  from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." left join ".$this->prefix."module_settings on ".$this->prefix."module_settings.user_id = ".$this->prefix."video.user_id where ".$this->prefix."video.user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and ".$this->prefix."module_settings.video in (1,-1) and  status = '0' order by date desc limit $offset,$noofpage");
                 return $result;
	 }
// for search
	 public function get_allsearchvideos($search_value='',$search_type='',$userid = '')
	 {      
	 if($search_type == 'friends_videos')  
	 {
	        $query = "select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."module_settings.video  from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." left join ".$this->prefix."module_settings on ".$this->prefix."module_settings.user_id = ".$this->prefix."video.user_id where ".$this->prefix."video.user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and ".$this->prefix."module_settings.video in (1,-1) and  status = '0' and video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' and ".$this->prefix."video.user_id = '$userid' order by date desc";
	        $result=$this->db->query($query);
                 return $result;
	 }
	 if($search_type == 'myvideo')
	 {
	         $result=$this->db->query("select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.* from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where user_id='$this->user_id' and status = '0' and video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' and ".$this->prefix."video.user_id = '$userid'  order by date  ");
	        return $result;	
	 }
	 if($search_type == 'popularvideos')
	 {  
	       
	        echo $query = "(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' and (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%')) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0'  and (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%')) order by video_viewed desc ";
	        $result=$this->db->query($query);
	         return $result;
	 }
	 else
	 {
	 $result=$this->db->query("(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' and  (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%') ) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0' and  (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%'))  order by date desc");
	 return $result;
	 }      
	 }

	 public function get_searchvideos($offset='',$noofpage='',$search_value='',$search_type='')
	 {
		    
	 if($search_type == 'friends_videos')  
	 { 
	        $result=$this->db->query("select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."module_settings.video  from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." left join ".$this->prefix."module_settings on ".$this->prefix."module_settings.user_id = ".$this->prefix."video.user_id where ".$this->prefix."video.user_id IN (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and ".$this->prefix."module_settings.video in (1,-1) and  status = '0' and video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' order by date desc limit $offset,$noofpage");
                 return $result;
	 }
	 if($search_type == 'myvideo')
	 { 
	         $result=$this->db->query("select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.* from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where user_id='$this->user_id' and status = '0' and video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' order by date  limit $offset,$noofpage"); 
	        return $result;	
	 }
	 if($search_type == 'popularvideos')
	 { 
	        $result=$this->db->query("(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' and (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' )) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0'  and (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' )) order by video_viewed desc limit $offset,$noofpage");
	         return $result;
	 }
	 else
	 {
		 $result=$this->db->query("(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0'  and  (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' )) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0' and (video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%') ) order by date desc limit $offset,$noofpage");
	 return $result;
	 }      
	
	 }
	  //edit video
	  public function  edit_video($title,$desc,$video_id)
	  {  
	        if(empty($title) || empty($desc))
	        {
	       $this->session->set("Emsg","Title/Description Fields Empty...");
                url::redirect($this->docroot.'video/createvideo/');	
	        }
	     $result=$this->db->query( "UPDATE ".$this->prefix."video SET `video_title` = '$title',`video_desc`= '$desc' WHERE `video_id` =$video_id "); 
	      url::redirect($this->docroot.'video/view_video?video_id='.$video_id);
	     return  $result;
	  }
	  
	//get the popular videos
	public function get_popular_videos($offset='',$noofpage='')
	{       /* "select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."  = ".$this->prefix."video.user_id where status = '0' order by video_viewed desc limit $offset,$noofpage" */
                $query = "(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."video.user_id in (SELECT user_id FROM ".$this->prefix."user_friend_list WHERE (friend_id ='$this->user_id' AND STATUS =1 ) UNION SELECT friend_id FROM ".$this->prefix."user_friend_list WHERE ( user_id ='$this->user_id' AND STATUS =1 )) and  ".$this->prefix."module_settings.video in (1,-1) or ".$this->prefix."module_settings.user_id = '$this->user_id'  and status = '0' ) 
union 
(select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."module_settings.video from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->prefix."module_settings on ".$this->prefix."video.user_id = ".$this->prefix."module_settings.user_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." where  ".$this->prefix."module_settings.video =  '1'  and status = '0')  order by video_viewed desc limit $offset,$noofpage";
	         $result=$this->db->query($query);
	         return $result;	
	}  








	//delete video
	public function delete_video($id)
	{
        	$check_user=$this->db->query("SELECT user_id from ".$this->prefix."video where video_id='$id'");
        	if($check_user->count() > 0)
        	{
	                if($check_user["mysql_fetch_array"]->user_id == $this->user_id) 
	                {
	                $result=$this->db->query("delete from ".$this->prefix."video where video_id='$id'");
                  	$this->db->query( "delete from ".$this->prefix."video_comments where type_id='$id' ");
                  	common::delete_update($id,20);
                  	common::delete_update($id,21);          	
                  	return 1;
                  	}
                  	else
                  	{
                  	return 0;
                  	}
	
	                $result=$this->db->query("delete from ".$this->prefix."video where video_id='$id'");
	                return $result;
                }
	}
	
	//Block video
	public function block_video($id,$status)
	{
	        $result=$this->db->query("update ".$this->prefix."video set status=$status where video_id='$id'");
	        return $result;
	}
		
	//show_video
	public function show_video($id)
	{       /* select * from ".$this->prefix."video where video_id='$id' order by date desc */
	       $result=$this->db->query("select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name,".$this->prefix."video_category.category,".$this->prefix."video_category.cat_id from ".$this->prefix."video left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield." left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id  where ".$this->prefix."video.video_id='$id' order by date desc  ");
	        return $result;
	} 
	/* related vidoes */
	public function relatedvideos($category_id,$video_id)
	{ 
	       $query = "select ".$this->prefix."video.*,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."video left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield."  where ".$this->prefix."video.cat_id='$category_id' and ".$this->prefix."video.video_id !='$video_id'  order by video_viewed desc  "; 
	      //$query = "select ".$this->prefix."video.* from ".$this->prefix."video where ".$this->prefix."video.video_tag like %$tag% order by video_viewed desc";
	      //echo $query ; 
	     
	      
	        $result=$this->db->query($query);
	        return $result;
	}
	
        /* Update video hit/view */
	public function upd_video_view($id)
	{       /* select * from ".$this->prefix."video where video_id='$id' order by date desc */
        	 $res=$this->db->query("UPDATE ".$this->prefix."video  SET video_viewed = video_viewed + 1 WHERE video_id = $id  ");
	        return $res;
	} 
		//show_video
	public function getmail($id)
	{
	        $result=$this->db->query("select email,name from ".$this->usertable." where id='$id'  ");
	        return $result;
	} 
	//get video for updates
	
	public function get_video($video_id)
	{
	        $result = $this->db->query("select thumb_url from ".$this->prefix."video where video_id='$video_id'  ");
	        return $result;
	} 

	
	//update comments count in video
	public function update_comments_count($video_id)
	{
	        $result=$this->db->query("update ".$this->prefix."video set comment_count=comment_count+1 where video_id='$video_id'");
	}

	//add the comment to video
	public function addcomment($userid,$desc,$video_id)
	{ 
	   if($desc!="")
	   {
      		$cmd_insert = $this->db->query( "insert into ".$this->prefix."video_comments(user_id,video_id,comments) VALUES ('$userid','$video_id','$desc')");
      		
      		$post_id = $cmd_insert->insert_id();
		$result1=$this->db->query("select video_title from ".$this->prefix."video where video_id='$video_id'");
		$videotitle=htmlspecialchars_decode($result1["mysql_fetch_object"]->video_title); 
		$this->update->updates_insert($userid,$video_id,21,$videotitle,$post_id);
		$result=$this->db->query(" SELECT user_id, video_title FROM `".$this->prefix."video` WHERE video_id = '$video_id' ");


                $usrid=$result["mysql_fetch_array"]->user_id;
                $friend_id=$userid;
                $type="Commented on video";
                $description='<a href='.$this->docroot.'video/view_video?video_id='.$video_id.'&best_answer=0>'.htmlspecialchars_decode($result["mysql_fetch_array"]->video_title).'</a>'; 
                Nauth::send_mail_id($usrid,$friend_id,$type,$description); 
		
	  
	   }
   	}
	//add videos

	public function add_video($url,$category)
	{	
	
         $title = $desc = $emb_code = $thumb_url= "";
        $video_url = explode('=',$url);	
        $video_url = explode('&',$video_url[1]);	
        $video_url = $video_url[0];  		        
        include Kohana::find_file('../modules/admin/views/videos/','simple_html_dom',TRUE,'php');
        $my_video = file_get_html($url); 
        $t =  array();
        foreach($my_video->find('meta') as $title)
        {
         $t[]=$title->content ."<br>";
        }
        $title = $t[0];
        $description = $t[2];  
        $tags =  '';
        foreach($my_video->find('div#watch-tags div a') as $tag) 
        {
                if($tags=="")
                {
                $tags =  $tag->innertext; 
                }
                else
                {
                  $tags = $tags.",".$tag->innertext;                 
                }

        }    
        $embcode = "<object width='640' height='385'><param name='movie' value='http://www.youtube.com/v/#videourl#'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/#videourl#' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='470' height='385'></embed></object>";
        $embedcode = str_replace('#videourl#', $video_url, $embcode);
        
        $thumb_url = "http://i2.ytimg.com/vi/#videourl#/default.jpg" ; 
        $thumb_url = str_replace('#videourl#', $video_url, $thumb_url);        
     
        if($title== 'noindex<br>' )
        {
                $this->session->set("Emsg","Video Embed Code Not Found.... Enter Correct Url");
                url::redirect($this->docroot.'video/');	
        }

        
        $title = strip_tags(html::specialchars($title));
        $desc = strip_tags(html::specialchars($description)); 
        $thumb_url = html::specialchars($thumb_url);
         $embedcode = mysql_escape_string($embedcode);

        $check_dup = $this->db->query("select * from ".$this->prefix."video  where user_id = '$this->user_id'  and embed_code = '$embedcode' and video_url = '$url' ") ; 
                if(count($check_dup) == 0) 
                {               
                        $result=$this->db->query("INSERT INTO ".$this->prefix."video ( `cat_id`,`video_title`, `video_desc`, `user_id`,`thumb_url`, `embed_code`,`video_url`,`video_tag`) VALUES ('$category','$title', '$desc', '$this->user_id','$thumb_url', '$embedcode','$url','$tags')");
                        $videoid=$result->insert_id();   
                        $this->update->updates_insert($this->user_id,$videoid,20,$title);
                        $this->session->set('Msg',"Video Added Successfully");
			url::redirect($this->docroot.'video/view_video?video_id='.$videoid);
                 } 
                 else
                 {
                $this->session->set("Emsg","Video Already Exists");
                url::redirect($this->docroot.'video/createvideo/');	                 
                 }


}
	//video category
	  public function video_cat($category,$offset= '',$noofpage='')
	  {
	    	$result=$this->db->query("  select ".$this->prefix."video.*,".$this->prefix."video_category.*,".$this->usertable.".".$this->unamefield." as name from ".$this->prefix."video LEFT JOIN ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->prefix."video.user_id = ".$this->usertable.".".$this->uidfield."  where  ".$this->prefix."video_category.cat_id='$category' order by date desc limit $offset,$noofpage "  );
		return $result;
	  }
  	  public function get_category_count($category)
	  {
	  	$result=$this->db->query("select * from ".$this->prefix."video LEFT JOIN ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id where  ".$this->prefix."video_category.cat_id='$category' " );
		return $result;
	  }

	//get category
	 public function get_category()
	 {
		 $result=$this->db->query("select * from ".$this->prefix."video_category" );
		 return $result;
	 } 
	 public function del_com($cid)
	 {
		 $vid = $this->db->query("SELECT  ".$this->prefix."video.video_id FROM `".$this->prefix."video_comments` left join ".$this->prefix."video on  ".$this->prefix."video_comments.video_id = ".$this->prefix."video.video_id  WHERE  comment_id = '$cid' " ); 
               
                  $v_id = $vid["mysql_fetch_object"]->video_id;
                  
                  $res=$this->db->query("delete  from ".$this->prefix."video_comments where comment_id= $cid" );
               	common::delete_update($v_id,21,$cid);
                  $result=$this->db->query("UPDATE ".$this->prefix."video SET comment_count = comment_count-1 WHERE video_id = $v_id" );
        	 return $result;
	 } 

 }


?>
