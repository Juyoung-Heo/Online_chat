<?
session_start();
if ( array_key_exists( "username", $_POST ) ) {	//주어진 키와 인덱스가 배열에 존재하는지 확인한다
	$_SESSION["user"] = $_POST["username"];
}
$user = $_SESSION["user"];

if(!$user){
	echo "<script>location.replace('./index.html');</script>";
  }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?php echo( $user ) ?> - Chatting</title>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="chat.js"></script>
<link rel="stylesheet" type="text/css" href="chat.css" />
</head>
<body>
    <header>
        <div id="h_title">CHAT</div></div>
        <div id="h_impor_area">
            <span id="_text">중요글 보기</span>
            <input type="checkbox" onclick="importantShow(this.checked)">
        </div>
    </header>
	<view></view>
	<form id="writeForm" onsubmit="chatManager.write(this); return false;">
	<write>
		<input name="name" id="name" type="hidden" value="<?=$_SESSION["user"]?>">
		<div id="msg" contenteditable="true" spellCheck="false" name="msg"></div>
		<input type="submit" name="btn" id="btn" value="전송">
	</write>
	</form>
	<div id="notice_area">
		<span id="notice_close" onclick="noticeClose(this)">x</span>
		<div id="notice_con"></div>
	</div>
</body>
<script>
	function layoutSetting(){
		$("#msg").css("width", $(document).width()-115+"px");
		$("view").css("height", ($(document).height()-$("header")[0].clientHeight-$("write")[0].clientHeight)+"px");
	}
	layoutSetting();
	$(window).resize(function(){
		layoutSetting();
	});
	var prevHeight = $('#msg')[0].clientHeight;
	if(!checkMobileDevice()){
		$('#msg').on('input change keydown paste',function(e){
			if(e.which == 13){
				e.preventDefault();
				chatManager.write($("#writeForm")[0]);
			}
			$("view").css("height", ($(document).height()-$("header")[0].clientHeight-$("write")[0].clientHeight)+"px");
			var curHeight = $(this)[0].clientHeight;
			if (prevHeight !== curHeight) {
				prevHeight = curHeight;
			}
		});
	}
	$(document).ready(function(){
		$(".message").each(function(){
			this.addEventListener('mousedown', function(e){
				alert(e);
			});
		});
	});
	function checkMobileDevice() {
		var mobileKeyWords = new Array('Android', 'iPhone', 'iPod', 'BlackBerry', 'Windows CE', 'SAMSUNG', 'LG', 'MOT', 'SonyEricsson');
		for (var info in mobileKeyWords) {
			if (navigator.userAgent.match(mobileKeyWords[info]) != null) {
				return true;

			}
		}
		return false;
	}
</script>
</html>