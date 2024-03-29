<?php defined('SYSPATH') or die('No direct script access.');
class Welcome_Controller extends Website_Controller 
{	
	const ALLOW_PRODUCTION = FALSE;
	public $template = 'template/template';
	public function __construct()
	{
		parent::__construct();
		$session = Session::instance();
		if($session->get('userid')){
			url::redirect($this->docroot."profile");
		}
		$this->get_city = $this->model->get_city();
		$this->module = "welcome";
	}
	
	public function index()
	{ 	
		$this->template->content = new View('home');
		$this->template->title = Kohana::config("application.strings.hometitle");
	}
	
	public function __call($method, $arguments)
	{
		$this->auto_render = TRUE;
		echo 'This text is generated by __call. If you expected the index page, you need to use: welcome/index/'.substr(Router::$current_uri, 8);
	}
}