<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin photos
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_photos_Model extends Model
 {
      public function __construct()
      {
	parent::__construct();
	$this->db = new Database();
	//user response messages
	$mes=Kohana::config('users_config.session_message');
	$this->create_album=$mes["create_album"];
	$this->invalid_photo=$mes["invalid_photo"];
	$this->album_exist=$mes["album_exist"];
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
	$this->session=Session::instance();
	$this->docroot=$this->session->get('DOCROOT');

      }
      //display album
      public function display_album($offset = '', $pageno = '', $noofpage = '')
      {
          //having album_permision=0
          $result = $this->db->query("select *,".$this->usertable.".".$this->uidfield." as id,".$this->usertable.".".$this->unamefield." as name,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id=".$this->prefix."photos_album.album_id ) as total,DATEDIFF(now(),album_date)as DATE from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield." order by ".$this->prefix."photos_album.album_id desc   limit $offset,$noofpage");
          return $result;
      }
      public function get_count_album()
      {
          $result = $this->db->query("select * from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield." order  by ".$this->prefix."photos_album.album_id desc");
          $count_albums = count($result);
          return $count_albums;
      }
      //display  friends album
      public function friends_album($userid, $offset = '', $pageno = '', $noofpage = '')
      {
          //having album_permision=0
          $result = $this->db->query("select *,(select count(*) from ".$this->prefix."photos where ".$this->prefix."photos.album_id=".$this->prefix."photos_album.album_id ) as total,DATEDIFF(now(),album_date)as DATE from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' AND ".$this->prefix."photos_album.album_permision=0 order by ".$this->prefix."photos_album.album_id desc   limit $offset,$noofpage");
          return $result;
      }
      public function friends_count_album($userid)
      {
          $result = $this->db->query("select * from ".$this->prefix."photos_album left join ".$this->usertable." on ".$this->prefix."photos_album.user_id=".$this->usertable.".".$this->uidfield."  having ".$this->prefix."photos_album.user_id='$userid' AND ".$this->prefix."photos_album.album_permision=0  order  by ".$this->prefix."photos_album.album_id desc");
          $count_albums = count($result);
          return $count_albums;
      }
      //view album
      public function view_albumphoto($album_id = "")
      {
          $result = $this->db->query("select * from ".$this->prefix."photos_album where album_id='$album_id'");
          return $result;
      }
      public function get_view_album($album_id)
      {
          $result = $this->db->query("select * from ".$this->prefix."photos_album where album_id='$album_id'");
          $count_vp = count($result);
          return $count_vp;
      }
      public function show_photo($album_id = "", $offset = '', $pageno = '', $noofpage = '')
      {

          $result = $this->db->query("select * from ".$this->prefix."photos where album_id='$album_id' limit $offset,$noofpage");
          return $result;
      }
	  
	  /**  Count Photo Count **/
	  
		public function get_count_show($album_id = "")
		{
			$result = $this->db->count_records("photos",array("album_id" => $album_id));
			return $result;
		}
      public function delete_photocomment($comment_id)
      {
          $result = $this->db->query("delete from ".$this->prefix."photos_comments where comment_id='$comment_id'");
    	  common::delete_update('',25,$comment_id);
          return $result;
      }
      //delete album
      public function delete_album($album_id = "")
      {
          $result = $this->db->query("delete from ".$this->prefix."photos_album where album_id='$album_id'");
 		  if(count($result) > 0){
		  		common::delete_update($album_id, 22);  
				$album_photo = $this->db->select("photo_id")->from("photos")->where(array("album_id" => $album_id))->get();
				foreach($album_photo as $id){
					common::delete_update( $id->photo_id, 25 );
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
				$this->db->delete('photos', array('album_id' => $album_id));	
				return 1;
			}
			else{
				return 0;
			}

      }
      //edit album
      public function edit_album($album_id, $edit_title, $edit_description)
      {
          $edit_title = html::specialchars($edit_title);
          $edit_description = html::specialchars($edit_description);
          $result = $this->db->query("update ".$this->prefix."photos_album set album_title='$edit_title',album_desc='$edit_description' where album_id='$album_id'");
          return $result;
      }
      //album cover
      public function album_cover($album_id, $album_cover)
      {
          $result = $this->db->query("update ".$this->prefix."photos_album set album_cover='$album_cover' where album_id='$album_id'");
          return $result;
      }

      /** Upload Photo **/
	  
      public function insert_photo($userid, $album_id, $upload_title, $upload_description, $photo_name)
      {
	  	  $upload_title = html::specialchars($upload_title);
          $upload_description = html::specialchars($upload_description);
          $_FILES = Validation::factory($_FILES)->add_rules('upload_photo', 'upload::valid', 'upload::type[gif,jpg,png]', 'upload::size[1M]');
          if($_FILES->validate()) {
				$result = $this->db->query("insert into ".$this->prefix."photos(album_id,user_id,photo_title,photo_desc,photo_date)values('$album_id','$userid','$upload_title','$upload_description',sysdate())");
		 
		 	 $filename = upload::save("upload_photo");
		      if($filename) {	
			  	$id = $result->insert_id();
				list($width, $height) = getimagesize($filename);
				$size_adj = photo_size::size($width, $height,50,50);
				extract($size_adj);
				Image::factory($filename)
					->resize($width_adj,$height_adj, Image::NONE)->crop(50, 50, 'top')
					->save(DOCROOT . '/public/album_photo/50/' . $id .'.jpg');
				//	
				$size_adj = photo_size::size($width, $height,100,100);
				extract($size_adj);
				Image::factory($filename)
					->resize($width_adj,$height_adj, Image::NONE)->crop(100, 100, 'top')
					->save(DOCROOT . '/public/album_photo/' . $id . '.jpg');
	
					if ($width < 600 ){
						Image::factory($filename)->save(DOCROOT . '/public/album_photo/normal/' . $id . '.jpg');
					} 
					else{
						Image::factory($filename)->resize(600, 600, Image::WIDTH)->save(DOCROOT . '/public/album_photo/normal/' . $id . '.jpg');
					}
				unlink($filename);
			}
		}
		else{
			Nauth::setMessage(-1,$this->invalid_photo);
			url::redirect($this->docroot.'admin_photos/upload/?album_id='.$album_id );
		}
	
	}
     
      public function album_photo($album_id = "")
      {
          $result = $this->db->query("select photo_id from ".$this->prefix."photos where album_id='$album_id' order by photo_id DESC limit 0,1");
          return $result;
      }
      //full photo
      public function full_photo($photo_id, $album_id)
      {
          $result = $this->db->query("select * from ".$this->prefix."photos where photo_id='$photo_id' AND album_id='$album_id' ");
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
              $result = $this->db->query("insert into ".$this->prefix."photos_comments(type_id,user_id,comments,cdate) values ('$photo_id','$userid','$photo_text',sysdate())");
              return $result;
          } else {
          }
      }
      //show photo
      public function show_comment($photo_id)
      {
          $result = $this->db->query("select *,".$this->usertable.".".$this->unamefield." as name,DATEDIFF(now(),cdate)as DATE from ".$this->prefix."photos_comments left join ".$this->usertable." on ".$this->prefix."photos_comments.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id having ".$this->prefix."photos_comments.type_id='$photo_id' ");
          return $result;
      }
      //delete photo
      public function delete_photo($photo_id)
      {
               $get_albm_id = $this->db->query("SELECT album_id from ".$this->prefix."photos where photo_id='$photo_id'");
                $albm_id = $get_albm_id['mysql_fetch_object']->album_id;  
                $get_photo_count = $this->db->query("SELECT id,photo_count from ".$this->prefix."updates where type_id='$albm_id' and action_id =22");
                if($get_photo_count->count() > 0)
                {
                        $upd_id =  $get_photo_count['mysql_fetch_object']->id; 
                }
                else
                {
                        $upd_id = '';
                }
                if($get_photo_count->count() > 0)
                {
	                if($get_photo_count['mysql_fetch_object']->photo_count > 1)
	                {
	                     $upd_update = $this->db->query("UPDATE ".$this->prefix."updates SET `photo_count` = photo_count-1  WHERE `id` = '$upd_id' ");                		               
	                }
			else
			{
			$del_upd = $this->db->delete("updates", array("id" => $upd_id));	                
			}
		}
	                 $del_photo_cmd = $this->db->query("select comment_id from  ".$this->prefix."photos_comments where type_id='$photo_id'");
       	                
                      foreach($del_photo_cmd as $r)
       	                { 
       	                common::delete_update($photo_id,25,$r->comment_id);
       	                } 
          $result = $this->db->query("delete from ".$this->prefix."photos where photo_id='$photo_id'");
          return $result;
                   
      }
      //edit photo
      public function edit_photo($photo_id, $photo_title)
      {
          $photo_title = html::specialchars($photo_title);
          $result = $this->db->query("update ".$this->prefix."photos set photo_title='$photo_title' where photo_id='$photo_id'");
          return $result;
      }

      //create the album
      public function createalbum($userid, $title, $desc, $share)
      {
		$title = html::specialchars($title);
		$desc = html::specialchars($desc);
		$result=$this->db->query("select count(*) as total_count from ".$this->prefix."photos_album where user_id='$userid' and album_title='$title'");
	if($result["mysql_fetch_array"]->total_count==0)
	{
		if (($title != "")) 
		{
			$result = $this->db->query("insert into ".$this->prefix."photos_album(user_id,album_title,album_desc,album_date,album_permision) VALUES( '$userid','$title','$desc',SYSDATE(),'$share')");
			//set the response message
			Nauth::setMessage(1,$this->create_album);
		}
	}else 
	{
		//set the response message
		Nauth::setMessage(1,$this->album_exist);
	}

      }
	 
 }
