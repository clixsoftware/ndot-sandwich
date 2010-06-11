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
<!--
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("7ca363512e6b49f9d1b7ebee2698ecd1");
}); 
</script>
-->
<?php
// check the user whether login or not
if($this->userid == ''){
?>
<div id="header">
  <div id="head_inner">
    <div class="logo fl mt-10 "><a href="<?php echo $this->docroot; ?>profile" title="N.Social" >N.Social</a></div>
    
    <div class="login_top">
      <form action="<?php echo $this->docroot;?>users/login/?url=<?php echo $this->input->get('url'); ?>" method="post" name="form" id="form" onsubmit="return submitform();">
        <table style="float:right;"> 
          <tr>
            <td><input  name="username" id="username" type="text" value="Email id" onkeypress="javascript:valid_message(this)" onclick="cleartext()" onblur="fillmail()" class="input_bt" />
            </td>
            <td><input   type="password" name="password" id="password"   value="Password" onkeypress="javascript:valid_message1(this)" onclick="clearpass()" onblur="fillpass()" class="input_bt" />
            </td>
            <td valign="middle"><input    type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/login_button_bg.jpg"   class="login_button" />
            </td>
          </tr>
        </table>
        
        <table class="forgot" >
          <tr>
            <td  class="colorfff"    ><a href="<?php echo $this->docroot;?>users/forgot_password"  class="paddingleft40 colorfff">Forgot your password?</a></td>
            <td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php 
	}
	elseif($this->userid != '') { 
		$search = Kohana::config('application.search');
		if(in_array($this->module,$search)){
			$this->search = $this->module;
		}
		else{
			$this->search = "profile";
		}

 ?>
 <div id="header">
 <div id="head_inner">
         
         <?php if($this->userid) { ?>
         <div class="logo fl  "><a href="<?php echo $this->docroot;?>profile" title="N.Social" >N.Social</a></div>
         <?php } else { ?>
         <div class="logo fl  "><a href="<?php echo $this->docroot;?>" title="N.Social" >N.Social</a></div>
         <?php }?>
         
<div class="navi fl">
<div class="navi_left fl  mt-10">
      <div class="menu">
        <ul>
<!--          <li><a href="<?php //echo $this->docroot; ?>profile" title="Home" style="font-size:13px;">N.Social</a></li>
-->          <li><a href="<?php echo $this->docroot; ?>profile" title="Home">Home</a></li>
          <li><a href="<?php echo $this->docroot; ?>profile/view/?uid=<?php echo $this->userid;?>" title="Profile">Profile</a></li>
          <li><a href="<?php echo $this->docroot; ?>profile/friends?uid=<?php echo $this->userid;?>" title="Friends">Friends</a></li>
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
    <li><a href="javascript:;" target="_self" title="More">Account <img src="/public/themes/<?php echo $this->get_theme;?>/images/account_drop.gif" /> </a>
      <ul class="ul_ch">
                  <li><a href="<?php echo $this->docroot;?>profile/updateprofile">Edit Profile</a></li>
                  <li><a href="<?php echo $this->docroot;?>users/settings">Change Password</a></li>
                  <li><a href="<?php echo $this->docroot;?>users/changephoto">Change Photo</a></li>
                  <li><a href="<?php echo $this->docroot;?>profile/privacy_setting">Privacy Settings</a></li>
                                  <li>          <?php
	if($this->usertype==3)
	{ ?>
	<!--<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("7ca363512e6b49f9d1b7ebee2698ecd1");
}); 
</script>-->

          <li><a href="javascript:;" title="Facebook Logout" onClick="FB.Connect.logout(window.location='http://192.168.1.2:1154/users/logout');" >Logout</a></li>
          <?php }else{
		?>
          <li><a href="<?php echo $this->docroot;?>users/logout">Logout</a></li>
          <?php } ?>
   			</li>
        </ul>
           </li>

        </ul>
      </div>    
      </div>
      </div>

            <div class="top_right fr  mt-25"><form action="<?php if($this->search){ echo '/'.$this->search;}?>/commonsearch" method="get" >
              <table class="search_table" border="0" cellpadding="0"  cellspacing="0">
                <tr>
                  <td valign="top"><input type="text" name="search_value" id="search_value" value="" /></td>
                  <td><input type="image" src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/images/search.jpg" alt="search" title="search" value="Search" /></td>
                </tr>
              </table>
            </form></div>
</div>
</div>
<?php
}
?>
