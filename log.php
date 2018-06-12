<?
session_start();
    $conn = mysql_connect("localhost", "evayul", "evayul");
	$dbconn = mysql_select_db("evayul", $conn);
    @mysql_query("set names utf8", $conn);
    
    $sql = "SELECT * FROM chat ORDER BY no ASC";
    $result = mysql_query($sql, $conn);

    $mg_cnt=1;
	while ($row = mysql_fetch_array($result))
    {
        $imp = $row['imp'];
        if($_SESSION['user']==$row['name']){
        echo "<div class='message ".$imp."' id='mg_".$row['no']."'>".$row['msg']."<div class='mg_time'>".$row['date']."</div></div>";
        }else{
            if($last_name!=$row['name']){
                echo "<div class='name other ".$imp."'>".$row['name']."</div>";
            }else{
                echo "<div class='name other ".$imp."' style='display:none;'>".$row['name']."</div>";
            }
            echo "<div class='message other ".$imp."' id='mg_".$row['no']."'>".$row['msg']."<div class='mg_time'>".$row['date']."</div></div>";
        }
        $last_name = $row['name'];
        $mg_cnt++;
	}
?>
