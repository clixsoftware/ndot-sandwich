<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_videos_Model extends Model
 {

     public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
		$this->session=Session::instance();
		$this->user_id=$this->session->get('userid');
		//include Kohana::find_file('../modules/admin/views/videos/','simple_html_dom',TRUE,'php');
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
		$this->docroot=$this->session->get('DOCROOT');
		
	}
	
     //get videos
	 public function get_allvideos()
	 {
	 $result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id order by date desc");
	 return $result;
	 }
     //get videos for pagination 
	 public function get_videos($offset='',$noofpage='')
	 {
	 $result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id order by date desc limit $offset,$noofpage");
	 return $result;
	 }
//add_video
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


             $query = "select * from ".$this->prefix."video  where video_url = '$url' and user_id = '$this->user_id'" ;  
             $check_dupli = $this->db->query($query);
                if(count($check_dupli) == 0) 
                {
                        $result=$this->db->query("INSERT INTO ".$this->prefix."video ( `cat_id`,`video_title`, `video_desc`, `user_id`,`thumb_url`, `embed_code`,`video_url`) VALUES ('$category','$title', '$desc', '$this->user_id','$thumb_url', '$embedcode','$url')");
                $this->session->set('Msg',"Video Added Successfully");
                url::redirect($this->docroot.'admin_videos');
                } 
                else
                {
                $this->session->set("Emsg","Video Already Exists");
                url::redirect($this->docroot.'admin_videos');	                 
                }


     }

	   //edit video
  public function  edit_video($title,$desc,$video_id)
  { 
  	        if(empty($title) || empty($desc))
	        {
	       $this->session->set("Emsg","Title/Description Fields Empty...");
                url::redirect($this->docroot.'admin_videos/');	
	        }
     $result=$this->db->query( "UPDATE ".$this->prefix."video SET `video_title` = '$title',`video_desc`= '$desc' WHERE `video_id` =$video_id "); 
     return  $result;
  }
	  	  

	//delete video
	public function delete_video($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."video where video_id='$id'");
  	$this->db->query( "delete from ".$this->prefix."video_comments where type_id='$id' ");
  	common::delete_update($id,20);
	return $result;
	}
	
	//Block video
	public function block_video($id,$status)
	{
	$result=$this->db->query("update ".$this->prefix."video set status=$status where video_id='$id'");
	return $result;
	}
	//getting the moderator permission
	public function get_moderator_permission()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_permission where id=4");
	        return $result;
	}
		//get category
	 public function get_category()
	 {
		 $result=$this->db->query("select * from ".$this->prefix."video_category" );
		 return $result;
	 }
	 //add category
	 public function add_cat($category)
	 {
	 	 $result=$this->db->query("insert into  ".$this->prefix."video_category (`category`) values ('$category') ");
	 	 $this->session->set("Msg","Video Category has been Added Successfully");
	 	 url::redirect($this->docroot."admin_videos/category");
		 return $result;
	 } 
	 	   //edit video
          public function  edit_cat($id,$category)
          { 
  	        if(empty($category))
	        {
	       $this->session->set("Emsg","Category Field is Empty...");
                url::redirect($this->docroot.'admin_videos/category');	
	        }
             $result=$this->db->query( "UPDATE ".$this->prefix."video_category SET `category` = '$category' WHERE `cat_id` =$id "); 
             return  $result;
        }
        	//delete category
	public function delete_cat($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."video_category where cat_id='$id'");
	return $result;
	}
	  	  public function get_category_count($category)
	  {
	  	$result=$this->db->query("select * from ".$this->prefix."video LEFT JOIN ".$this->prefix."video_category on ".$this->prefix."video.cat_id = ".$this->prefix."video_category.cat_id where  ".$this->prefix."video_category.cat_id='$category' " );
		return $result;
	  }

 
	 // for search
	 public function get_allsearchvideos($search_value)
	 { 
	 $result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."video.user_id where video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%'  and status = '0' order by date desc");
		 return $result;
	 }

	 public function get_searchvideos($offset='',$noofpage='',$search_value)
	 {
		 $result=$this->db->query("select * from ".$this->prefix."video left join ".$this->prefix."video_category on ".$this->prefix."video.cat_id= ".$this->prefix."video_category.cat_id left join ".$this->usertable." on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."video.user_id where video_title like '%$search_value%' or video_desc like '%$search_value%' or category  like '%$search_value%' or name  like '%$search_value%' and status = '0' order by date desc limit $offset,$noofpage");
		 return $result;	
	 }
	

	 
 }
