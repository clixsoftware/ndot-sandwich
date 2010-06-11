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
<link rel="shortcut icon" href="<?php echo $this->docroot;?>public/images/favicon.jpg" type="image/x-icon" />
<style>
body{ font-family:arial; font-size:12px; color:#333; background:none; }
.boxstyle{ padding:10px; border:1px solid #ccc; background-color:#ececec;}
.boxwhitestyle{ padding:10px; border:1px solid #ccc; background-color:#fff; }
.postbutton{ background-color:#173248; border:1px solid #ddd; padding:10px; color:#fff; font-weight:bold;}
a{ color:#2A6AA0; font-size:12px;}
h1{ margin:0px; padding:0px; font-size:20px; color:#666;}
.iu{ font-style:italic; text-decoration:underline; font-size:11px; color:#666;}
.150px{ width:100px;}
.photobox{ padding:1px; border:1px solid #bbb; width:60px;}
.date{ color:#666; font-style:italic; }
</style>
</head>
<body>
  <?php echo $content ?> </div>
</body>
</html>
