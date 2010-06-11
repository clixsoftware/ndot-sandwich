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
    
    //generate unique mate tags for all pages
    $generate_meta_key = $project_title.',';
    if($this->template->title)
    {
        $key_val = explode(' ',$this->template->title);
        foreach($key_val as $m_key)
        {
               if(strlen($m_key)>4) 
               {
                  $generate_meta_key .= $m_key.",";
               }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="description" content="<?php echo $project_title.' '.$meta_desc.'.'.$this->template->title.'.';?>" />
<meta name="keywords" content="<?php echo $generate_meta_key.' '.$meta_keywords;?>" />
<link rel="shortcut icon" href="<?php echo $this->docroot;?>public/images/favicon.jpg" type="image/x-icon" />
<title>
<?php if($title!='') { echo $project_title." - ".html::specialchars($title); } else { echo $project_title;} ?>
</title>
<link href="<?php echo $this->docroot;?>public/css/layout/screen.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/css/jquery_validation_include_css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->docroot;?>public/js/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->docroot;?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/ui.datepicker.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/login_validation.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/facebox/facebox.js" type="text/javascript"></script>
<script src="<?php echo $this->docroot;?>public/js/validation.js" type="text/javascript"></script>
 

</head>
<body>
<?php require_once("$this->get_theme/header.php");?>
<div class="container">
  <script type="text/javascript">
   $(document).ready(function () {
		if($('#messagedisplay')){
		  $('#messagedisplay').animate({opacity: 1.0}, 5000)
		  $('#messagedisplay').fadeOut('slow');
		}
		//error message
		if($('#error_messagedisplay')){
			$('#error_messagedisplay').animate({opacity: 1.0}, 5000)
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
      <div id="messagedisplay" class="span-16 success" style="margin-top:-20px; height:35px; float:none;">
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
    <div id="error_messagedisplay" class="span-16 error" style="margin-top:-10px; height:35px; float:none;">
      <div class="span-1  text_center"><img src="<?php echo $this->docroot;?>public/themes/<?php echo $this->get_theme;?>/images/failure.jpg" /> </div>
      <div class="span-14">Sorry!<br/>
        <?php echo $this->error_response; ?> </div>
    </div>
  </center>
  </div>
  <?php 
	  }
	?>

  <?php echo $content ?> 
  </div>
<?php require_once("$this->get_theme/footer.php");?>

</body>
</html>
