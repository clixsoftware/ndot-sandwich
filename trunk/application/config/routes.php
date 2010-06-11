<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * @package  Core
 *
 * Sets the default route to "welcome"
 */
$config['_default'] = 'welcome';
$config['photos/zoom/(.*)/(.*).html'] = 'photos/zoom/$1/$2';
$config['blog/view/(.*)/(.*).html'] = 'blog/view/$1/$2';
$config['blog/category/(.*)_(.*).html'] = 'blog/category/$1/$2';
//$config['video/(.*)_(.*).html'] = 'video/upd_video_view/$1/$2';

$config['notifications.html'] = 'updates/notifications';




  
      
      
