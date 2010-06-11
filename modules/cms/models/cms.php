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
	class Cms_Model extends Model
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
			$this->update=new update_model_Model();
			$db=new Database();
			$this->docroot=$this->session->get('DOCROOT');
			
		}

	
	//get pages content
	public function get_page($title)
	{
	$result=$this->db->query("select * from ".$this->prefix."cms where cms_title='$title'");
	return $result;
	}
	//search pages content
	public function get_text($text)
	{
	$result=$this->db->query("select * from ".$this->prefix."cms where cms_title='%$text%' or cms_desc='%$text%'");
	return $result;
	}
}
?>
