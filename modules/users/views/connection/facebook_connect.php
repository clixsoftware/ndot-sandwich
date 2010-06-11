

<?php

require_once 'facebook.php';

//API key and secret keys
// old api key 7ca363512e6b49f9d1b7ebee2698ecd1
//old sec 8771b623278121ad2ef38501d77e9410
$appapikey = '7ca363512e6b49f9d1b7ebee2698ecd1'; 
$appsecret = '8771b623278121ad2ef38501d77e9410';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();

//echo $user_id;

//get the friends
//    $this->invite_facebook_users=$facebook->api_client->connect_registerUsers($user_id.'@'.'facebook.com');
//foreach($this->invite_facebook_users as $test) { var_dump($test); } exit;

$user_details = $facebook->api_client->users_getInfo($user_id, 'last_name, first_name'); 
$data['first_name'] = $user_details[0]['first_name'];
$data['last_name'] = $user_details[0]['last_name']; 

//calling connect model class
$this->model=new Connection_Model;
$this->model->facebook_registration($user_id,$data['first_name']);

?>


