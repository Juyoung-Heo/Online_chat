<table>
<?
	$conn = mysql_connect("localhost", "evayul", "evayul");
	$dbconn = mysql_select_db("evayul", $conn);
	@mysql_query("set names utf8", $conn);

	$sql = "SELECT * FROM messages order by message_id desc";

	$result = mysql_query($sql, $conn);

	while($row = mysql_fetch_array($result)){?>
		<tr><td><? echo($row[1]) ?></td>
		<td><? echo($row[2]) ?></td></tr>
<?	}
?>
</table>
