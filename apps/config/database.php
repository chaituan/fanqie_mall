<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$active_group = 'default';
$query_builder = TRUE;

$db ['default'] = array (
		'dsn' => '',
		'hostname' => 'localhost',
		'username' => '', // 数据库帐号
		'password' => '', // 数据库密码
		'database' => '',//数据库
		'dbdriver' => 'mysqli',
		'dbprefix' => 'ct_',
		'pconnect' => FALSE,
		'db_debug' => (ENVIRONMENT !== 'production'),
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array (),
		'save_queries' => TRUE 
);
