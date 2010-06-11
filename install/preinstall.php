<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>Welcome to the NdotSocial  1.0 Installation Wizard</title>
   
   <link rel="stylesheet" href="style.css" type="text/css">
</head>
<style type="text/css">
body { width: 43em; margin: 0 auto; font-family: sans-serif; font-size: 90%; }

#tests table { border-collapse: collapse; width: 100%; }
	#tests table th,
	#tests table td { padding: 0.2em 0.4em; text-align: left; vertical-align: top; }
	#tests table th { width: 12em; font-weight: normal; font-size: 1.2em; }
	#tests table tr:nth-child(odd) { background: #eee; }
	#tests table td.pass { color: #003300; }
	#tests table td.fail { color: #911; }
		#tests #results { color: #fff; }
		#tests #results p { padding: 0.2em 0.4em; }
		#tests #results p.pass { background: #003300; }
		#tests #results p.fail { background: #911; }
.style1 {
	font-size: 14px;
	font-weight: bold;
}
</style>


<body>
<?php $docroot = $_GET["docroot"]; ?>
	<form action="install.php?docroot=<?php echo $docroot; ?>" method="post" name="form" id="form">
  <table class="shell" align="center" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td colspan="2" id="help"><a href="readme.html" target="_blank">Help </a></td></tr>
    <tr>
      <th width="500">
		<p>&nbsp;</p>
		Welcome to the NdotSocial  1.0 Installation Wizard</th>

      <th style="text-align: right;" height="30" width="200"><a href="http://www.ndot.in/" target="_blank">
	  <img src="../public/images/logo.jpg" alt="N.social" border="0" height="30" width="145"></a>
      </th>
    </tr>
   <tr>
      <td colspan="2" id="ready_image"><img src="../public/images/install.jpg" alt="N.social" border="0" height="190" width="698"></td>
    </tr>

    <tr>
      <td colspan="2" id="ready">Are you ready to install? </td>
    </tr>

    <tr>
      <td colspan="2">
        <p><strong>Please
read the following important information before proceeding with the
installation. The information will help you determine whether or not
you are ready to install the application at this time.</strong></p>




            <table class="Welcome" border="0" cellpadding="0" width="100%">
            <tbody><tr>

                <th><span onClick="showtime('sys_comp');" style="cursor: pointer;"><span id="adv_sys_comp" style="display: none;"><img src="install.php_files/advanced_search.gif" border="0"></span>&nbsp;Required System Components</span></th>
            </tr>
                <tr><td>
                    <div id="sys_comp">
                    Before you begin, please be sure that you have the supported versions of the following system
                      components:<br>
                      <ul>
                      <li> Database/Database Management System MySQL</li>
                      <li> Web Server Apache</li>
                      </ul>
                      <br>
                    </div>
                </td>
            </tr></tbody></table>


            <table class="Welcome" border="0" cellpadding="0" width="100%">
            <tbody><tr>
                <th><span onClick="showtime('sys_check');" style="cursor: pointer;"><span id="adv_sys_check" style="display: none;"><img src="install.php_files/advanced_search.gif" border="0"></span>&nbsp;Initial System Check</span></th>
            </tr>
                <tr><td>
                    <div id="tests">
<?php $failed = FALSE ?>
<table cellspacing="0" border="1">
<tr>
<th width="236">PHP Version</th>
<?php if (version_compare(PHP_VERSION, '5.2', '>=')): ?>
<td width="118" class="pass"><?php echo PHP_VERSION ?></td>
<?php else: $failed = TRUE ?>
<td width="198" class="fail">Kohana requires PHP 5.2 or newer, this version is <?php echo PHP_VERSION ?>.</td>
<?php endif ?>
</tr>

<?php
 function _iscurlinstalled() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
}
if (_iscurlinstalled()) {
$curl = "cURL is installed"; $cerror = '0'; }
else  {
$curl = "cURL is NOT installed"; $cerror = '1'; }
?>
 


<tr>
<th width="236">Curl </th>
<?php if($cerror == '0'): ?>
<td width="118" class="pass"><?php  echo 'Pass'; ?></td>
<?php else: $failed = TRUE ?>
<td width="198" class="fail"><?php echo "Enable curl in php.ini file";?>.</td>
<?php endif ?>
</tr>


<tr>
<th>PCRE UTF-8</th>
<?php if ( !function_exists('preg_match')): $failed = TRUE ?>
<td class="fail"><a href="http://php.net/pcre">PCRE</a> support is missing.</td>
<?php elseif ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
<td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support.</td>
<?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
<td width="82" class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with Unicode property support.</td>
<?php else: ?>
<td width="48" class="pass">Pass</td>
<?php endif ?>
</tr>
<tr>
<th>Reflection Enabled</th>
<?php if (class_exists('ReflectionClass')): ?>
<td class="pass">Pass</td>
<?php else: $failed = TRUE ?>
<td class="fail">PHP <a href="http://www.php.net/reflection">reflection</a> is either not loaded or not compiled in.</td>
<?php endif ?>
</tr>
<tr>
<th>Filters Enabled</th>
<?php if (function_exists('filter_list')): ?>
<td class="pass">Pass</td>
<?php else: $failed = TRUE ?>
<td class="fail">The <a href="http://www.php.net/filter">filter</a> extension is either not loaded or not compiled in.</td>
<?php endif ?>
</tr>
<tr>
<th>Iconv Extension Loaded</th>
<?php if (extension_loaded('iconv')): ?>
<td class="pass">Pass</td>
<?php else: $failed = TRUE ?>
<td class="fail">The <a href="http://php.net/iconv">iconv</a> extension is not loaded.</td>
<?php endif ?>
</tr>

<tr>
<th>SPL Enabled</th>
<?php if (function_exists('spl_autoload_register')): ?>
<td class="pass">Pass</td>
<?php else: $failed = TRUE ?>
<td class="fail"><a href="http://php.net/spl">SPL</a> is not enabled.</td>
<?php endif ?>
</tr>

<?php if (extension_loaded('mbstring')): ?>
<tr>
<th>Mbstring Not Overloaded</th>
<?php if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING): $failed = TRUE ?>
<td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP's native string functions.</td>
<?php else: ?>
<td class="pass">Pass</td>
</tr>
<?php endif ?>
<?php else: // check for utf8_[en|de]code when mbstring is not available ?>
<tr>
<th>XML support</th>
<?php if ( ! function_exists('utf8_encode')): $failed = TRUE ?>
<td class="fail">PHP is compiled without <a href="http://php.net/xml">XML</a> support, thus lacking support for <code>utf8_encode()</code>/<code>utf8_decode()</code>.</td>
<?php else: ?>
<td class="pass">Pass</td>
<?php endif ?>
</tr>
<?php endif ?>
<tr>
<th>URI Determination</th>
<?php if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF'])): ?>
<td class="pass">Pass</td>
<?php else: $failed = TRUE ?>
<td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code> or <code>$_SERVER['PHP_SELF']</code> is available.</td>
<?php endif ?>
</tr>
<tr>
  <td><span class="style1">The following files must be writeable:</span></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  
  <td><ul>
<li><b>/application/config</b></li><?php $permp = substr(sprintf('%o', fileperms('../application/config')), -4);?></td>
  <td><?php if($permp!='0777')
		{
		        $failed = TRUE;
                        echo "<font color='red'>Fail</font>";
		}
		else
		{
		        echo "<font color='#003300'>Pass</font>";
		}
		?></td>
		<td>&nbsp;</td>
</tr>
<tr>
  <td><ul><li><b>/application/logs</b></li><?php $permq = substr(sprintf('%o', fileperms('../application/logs')), -4);?></td>
  <td> <?php if($permq!='0777')
		{
		        $failed = TRUE;
		        echo "<font color='red'>Fail</font>";
		}
		else
		{
		        echo "<font color='#003300'>Pass</font>";
		}
		?></td>
  <td>&nbsp;</td>
</tr>
<tr>
<td><ul><li><b>/public</b></li><?php $permr = substr(sprintf('%o', fileperms('../public')), -4); ?></td>
<td><?php          if($permr!='0777')
		{
		        $failed = TRUE;
		        echo "<font color='red'>Fail</font>";
		}
		else
		{
		        echo "<font color='#003300'>Pass</font>";
		}
		?></td>
<td>&nbsp;</td>
</tr>
</table>


		

               

       
</ul>
</li>
If the check fails, you will
not be able to proceed with the installation. An error message will be
displayed, explaining why your system did not pass the check. After
making any necessary changes, you can undergo the system check again to
continue the installation.<br>

<div id="results">
<?php if ($failed === TRUE) 
{
?>
<p class="fail"> may not work correctly with your environment.</p>
<?php 
}
else
{ 
?>
<p class="pass">Your environment passed all requirements.</p>
<?php
}
 ?>
</div>

</div>
                </td>
            </tr></tbody></table>


            <table class="Welcome" border="0" cellpadding="0" width="100%">
            <tbody><tr>
                <th><span onClick="showtime('installType');" style="cursor: pointer;"><span id="adv_installType" style="display: none;"><img src="install.php_files/advanced_search.gif" border="0"></span>&nbsp;Install Process Flow by steps </span></th>
            </tr>
                <tr><td>
                  <div id="installType">
                      <p align="center"><strong>Step:1</strong></p>
                      <p>If all the Initial system check has passed then give next in the bottom of this page.</p>
                      <p>1. Given the host name correctly. For example. &quot;localhost&quot;.</p>
                      <p>2. Give the database details - User, Password and DB name correctly. If database has not created yet then first create the database.</p>
                      <p>3. If you need any prefix to tables then give your prefix or leave as it is. There will be &quot;<strong>ndot_</strong>&quot; default. </p>
                      <p align="center"><strong>Step:2</strong></p>
                      <p>1. Give your site title and give admin email id and password.</p>
                      <p>2. After the getting the Typical or the Custom installation.<br>
                        <br>
                      For <b>Typical</b> installations, you will need to know the following:</p>
                      <ul>
                      <li>In this all the modules will be enabled and u also can change the settings after logging in. </li>
                      </ul>
                      <p>

                      For the <b>Custom</b> setup, you might also need to know the following:                      </p><ul>
                      <li>In this you can select the modules for installation.</li>
                                  <li>If you select Custom then it will lead to &quot;Step:3&quot;<br>
                        </li>
                      </ul>
                                  <p>3. In User Table Preference select &quot;<strong>Table Exists</strong>&quot; if you already have users table and give the appropriate table name and their field names.</p>
                                  <p>4. If u don't have any users table and select &quot;<strong>New Table</strong>&quot; and give &quot;<strong>Next</strong>&quot;.  </p>
                                  <p align="center"><strong>Step:3</strong></p>
                                  <p>1. If you have selected Custom in Step:2 then it ll lead to this page, where you will have checkbox to select needed modules for your website. </p>
                                  <p>2. Select required modules and give install to complete the installation.</p>
                                  <p>For more detailed information, please see the readme.html. </p>
                                  <p align="center"><strong>Third Party Integration</strong></p>
                                  <p>  If you want to install n.social with any other 3rd party package like Wordpress, Joomla or Drupal do some manual changes as said below</p>
                                  <h4>For Wordpress</h4>
                                  <p> Use this code for wordpress Application configuration. <br>
                                    Just go to wp-includes-&gt;user <br>
                                    In user file append this content in 65th line under the do_action('wp_login', $credentials['user_login']); function. <br>
  <h5>Code:</h5> 
                                    /** <br>
                                    * Login Ndot social; <br>
                                    * call the ndot extranal function; <br>
                                    */ <br>
                                    require( $_SERVER['DOCUMENT_ROOT']. '/ndotsocial/ndot.php' ); $ndot = new Ndot(); 	$user_info = (array)$user; <br>
                                    $userid = $user_info["ID"]; $username =$user_info["display_name"]; 	$email=$user_info["user_email"]; <br>
                                    $ndot-&gt;login($userid,$username,$email); <br>
                                    // <br>
                                  </p>
                                  <h4>For Drupal</h4>
                                  <p> Use this code for Drupal Application configuration. <br>
                                    Just go to modules -&gt; user -&gt; user.module <br>
                                    In user.module file append this content in 1407nd line under the if ($user-&gt;uid) { <br>
  <h5>Code:</h5> 
                                    /** <br>
                                    * Login Ndot social; <br>
                                    * call the ndot extranal function; <br>
                                    */ <br>
                                    require( $_SERVER['DOCUMENT_ROOT']. '/ndot/ndot.php' ); <br>
                                    $ndot = new Ndot(); <br>
                                    $ndot-&gt;login($user-&gt;uid,$user-&gt;name,$user-&gt;mail); <br>
                                    // </p>
                                  <h4>For Joomla</h4>
                                  <p> Use this code for Joomla Application configuration. <br>
                                    Just go to components -&gt; com_user -&gt;controller <br>
                                    In controller file append this content in 152nd line under the if(!JError::isError($error))
                                    { . <br>
          <h5>Code:</h5> 
                                    /** <br>
                                    * Login Ndot social; <br>
                                    * call the ndot extranal function; <br>
                                    */ <br>
                                    require( $_SERVER['DOCUMENT_ROOT']. '/ndot/ndot.php' );  $ndot = new Ndot(); 	foreach($_SESSION as $t){ <br>
                                    $uid= $t["user"]-&gt;id; $uname = $t["user"]-&gt;username;  $email = $t["user"]-&gt;email; <br>
                                    }  $ndot-&gt;login($uid,$uname,$email); <br>
                                    // </p>
                                  <p>&nbsp;</p>
                  </div>
                </td>
            </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
            </tbody></table>
      </td>
    </tr>

    <tr>
      <td colspan="2" align="right" height="20">
        <hr>
                <input name="current_step" value="0" type="hidden">
				
        <table class="stdTable" border="0" cellpadding="0" cellspacing="0">
          <tbody><tr>
                <td>
	               <input name="goto" value="Back" type="hidden"></td>
	            <td><input class="next"  value="" type="submit"/></td>
          </tr>
        </tbody></table>
      </td>
    </tr>
  </tbody></table>
	</form>
    <script>
        function showtime(div){

            if(document.getElementById(div).style.display == ''){
                document.getElementById(div).style.display = 'none';
                document.getElementById('adv_'+div).style.display = '';
                document.getElementById('basic_'+div).style.display = 'none';
            }else{
                document.getElementById(div).style.display = '';
                document.getElementById('adv_'+div).style.display = 'none';
                document.getElementById('basic_'+div).style.display = '';
            }

        }
    </script>
    <div class="instal_footer">Copyright &copy;2009 ndot.in.</div>
</body></html>
