<?php
  defined('SYSPATH') or die('No direct script access.');
 /**
 * Defines all photos database activity
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

  class Photos_Model extends Model
  {
      public function __construct()
      {
		parent::__construct();
		$this->db = new Database();
		//user response messages
		include Kohana::find_file('../application/config','database',TRUE,'php'); 

	  	$this->ustatus = $config['ustatus'];
		$this->uidfield = $config['uidfield'];
		
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		$mes=Kohana::config('users_config.session_message');
		$this->create_album=$mes["create_album"];
		$this->invalid_photo=$mes["invalid_photo"];
		$this->album_exist=$mes["album_exist"];
		$this->upload_photo=$mes["upload_photo"];
		$this->session = Session::instance();
		$this->user_id = $this->session->get('userid');
		//model object
		$this->update=new update_model_Model();
		$this->session=Session::instance();
		$this->usr_id = $this->session->get('userid');
		
		 $this->photos_size = Kohana::config('application.photos');
	 	 $this->thumb_size = Kohana::config('application.thumb');

      }
	  
      //display album
      public function display_album($userid, $offset = '', $pageno = '', $noofpage = '',$friend = 0)
      {
	  	if($userid == $this->user_id){
			$condtiion = "and album_permision in (0,-1,1)";
		}
		elseif($friend > 0){
			$condtiion = "and album_permision in (0,1)";
		}
		else{
			$condtiion = "and album_permision in (0)";
		}
          //having album_permision=0
          $result = $this->db->query("select *,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id=".$this->prefix."photos_album.album_id ) as total,album_date from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' $condtiion  order by ".$this->prefix."photos_album.album_id desc   limit $offset,$noofpage");
          return $result;
      }
	  
	  //count the  albums
      public function get_count_album($userid,$friend = 0)
      {
	  	  if($userid == $this->user_id){
			$condtiion = "and album_permision in (0,-1,1)";
		}
		elseif($friend > 0){
			$condtiion = "and album_permision in (0,1)";
		}
		else{
			$condtiion = "and album_permision in (0)";
		}
          $result = $this->db->query("select * from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' $condtiion order  by ".$this->prefix."photos_album.album_id desc");
          $count_albums = count($result);
          return $count_albums;
      }
	  
	  
	  public function get_friends_id($userid = "" ,$status = 1)
	  {
	  	$sql = "Select ".$this->uidfield." as id from (SELECT ".$this->prefix."user_friend_list.user_id as uid,request_id FROM ".$this->prefix."user_friend_list  where (friend_id='$userid' and status='$status') union SELECT friend_id,request_id FROM ".$this->prefix."user_friend_list  where (user_id='$userid' and status='$status')) as tab left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield."=tab.uid  where ".$this->usertable.".".$this->ustatus."= 1 ";
		$exe = $this->db->query($sql);
	  
	  $friend_id = '';
	   if(count($exe) > 0){
	   		foreach($exe as $r){
				$friend_id .= $r->id.",";
			}
			 $friends_id = substr($friend_id,0,-1);
	   }
	   else{
	   		 $friends_id = 0;
	   }
	   	return $friends_id;
	  }
	  
      //display  friends album
      public function friends_album($userid, $offset = '', $pageno = '', $noofpage = '', $status = 1, $friends_id = 0)
      {
		 $result = $this->db->query("select *,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id= ".$this->prefix."photos_album.album_id ) as total,album_date from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id in ($friends_id) AND (".$this->prefix."photos_album.album_permision = 0 OR  ".$this->prefix."photos_album.album_permision = 1 ) order by ".$this->prefix."photos_album.album_id desc   limit $offset,$noofpage");
		  return $result;
      }
	  //friends
      public function friends_count_album($userid = "" ,$status = 1 ,$friends_id = 0)
      {
          $result = $this->db->query("select album_id from ".$this->prefix."photos_album where ".$this->prefix."photos_album.user_id in ($friends_id) AND  (".$this->prefix."photos_album.album_permision = 0 OR  ".$this->prefix."photos_album.album_permision = 1 )");
          $count_albums = count($result);
          return $count_albums;
      }
	  
     
	  //get the albums photo lists
      public function get_view_album($album_id)
      {
          $result = $this->db->query("select * from ".$this->prefix."photos_album where album_id='$album_id'");
          $count_vp = count($result);
          return $count_vp;
      }
	 
      
	 
      /* to get album photo to show in updates */
	  public function get_abmphoto($album_id)
      {
          $result = $this->db->query("select photo_name,photo_title,photo_id from ".$this->prefix."photos where album_id='$album_id' order by photo_id desc ");
          return $result;  
      }      
      
	  //delete the photo comments
      public function delete_photocomment($comment_id)
      {
          	$check_user=$this->db->query("SELECT user_id from ".$this->prefix."photo_comment where comment_id='$comment_id'");
	        if($check_user["mysql_fetch_array"]->user_id == $this->user_id) 
	        {
                $result = $this->db->query("delete from ".$this->prefix."photo_comment where comment_id='$comment_id'");
          	  return 1;
          	}
          	else
          	{
          	return 0;
          	}  
      }
	  
     /**  DELETE ALBUM **/
	 
      public function delete_album($album_id = "" ,$userid = "")
      {
			$result = $this->db->delete('photos_album', array('album_id' => $album_id,"user_id" => $userid));	
			if(count($result) > 0){
				$album_photo = $this->db->select("photo_id")->from("photos")->where(array("album_id" => $album_id ,"user_id" => $userid))->get();
				
				foreach($album_photo as $id){
					common::delete_update( $id->photo_id, 25 );
					common::delete_update( $album_id , 22 );
					
					$root = DOCROOT."public/album_photo/"; 
		
					if(file_exists($root.$id->photo_id.".jpg")) { 
						unlink($root.$id->photo_id.".jpg");
					}
					if(file_exists($root."50/".$id->photo_id.".jpg")){
						unlink($root."50/".$id->photo_id.".jpg");
					}
					if(file_exists($root."normal/".$id->photo_id.".jpg")){
						unlink($root."normal/".$id->photo_id.".jpg");
					}
			
				}
				$this->db->delete('photos', array('album_id' => $album_id,"user_id" => $userid));	
				return 1;
			}
			else{
				return 0;
			}
      }
	  
	/** EDIT ALBUM **/
	
	public function edit_album($albumid = 0, $title = "", $description = "", $share = 0)
	{
		$result = $this->db->update("photos_album",array("album_title" => $title, "album_desc" => $description, "album_permision" => $share ),array("user_id" => $this->usr_id, "album_id" => $albumid));
		if(count($result) > 0){
			$this->update->updates_insert($this->usr_id,$albumid,24,$title);
			return 1;
		}
		else{
			return 0;
		}
	}
	  
      //album cover
      public function album_cover($album_id, $album_cover)
      {
          $result = $this->db->query("update ".$this->prefix."photos_album set album_cover='$album_cover' where album_id='$album_id'");
          return $result;
      }
     	
      public function album_photo($album_id)
      {
          $result = $this->db->query("select photo_id from ".$this->prefix."photos where album_id='$album_id' order by photo_id DESC limit 0,1");


echo count($result);
          return $result;
      }
	  
	/** GET ALBUM PHOTO COUNT **/
	
	public function album_photo_count($album_id = "", $photo_id = "", $photo_index = "")
	{
		$result = $this->db->select("photo_id")->from("photos")
								->where(array("album_id" => $album_id))
								->orderby("photo_id","DESC")
								->limit(1,$photo_index - 1)
								->get();
		if($result->count() > 0){
			if($result->current()->photo_id == $photo_id){
				$result = $this->db->select("user_id")->from("photos")->where(array("album_id" => $album_id,"object_type" => 1));
				return $result;
			}
		}
		
		return 0;
	}
	
	/**  GET PREVIOUS AND NEXT PHOTO **/
	
	public function album_photo_pre_next($photo_index = "", $album_id = "")
	{
		$result = $this->db->select("photo_id","album_id")->from("photos")
							->where(array("album_id" => $album_id))
							->orderby("photo_id","DESC")
							->limit(1,$photo_index)
							->get();
		return $result;	
	}	  
	  
	/**  GET PHOTO FULL VIEW **/
	
	public function full_photo($album_id,$photo_id)
	{
		$result = $this->db->from("photos")
							->where(array("photo_id" => $photo_id, "album_id" => $album_id, "object_type" => 1))
							->get();
		return $result;
	}
	  
      public function get_count_fullshow($photo_id, $album_id)
      {
          $result = $this->db->query("select * from ".$this->prefix."photos where photo_id='$photo_id' AND album_id='$album_id'");
          $count_full = count($result);
          return $count_full;
      }
	  
      //photo comment
		public function photo_comment($photo_id, $photo_text, $userid)
		{
			$photo_text = html::specialchars($photo_text);
		
			if ($photo_text != "") {
				$this->db->query("update ".$this->prefix."photos set count_comment=count_comment+1 where photo_id='$photo_id'");
				$result = $this->db->query("insert into ".$this->prefix."photo_comment(photo_id,user_id,comments,photo_date) values ('$photo_id','$userid','$photo_text',sysdate())");
				$post_id = $result->insert_id();
				$result1=$this->db->query("select photo_title from ".$this->prefix."photos where photo_id='$photo_id'");
				$phototitle=htmlspecialchars_decode($result1["mysql_fetch_object"]->photo_title); 
				$this->update->updates_insert($userid,$photo_id,25,$phototitle,$post_id);
				return $result;
			}
			 else {
			}
		}
      /** GET  PHOTO COMMENT  **/
	  
      public function show_comment($photo_id = "")
      {
          $result = $this->db->query("select *,photo_date from ".$this->prefix."photo_comment left join ".$this->usertable." on ".$this->prefix."photo_comment.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id having ".$this->prefix."photo_comment.photo_id='$photo_id' ");
          return $result;
      }
             
	    /**  DELETE PHOTO **/
		
		public function delete_photo($photo_id = "" ,$albm_id = "" ,$userid = "")
		{
			$result = $this->db->delete("photos", array("photo_id" => $photo_id, "user_id" => $userid,"album_id" => $albm_id ));
			if($result->count() > 0){
				$get_photo_count = $this->db->query("SELECT id,photo_count from ".$this->prefix."updates where type_id='$albm_id' and action_id = 22");
				if(count($get_photo_count) > 0){
					$upd_id =  $get_photo_count['mysql_fetch_object']->id; 
					if($get_photo_count['mysql_fetch_object']->photo_count > 1){
						$upd_update = $this->db->query("UPDATE ".$this->prefix."updates SET photo_count = photo_count-1  WHERE id = '$upd_id' ");                		               		}
					else{
						$del_upd = $this->db->delete("updates", array("id" => $upd_id));	                
					}
				}
				$photo_cmd = $this->db->select("comment_id")->from("photos_comments")
									->where(array("type_id" => $photo_id, "user_id" => $userid))
									->get();
										
				foreach($photo_cmd as $r){ 
					common::delete_update($photo_id,25,$r->comment_id);
				} 
				$this->db->delete("photos_comments", array("type_id" => $photo_id, "user_id" => $userid));
				
				$root = DOCROOT."public/album_photo/"; 
		
				if(file_exists($root.$photo_id.".jpg")) { 
					unlink($root.$photo_id.".jpg");
				}
				if(file_exists($root."50/".$photo_id.".jpg")){
					unlink($root."50/".$photo_id.".jpg");
				}
				if(file_exists($root."normal/".$photo_id.".jpg")){
					unlink($root."normal/".$photo_id.".jpg");
				}
				
				return 1;
			}
			else{
				return 0;
			}
	
		}
	  
      //edit photo
      public function edit_photo($photo_id, $photo_title)
      {
          $photo_title = html::specialchars($photo_title);
          $result = $this->db->query("update ".$this->prefix."photos set photo_title='$photo_title' where photo_id='$photo_id'");
          return $result;
      }

	
	/**  CREATE NEW ALBUM  **/
	
	public function createalbum($userid, $title, $desc, $share)
	{
		 $unique = $this->db->count_records("photos_album", array("user_id" => $userid, "album_title" => $title));
		 if($unique == 0){
		 	if(trim($title)){
				$title = html::specialchars($title);
				$desc = html::specialchars($desc);
				$result = $this->db->query("insert into ".$this->prefix."photos_album(user_id,album_title,album_desc,album_date,album_permision) VALUES( '$userid','$title','$desc',SYSDATE(),'$share')");

				Nauth::setMessage(1,$this->create_album);
			}
			else{
				Nauth::setMessage(-1,"Invalid  Album Title");
			}
		 }
		 else{
		 	Nauth::setMessage(-1,$this->album_exist);
		 }
	}
	 
	/** COUNT PHOTOS IN PERTICULAR ALBUM **/
	 
	public function get_count_show($album_id = "" )
	{
		$result = $this->db->count_records("photos", array("album_id" => $album_id, "object_type" => 1)); 
		return $result;
	} 
	 
	/** LIST PERTICULAR ALBUM PHOTO **/
	
	public function show_photo($album_id, $offset = '', $pageno = '', $noofpage = '')
	{	  
		$album_photo = $this->db->from("photos")
								->where(array("album_id" => $album_id, "object_type" => 1 ))
								->orderby("photo_id" , "DESC")
								->limit($noofpage,$offset)
								->get();
		return $album_photo;
	}
	  
	/** CHECK ALBUM EXIST OR NOT **/
	  
	public function view_albumphoto($album_id = "")
	{ 
		$result = $this->db->from("photos_album")->where(array("album_id" => $album_id))->get();
		return $result;
	}
	  
	  /**  UPLOAD ALBUM PHOTO **/
	  
	public function insert_photo($userid = "", $album_id = "", $upload_title = "", $photo_name = "")
	{
		if($_FILES){
			$i = 0;  $img_error_type = '' ; $img_error_size = '';
			foreach( arr::rotate($_FILES['upload_photo']) as $file )
			{ 	$j = $i + 1 ; 
				if($file["type"] !== "image/jpeg"){
					$img_error_type  .=  $upload_title[$i].",";
				}
				else{
					if($file["size"] > 1048575 ){
						$img_error_size .= $upload_title[$i].",";
					}
					else { 
						$upload_title[$i] = html::specialchars($upload_title[$i]);
						$photo_name[$i] = html::specialchars($photo_name[$i]);
						$result = $this->db->query("insert into ".$this->prefix."photos(album_id,user_id,photo_title,photo_date)values('$album_id','$userid','$upload_title[$i]',sysdate())");
						if(count($result) > 0){
							$id = $result->insert_id();
							$filename = upload::save($file);
							list($width, $height) = getimagesize($filename);
							if($filename){
								$album_width = $this->thumb_size["album"]["width"];
								$album_height = $this->thumb_size["album"]["height"];
									  
								$size_adj = photo_size::size($width, $height,$album_width,$album_height);
								extract($size_adj);
								Image::factory($filename)
									->resize($width_adj,$height_adj, Image::NONE)->crop($album_width, $album_height, 'top')
									->save(DOCROOT . '/public/album_photo/50/' . $id .'.jpg');
									
								$size_adj = photo_size::size($width, $height,100,100);
								extract($size_adj);
								Image::factory($filename)
									->resize($width_adj,$height_adj, Image::NONE)->crop(100, 100, 'top')
									->save(DOCROOT . '/public/album_photo/' . $id . '.jpg');
					
					
									 $album_width = $this->photos_size["album"]["width"];
									  $album_height = $this->photos_size["album"]["height"];

									if ($width < $album_width ){
										Image::factory($filename)->save(DOCROOT . '/public/album_photo/normal/' . $id . '.jpg');
									} 
									else{
										Image::factory($filename)->resize($album_width,  $album_height, Image::WIDTH)->save(DOCROOT . '/public/album_photo/normal/' . $id . '.jpg');
									}
								unlink($filename);
								
								
							} 
						} 
					}
				}
				$i++;
			}
			
			
		}
		
		// UPDATES
	$check_upd = $this->db->query("select id from ".$this->prefix."updates where type_id = '$album_id' and action_id = '22' ");
	if(count($check_upd))
	{ 
		$check_upd_date = $this->db->query("select id from ".$this->prefix."updates where type_id = '$album_id' and action_id = '22' and trim(DATE(date)) = CURDATE() ");			
		if(count($check_upd_date))
		{
			$upd_id = $check_upd_date['mysql_fetch_object']->id; 
			$upd_update = $this->db->query("UPDATE ".$this->prefix."updates SET `photo_count` = photo_count + '$i'  , date = now() WHERE `id` = '$upd_id' ");                		               
	        }
	        else
	        {
			        $upd_id = $check_upd['mysql_fetch_object']->id; 
			        $upd_update = $this->db->query("UPDATE ".$this->prefix."updates SET `photo_count` = '$i' , date = now() WHERE `id` = '$upd_id' ");
	        }
	}
	else
	{ 
		$albm_title = $this->db->query("select album_title from ".$this->prefix."photos_album where album_id = '$album_id' ");
		$album_title = $albm_title["mysql_fetch_object"]->album_title; 
		$this->update->updates_insert($userid,$album_id,22,$album_title,'',$i);			
	} 
		
		$img_err = '';
		if($img_error_type !== ''){
			$img_err .= substr($img_error_type,0,-1)." Invalid Image Type ,";
		}
		if($img_error_size !== ''){
		
			$img_err .= substr($img_error_size,0,-1)." Image Should greater then 1MB. ";
		}
		if($img_err !== ''){
			Nauth::setMessage(-1,substr($img_err,0,-1));
		}
		else{
			Nauth::setMessage(1,$this->upload_photo);
		}

	}
 
 	 //search album
      public function search_album($key,$userid, $offset = '', $pageno = '', $noofpage = '')
      {
          //having album_permision=0
          $result = $this->db->query("select *,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id=".$this->prefix."photos_album.album_id ) as total,album_date from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' AND ".$this->prefix."photos_album.album_title like '%$key%' order by ".$this->prefix."photos_album.album_id desc   limit $offset,$noofpage");
          return $result;
      }
      public function search_album_count($key,$userid)
      {
          //having album_permision=0
          $result = $this->db->query("select *,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id=".$this->prefix."photos_album.album_id ) as total,album_date from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' AND ".$this->prefix."photos_album.album_title like '%$key%' order by ".$this->prefix."photos_album.album_id desc");
         
          return count($result);
      }
        //delete photo comment
        public function delete_photo_comment($cid,$pid)
        {
                $this->db->query("update ".$this->prefix."photos set count_comment=count_comment-1 where photo_id='$pid'");
                $result = $this->db->query( "delete from ".$this->prefix."photo_comment where comment_id='$cid' ");
                return $result;
        }
		
  }

?>
