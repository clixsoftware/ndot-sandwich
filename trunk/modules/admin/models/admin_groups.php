<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin groups
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_groups_Model extends Model
 {

    	 public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
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
	//get the groups information to edit
	public function edit_group($gid)
	{
		 $result=$this->db->query("select * from ".$this->prefix."groups where group_id='$gid'");
		 return $result;
	}
	//get the city list
	public function get_city()
	{
	        $select = "select * from ".$this->prefix."city";
		$result = $this->db->query($select);
		return $result;
	}
	
	//category list
	public function all_category()
	{
	$result=$this->db->query("select * from ".$this->prefix."group_category");
	return $result;
	}
	//update the group
	public function update_group($title,$group_image,$country,$category,$access,$website,$desc,$company,$userid,$member,$location,$gid)
	{
	$title = html::specialchars($title);
	$desc = html::specialchars($desc);
	$company = html::specialchars($company);
	$location = html::specialchars($location);
	
		$this->result=$this->db->query("update ".$this->prefix."groups set group_name='$title',group_desc='$desc',group_category='$category',group_access='$access',company_name='$company',website='$website',location='$location',group_country='$country' where group_id='$gid'");
		
		//upload the new photo

			$_FILES = Validation::factory($_FILES)
				->add_rules('group_image', 'upload::valid', 'upload::type[gif,jpg,png,jpeg]', 'upload::size[1M]');
		
			if ($_FILES->validate())
			{  

				$file_name = upload::save('group_image'); 
				$file_path=end(explode('.',$file_name)); 
				$userDoc=DOCROOT."upload/$file_name";
				//$userDoc=str_replace("/","\'",$userDoc);
				$userDoc=str_replace("'","",$userDoc);
				$group_id=$gid;
				if($file_name)
				{
			
				$this->db->query("UPDATE `".$this->prefix."groups` set group_photo='$group_id.$file_path' where group_id='$group_id'");
				Image::factory($file_name)
					->resize(58, 60, Image::WIDTH)
					->save(DOCROOT.'public/group_photo/50/'.$group_id.'.'.$file_path.'');
				//$title=html_entity_decode($title);
				Image::factory($file_name)
					->save(DOCROOT.'public/group_photo/'.$group_id.'.'.$file_path.'');
					unlink($file_name);		   
				}
			}
	}
	
	//update category
	public function update_category($category_id,$category_name='')
	{
	$category_name=html::specialchars($category_name);  	 	
	$result=$this->db->query("update ".$this->prefix."group_category set group_category_name='$category_name' where group_category_id='$category_id'");
	}
	//insert category
	public function insert_category($category_name)
	{ 
	$category_name=html::specialchars($category_name);
	$result=$this->db->query("insert into ".$this->prefix."group_category(group_category_name)values('$category_name')");
	}

	//group category list
	public function get_groups_category($offset='',$noofpage='')
	{
	$result=$this->db->query("select * from ".$this->prefix."group_category limit $offset,$noofpage");
	return $result;
	}	
	//count the group category
	public function category_count()
	{
	$result=$this->db->query("select * from ".$this->prefix."group_category");
	return count($result);
	}

	//delete category
	public function delete_category($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."group_category where group_category_id='$id'");
	
	return $result;
	}
          //get groups lists
	 public function get_search_groups_list($key='',$offset='',$noofpage='')
	 {
		$result=$this->db->query("select *,group_id,group_photo,".$this->prefix."groups.user_id,group_name,group_desc,group_access,group_category,member_count,create_date,name,user_photo,group_category_name from ".$this->prefix."groups left join ".$this->usertable." on ".$this->prefix."groups.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."group_category on ".$this->prefix."groups.group_category=".$this->prefix."group_category.group_category_id  where group_status=1 AND group_name like '%$key%' order by group_id desc limit $offset,$noofpage");
		return $result;
	 }	

	 //count the groups
	 public function get_search_groups_count($key='')
	 {
		$result=$this->db->query("select *,group_id,group_photo,".$this->prefix."groups.user_id,group_name,group_desc,group_access,group_category,member_count,create_date,name,user_photo,group_category_name from ".$this->prefix."groups left join ".$this->usertable." on ".$this->prefix."groups.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."group_category on ".$this->prefix."groups.group_category=".$this->prefix."group_category.group_category_id  where group_status=1  AND group_name like '%$key%'");
		return count($result);
	 }
	 
	
	//my groups
        public function get_groups($offset='',$noofpage='')
        {
	   $result=$this->db->query("select *,DATEDIFF(now(),create_date)AS DATE,".$this->usertable.".".$this->unamefield."
		as name from ".$this->prefix."groups LEFT JOIN ".$this->usertable." ON ".$this->prefix."groups.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id left join ".$this->prefix."group_category on ".$this->prefix."groups.group_category =".$this->prefix."group_category.group_category_id order by ".$this->prefix."groups.group_id desc limit $offset,$noofpage " );
	   return $result;
        }

        //total group count
	public function get_groups_count()
	{
	   $count =$this->db->count_records('groups');
	   return $count;
	}

	//delete groups
        public function delete_group($id)
	{
	  $this->db->query( "delete from ".$this->prefix."groups where group_id='$id'");
        }
	public function block_group($id,$opr)
	{
	  $this->db->query( "update ".$this->prefix."groups set group_status='$opr' where group_id='$id'");
        }

	 
 }
