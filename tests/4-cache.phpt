--TEST--
trans cache
--FILE--
<?php
$cache = TRUE;
include_once dirname(__FILE__) . "/connect.inc.php";

$db->debug = function($query, $parameters) {
	echo "$query\n";
};

$articles = $db->article();
foreach ($articles->limit(1) as $article) {
	$article['viewed'];
	$article['title'];
}
$articles->__destruct();

$articles = $db->article();
foreach ($articles->limit(1) as $article) {
	$article['viewed'];
	$article['title'];
}

?>
--EXPECTF--
// toto nefunguje, neviem ako doplniť položky z prekladovej tabuľky do cache

SELECT * FROM article
SELECT * FROM article_trans WHERE (article_trans.article_id IN (1, 2)) AND (language IN ('sk', 'en')) ORDER BY article_trans.article_id, language = "en"
SELECT id, viewed FROM article
SELECT article_id, language, title FROM article_trans WHERE (article_trans.article_id IN (1, 2)) AND (language IN ('sk', 'en')) ORDER BY article_trans.article_id, language = "en"
