<?php
/*
 * To install:
 *   1. Copy this file to config.php
 *   2. Follow the instructions below to make the app work.
 */

/*
 * Enter your callback URL here. That's the location where index.php
 * resides. Make sure it's your exact root - facebook.com
 * and www.facebook.com are different.
 */
$callback_url     = 'http://192.168.1.99/therunaround/';

/*
 * Get the API key and secret from http://facebook.com/developers
 * Note that each callback URL needs its own app id.
 *
 * Set the callback URL in your developer app to match the one you chose above.
 * This is important so that the Javascript cross-domain library works correctly.
 *
 */
$appapikey = '1943811d592d70875f783fdf2286f413';
$appsecret = 'fb284f74180085fae9b26eb90fe48149';

/*
 * MySQL database connection information.
 *
 * If this doesn't work for you, then write your own
 * MySQL connection function at db_get_custom_conn()
 *
 */

// IP address or hostname of your MySQL database server
$db_host         = 'localhost';

// username for database login
$db_user         = 'root';

// database password for the given user
$db_pass         = 'mysql';


/*
 * Create a new MySQL database (or use an existing one), and then add these tables.
 *

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `name` text,
  `password` text,
  `email` text,
  `fb_uid` int(11) default NULL,
  `email_hash` varchar(64) default NULL,
  PRIMARY KEY `username` (`username`)
);

CREATE TABLE `runs` (
  `username` varchar(255),
  `date` int(11) default NULL,
  `miles` int(11) default NULL,
  `route` text default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
);

Now add the database name here:
*/
//$db_name         = 'therunaround';

// This is the root of the facebook site you'll be hitting. In production, this will be facebook.com
$base_fb_url     = 'connect.facebook.com';

/*
 * The Run Around has a single feed story, which is displayed when you add a run.
 * The feed story template needs to be registered with your app_key, and then just passed
 * at run time. To register the feed bundle for your app, visit:
 *
 * www.yourapp.com/register_feed_forms.php
 *
 * Then copy/paste the resulting feed bundle ID here.
 */
$feed_bundle_id  = 99999999;
