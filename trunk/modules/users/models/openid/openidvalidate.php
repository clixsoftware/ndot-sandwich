<?php
$domain_name=$_SERVER["HTTP_HOST"];

if(isset($_SESSION['login']) && $_SESSION['login']){
	header("Location:/");
	exit;
}
?>

<form name="openid_form" id="openid_form" action="" method="post">
<label>
URL:<input type="text" name="openid_identifier" id="openid_identifier" maxlength="320" />
</label>
<input type="hidden" name="process" value="1" />
<button type="submit" >Sign In</button>
</form>
<?php

/*
* If $_POST['process'] is set, begin OpenID login form processing.
*/
if(isset($_POST['process'])){ 
	/*
	* Include the Dope OpenID class file.
	*/
	require 'class.dopeopenid.php';
	
	/*
	* URL input is expected here.
	*/
	$openid_url = trim($_POST['openid_identifier']);
	
	/*
	* If running PHP 5, use the built-in URL validator.
	* Else use something like the following regex to validate input.
	*/
	if(function_exists('filter_input')) {
		if( ! filter_input(INPUT_POST, "openid_identifier", FILTER_VALIDATE_URL)) {
			$error = "Error: OpenID Identifier is not in proper format.";
		}
	}
	else 
	{
		// Found this on Google. Seems to match most valid URLs. Feel free to modify or replace.
		if( ! eregi("^((https?)://)?(((www\.)?[^ ]+\.[com|org|net|edu|gov|us]))([^ ]+)?$",$openid_url)) {
			$error = "Error: OpenID Identifier is not in proper format.";
		}
	}
	
	// Proceed if we made it through without setting $error
	if ( ! isset($error)) { 
		/*
		* Store the user's submitted OpenID Identity for later use.
		*/
		$_SESSION['openid_url'] = $openid_url;

		/*
		* Create a new Dope_OpenID object
		*/
		$openid = new Dope_OpenID($openid_url);
		/*
		* YOU MUST EDIT THIS LINE.
		* The user's OpenID provider will return them to the URL that you provide here.
		* It could be a separate verify.php script, or just pass a parameter to tell a
		* single processing script what to do (like I've done with this file you're reading).
		*/
		//$openid->setReturnURL("http://www.stevelove.org/projects/dope-openid/demo/login.php?action=verify");
		
		$openid->setReturnURL("http://$domain_name/users?action=verify");
		
		/*
		* YOU MUST EDIT THIS LINE
		* Set the trust root. This is the URL or set of URLs the user will be asked
		* to trust when signing in with their OpenID Provider. It could be your base
		* URL or a subdirectory thereof. Up to you.
		*/
		//$openid->SetTrustRoot('http://www.stevelove.org/projects/dope-openid/demo/');
		$openid->SetTrustRoot("http://$domain_name/users");
		/*
		* EDIT THIS LINE (OPTIONAL)
		* When the user signs in with their OpenID Provider, these are
		* the details you would like sent back for your own use.
		* Dope OpenID attempts to get this information using both Simple Registration
		* and Attribute Exchange protocols. The type that is returned depends on the
		* user's Provider. Each provider chooses what they wish to provide and all 
		* defined attributes may not be available. To see where these two types of
		*  attributes intersect, see the following: http://www.axschema.org/types/
		*/
		$openid->setOptionalInfo(array('dob','fullname','country','language','email'));
		
		/*
		* EDIT THIS LINE (OPTIONAL)
		* This is the same as above, except much stricter. By using this method, you
		* are telling the OpenID Provider you *must* have this information. If the Provider
		* will not give you the information the transaction should logically fail, either 
		* at the Provider's end or yours. No info, no sign in. Uncomment to use it.
		*/
		//$openid->setRequiredInfo(array('dob','nickname','country','language','email'));
		
		/*
		* EDIT THIS LINE (OPTIONAL)
		* PAPE Policies help protect users and you against phishing and other authentication
		* forgeries. It's an optional extension, so not all OpenID Providers will be using it.
		* Uncomment to use it.
		* More info and possible policy values here: http://openid.net/specs/openid-provider-authentication-policy-extension-1_0-01.html
		*/
		//$openid->setPapePolicies('http://schemas.openid.net/pape/policies/2007/06/phishing-resistant ');
		
		/*
		* EDIT THIS LINE (OPTIONAL)
		* Also part of the PAPE extension, you can set a time limit for users to
		* authenticate themselves with their OpenID Provider. If it takes too long,
		* authentication will fail and the user will not be allowed access to your site.
		* Uncomment and set a value in seconds to use.
		*/
		//$openid->setPapeMaxAuthAge(120);
		
		/*
		* Attempt to discover the user's OpenID provider endpoint
		*/ 
		$endpoint_url = $openid->getOpenIDEndpoint();
		if($endpoint_url){
			// If we find the endpoint, you might want to store it for later use.
			$_SESSION['openid_endpoint_url'] = $endpoint_url;
			// Redirect the user to their OpenID Provider
			$openid->redirect();
			// Call exit so the script stops executing while we wait to redirect.
			exit;
		}
		else{
			/*
			* Else we couldn't find an OpenID Provider endpoint for the user.
			* You can report this error any way you like, but just for demonstration
			* purposes we'll get the error as reported by Dope OpenID. It will be
			* displayed farther down in this file with the HTML.
			*/
			$the_error = $openid->getError();
			$error = "Error Code: {$the_error['code']}<br />";
			$error .= "Error Description: {$the_error['description']}<br />";
		}
	}	
}


/*
* Begin the verification process.
* Note: This is the script that should execute at your return URL, 
* in case you choose to put it in a separate file.
*/
if(isset($_GET['action']) && $_GET['action']=="verify" && $_GET['openid_mode'] != "cancel"){ 
	/*
	* Include the Dope OpenID class file
	*/
	require_once 'class.dopeopenid.php';
	
	
	// Get the user's OpenID Identity as returned to us from the OpenID Provider
	$openid_url = $_GET['openid_identity'];
	
	/*
	* Create a new Dope_OpenID object.
	*/
	$openid = new Dope_OpenID($openid_url);
	
	/*
	* All the data we received from the OpenID Provider must now be sent back
	* to validate it and verify that nothing has been tampered with in the process.
	*/
	$validate_result = $openid->validateWithServer();
	$this->model=new Connection_Model();
	
	if ($validate_result === TRUE) {
		/*
		* If validation is successful, your next step is to
		* see if the user already exists in your database. Specifically, you
		* need your own function to check for a user_id where openid_url = $openid_url
		*/
                
                $user_id=$this->model->get_openid_user($openid_url);
                $userinfo = $openid->filterUserInfo($_GET);
		
			
                        $username = $userinfo['fullname'];
			$email= $userinfo['email'];
			$openid_url = $openid_url;
			$this->model->openid_registration($username,$email,$openid_url);

		//$user_id = popdup_get_user_function($openid_url);
             
		
		/*
		* If you get a user ID back from your function, this user is a member of
		* your website and is all set up to log in with OpenID. You should now
		* call your own function that logs in the user on your site.
		*/

		
	}
	else if ($openid->isError() === TRUE){
		/*
		* Else if you're here, there was some sort of error during processing.
		*/		
		$the_error = $openid->getError();
		$error = "Error Code: {$the_error['code']}<br />";
		$error .= "Error Description: {$the_error['description']}<br />";
	}
	else{
		/*
		* Else validation with the server failed for some reason.
		*/
		$error = "Error: Could not validate the OpenID at {$_SESSION['openid_url']}";
	}	
}
/*
* The user canceled the process at some point. Nothing to do here except let them know.
*/
else if (isset($_GET['openid_mode']) && $_GET['openid_mode'] == "cancel") { 
	$error = "OpenID authorization canceled by user.";
}

/*
* Begin HTML display of login form and any errors that might have occurred.
*/
?>
