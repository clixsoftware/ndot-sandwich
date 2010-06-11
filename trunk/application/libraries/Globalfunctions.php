<?php defined('SYSPATH') or die('No direct script access.');

class Globalfunctions_Core{

	/****
		@author = Nandakumar
		@purpose = For checking Null Variables
	****/
	function checknull($input,$alt){
	$input  = trim($input);
	$input 	= strip_html_tags($input);
	if(is_null($input) || strlen($input)<1 || $input ==""){
		$input = $alt;
	}
	return $input;
	}
	/****
		@author = Nandakumar
		@purpose = Eliminating Mysql injection
	****/
	function safeEscapeString($string)
	{
	if (get_magic_quotes_gpc()) {
	return $string;
	} else {
	return mysql_escape_string($string);
	}
	}
	
	/****
		@author = Nandakumar
	****/
	function turn_red($haystack,$needle)
	{
		 $h=strtoupper($haystack);
		 $n=strtoupper($needle);
		 $pos=strpos($h,$n);
		 if ($pos !== false)
			 {
			$var=substr($haystack,0,$pos)."<font color='#ff9000' style='background-color:#f8f8f8;'>".substr($haystack,$pos,strlen($needle))."</font>";
			$var.=substr($haystack,($pos+strlen($needle)));
			$haystack=$var;
			}
		 return $haystack;
	}
	/****
		@author = Nandakumar
	****/
	function makeClickableLinks($text) {
	
	  $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
		'<a href="\\1" class="bottomlinks" target="_blank">\\1</a>', $text);
	  $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
		'\\1<a href="http://\\2" class="bottomlinks" target="_blank">\\2</a>', $text);
	  $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
		'<a href="mailto:\\1" class="bottomlinks" target="_blank">\\1</a>', $text);
	  
	return $text;
	
	}
	
	// func: redirect($to,$code=307)
	// spec: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	function redirect($to,$code=301)
	{
	  $location = null;
	  $sn = $_SERVER['SCRIPT_NAME'];
	  $cp = dirname($sn);
	  if (substr($to,0,4)=='http') $location = $to; // Absolute URL
	  else
	  {
		$schema = $_SERVER['SERVER_PORT']=='443'?'https':'http';
		$host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
		if (substr($to,0,1)=='/') $location = "$schema://$host$to";
		elseif (substr($to,0,1)=='.') // Relative Path
		{
		  $location = "$schema://$host/";
		  $pu = parse_url($to);
		  $cd = dirname($_SERVER['SCRIPT_FILENAME']).'/';
		  $np = realpath($cd.$pu['path']);
		  $np = str_replace($_SERVER['DOCUMENT_ROOT'],'',$np);
		  $location.= $np;
		  if ((isset($pu['query'])) && (strlen($pu['query'])>0)) $location.= '?'.$pu['query'];
		}
	  }
	
	  $hs = headers_sent();
	  if ($hs==false)
	  {
		if ($code==301) header("301 Moved Permanently HTTP/1.1"); // Convert to GET
		elseif ($code==302) header("302 Found HTTP/1.1"); // Conform re-POST
		elseif ($code==303) header("303 See Other HTTP/1.1"); // dont cache, always use GET
		elseif ($code==304) header("304 Not Modified HTTP/1.1"); // use cache
		elseif ($code==305) header("305 Use Proxy HTTP/1.1");
		elseif ($code==306) header("306 Not Used HTTP/1.1");
		elseif ($code==307) header("307 Temorary Redirect HTTP/1.1");
		else trigger_error("Unhandled redirect() HTTP Code: $code",E_USER_ERROR);
		header("Location: $location");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	  }
	  elseif (($hs==true) || ($code==302) || ($code==303))
	  {
		// todo: draw some javascript to redirect
		$cover_div_style = 'background-color: #ccc; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;'; 
		echo "<div style='$cover_div_style'>\n";
		$link_div_style = 'background-color: #fff; border: 2px solid #f00; left: 0px; margin: 5px; padding: 3px; ';
		$link_div_style.= 'position: absolute; text-align: center; top: 0px; width: 95%; z-index: 99;';
		echo "<div style='$link_div_style'>\n";
		echo "<p>Please See: <a href='$to'>".htmlspecialchars($location)."</a></p>\n";
		echo "</div>\n</div>\n";
	  }
	  exit(0);
	}
	
	/*****************Send Email ********************************/
	function sendEmail($email,$subject,$body){
	$to = $email;
	if (mail($to, $subject, $body)) {
	  echo("<p>Message successfully sent!</p>");
	 } else {
	  echo("<p>Message delivery failed...</p>");
	 }
	}
	/************* Email Validation ****************************/
	function is_valid_email($email) {
	  $result = TRUE;
	  if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
		$result = FALSE;
	  }
	  return $result;
	}
	function checkEmail($email) 
	{	
	   if(!eregi("^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$", $email)) 
	   {
		  return FALSE;
	   }
	
	   list($eUsername, $eDomain) = split("@",$email);
	   
	   if(getmxrr($eDomain, $MXHost, $mx_weight)) 
	   {
		  return TRUE;
	   }
	   else 
	   {
		  if(@fsockopen($eDomain, 25, $errno, $errstr, 30)) 
		  {
			 return TRUE; 
		  }
		  else 
		  {
			 return FALSE; 
		  }
	   }
	}
	

	/****
			Purpose: Check the URL  is valid or not
			Date   : 09/25/2006
	****/
	
		function isValidURL($url)
		{
			if(preg_match('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)){
				$component = parse_url ($url);
				//echo $component['host'];
				if(isDomainResolves($component['host'])){
						return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;				
			}
		}
	/****
			Purpose: Check the Domain name resolves?
			Date   : 09/25/2006
	****/
		function isDomainResolves($domain)
		{
			 return gethostbyname($domain) != $domain;
		}		
	
	/****   
			Purpose: Checking for Link Active
			Date   : 09/20/2006
	****/
	function checklink($link){
		list($eUsername, $eDomain) = split("@",$email);
	   
	   if(getmxrr($eDomain, $MXHost, $mx_weight)) 
	   {
		  return TRUE;
	   }
	   else 
	   {
		  if(@fsockopen($eDomain, 25, $errno, $errstr, 30)) 
		  {
			 return TRUE; 
		  }
		  else 
		  {
			 return FALSE; 
		  }
	   }
	
	}
	
	/****
			Purpose: Utility for form variable checking
			Date   : 09/22/2006
			parameters : from(if int/float its value), to, type 
	****/
	function isvalid($from,$to,$type,$field){
	$retval = false;
	if($type="s"){
		if(strlen($field)>=$from && strlen($field)<=$to){
			//echo strlen($field).":".$from.":".$to.":".$field."~~";
			//echo strlen($field).":".$from;
			$retval = true;
		}
	}
	if($type="i"){
		if( gettype($field) =="integer"){
			if($field >=$from && $field<=$to){
				$retval = true;
			}
		}
	}
	if($type="f"){
		if( gettype($field) =="double"){
			//settype($from,"double");
			//settype($to,"double");
			if($field >=$from && $field<=$to){
				//echo "i dsdsoube".$field;
				$retval = true;
			}
		}
	}
	return $retval;
	}
	function handlespecials( $string )
	{
	  $string = str_replace ( '&','', $string );
	  $string = str_replace ( '\'','', $string );
	  $string = str_replace ( '"','', $string );
	  $string = str_replace ( '<', '',$string );
	  $string = str_replace ( '>', '',$string );
	  $string = str_replace ( '/', '',$string );
	  $string = str_replace ( ';', '',$string );
	  $string = str_replace ( '?', '',$string );
	  $string = str_replace ( ':', '',$string );
	  $string = str_replace ( ',', '',$string );
	  $string = str_replace ( '{', '',$string );
	  $string = str_replace ( '}', '',$string );  
	  $string = str_replace ( '(', '',$string );  
	  $string = str_replace ( ')', '',$string );  
	  $string = str_replace ( '`', '',$string );  
	  $string = str_replace ( '!', '',$string );    
	  $string = str_replace ( '@', '',$string );    
	  $string = str_replace ( '%', '',$string );    
	  $string = str_replace ( '$', '',$string );    
	  $string = str_replace ( '[', '',$string );    
	  $string = str_replace ( ']', '',$string );    
	  $string = str_replace ( '.', '',$string );    
	  $string = str_replace ( '~', '',$string );    
	  $string = str_replace ( '#', '',$string );    
	  $string = str_replace ( ' ', '-',$string );  
	
	  //echo $string;
	  return $string;
	}
	
	function get_time_difference( $start, $end )
	{
		$uts['start']      =    strtotime( $start );
		$uts['end']        =    $end ;
		if( $uts['start']!==-1 && $uts['end']!==-1 )
		{
			if( $uts['end'] >= $uts['start'] )
			{
				$diff    =    $uts['end'] - $uts['start'];
				if( $days=intval((floor($diff/86400))) )
					$diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )
					$diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )
					$diff = $diff % 60;
				$diff    =    intval( $diff );            
				return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
			}
			else
			{
				trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
			}
		}
		else
		{
			trigger_error( "Invalid date/time data detected", E_USER_WARNING );
		}
		return( false );
	}
	
	function drwhdr($hdr=" desiji - Social Networking " ){
		?>
	<html>
	<head>
	<title><?php echo $hdr; ?></title>
	<!--link href="<?php echo $this->docroot;?>favicon.ico" rel="SHORTCUT ICON" /-->
		<?php
	}
	
	/*function strip_html_tags( $text )
	{
		$text = preg_replace(
			array(
			  // Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
			  // Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),
			$text );
		return strip_tags( $text );
	}
	*/
	function deletefile($filename){
		if(file_exists("$filename"))
		{
			if(unlink("$filename"))
			{
				return true;
			}
			else
			{
				return false;
			}	
		}else{
			return false;
		}
	}
	
	function http_test_existance($url) {
	 return (($fp = @fopen($url, 'r')) === false) ? false : @fclose($fp);
	}
	
	function getdatediff($dt){
		if( $diff=@get_time_difference($dt, time()) ) // <-- HERE!
		{
		  if($diff["days"] > 0){
			echo $diff["days"] . " days ago.";
		  }
		  else{
			if($diff["hours"]>0){
				echo $diff["hours"]." hours ".$diff["minutes"]. " min ";
			}
			else{
				echo $diff["minutes"]." min ".$diff["seconds"]. " sec ";
			}
		  }
		}else{
		
		}
	
	}
	function strip_html_tags( $text )
	{
		$text = preg_replace(
			array(
			  // Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
			  // Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),
			$text );
		return strip_tags( $text );
	}


/************* DB Functions ************************/
	
	function drwcombo($queryString,$selectval=""){
		//$queryString = "select catname,id from groups_category ";
		$resultSet = mysql_query($queryString);
		while($noticia = mysql_fetch_array($resultSet)){
			if($selectval== $noticia[1]){
				echo '<option value="'.$noticia[1].'" selected=selected >'.$noticia[0].'</option>';
			}else{
				echo '<option value="'.$noticia[1].'" >'.$noticia[0].'</option>';
			}
		}
	}
	function countQuery($queryString=""){
		if($queryString!=""){
			//echo $queryString;
			$resultSet = mysql_query($queryString);
			return mysql_result($resultSet,0,0);
		}
		return 0;
	}
	function isRecordAvailable($queryString=""){
		if($queryString!=""){
			//echo $queryString;
			$resultSet = mysql_query($queryString);
			if(mysql_num_rows($resultSet) > 0 ){
				return mysql_result($resultSet,0,0);
			}else{
				return -1;				
			}
		}
		return 0;
	}
	
	function dateTimeDiff($data_ref){
		
		$current_date = date('Y-m-d H:i:s');
	
		// Extract from $current_date
		$current_year = substr($current_date,0,4);
		$current_month = substr($current_date,5,2);
		$current_day = substr($current_date,8,2);
		
		// Extract from $data_ref
		$ref_year = substr($data_ref,0,4);
		$ref_month = substr($data_ref,5,2);
		$ref_day = substr($data_ref,8,2);
		
		// create a string yyyymmdd 20071021
		$tempMaxDate = $current_year . $current_month . $current_day;
		$tempDataRef = $ref_year . $ref_month . $ref_day;
	
		$tempDifference = $tempMaxDate-$tempDataRef;
	
	// If the difference is GT 10 days show the date
		if($tempDifference >= 50){ //echo $tempDifference;
			echo $data_ref;
		} else {
			// Extract $current_date H:m:ss
			$current_hour = substr($current_date,11,2);
			$current_min = substr($current_date,14,2);
			$current_seconds = substr($current_date,17,2);
			
			// Extract $data_ref Date H:m:ss
			$ref_hour = substr($data_ref,11,2);
			$ref_min = substr($data_ref,14,2);
			$ref_seconds = substr($data_ref,17,2);
			
			$hDf = $current_hour-$ref_hour;
			$mDf = $current_min-$ref_min;
			$sDf = $current_seconds-$ref_seconds;
			
			// Show time difference ex: 2 min 54 sec ago.
			$dDf=$tempDifference;
			if($dDf<1){
			if($hDf>0){
			if($mDf<0){
			$mDf = 60 + $mDf;
			$hDf = $hDf - 1;
			echo $mDf . ' min ago';
			} else {
			echo $hDf. ' hr ' . $mDf . ' min ago';
			}
			} else {
			if($mDf>0){
			echo $mDf . ' min ' . $sDf . ' sec ago';
			} else {
			echo $sDf . ' sec ago';
			}
			}
			} else {
			echo $dDf . ' days ago';
			}
			
		}
	}
	
}
