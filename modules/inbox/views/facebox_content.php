<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
echo '<style>', "\n"; 
//include Kohana::find_file('../public/css/', 'inbox', TRUE, 'css'); 
include Kohana::find_file($this->docroot.'/public/css/', 'facebox', TRUE, 'css'); 
//include Kohana::find_file('../public/css/', 'inboxcontent', TRUE, 'css'); 
echo '</style>';

?>

<script src="<?php echo $this->docroot;?>/public/js/jquery.js"></script>
<!--<link href="<?php echo $this->docroot;?>facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="/public/js/facebox.js"></script>-->
<script>
$(document).ready(function($) {
$('a[rel*=facebox]').facebox()
}) 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Chandru</h1>
<a href="<?php echo $this->docroot;?>public/images/closelabel.gif" rel="facebox[.bolder]">Image</a><br />
<a href="#loginpage" rel="facebox[.bolder]" >Login</a><br />
<a href="facebox.html" rel="facebox" >External html files</a><br />	
<div id="loginpage" style="display:none;">
<form action="<?php echo $this->docroot;?>inbox/inbox/inboxshow" method="post">
User name:<input type="text" value="" /><br /><br />
Pass word:<input type="password"  value="" /> <br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Login" />
<input type="reset" value="reset" />
</form>
</div>
</body>
</html>
