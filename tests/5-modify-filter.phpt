--TEST--
trans modify row
--FILE--
<?php
include_once dirname(__FILE__) . "/connect.inc.php";

$db->article()->where('id = 1')->update(array('title' => "aaa"));


?>
--EXPECTF--
