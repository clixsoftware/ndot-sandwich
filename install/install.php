<?php
$d = trim($_SERVER['SCRIPT_FILENAME'],"install.php"); 
if(file_exists($d.'application/config/database.php'))
{ 
	include_once '../application/config/database.php';
	$prefix=$config['default']['table_prefix'];
	$host=$config['default']['connection']['host'];
	$user=$config['default']['connection']['user'];
	$pass=$config['default']['connection']['pass'];
	$db=$config['default']['connection']['database'];
	$link = mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error());
	$tablename= $prefix.'general_settings';
	////////
	/*function table_exists ($table, $db) 
	{ 
		$tables = mysql_list_tables ($db); 
		while (list ($temp) = mysql_fetch_array ($tables)) 
		{
			if ($temp == $table) 
			{
				return TRUE;
			}
		}
		return FALSE;
	}*/
	////
	
	$tables = mysql_list_tables($db);
	$num_tables = @mysql_numrows($tables);
	$i = 0;
	$exist = 0;
	while($i < $num_tables)
	{
	$tablename = mysql_tablename($tables, $i);
	if ($tablename=='table_search') $exist=1;
	$i++;
	}
	if ($exist==0)
	{
		//if the table does not exist
		$e=$_SERVER['REQUEST_URI'];
		$e = trim($e,"install.php.");
		header("Location: $e");
	} 
	else 
	{
	//the table exist
		$docroot=$_SERVER['REQUEST_URI'].'process.php';
		?>
		<script type="text/javascript">
		window.location = "<?php echo $docroot; ?>";
		</script>
		<?php
		exit;
	}
	mysql_close($connect);
	 
	/*if (table_exists($tablename, $db)) 
	{ 
		$e=$_SERVER['REQUEST_URI'];
		$e = trim($e,"install.php.");
		header("Location: $e");
	}
	else
	{ 
		echo $docroot=$_SERVER['REQUEST_URI'].'process.php';
		exit;
		?>
		<script type="text/javascript">
		window.location = "<?php echo $docroot; ?>";
		</script>
		<?php
	exit;
	} */
}

	//Second Request Start Here
	if(isset($_POST['step2']))
	{
	
		/*Database Information*/
		$host  = trim($_POST['host']);
		$db  = trim($_POST['db']);
		$user   = trim($_POST['user']);
		$pass = trim($_POST['pass']);
		$prefix  = trim($_POST['prefix']);
		$table = trim($_POST['table']);
		$docroot = trim($_POST['docroot']);
		/* data base connection */
		$link = mysql_connect($host, $user, $pass);
		if($link)
		{
			$url="";
		}
		else
		{
			$url = $_SERVER['REQUEST_URI'];
			$msg1 = '1';
			?>
			<script type="text/javascript">
			window.location = "<?PHP echo "?msg1=$msg1"; ?>";			 
			</script>
		<?php exit;
		}
		
		/* db select */
		$select = mysql_select_db($db);
		if($select)
		{
			$url="";
		}
		else
		{   
			$url = $_SERVER['REQUEST_URI'];
			$msg2 = '2';
			?>
			<script type="text/javascript">
			window.location = "<?PHP echo $url."?msg2=$msg2"; ?>";			 
			</script>
		<?php 
		exit;
        }
		$perms = substr(sprintf('%o', fileperms('../application/config')), -4);
		$perm = substr(sprintf('%o', fileperms('../application/logs')), -4);
		if($perms!="0777" || $perm!="0777")
		{
			$msg3 = '3';
			$msg4 = '4';
			?>
			<script type="text/javascript">
			window.location = "<?PHP echo "?msg3=$msg3&msg4=$msg4"; ?>";			 
			</script>
			<?php
		}
		else
		{
			$str=implode("",file('../application/config/database-sample.php'));		
			/*Config File Writing Starts here*/
			$str=str_replace('yourhostname',$host,$str);
			$str=str_replace('yourdbname',$db,$str);
			$str=str_replace('yourmysqlusername',$user,$str);
			$str=str_replace('yourmysqlpassword',$pass,$str);
			$str=str_replace('yourtableprefix',$prefix,$str);
			$str=str_replace('yourtmppath',$temppath,$str);//tmp path
			$str=str_replace('yourserverpath',$docroot,$str); // docroot for server
			$fp=fopen('../application/config/database.php','w');
			fwrite($fp,$str,strlen($str));
			fclose($fp);
		}
		$url1 = $_SERVER['REQUEST_URI'];
		?>
		<script type="text/javascript">
		window.location = "<?php echo $url."process.php"; ?>";
		</script>
		<?php 
			/*Installation Step:1 Ends Here*/
	}/*First Request Process Ends here*/
?>		


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NDOT Installation</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="../public/js/jquery.js" type="text/javascript"></script>

    <script src="../public/themes/default/js/jquery.validate.js" type="text/javascript"></script>
    
    <script src="../public/js/jquery.validate.js" type="text/javascript"></script>
    


	
	</head>
	<body>	
    <div class="instal_outer">
<div class="instal_logo"></div>
<div class="instal_inner">



<body class="twoColElsLtHdr">

<div id="container">
  <div id="header">
    <h1>Ndot Package Install </h1>
    <!-- end #header --></div>
     
    <p>
	<?php  $d = trim($_SERVER['SCRIPT_FILENAME'],"install.php");
$msg1=$_GET['msg1'];
if($msg1==1)
echo '<font color="red">The given information is not correct please re-enter!</font>';
$msg2=$_GET['msg2'];
if($msg2==2)
echo '<font color="red">The database is not correct please re-enter!</font>';
$msg3=$_GET['msg3'];
if($msg3==3)
echo '<font color="red">The /application/config folder does not have write permission please set the permission!</font>';
$msg4=$_GET['msg4'];
if($msg4==4)
echo '<br><font color="red">The /application/logs folder does not have write permission please set the permission!</font>';
?>
<script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>
<?php $docroot = $_GET["docroot"]; ?>
<form action="" method="post" name="install_form" id="install" >
<input name="docroot" value="<?php echo $docroot; ?>" type="hidden">
  <table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
<tr><td width="414">
  <div align="center">
    <table width="422" border="0" >
      <tr><td width="184">Host Name
    <td width="10">
    <td width="10">:</td>
    <td width="201"><input type="text" name="host" class="required" title="Enter your hostname"/></td></tr>
      <tr><td>Database Name<td><td>:</td><td><input type="text" name="db" value="ndotsocial" class="required" title="Enter your database name correctly"/></td></tr>
      <tr><td>DB Username<td><td>:</td><td><input type="text" name="user" class="required" title="Enter your database user name"/></td></tr>
      <tr><td>DB Password<td><td>:</td><td><input type="password" name="pass" class="" title="Enter your database password"/></td></tr>
      <tr><td>Table Prefix<td><td>:</td><td><input type="text" name="prefix" value="ndot_" /></td></tr>
      <?php // <tr><td>3rd Party install<td><td>:</td><td><input type="radio" name="party" value="1" id="yes" title="Install 3rd Party Also"/>Yes<input type="radio" name="party" value="0" id="no" checked="true" title="Install Only Ndot Social"/>No</td></tr> ?>
    </table>
  </div></td><td width="10"></td></table>
</td></tr></table>&nbsp;
<table width="722" border="0">
  <tr>
    <td><div align="right">
      <input name="step2" type="submit" value="" class="next" cursor:pointer;/>
    </div></td>
  </tr>
</table>
</form>
</p> 


 </div>
    <div class="instal_footer">Copyright &copy;2009 ndot.in.</div>
    </div>
</body>
</html>



