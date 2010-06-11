<?php //defined('SYSPATH') or die('No direct script access.');
/**
 * @package  Database
 *
 * Database connection settings, defined as arrays, or "groups". If no group
 * name is used when loading the database library, the group named "default"
 * will be used.
 *
 * Each group can be connected to independently, and multiple groups can be
 * connected at once.
 *
 * Group Options:
 *  benchmark     - Enable or disable database benchmarking
 *  persistent    - Enable or disable a persistent connection
 *  connection    - Array of connection specific parameters; alternatively,
 *                  you can use a DSN though it is not as fast and certain
 *                  characters could create problems (like an '@' character
 *                  in a password):
 *                  'connection'    => 'mysql://dbuser:secret@localhost/kohana'
 *  character_set - Database character set
 *  table_prefix  - Database table prefix
 *  object        - Enable or disable object results
 *  cache         - Enable or disable query caching
 *	escape        - Enable automatic query builder escaping
 */
$config ['default'] = array
(
	'benchmark'     => TRUE,
	'persistent'    => FALSE,
	'connection'    => array
	(
		'type'     => 'mysql',
		'user'     => 'yourmysqlusername',
		'pass'     => 'yourmysqlpassword',
		'host'     => 'yourhostname',
		'port'     => FALSE,
		'socket'   => FALSE,
		'database' => 'yourdbname'
	),
	'character_set' => 'utf8',
	'table_prefix'  => 'yourtableprefix',
	'object'        => TRUE,
	'cache'         => FALSE,
	'escape'        => TRUE
);
//getting details for the users fields for creating users table
$config['usertable']= 'yourusertablename';
$config['uidfield'] = 'youruseridfield';
$config['unamefield'] = 'yourusernamefield';
$config['upass'] = 'youruserpasswordfield';
$config['uemail'] = 'youruseremailidfield';
$config['ustatus'] = 'youruserstatusfield';
$config['utype'] = 'yourusertypefield';
$config['tempath'] = 'yourtmppath';
$config['openid'] = 'open_id';   //facebook unique id will store in this field... 
$config['thirdid'] = 'third_id'; //twitter and openid will store in this field... 
$config['server_path'] = 'yourserverpath';
//for storing temp variables
