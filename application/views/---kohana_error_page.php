<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $error ?></title>
<base href="http://php.net/" />
</head>
<body>
<style type="text/css">
<?php include Kohana::find_file('views', 'kohana_errors', FALSE, 'css') ?>
</style>
<center>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/" style="border:0px; text-decoration:none;">
<?php
	if($error == "Page Not Found"){
	?>
    <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/public/images/404.png" style="border:0px;" />
    <?php
	}else{
?>
    <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/public/images/500.png" style="border:0px;" />
<?php } ?>
</a><br/>
</center>


</body>
</html>
