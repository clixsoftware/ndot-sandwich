<?php
// Twitter Demo Controller V1
//      By Tom Morton [Errant]

class Ktwitter_Controller extends Controller {
    
    public $IN_PRODUCTION = False;

    public function install()
    { 
	    $page = new View('ktwitter/template');
        $page->content = new View('ktwitter/install');
        $page->render(TRUE);
    }
    
    public function index()
    { 
        $page = new View('ktwitter/template');
        $page->content = new View('ktwitter/index');
        $page->render(True);
    }    

 
}
