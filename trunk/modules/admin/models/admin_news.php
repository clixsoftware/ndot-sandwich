<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_news_Model extends Model
 {

     public function __construct()
	 {
		$this->session=Session::instance();
        	parent::__construct();
         	/*User response messages*/
	         $mes=Kohana::config('users_config.session_message');
	         $this->add_news=$mes["add_news"];
                $this->upload_valid=$mes["invalid_photo"];
		$db=new Database();
		include Kohana::find_file('../application/config','database',TRUE,'php');
		$this->config = $config ['default'];
		$this->prefix = $this->config['table_prefix'];
		$this->usertable = $config['usertable'];
		
	}
	public function get_allnews()
	 {
	 $result=$this->db->query("select *,datediff(now(),news_date) as dat from ".$this->prefix."news order by news_date desc");
	 return $result;
	 }
     	//get news for pagination 
	 public function get_newsp($offset='',$noofpage='')
	 { 
	 $result=$this->db->query("select *,datediff(now(),news_date) as dat from  ".$this->prefix."news order by news_date desc limit $offset,$noofpage");
	 return $result;
	 }
	//delete news
	public function delete_news($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."news where news_id='$id'");
	return $result;
	}
	public function delete_category($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."news_category where category_id='$id'");
	return $result;
	}
     //get news
	 public function get_news()
	 {
	 $result=$this->db->query("select *,datediff(now(),news_date) as dat from ".$this->prefix."news order by news_id desc");
	 return $result;
	 }
	 
	 //get category
	 public function get_category()
	 {
	 $result=$this->db->query("select * from ".$this->prefix."news_category");
	 return $result;
	 }
	 public function addcat($category)
   	{
	$result=$this->db->query("INSERT INTO ".$this->prefix."news_category (`category_name`) VALUES ('$category')");
	}
	
	
	 //add news
	  public function addnews($title='',$desc='',$category='',$type='',$id='',$file_name='',$user_id)
	  {
		$title=html::specialchars($title);
		$desc=html::specialchars($desc);
		
	    	if(($title!="") && ($desc!=""))
		{
		       if($type=="add")
		        { 
		              if($file_name!="")
		              {			 
		                        //upload the new photo
		                        $_FILES = Validation::factory($_FILES)
			                        ->add_rules('news_image', 'upload::valid', 'upload::type[gif,jpg,png,jpeg]', 'upload::size[1M]');
		
		                                if ($_FILES->validate())
		                                {  
		                                        $filename = upload::save('news_image'); 
		                                        $file_path=end(explode('.',$filename)); 
			                                /* $userDoc=DOCROOT."upload/$filename";
			                                //$userDoc=str_replace("/","\'",$userDoc);
			                                $userDoc=str_replace("'","",$userDoc); */
			                                if($filename)
			                                {
		                                $result=$this->db->query( "insert into ".$this->prefix."news(news_title,news_desc,news_date,news_category,user_id) VALUES('$title','$desc',SYSDATE(),'$category',$user_id)"); 
		                              	Nauth::setMessage(1,$this->add_news); 
		                                $news_id=$result->insert_id();			
			                                $this->db->query("update ".$this->prefix."news set news_photo='$news_id.$file_path' where news_id='$news_id'");
			                                Image::factory($filename)
				                                ->resize(58, 60, Image::WIDTH)
				                                ->save(DOCROOT.'public/news_photo/50/'.$news_id.'.'.$file_path.'');
			                                //$title=html_entity_decode($title);
			                                Image::factory($filename)
        			                                ->resize(180, 150, Image::WIDTH)
				                                ->save(DOCROOT.'public/news_photo/'.$news_id.'.'.$file_path.'');
				                                unlink($filename);	
				                                
			                                }
		                                }
		                                else
		                                {
		                                Nauth::setMessage(-1,"$this->upload_valid");

		                                }
		                       }
		                       else
		                       { 
		                            $result=$this->db->query( "insert into ".$this->prefix."news(news_title,news_desc,news_date,news_category,user_id) VALUES('$title','$desc',SYSDATE(),'$category',$user_id)"); 
                      				Nauth::setMessage(1,$this->add_news); 
		                            return $result;
		                       }


	            	}
		        else
		        {
		           $result=$this->db->query("update ".$this->prefix."news set news_title='$title',news_desc='$desc',news_category='$category' where news_id='$id' ");
		          // $this->session->set('Msg', 'News Updated Successfully');
		        }
		
		

		
		}
	   }
	   //edit news
	  public function  editnews($title='',$desc='',$category='',$type='',$id='',$file_name='',$user_id)
	  {
		$title=html::specialchars($title);
		$desc=html::specialchars($desc);
	    	$result=$this->db->query("update ".$this->prefix."news set news_title='$title',news_desc='$desc',news_category='$category' where news_id='$id' ");

		
		//upload the new photo
		$_FILES = Validation::factory($_FILES)
			->add_rules('news_image', 'upload::valid', 'upload::type[gif,jpg,png]', 'upload::size[1M]');
		
		if ($_FILES->validate())
		{  
		        $filename = upload::save('news_image'); 
		        $file_path=end(explode('.',$filename)); 
			$userDoc=$userDoc=DOCROOT."upload/$file_name";
			//$userDoc=str_replace("/","\'",$userDoc);
			$userDoc=str_replace("'","",$userDoc);
			if($filename)
			{
			$this->db->query("update ".$this->prefix."news set news_photo='$id.$file_path' where news_id='$id'");
			Image::factory($filename)
				->resize(58, 60, Image::WIDTH)
				->save(DOCROOT.'public/news_photo/50/'.$id.'.'.$file_path.'');
			Image::factory($filename)
			         ->resize(180, 150, Image::WIDTH)				
				->save(DOCROOT.'public/news_photo/'.$id.'.'.$file_path.'');
				unlink($filename);		   
			}
		}
		else
		{
                         Nauth::setMessage(-1,"$this->upload_valid");
		}
		
	     return  $result;
	  }
	
	public function editcat($category,$id)
	{
	$result=$this->db->query("update ".$this->prefix."news_category set category_name='$category' where category_id='$id' ");
	return  $result;	
	}	  
	
	 
 }
