<?
	session_start();
	
	$conn = mysql_connect("localhost", "evayul", "evayul");
	$dbconn = mysql_select_db("evayul", $conn);
	@mysql_query("set names utf8", $conn);

	$sql = "INSERT INTO messages VALUES (null, '$_SESSION[user]', '$_POST[message]')";
	mysql_query($sql, $conn);
?>
<table>
<?
	$sql = "SELECT * FROM messages";
	$result = mysql_query($sql, $conn);

	while($row = mysql_fetch_array($result)){?>
		<tr><td><? echo($row[1]) ?></td>
		<td><? echo($row[2]) ?></td></tr>
<?	}
?>
</table>
