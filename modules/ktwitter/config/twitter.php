<?php

/*
 *    Twitter Oauth Config
 *        you are going to have to edit details into here
 *        for the library to work right!
 *
 */


// To get consumer key/secret you need to visit http://www.twitter.com/oauth_clients and create an app
// Consumer key from twitter
$config['consumer_key'] = 'Q2lPaQzsFeROE9lSt8UPxQ';
// Consumer Secret from twitter
$config['consumer_secret'] = '0IxTYM8WpWs4d4INfyN2HLuwcL8NeQICFfgpO87os';



// database table in which to store the user keys

	
//ndot changes
$pre_fix = Kohana::config('database.default');
$tab_prefix = $pre_fix["table_prefix"];

$config['database_table'] = 'twitter_users';

// whether to use native Curl OR the Kohana Curl module
$config['use_kcurl_library'] = False;

// Sets whether to use a cookie to persist logins
$config['use_cookie'] = True;

// storage cookie details
$config['cookie'] = array(
               'name'   => 'KTwitter_Cookie',
               'expire' => '86500',
               'domain' => '.ndot.in',
               'path'   => '/');
