--TEST--
trans select result
--FILE--
<?php
include_once dirname(__FILE__) . "/connect.inc.php";
$db->debug = true;

$db->article()->select('title')->fetch();

?>
--EXPECTF--

