<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_classifieds_Model extends Model
 {

     public function __construct()
	 {
		
        	parent::__construct();
		$db=new Database();
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
	public function get_allclassifieds()
	 {
		$query = "select *,datediff(now(),date) as dat from ".$this->prefix."classifieds left join ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id = ".$this->prefix."category_ads.cat_id order by date desc";
	 $result=$this->db->query($query);
	 return $result;
	 }
     	//get classifieds for pagination 
	 public function get_classifieds($offset='',$noofpage='')
	 {
	 $result=$this->db->query("select *,datediff(now(),date) as dat,(select name from ".$this->usertable." where id = ".$this->prefix."classifieds.user_id ) as username,".$this->prefix."classifieds.id as class_id from ".$this->prefix."classifieds left join ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id = ".$this->prefix."category_ads.cat_id order by date desc limit $offset,$noofpage");
	 return $result;
	 }
	//delete classifieds
	public function delete_classifieds($id)
	{
       
        $result=$this->db->query(" select cat_id from ".$this->prefix."classifieds where id='$id'");
        $catid=$result['mysql_fetch_array']->cat_id;
        $res=$this->db->query("update ".$this->prefix."category_ads set ads_count=ads_count-1 where cat_id='$catid' ");
	$res_del=$this->db->query("delete from ".$this->prefix."classifieds where id='$id'");
        common::delete_update($id , 13 );  
	return $res_del;
	}
	public function delete_category($id)
	{
	$result=$this->db->query("delete from ".$this->prefix."category_ads where cat_id='$id'");
	return $result;
	}
     //get classifieds
	 public function get_classifiedssp()
	 {
	 $result=$this->db->query("select *,datediff(now(),date) as dat from ".$this->prefix."classifieds order by id desc");
	 return $result;
	 }
	 
	 //get category
	 public function get_category()
	 {
	 $result=$this->db->query("select * from ".$this->prefix."category_ads");
	 return $result;
	 }
	public function get_country()
	{
		$select = "select * from ".$this->prefix."country";
		$result = $this->db->query($select);
		return $result;
	}	
	 public function addcat($category,$parent_id)
   	{
	$result=$this->db->query("INSERT INTO ".$this->prefix."category_ads (`category`,`parent_id`) VALUES ('$category','$parent_id')");
	return $result;
	}
	
	
	 //add classifieds
	  public function post_ads($name,$city,$country,$mobile,$type,$category,$email,$title,$desc,$price,$userid)
	{
	$result=$this->db->query(" INSERT INTO ".$this->prefix."classifieds ( `cat_id`, `name`, `title`, `desc`, `email`, `phone`, `type`, `country`, `city`, `price`, `user_id`) VALUES ( '$category', '$name', '$title', '$desc', '$email', '$mobile', '$type', '$country', '$city', '$price', '$userid')");
        $result2=$this->db->query("UPDATE ".$this->prefix."category_ads SET ads_count=ads_count+1 WHERE cat_id='$category'");
	return $result;
	}
	   //edit classifieds
	  public function  edit_classifieds($title='',$desc='',$category='',$name='',$mobile='',$email='',$price='',$country='',$id='')
	  {
		$title=html::specialchars($title);
		$name=html::specialchars($name);
		$desc=html::specialchars($desc);
	    	$result=$this->db->query("update ".$this->prefix."classifieds set title='$title',`desc`='$desc',cat_id='$category',name='$name',phone='$mobile',email='$email',price='$price',country='$country' where id='$id' ");
		
	
	     return  $result;
	  }
	
	public function editcat($category,$id)
	{ 
	$result=$this->db->query("update ".$this->prefix."category_ads set category='$category' where cat_id='$id' ");
	return  $result;	
	}	  
	public function search_classifieds_advanced($key,$offset='',$noofpage='')
	  {
	  
	  $query = "select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."classifieds.id as class_id,date as DATE,datediff(now(),date) as dat from ".$this->prefix."classifieds left join ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id = ".$this->prefix."category_ads.cat_id left join ".$this->prefix."users on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."classifieds.user_id where 1=1";
	  
	  if($key)
	  {
	        $query .= " and ".$this->prefix."classifieds.price like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."classifieds.title like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."category_ads.category like '%$key%'";
	  }
	  $query .= " limit $offset,$noofpage ";
	  $result = $this->db->query($query);
	  
		return $result;
	  }
	  
	  //count search category
	  public function get_search_count($key)
	  {
                $query = "select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."classifieds.id as class_id,date as DATE,datediff(now(),date) as dat from ".$this->prefix."classifieds left join ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id = ".$this->prefix."category_ads.cat_id left join ".$this->prefix."users on ".$this->usertable.".".$this->uidfield." = ".$this->prefix."classifieds.user_id where 1=1";  
	  if($key)
	  {
	        $query .= " and ".$this->prefix."classifieds.price like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."classifieds.title like '%$key%'";
	  }
	  if($key)
	  {
	        $query .= " OR ".$this->prefix."category_ads.category like '%$key%'";
	  }
	  $result = $this->db->query($query);
	  $count=count($result);
	  return $count;
	  }
	/*public function search_classifieds($key,$offset='',$noofpage='')
	  {
		  
	  	$query="select *,datediff(now(),date) as dat,(select name from ".$this->usertable." where id = ".$this->prefix."classifieds.user_id ) as username from ".$this->prefix."classifieds LEFT JOIN ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id=".$this->prefix."category_ads.cat_id where ".$this->prefix."classifieds.title like '%$key%' OR ".$this->prefix."classifieds.desc like '%$key%' OR ".$this->prefix."classifieds.name like '%$key%'";
    
	        $query .= "limit $offset,$noofpage ";
	        $result=$this->db->query("$query");
		return $result;
	  }
	 //count search category
	  
	  public function get_search_count($key)
	  {
		  $result =$this->db->query("select *,datediff(now(),date) as dat from ".$this->prefix."classifieds LEFT JOIN ".$this->prefix."category_ads on ".$this->prefix."classifieds.cat_id=".$this->prefix."category_ads.cat_id where ".$this->prefix."classifieds.title like '%$key%'" );
       $count=count( $result);
       return $count;
	  }*/
	  
	  public function block_unblock($status,$id)
	  {
	  		if($status != '')
			{
				$query = "update ".$this->prefix."classifieds set status = '$status' where id='$id'";
				$result = $this->db->query($query);
				return 1;
			}
			else
			{
				return -1;
			}
	  }
	  
 }
