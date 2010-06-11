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

<div id="container_main">
<?php
// check the user whether login or not
if($this->userid == ''){
?>
<div id="header">
<div id="header_left"> </div>
  <div id="head_inner">
    <div class="logo fl"> <a href="<?php echo $this->docroot; ?>" title="N.Social" ><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/logo.jpg" /></a> </div>
    <div class="login_top">
      <form action="<?php echo $this->docroot;?>users/login/?url=<?php echo $this->input->get('url'); ?>" method="post" name="form" id="form" onsubmit="return submitform();">
        <table style="float:right;" cellpadding="0" cellspacing="0">
          <tr>
            <td><input  name="username" id="username" type="text" value="Email" onkeypress="javascript:valid_message(this)" onclick="cleartext()" onblur="fillmail()" class="input_bt" />
              &nbsp;&nbsp;&nbsp; </td>
            <td><input   type="password" name="password" id="password"   value="Password" onkeypress="javascript:valid_message1(this)" onclick="clearpass()" onblur="fillpass()" maxlength="16" class="input_bt" />
              &nbsp;&nbsp;&nbsp; </td>
            <td valign="middle"><input    type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/login_button_bg.jpg"   class="login_button" />
            </td>
          </tr>
          <tr>
            <td align="right" colspan="3"><a href="<?php echo $this->docroot;?>users/forgot_password"  class="colorfff" >Forgot your password?</a> </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <div id="header_right"></div>
</div>
<?php 
	}
	elseif($this->userid != '') { 
		$search = Kohana::config('application.search');
		if(in_array($this->module,$search)){
			$this->search = $this->module;
		}
		else{
		        
			$this->search = $_SERVER['REQUEST_URI'];
		}

 ?>
<div id="header"><div id="header_left"> </div>
  <div id="head_inner">
    <div class="logo fl "> <a href="<?php echo $this->docroot; ?>" title="N.Social" ><img src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/logo.jpg" /></a> </div>
    <div class="navi fl">
      <div class="navi_left fl  mt-10">
        <div class="menu">
          <ul>
            <li><a href="<?php echo $this->docroot; ?>profile" title="Home">Home</a></li>
            <li><a href="<?php echo $this->docroot; ?>profile/view/?uid=<?php echo $this->userid;?>" title="Profile">Profile</a></li>
            <li><a href="<?php echo $this->docroot; ?>profile/friends?uid=<?php echo $this->userid;?>" title="Friends">Friends</a></li>
             <li><a href="<?php echo $this->docroot; ?>notifications.html" title="notifications">Notifications</a></li>
          </ul>
        </div>
      </div>
      <div class="navi_right fl mt-10">
        <div class="menu" style="float:right;">
          <ul>
            <?php
	 if($this->usertype==-1 || $this->usertype==-2) { ?>
            <li><a href="<?php echo $this->docroot;?>admin">Admin </a></li>
            <?php } else { ?>
            <?php } ?>
            <li>
            <a href="javascript:;" target="_self" title="More">Account <img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/account_drop.gif" /> </a>
            <ul class="ul_ch">
              <li><a href="<?php echo $this->docroot;?>profile/updateprofile">Edit Profile</a></li>
              <li><a href="<?php echo $this->docroot;?>users/settings">Change Password</a></li>
              <li><a href="<?php echo $this->docroot;?>users/changephoto">Change Photo</a></li>
              <li><a href="<?php echo $this->docroot;?>profile/privacy_setting">Privacy Settings</a></li>
              <li><a href="<?php echo $this->docroot;?>users/logout">Logout</a></li>

            </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="top_right fr  mt-25">
      <form action="<?php echo substr($this->docroot,0,-1); ?><?php if($this->search){ echo '/'.$this->search;}?>/commonsearch" method="get" >
        <table class="search_table" border="0" cellpadding="0"  cellspacing="0">
          <tr>
            <td valign="top"><input type="text" name="search_value" id="search_value" value="" /></td>
            <td><input type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/search.jpg" alt="search" title="search" value="Search" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
    <div id="header_right"></div>
    </div>
    
</div>
<?php
}
?>
