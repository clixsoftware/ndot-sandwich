<?php
/**
 * It cointains the user login form and third party login.
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 **/
?>
<script>
$(document).ready(function(){
$("#call_openid").click(function()
{
$("#connect_openid").toggle("slow");
}
);
});
</script>



<div class="banner_right">
<div  class="social_join" >
<div style="float:left;width:320px; margin-left:10px;">

<!-- <fb:login-button v="2" size="medium" onlogin="window.location.reload(true);">Connect</fb:login-button> -->
<a href="<?php echo $this->docroot;?>users/facebook" class="mr-3"><img src="<?php echo $this->docroot;?>public/images/facebook_top.jpg" title="facebook"  alt="facebook" /></a>
<?php
//redirecting to facebook callback url
$next=$this->input->get("next");
if(isset($next))
{
url::redirect($this->docroot."connection");
}
?>

<?php
//twitter Oauth integration
                $project = trim($_SERVER['SCRIPT_NAME'],"index.php.");
				
		include($this->file_docroot."modules/ktwitter/controllers/ktwitter/demo.php");		
		$ktwitter = new Demo_Controller();
		$ktwitter->index();

		echo $this->response_from_twitter;

		if(isset($this->twitter_username))
		{
		        $ktwitter->ndot_registration($this->twitter_username);
		}
?>

<a id="call_openid" style="cursor:pointer;"> <img src="<?php echo $this->docroot; ?>public/images/cone3.jpg" title="Connect with Openid" title="Connect with Openid"/></a>
</div>

<div id="connect_openid" style="display:none;float:left;margin-top:3px;">
<?php
//openid integration
$project = trim($_SERVER['SCRIPT_NAME'],"index.php.");
include($this->file_docroot."/modules/users/models/openid/openidvalidate.php");
?>
</div>
</div>



