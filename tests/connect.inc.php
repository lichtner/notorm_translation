<?php
error_reporting(E_ALL | E_STRICT);

include_once dirname(__FILE__) . '/../../notorm/NotORM.php';
include_once dirname(__FILE__) . "/../notorm_translator/Trans.php";

$connection = new PDO("mysql:dbname=notorm_trans", "root", "",
		array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"));
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$structure = new NotORM_Trans_Structure($connection);

if (isset($cache)) {
	$_SESSION = array(); // not session_start() - headers already sent
	$cache = new NotORM_Cache_Session;
} else {
	$cache = NULL;
}

$db = new NotORM_Trans($connection, $structure, $cache);
$db->setRowClass('NotORM_Trans_Row');
$db->setLanguages('sk', 'en');


