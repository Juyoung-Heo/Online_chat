<style>
	body {background:#444;}
</style>
<?
	$Conn = mysql_connect("localhost", "DB ID", "DB PW");
	mysql_selectdb("DB NAME");
	$data = mysql_query("SELECT * FROM table ORDER BY no DESC");
	while ($row = mysql_fetch_array($data))
	{
		echo('<div style="background:#777; font-weight:bold; color:#DDD; margin-top:10px; padding:10px;">');
		echo($row['user']."님의 말 ▶".$row['chat']."<br>");
		echo("</div>");
	}
?>
