<?php

echo new View("facebook-platform/php/facebook");

// Author : K.Dhanaraj
// Purpose: Getting the Response from the FaceBook Request.  
header('Cache-Control: max-age=225065900');
header('Expires:');
header('Pragma:');
$appapikey = '7ca363512e6b49f9d1b7ebee2698ecd1';
$appsecret = '8771b623278121ad2ef38501d77e9410';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();

$user_details = $facebook->api_client->users_getInfo($user_id, 'last_name,first_name,pic,email'); 

$data['first_name'] = $user_details[0]['first_name'];
$data['last_name'] = $user_details[0]['last_name']; 
$data['pic'] = $user_details[0]['pic']; 
$data['email'] = $user_details[0]['email']; 
$username="FB_".$user_id;

$this->session->set("f_user_photo",$data['pic']);
//calling connect model class
$this->model=new Connection_Model;
$this->model->facebook_registration($user_id,$data['first_name'],$data['last_name'],$data['pic']);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>cross domain receiver page</title>
</head>
<body>

<!--
This is a cross domain (XD) receiver page. It needs to be placed on your domain so that the Javascript
  library can communicate within the iframe permission model. Put it here:

  http://www.example.com/xd_receiver.php
-->
<script> window.close();window.location="http://192.168.1.2:1154/profile/updateprofile";  </script>

</body>
</html>


