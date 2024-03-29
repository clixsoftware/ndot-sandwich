<?php defined('SYSPATH') OR die('No direct access allowed.'); 
/**
 * Includes the header,center,footer and all css files contents. It contains response message also..,
 *
 * @package    Ndot Open Source
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 *
 */

    $project_title = $this->general_setting_info["title"];
    $meta_keywords = $this->general_setting_info["meta_keywords"];
    $meta_desc = $this->general_setting_info["meta_desc"];
    $logo_path = $this->general_setting_info["logo_path"];
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="description" content="<?php echo $meta_desc;?>" />
<meta name="keywords" content="<?php echo $meta_keywords;?>" />
<link rel="shortcut icon" href="<?php echo $this->docroot;?>public/images/favicon.jpg" type="image/x-icon" />
<title>
<?php if($title!='') { echo html::specialchars($title); } else { echo $project_title;} ?>
</title>
<link href="<?php echo $this->docroot;?>public/css/layout/screen.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/jquery_validation_include_css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/home.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/events.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/js/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/ui.datepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/login_validation.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/js/facebox/facebox.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/validation.js" type="text/javascript"></script>
</head>
<body>
<?php //require_once("header.php");?>
<div class="container">
  <script>
	$(document).ready(function () {
		if($('#messagedisplay')){
		  $('#messagedisplay').animate({opacity: 1.0}, 10000)
		  $('#messagedisplay').fadeOut('slow');
		}
		//error message
		if($('#error_messagedisplay')){
			$('#error_messagedisplay').animate({opacity: 1.0}, 10000)
			$('#error_messagedisplay').fadeOut('slow');
		}
		});
	</script>
  <?php 
	//show the response message
	  if(!empty($this->response))
	  { ?>
  <div class="span-24">
    <center>
      <div id="messagedisplay" class="span-16 success" style="margin-top:-30px; height:35px; float:none;">
        <div class="span-1  text_center"><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/success.jpg" /> </div>
        <div class="span-14">Success!<br/>
          <?php echo $this->response; ?></div>
      </div>
    </center>
  </div>
  <?php 
	  }
	?>
  <?php 
	//show the error response message
	  if(!empty($this->error_response))
	  { ?>
  <div class="span-24">
 <center>
    <div id="error_messagedisplay" class="span-16 error" style="margin-top:-30px; height:35px; float:none;">
      <div class="span-1  text_center"><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/failure.jpg" /> </div>
      <div class="span-14">Sorry!<br/>
        <?php echo $this->error_response; ?> </div>
    </div>
  </center>
  </div>
  <?php 
	  }
	?>
  <?php 
  	//$this->notice = " Sample Notice";
	//show the error response message
	  if(!empty($this->notice))
	  { ?>
  <div class="span-24">
  <center>
    <div id="notice_messagedisplay" class="span-16 notice" style="margin-top:-30px; height:35px; float:none;">
      <div class="span-1  text_center"><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/notice.jpg" /> </div>
      <div class="span-14">Notice!<br/>
        <?php echo $this->notice; ?> </div>
    </div>
  </center>
  <?php 
	  }
	?>	
  <?php echo $content ?> </div>
<?php //require_once("footer.php");?>
</body>
</html>
