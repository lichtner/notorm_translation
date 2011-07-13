<?php

include_once dirname(__FILE__) . '/trans/Trans.php';

$connection = new PDO('mysql:dbname=notorm_trans', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"));
$structure = new NotORM_Trans_Structure($connection);

$db = new NotORM_Trans($connection, $structure, new NotORM_Cache_Database($connection));
$db->setRowClass('NotORM_Trans_Row');
$db->setLanguages('sk', 'en');
$db->debug = true;

$article = $db->article[1];
echo "$article[id]; $article[viewed]; $article[title]\n";
