<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_cms_Model extends Model
 {

     public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
		$this->session=Session::instance();
		$this->docroot=$this->session->get('DOCROOT');
		/*User response messages*/
	         $mes=Kohana::config('users_config.session_message');
		 $this->delete_page=$mes["delete_page"];
		 $this->create_page=$mes["create_page"];
		 $this->edit_page=$mes["edit_page"];
 	         $this->exists_page=$mes["exists_page"];
        	$this->user_id=$this->session->get('userid');           
		include Kohana::find_file('../modules/admin/views/videos/','simple_html_dom',TRUE,'php');
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
		
	}
	
  
        //Get all pages
	public function get_pages($offset='',$noofpage='')
	{
	$result=$this->db->query("select * from ".$this->prefix."cms limit $offset,$noofpage");
	return $result;
	}
	
	//Count pages
	public function count_pages($cms_id='')
	{
                if($cms_id=='')
                { 
                        $result=$this->db->query("select * from ".$this->prefix."cms");
                        return $result;
                }
                else
                { 
                        $result=$this->db->query("select * from ".$this->prefix."cms where cms_id='$cms_id' ");
                        return $result;
                }
	}
	//create pages
        public function  create_pages($title,$desc,$meta,$cms_id,$meta_desc)
        { 
                $res=$this->db->query("select cms_title from ".$this->prefix."cms where cms_title='$title' ");
                if(count($res))
                { 
                        Nauth::setMessage(-1,$this->exists_page);
                        url::redirect($this->docroot.'admin_cms/create_pages');
                
                }
                else
                {
                $result=$this->db->query( "INSERT INTO ".$this->prefix."cms (`cms_title`, `cms_desc`, `cms_metatag`,`cms_metadesc`) VALUES ('$title', '$desc', '$meta','$meta_desc');"); 
                Nauth::setMessage(1,$this->create_page);
                url::redirect($this->docroot.'admin_cms');
                return  $result;
                }

        }
	//edit pages
        public function  edit_pages($title,$desc,$meta,$cms_id,$meta_desc)
        { 
                $result=$this->db->query( "UPDATE ".$this->prefix."cms SET `cms_title` = '$title',`cms_desc`= '$desc',`cms_metatag` = '$meta',`cms_metadesc`='$meta_desc' WHERE `cms_id` =$cms_id "); 
                return  $result;
        }
        //delete pages
	public function delete_page($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."cms where cms_id='$id'");
	return $result;
	}
		
	//getting the moderator permission
	public function get_moderator_permission()
	{
	        $result=$this->db->query("select * from ".$this->prefix."members_permission where id=4");
	        return $result;
	}
	
	


	 
 }



