<?php defined('SYSPATH') OR die('No direct access allowed.'); 
/**
 * Includes the header before login and after login design.,
 *
 * @package    Ndot Open Source
 * @author     Madhiyalagan
 * @copyright  (c) 2010 Ndot.in
 *
 */
?>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("7ca363512e6b49f9d1b7ebee2698ecd1");
}); 
</script>

<script>
function valid_message(id)
{
	var email = id.value;
	if(isValidEmailAddress(email))
		{
			document.getElementById('username').style.background = '#BBFFBB';
		}
		else
		{
			document.getElementById('username').style.background = '#FF9779';
			return false;
		}
}

function valid_message1(id)
{
	var pass = id.value;
	if(pass!= '')
		{
			document.getElementById('password').style.background = '#BBFFBB';
		}
		else
		{
			document.getElementById('password').style.background = '#FF9779';
			return false;
		}
}
</script>


<div id="header"  >
<div id="head_inner">

<div id="logo"><a href="<?php echo $this->docroot;?>" >N.Social</a></div> 

<?php
// check the user whether login or not
if($this->userid == '')
{
?>
	 <div class="login_top">
	<form action="<?php echo $this->docroot;?>users/login/?url=<?php echo $this->input->get('url'); ?>" method="post" name="form" id="form" onsubmit="return submitform();">
	 
	<table >
	<tr>
	<td>
	  <input  name="username" id="username" type="text" value="Email id" onkeypress="javascript:valid_message(this)" onclick="cleartext()" onblur="fillmail()" class="input_bt" />  </td><td>
	 <input   type="password" name="password" id="password"   value="Password" onkeypress="javascript:valid_message1(this)" onclick="clearpass()" onblur="fillpass()" class="input_bt" /> </td>
	   
	<td><input    type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/login_button_bg.jpg"   class="login_button" /> </td>
	 </tr></table>

	<table class="forgot" >
	<tr>
	<td  class="colorfff"    >
	 <input   type="checkbox"  name="Remember Me" /> Remember Me </td>
	 <td>
	 
	 <a href="<?php echo $this->docroot;?>users/forgot_password"  class="paddingleft40 colorfff">Forgot your password?</a></td><td>
	  
	</tr></table>
	  </form>
	 </div>

 <?php }elseif($this->userid != '')
 { ?>
		<div class="menu">
		<ul>
		<li><a href="<?php echo $this->docroot; ?>profile/" title="Home">Home</a></li>
		<li><a href="<?php echo $this->docroot; ?>profile/myprofile" title="Profile">Profile</a></li>
		<li><a href="<?php echo $this->docroot; ?>profile/friends" title="Friends">Friends</a></li>		
		<li><a href="<?php echo $this->docroot; ?>inbox" title="Inbox">Inbox</a></li>
		<li><a href="<?php echo $this->docroot; ?>answers" title="Answers">Answers</a></li>
		<li class="li_hc"><a href="javascript:;" target="_self" title="More">More</a>
			<!-- sub menu -->
			 <ul class="ul_ch">
			 	<li><a href="<?php echo $this->docroot; ?>groups" title="Groups">Groups</a></li>
				<li><a href="<?php echo $this->docroot; ?>news" title="News">News</a></li>
				<li><a href="<?php echo $this->docroot; ?>events" title="Events">Events</a></li>
				<li><a href="<?php echo $this->docroot; ?>classifieds" title="Classifieds">Classifieds</a></li>
				<li><a href="<?php echo $this->docroot; ?>video" title="Videos">Videos</a></li>
				<li><a href="<?php echo $this->docroot; ?>blog" title="Blogs">Blogs</a></li>
				<li><a href="<?php echo $this->docroot; ?>photos" title="Phots">Photos</a></li>
				<li><a href="<?php echo $this->docroot; ?>forum" title="Forums">Forums</a></li>
			</ul>

      		</li>

		</ul>
        
	</div>
    
	<div class="login_top">
	<ul>
	<?php

	 if($this->usertype==-1 || $this->usertype==-2) { ?>
	<li><a href="<?php echo $this->docroot;?>admin">Admin </a></li> <?php } else { ?>

	<li><a href="<?php echo $this->docroot;?>profile/"><?php echo $this->username;?></a></li>
	<?php } ?>

	<li><a href="<?php echo $this->docroot;?>users/settings">Settings</a></li>
	<?php
	if($this->usertype==3)
	{ ?>
	<li><a href="javascript:;" title="Facebook Logout" onClick="FB.Connect.logout(window.location='http://192.168.1.2:1111/users/logout');" >Logout</a></li>
	<?php 
	}
	else
	{
	?>
	<li><a href="<?php echo $this->docroot;?>users/logout">Logout</a></li>
	<?php 
	}
	?>

	</ul>

	<form action="<?php if($this->module){ echo '/'.$this->module;}?>/commansearch" method="get" >
	<table class="search_table" border="0" >
	<tr><td valign="top"><input type="text" name="search_value" id="search_value" value="" /></td>
	<td  valign="top"><input type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/search.jpg" alt="search" title="search" value="Search" class="h_search"/></td> </tr>
	</table>
	</form>
	</div>
<?php


}
?>

 
</div>

</div>
