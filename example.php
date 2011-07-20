<?php

/**
 * NotORM translation example usage
 *
 * 1. create mysql database notorm_trans from file tests/database-for-tests.sql
 * 2. set up your pdo
 */

// set path for notorm
include_once dirname(__FILE__) . '/../notorm/NotORM.php';
include_once dirname(__FILE__) . '/notorm_translation/Trans.php';

$connection = new PDO('mysql:dbname=notorm_trans', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"));
$structure = new NotORM_Structure_Trans($connection);

$db = new NotORM_Trans($connection, $structure, new NotORM_Cache_Database($connection));
// $db = new NotORM_Trans($connection, $structure, new NotORM_Cache_Session);
$db->setRowClass('NotORM_Row_Trans');
$db->setLanguages('sk', 'en');
//$db->debug = true;

$article = $db->article[1];
echo "$article[id]; $article[viewed]; $article[title]\n";
