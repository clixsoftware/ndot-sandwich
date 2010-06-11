<?php defined('SYSPATH') OR die('No direct access allowed.'); 
/**
 * It cointains the facebook connection controlls
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/
?>

<?php 
class Connection_Controller extends Website_Controller
{
	public $template = 'template/template';

	         public function __construct()
		 {
			 parent::__construct();
			
                         $this->template->title="Facebook Connection";	  
		 }
		 public function index()
		 { 
                    //call the facebook activity file
                    $this->template->content=new View("/connection/facebook_connect");
                    
		 }
		 
				 
}

?>
