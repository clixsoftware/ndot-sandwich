<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php 
class Confirm_Controller extends Website_Controller
{
	public $template = 'template/template';
	
	public function __construct()
		 {
			 parent::__construct();
			 $this->model=new Confirm_Model();
		 }
		 public function index()
		 {

		 }

		public function confirm_email($id,$subject,$message,$type,$from_id)
		{
			if($id)
			{
				if($type == 1)
				{
					$this->template->title = '';
					$this->template->send_confirm_email = $this->model->insert_mail($id,$subject,$message,$from_id);
					$this->session->set('Msg','Registration Completed');
					url::redirect($this->docroot);
				}
			}
		}
		 
 }
?>
