<!DOCTYPE html>
<title>jQuery AJAX</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=3.0, user-scalable=yes"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { //이 HTML도큐먼트가 로드되면 실행되는 함수
	$("#send").click(function() { //#send 의 클릭 이벤트 발생시
		var form_data = { //POST로 보낼 formdata를 ajax형태로 생성해줌.
			name: $("#name").val(),
			msg: $("#msg").val(),
			is_ajax: 1
		};
		$.ajax({ //Jquery에서 지원하는 AJAX
			type: "POST",
			url: "post.php",
            data: form_data,
            success: ajax_request("log.php")
		});
		return false;
	});
});
function ajax_request(url) //이 함수는 Jquery를 사용하지 않은 AJAX
{
	var xhr = new XMLHttpRequest();
	xhr.open('get', url);
	xhr.onreadystatechange = function(){
		if(xhr.readyState === 4){
				if(xhr.status === 200){
				$("#chatLog").html(xhr.responseText);
			}else{
				if (xhr.status != 0)
					alert('Error: '+xhr.status);
			}
		}
	}
	xhr.send(null)
}
var timer = setInterval(function () { //인터벌 500인 타이머 생성후 코드 반복 실행
	ajax_request("log.php"); //0.5초마다 log.php의 내용을 불러온다.
	}, 500);
</script>
<form id="form1" name="form1" action="post.php" method="post">
	<input type='text' id='name' name='name' placeholder="이름"/>
	<input type='text' id='msg' name='msg' placeholder="메세지"/>
	<input type="submit" id="send">
</form>
<div id="chatLog"></div>
</html>
