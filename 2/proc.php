<?
if(!$_GET['date'])
{
	$_GET['date'] = date('Y-m-d H:i:s');
}

$conn = mysql_connect("localhost", "evayul", "evayul");
$dbconn = mysql_select_db("evayul", $conn);
@mysql_query("set names utf8", $conn);

$sql = 'SELECT * FROM chat';
$result = mysql_query($sql, $conn);

$data = array();
$date = $_GET['date'];

while($v = mysql_fetch_array($result))
{
	$data[] = $v;
	$date = $v['date'];
}

echo json_encode(array('date' => $date, 'data' => $data));
?>