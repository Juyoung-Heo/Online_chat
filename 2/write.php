<?
$db = mysql_connect("localhost", "evayul", "evayul");
mysql_select_db("evayul", $db);
@mysql_query("set names utf8", $db);

$sql = '
INSERT INTO chat(name, msg, date)
VALUES(
	"' . ($_POST['name']) . '",
	"' . ($_POST['msg']) . '",
	NOW()
)
';
mysql_query($sql, $db);
?>