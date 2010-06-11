<?
//      By Tom Morton [Errant]
class Api_Controller extends Controller {
    
    public $IN_PRODUCTION = False;

    public function index()
    {
        $page = new View('ktwitter/template');
        $page->content = new View('ktwitter/api/index');
        $page->render(True);
    }
  
    public function twitter()
    {
        $page = new View('ktwitter/template');
        $page->content = new View('ktwitter/api/twitter.lib');
        $page->render(True);
    }
  
    public function twitter_user_model()
    {
        $page = new View('ktwitter/template');
        $page->content = new View('ktwitter/api/twitter_user.model');
        $page->render(True);
    }
  

 
}