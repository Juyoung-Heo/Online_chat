<?
    $conn = mysql_connect("localhost", "evayul", "evayul");
    $dbconn = mysql_select_db("evayul", $conn);
    @mysql_query("set names utf8", $conn);


    $mode = $_POST['mode'];

    if($mode=="write"){
        $name = $_POST['name'];
        $msg = $_POST['msg'];
        $sql = "INSERT INTO chat (name, msg, date) VALUES ('$name', '$msg', NOW())";
        $result = mysql_query($sql, $conn);
    }else if($mode=="important"){
        $mid = $_POST['mid'];
        $val = $_POST['val'];
        $sql = "UPDATE chat set imp = '$val' where no = '$mid'";
        $result = mysql_query($sql, $conn);
    }else if($mode=="delete"){
        $mid = $_POST['mid'];
        $sql = "DELETE from chat where no = '$mid'";
        $result = mysql_query($sql, $conn);
    }
?>
