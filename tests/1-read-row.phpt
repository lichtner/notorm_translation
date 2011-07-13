--TEST--
trans read row
--FILE--
<?php
include_once dirname(__FILE__) . "/connect.inc.php";

$article = $db->article[1];
echo "$article[id]; $article[viewed]; $article[title]\n";
?>
--EXPECTF--
1; 10; Prvý článok
