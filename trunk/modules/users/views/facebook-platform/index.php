<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Dhanaraj k
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 

require_once 'php/facebook.php';
require_once 'lib/user.php';
include 'lib/config.php';
include 'lib/core.php';
include 'lib/display.php';
include 'lib/fbconnect.php';
include 'lib/friends.php';
include 'lib/run.php';
//include 'lib/user.php';
//include_once MAIN_PATH.'/facebook-client/facebook.php';
$appapikey = '1943811d592d70875f783fdf2286f413';
$appsecret = 'fb284f74180085fae9b26eb90fe48149';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();

// Greet the currently logged-in user!
echo "<p>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</p>";

// Print out at most 25 of the logged-in user's friends,
// using the friends.get API method
echo "<p>Friends:";
$friends = $facebook->api_client->friends_get();
$friends = array_slice($friends, 0, 25);
foreach ($friends as $friend) {
  echo "<br>$friend";
}
echo "</p>";

?>



 
