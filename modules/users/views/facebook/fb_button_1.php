<?php 

$ss=$_SERVER["HTTP_USER_AGENT"];
//echo $ss; exit;
if(stristr($ss,"MSIE")) { ?>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("1943811d592d70875f783fdf2286f413");
}); 
</script>

<?php } else { ?>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("1943811d592d70875f783fdf2286f413","/users/facebook_receiver");
}); 
</script>
<?php } ?>		


<?php if($this->userid=="") { ?>
<script>window.location='http://<?php echo $_SERVER['HTTP_HOST']; ?>/users/facebook_receiver'</script>
<div id="FB_HiddenContainer"  style="position:absolute; top:-10000px; width:0px; height:0px;" ></div>
<?php } else { ?>
<a href="#" title="Facebook Logout" onClick="FB.Connect.logoutAndRedirect('http://<?php echo $_SERVER['HTTP_HOST']; ?>/users/logout'); return false;" >
<img id="fb_logout_image"  src="/images/logout_small.gif" alt="Connect logout" /></a>
<?php } ?>

