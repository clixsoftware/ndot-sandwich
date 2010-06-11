<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Defines all database activity for admin answers and question
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */

class Admin_answers_Model extends Model
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
		
		/*User response messages*/
  		$mes=Kohana::config('users_config.session_message');
		$this->add_category=$mes["add_category"];
		$this->category_exist=$mes["category_exist"];
	}
	
	 //get category
	 public function get_category()
	 {
	         $result=$this->db->query("select * from ".$this->prefix."category");
	         return $result;
	 }

	//manage question
	public function manage_question($offset='',$noofpage='')
	{
	        $result=$this->db->query("select ".$this->prefix."question.id,".$this->prefix."question.question,".$this->prefix."question.user_id,name,user_photo,status from ".$this->prefix."question left join ".$this->usertable." on ".$this->prefix."question.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id order by ".$this->prefix."question.id desc limit $offset,$noofpage");
	        return $result;
	}
	
	public function count_question()
	{
	        $result=$this->db->query("select ".$this->prefix."question.id,question,".$this->prefix."question.user_id,name,user_photo,status from ".$this->prefix."question  left join ".$this->usertable." on ".$this->prefix."question.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id order by ".$this->prefix."question.id desc");
	        return count($result);

	}

	//manage answers
	public function manage_answer($offset='',$noofpage='')
	{
	        $result=$this->db->query("select * from ".$this->prefix."answer left join ".$this->usertable." on ".$this->prefix."answer.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id order by answers_id desc limit $offset,$noofpage");
	        return $result;
	}
	public function count_answer()
	{
	        $result=$this->db->query("select * from ".$this->prefix."answer left join ".$this->usertable." on ".$this->prefix."answer.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."=".$this->prefix."users_profile.user_id order by answers_id desc ");
	        return count($result);

	}

	//delete question
	public function delete_question($id)
	{
	        $result=$this->db->query("delete from ".$this->prefix."question where id='$id'");
	        $res=$this->db->query("delete from ".$this->prefix."answer where id='$id'");
	        common::delete_update($id,8);
	        $res=$this->db->query("select answers_id from ".$this->prefix."answer where id='$id'");
	        foreach($res as $r)
	        {
	        $aid = $r->answer_id;
	        common::delete_update($aid,9);
	        }
	        return $result;
	}
	//delete answer
	public function delete_answer($aid,$qid)
	{
	        $result=$this->db->query("delete from ".$this->prefix."answer where answers_id='$aid'");
	        $this->db->query("update ".$this->prefix."question set answer=answer-1 where id='$qid'");
	        return $result; 
	}
	//question access
	public function set_question_access($status,$id)
	{
		$result=$this->db->query("update ".$this->prefix."question set status='$status' where id='$id'");
		return $result;
	}

	//answer access
	public function set_answer_access($status,$id)
	{
		$result=$this->db->query("update ".$this->prefix."answer set status='$status' where answers_id='$id'");
		return $result;
	}
	//category list
	public function all_category()
	{
	        $result=$this->db->query("select * from ".$this->prefix."answers_category");
	        return $result;
	}
	//update category
	public function update_category($category_id,$category_name='')
	{
	        $category_name=html::specialchars($category_name);
	        $result=$this->db->query("update ".$this->prefix."answers_category set category_name='$category_name' where category_id='$category_id'");
	}
	//insert category
	public function insert_category($category_name)
	{
	        $category_name=html::specialchars($category_name);
	        $result=$this->db->query("select count(*) as total_count from ".$this->prefix."answers_category where category_name='$category_name'");
		        if($result["mysql_fetch_array"]->total_count==0)
		        {
				        if($category_name!='')
				        {
				        $this->db->query("insert into ".$this->prefix."answers_category(category_name)values('$category_name')");
				        Nauth::setMessage(1,$this->add_category);
				        }
		        }
		        else
		        {
			        Nauth::setMessage(-1,$this->category_exist);
		        }
	}

	//blog category list
	public function get_answers_category($offset='',$noofpage='')
	{
	        $result=$this->db->query("select * from ".$this->prefix."answers_category limit $offset,$noofpage");
	        return $result;
	}	
	//count the blog category
	public function answers_category_count()
	{
	        $result=$this->db->query("select * from ".$this->prefix."answers_category");
	        return count($result);
	}

	//delete category
	public function delete_category($id)
	{
	        $result=$this->db->query("delete from ".$this->prefix."answers_category where category_id='$id'");
	
	        return $result;
	}
	//search the questions and answers
	public function search_operation($search_value='',$search_category='',$offset='',$pageno='',$noofpage='',$unanswered='')
	{
		$search_value=html::specialchars($search_value);
		$query="select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."question.id as question_id,time as cdate from ".$this->prefix."question left join ".$this->usertable." on ".$this->prefix."question.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."= ".$this->prefix."users_profile.user_id left join ".$this->prefix."answers_category on ".$this->prefix."question.category=".$this->prefix."answers_category.category_id where ";
		
		if($search_value!='' && $search_category!='')
		{
			$query.="( ".$this->prefix."question.question  like '%$search_value%' OR ".$this->prefix."question.category='$search_category' )";
		}
		else if($search_value!='')
		{
			$query.="".$this->prefix."question.question  like '%$search_value%' ";
		}
		else if($search_category!='')
		{
			$query.=$this->prefix."question.category='$search_category' ";
		}
		else
		{
			$query.="1=1";
		}
		
		//checking unanswered question...
		if($unanswered=="on")
		{
			$query.=" AND ".$this->prefix."question.answer=0";
		}
			$query.=" limit $offset,$noofpage";
			
		
		$result=$this->db->query($query);
		return $result;
		
	}
	
	//count the search results

	public function get_search_operation_count($search_value='',$search_category='',$unanswered='')
	{
		$search_value=html::specialchars($search_value);
		$query="select *,".$this->usertable.".".$this->unamefield." as username,".$this->prefix."question.id as question_id,time as cdate from ".$this->prefix."question left join ".$this->usertable." on ".$this->prefix."question.user_id=".$this->usertable.".".$this->uidfield." left join ".$this->prefix."users_profile on ".$this->usertable.".".$this->uidfield."= ".$this->prefix."users_profile.user_id left join ".$this->prefix."answers_category on ".$this->prefix."question.category=".$this->prefix."answers_category.category_id where  ";
		
		if($search_value!='' && $search_category!='')
		{
			$query.="(".$this->prefix."question.question  like '%$search_value%' OR ".$this->prefix."question.category='$search_category' )";
		}
		else if($search_value!='')
		{
			$query.="".$this->prefix."question.question  like '%$search_value%' ";
		}
		else if($search_category!='')
		{
			$query.="".$this->prefix."question.category='$search_category' ";
		}
		else
		{ 
			$query.="1=1";
		}
		//checking unanswered question...
		if($unanswered=="on")
		{       
			$query.=" AND ".$this->prefix."question.answer=0";
		}
	
			$result=$this->db->query($query);
			return count($result);
	}
 }?>
