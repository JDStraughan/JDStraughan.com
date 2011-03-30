<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array(
		'type'       => 'mysql',
		'connection' => array(
			'hostname'   => '127.0.0.1',
			'username'   => 'jason',
			'password'   => 'asdf',
			'persistent' => FALSE,
			'database'   => 'jdstraughan',
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'backup' => array(
		'type'       => 'mysql',
		'connection' => array(
			'hostname'   => '205.186.146.180',
			'username'   => 'remote',
			'password'   => 'sup3rdup3r!#32',
			'persistent' => FALSE,
			'database'   => 'db_name',
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);