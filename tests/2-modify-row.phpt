--TEST--
trans modify row
--FILE--
<?php
include_once dirname(__FILE__) . "/connect.inc.php";
$db->debug = function ($query, $params) {
	$params = implode(', ', $params);
	$params = ($params ? " -- $params" : "");
	echo "$query;$params\n";
};

$db->insert('article', array(
	'id' => 100,
	'user_id' => 1,
	'viewed' => 5,
	'title' => 'title sk',
));

$db->article[100]->delete();

// toto ale nefunguje, lebo NotORM_Result neviem podediť a upraviť
//$db->article('id', 100)->delete();

?>
--EXPECTF--
INSERT INTO article (id, user_id, viewed) VALUES (100, 1, 5);
INSERT INTO article_trans (title, article_id, language) VALUES ('title sk', 100, 'sk');
SELECT * FROM article WHERE (id = 100);
SELECT * FROM article_trans WHERE (article_trans.article_id IN (100)) AND (language IN ('sk', 'en')) ORDER BY article_trans.article_id, language = "en" LIMIT 1 OFFSET 0;
DELETE FROM article_trans WHERE (article_id = ?); -- 100
DELETE FROM article WHERE (id = '100');
