<?php
 $config['modules'] = array ( MODPATH.'updates',
MODPATH.'blog',
MODPATH.'friends',
MODPATH.'forum',
MODPATH.'inbox',
MODPATH.'news',
MODPATH.'photos',
MODPATH.'video',
MODPATH.'ktwitter',
MODPATH.'lib',
MODPATH.'debug_toolbar',
MODPATH.'admin',
MODPATH.'profile',
MODPATH.'users',
MODPATH.'cms',
MODPATH.'comments',
MODPATH.'thirdparty'
);
$config['search']= array ( 1 => 'answers',
 2 => 'blog',
 5 => 'forum',
 7 => 'inbox',
 8 => 'news',
 9 => 'photos',
 10 => 'video',
 11 => 'profile'
  ); 
  
  
 $config["photos"] = array("profile" => array("width" => 135, "height" => 250), "groups" => array("width" => 135, "height" => 250 ), "album" => array("width" => 600, "height" => 600 ));
 
 $config["thumb"] = array("profile" => array("width" => 40, "height" => 40), "groups" => array("width" => 50, "height" => 50 ), "album" => array("width" => 50, "height" => 50 ));
