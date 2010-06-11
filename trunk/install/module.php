<?php
	if($_POST)
	{	        	        
                /*Getting information for Db connectivity from database.php file */
                include_once '../application/config/database.php';
                $prefix=$config['default']['table_prefix'];
                $host=$config['default']['connection']['host'];
                $user=$config['default']['connection']['user'];
                $pass=$config['default']['connection']['pass'];
                $db=$config['default']['connection']['database'];
                /*module Information*/

                //$all  = $_POST['checkall'];
                $answer  = $_POST['chk1'];
                if($answer!='0') { $answer='1'; }  
                $blogs  = $_POST['chk2'];
                if($blogs!='0') { $blogs='1'; }  
                $CMS  = $_POST['chk3'];
                if($CMS!='0') { $CMS='1'; }  
                $classifieds = $_POST['chk4'];
                if($classifieds!='0') { $classifieds='1'; }  
                $events = $_POST['chk5'];
                if($events!='0') { $events='1'; }  
                $forums = $_POST['chk6'];
                if($forums!='0') { $forums='1'; }  
                $friends  = $_POST['chk7'];
                if($friends!='0') { $friends='1'; }  
                $groups  = $_POST['chk8'];
                if($groups!='0') { $groups='1'; }  
               
                $news = $_POST['chk10'];
                if($news!='0') { $news='1'; }   
                $updates = $_POST['chk12'];
                if($updates!='0') { $updates='1'; }  
                $photos  = $_POST['chk11'];
                
                /* if($photos!='0') { $photos='1'; } 
                $inbox   = $_POST['chk9'];
                if($inbox!='0') { $inbox='1'; }  
                $videos = $_POST['chk13'];
                if($videos!='0') { $videos='1'; }  */
                
                /*$str=implode("",file('application/config/application-sample.php'));					
                $fp=fopen('application/config/application.php','w');
                fwrite($fp,$str,strlen($str));
                fclose($fp);*/

                //if (empty($prefix)) $prefix = ''; else { if(substr($prefix, -1)!="_") $prefix=$prefix."_";   }
                /* data base connection */
                $link = mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error());
                /* db select */
                $select = mysql_select_db($db) or die('Query failed: ' . mysql_error());
                //checking user table of other party
                $sql="INSERT INTO `".$prefix."menus` (`name`, `link`, `status`, `description`, `system_module`) VALUES
                ('updates', 'profile', 0, 'LIst the all friends updates and users activities', 1),
                ('answers', 'answers', $answer, 'defines the questions and answers', 0),
                ('blogs', 'blogs', $blogs, 'Defines the blog activity', 0),
                ('friends', 'profile/friends', 0, 'List the friends list', 1),
                ('CMS', '', 0, 'Defines the content manage sys', 1),
                ('classifieds', 'classifieds', $classifieds, 'Defines the classifieds activity', 0),
                ('events', 'events', $events, 'Defines the events', 0),
                ('forums', 'forum', $forums, 'Defines the forum', 0),
                ('groups', 'groups', $groups, 'Defines the groups', 0),
                ('inbox', 'inbox', 0, 'Defines the inbox', 1),
                ('news', 'news', $news, 'Defines the news', 0),
                ('photos', 'photos', 0, 'Defines the photos', 1),
                ('video', 'video', 0, 'Defines the Videos', 1),
                ('ktwitter', '', 0, 'Defines the twitter integration', 1),
                ('lib', '', 0, 'Defines common library functions', 1),
                ('debug_toolbar', '', 0, 'Defines the Debugger tools', 1),
                ('gmaps', '', 0, 'Defines the gmap to us', 1),
                ('admin', '', 0, 'Defines the admin', 1),
                ('profile', '', 0, 'Defines the profile', 1),
                ('users', '', 0, 'Defines the users', 1);";
                $exe=mysql_query($sql) or die(mysql_error());
	        $sql1="select * from ".$prefix."menus";
	        $modres=mysql_query($sql1) or die(mysql_error());
	
                /*$r="";
                $s="";
                //print_r($this->get_module); 
                while ($mod = mysql_fetch_array ($modres)) 
                {
                        if($mod['system_module']==0)
                        {
                                $r=$r."'".$mod['name']."'"."=>".$mod['status'].",\n";
                              
                        }
                }
                $r1='$'."config['module_enable'] = array(".$r.");";
                
                $sql2="select * from ".$prefix."menus";
	        $mods=mysql_query($sql2) or die(mysql_error());
                
                while ($module = mysql_fetch_array ($mods))
                {
                        if($module['status']==0)
                        {
                                $s=$s."MODPATH".".'".$module['name']."',\n";
                        }
                }

                $s1='$'."config['modules'] = array (".$s.");";

                $result = '<?php '."\n"." ".$r1."\n".$s1;

                //check permission for application config file
                $perms = substr(sprintf('%o', fileperms('application/config')), -4);
                if($perms!="0777")
                {
                        $msg = '1';
                        $d=$_SERVER['REQUEST_URI'];
                        $d = trim($d,"process.php.");
                        ?>
                        <script type="text/javascript">
                        window.location = "<?PHP echo $url."?msg=$msg"; ?>";			 
                        </script>
                        <?php
                }
                else
                {                        

                //chmod($this->file_docroot.'/application/config/application.php', 0755);
                $fp = fopen('application/config/application.php','w');
                fwrite($fp,$result,strlen($result));
                fclose($fp);*/
                 $d=$_SERVER['REQUEST_URI'];
                 $d = trim($d,"/module.php.");	
                  $d = trim($d,"/install");
                        $d = 'http://'.$_SERVER['HTTP_HOST'].'/'.$d.'/';      		    
                 ?>
                        <script type="text/javascript">
                        window.location = "<?PHP echo $d; ?>";			 
                        </script>
                        <?php			  
                exit;
                /*Installation Ends Here*/
                }
	}//Second Request Process Ends here
?>		
	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NDOT Installation</title>
<link rel="stylesheet" href="style.css" type="text/css">
    <script src="public/themes/default/js/jquery.validate.js" type="text/javascript"></script>
    <script src="public/js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>

</head>
<body>
   <div class="instal_outer">
<div class="instal_logo"></div>
<div class="instal_inner">
<h1>Ndot Package Install </h1>
<div><font size="3px">Select Module</font></div>

<?php 
$msg1=$_GET['msg'];
if($msg==1)
echo '<font color=red>The /application/config folder does not have write permission please set the permission!</font>';
?>
<form action="" method="post" id ="frm1" name="frm1" >

<table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">

<tr><td width="420">
<table width="326" border="0" >
<tr>
  <td width="100" height="22">All<td width="49">
<td width="71">:</td>
<td width="88"><input type="checkbox" value="0" name='checkall' onclick='checkedAll(frm1);'/></td>
</tr>
<tr>
  <td>Answers
  <td><td>:</td><td><input type="checkbox" name="chk1" value="0"></td></tr>
<tr>
  <td>Blogs
  <td><td>:</td><td><input type="checkbox" name="chk2" value="0"></td></tr>
<tr>
  <td>CMS
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk3" value="0"></td>
</tr>
<tr>
  <td>Classifieds
  <td><td>:</td><td><input type="checkbox" name="chk4" value="0"></td></tr>
<tr>
  <td height="24">Events
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk5" value="0"></td>
</tr>
<tr>
  <td height="24">Forums
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk6" value="0"></td>
</tr>
<tr>
  <td height="24">Friends
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk7" value="0"></td>
</tr>
<tr>
  <td height="24">Groups
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk8" value="0"></td>
</tr>

<tr>
  <td height="24">News
  <td>
  <td>:</td>
  <td><input type="checkbox" name="chk10" value="0"></td>
</tr>

<tr>
  <td height="24">
  <td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td height="24">
  
  <td><input name="" type="reset" value="" class="reset"/>
  
  <td>&nbsp;</td><td><input name="" type="submit" value="" class="next"/></td></tr>
</table>

</table>
</td>
  </table>
</td></tr></table>
 </div>
    <div class="instal_footer">Copyright &copy;2009 ndot.in.</div>
    </div>
</body>
</html>
