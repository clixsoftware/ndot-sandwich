<?php
// Twitter Demo Controller V1
//      By Tom Morton [Errant]
 
class Demo_Controller extends Controller {
   
    public $IN_PRODUCTION = False;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->twitter = new Twitter;
      	
        // must call this to grab the user from the session/cookie
        $this->twitter->check_login();
        
        $this->page = new View('ktwitter/template');
		
		

    }
    
    public function index()
    { 
        if($this->twitter->check_login())
        {
            // Example One: obtain the rate limit status
            // i.e. the requests you have remaining this hour
            $limits = $this->twitter->rateLimitStatus();
            
            // Example Two: get the latest status updates
            // It returns an array of Tweets
            $timeline = $this->twitter->getStatus();
            $user_name=array($this->twitter);

            $this->page->content = new View('ktwitter/demo/logged_in',array('twitter'=>$this->twitter,'limits'=>$limits,'timeline'=>$timeline));
           
           // url::redirect($this->docroot."users");
        }
        else
        { 
            // Obtain the request tokens with which to build the URL
		   
		   $this->twitter->getRequestTokens(); 
            
            // Obtain the OAuth URL to visit
            $url = $this->twitter->getAuthorizeUrl();
            
            $this->page->content = new View('ktwitter/demo/not_logged_in',array('url'=>$url));
        }
        
        $this->page->render(True);
    }

  
    public function completed()
    {
        // At this point the user has been to Twitter and granted us access
        // Twitter hands us back to this URL and we have to then make
        // some background OAuth requests to obtain the users keys
        //
        // You have to follow an sequence of API calls to achieve this
        // Rather than make it one single call I split it up so
        // It is a) easier to understand the process and b) because
        // a lot of this is "blocking" calls and so it makes it somewhat
        // easier to debug
        if($this->twitter->check_login() == False)
        {
            // This gets the tokens from the database ready to trade
            $this->twitter->sessionRequestTokens();
            
            // Now we go to Twitter direct and ask to trade the request
            // tokens for access tokens (the ones that give us Oauth
            // privileges). This uses CURL.
            $this->twitter->tradeRequestForAccess();
            
            // Tries to store the tokens in OUR db
            // Also sets a cookie to remember we did all this
            if($this->twitter->storeTokens())
            {

                // if successful we head back to further demo's :)
                url::redirect('/');
            }
            else
            {
                echo "help - a wierd error occured somewhere. Check your installation again";
            }
            
        }
        else
        {
            url::redirect('/ktwitter/demo');
        }
    }
    
    public function logout()
    {
        // check_login returns TRUE if we are logged in properly
        if($this->twitter->check_login() != False)
        {
            // Revoke the session - this means logging out
            // Note that it also removes the Oauth access keys from Twitter NOT jsut removing the cookie
            $this->twitter->revokeSession(True);
            
        }
        //url::redirect('ktwitter/demo');
        url::redirect($this->docroot.'users');
    }
       
    public function status()
    {
        // check we are logged in or bad things can happen
        if($this->twitter->check_login() == False)
        {
            url::redirect($this->docroot.'ktwitter/demo');
        }
        
        $response = False;
        // now if we are "POSTING" then we need to update status first
        if($_POST)
        {
            // setStatus does what it says on the tin (no input sanitized!!!!!)
            $response = $this->twitter->setStatus($this->input->post('status'));
            
            // manipulating the response object
            $response = $response->text;

        }
        
        // get the timeline
        $timeline = $this->twitter->getStatus();
        
        // show the page
        $this->page->content = new View('ktwitter/demo/status',array('response'=>$response,'timeline'=>$timeline));
        $this->page->render(True);
       
    }
    //login and registration via twitter to ndot open source user
    public function ndot_registration($uname='')
    {
		$this->model = new Twitter_user_Model();
		$this->result = $this->model->user_registration($uname);
    }

}
