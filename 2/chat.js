
var chatManager = new function(){

	var idle 		= true;
	var interval	= 500;
	var xmlHttp		= new XMLHttpRequest();
	var finalDate	= '';

	// Ajax Setting
	xmlHttp.onreadystatechange = function()
	{
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
		{
			// JSON 포맷으로 Parsing
			res = JSON.parse(xmlHttp.responseText);
			finalDate = res.date;
			
			// 채팅내용 보여주기
			chatManager.show(res.data);
			
			// 중복실행 방지 플래그 OFF
			//idle = true;
		}
	}

	// 채팅내용 가져오기
	this.proc = function()
	{
		// 중복실행 방지 플래그가 ON이면 실행하지 않음
		if(!idle)
		{
			return false;
		}

		// 중복실행 방지 플래그 ON
		idle = false;

		// Ajax 통신
		xmlHttp.open("GET", "proc.php?date=" + encodeURIComponent(finalDate), true);
		xmlHttp.send();
	}

	// 채팅내용 보여주기
	this.show = function(data)
	{

		var mg_cnt=1;
		// 채팅내용 추가
		for(var i=0; i<data.length; i++)
		{
			newMessage = document.createElement("div");
			newMessage.classList.add("message");
			newMessage.id = "mg_"+mg_cnt;

			newMessage.innerHTML = data[i].msg+"<div class='mg_time'>"+data[i].date+"</div>";
			$("view")[0].appendChild(newMessage);
			newMessage.addEventListener('click', function(event){
				if(event.target.children[0])
					event.target.children[event.target.children.length-1].style.display = "block";
			});
			mg_cnt++;
		}

		// 가장 아래로 스크롤
		$("view")[0].scrollTop = $("view")[0].scrollHeight;

		$("#msg").focus();
	}

	// 채팅내용 작성하기
	this.write = function(frm)
	{
		var xmlHttpWrite	= new XMLHttpRequest();
		var name			= frm.name.value;
		var msg				= $("#msg")[0].textContent;
		var param			= [];
		
		// 이름이나 내용이 입력되지 않았다면 실행하지 않음
		if(name.length == 0 || msg.length == 0)
		{
			return false;
		}
		
		// POST Parameter 구축
		param.push("name=" + (name));
		param.push("msg=" + (msg));
				
		// Ajax 통신
		xmlHttpWrite.open("POST", "write.php", true);
		xmlHttpWrite.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttpWrite.send(param.join('&'));
		
		// 내용 입력란 비우기
		$("#msg")[0].textContent = '';

		// 중복실행 방지 플래그 OFF
		idle = true;

		// 채팅내용 갱신
		chatManager.proc();
	}

	// interval에서 지정한 시간 후에 실행
	setInterval(this.proc, interval);
}

var clickedMg;
//오른쪽 마우스
$(document).bind("contextmenu", function(event) {
	if (event.target.classList.contains('message') || event.target.classList.contains('mg_time')){
		event.preventDefault();
		clickedMg = event.target;
		$("div#mg_menu").each(function(){
			this.parentNode.removeChild(this);
		});
		$("<div id='mg_menu'><ul><li onclick='removeMg(clickedMg)'>삭제</li><li onclick='Notice(clickedMg)'>공지</li><li onclick='important(clickedMg)'>중요표시</li></ul></div>")
			.appendTo("body")
			.css({top: event.pageY + "px", left: event.pageX + "px"});
	}
}).bind("click", function(event) {
	$("div#mg_menu").hide();
		$("div#mg_menu_mobile").each(function(){
			this.parentNode.removeChild(this);
		});
});

var mg_cnt=1;
function writeMessage(){
	if($("#msg")[0].innerHTML){
		// newMessage = document.createElement("div");
		// newMessage.classList.add("message");
		// newMessage.id = "mg_"+mg_cnt;

		// var today = new Date();
		// var year = today.getFullYear().toString();
		// var month = (today.getMonth()+1).toString();
		// var day = today.getDate().toString();
		// var mmChars = month.split('');
		// var ddChars = day.split('');
		// var dateString = year + '-' + (mmChars[1]?month:"0"+mmChars[0]) + '-'
		// + (ddChars[1]?day:"0"+ddChars[0]);
		
		// var hour = today.getHours().toString();
		// var minute = today.getMinutes().toString();
		// var hourChars = hour.split('');
		// var minChars = minute.split('');
		// var timeString = (hourChars[1]?hour:"0"+hourChars[0]) + ":" + (minChars[1]?minute:"0"+minChars[0]);         

		// nowTime = dateString + " " +timeString;
		// newMessage.innerHTML = $("#w_textarea")[0].innerHTML+"<div class='mg_time'>"+nowTime+"</div>";
		// $("view")[0].appendChild(newMessage);
		// newMessage.addEventListener('click', function(event){
		// 	if(event.target.children[0])
		// 		event.target.children[event.target.children.length-1].style.display = "block";
		// });
		if(checkMobileDevice()){
			newMessage.addEventListener('dblclick', function(event){
				if (event.target.classList.contains('message') || event.target.classList.contains('mg_time')){
					event.preventDefault();
					clickedMg = event.target;
					$("div#mg_menu_mobile").each(function(){
						this.parentNode.removeChild(this);
					});
					$("<div id='mg_menu_mobile'><ul><li onclick='removeMg(clickedMg)'>삭제</li><li onclick='Notice(clickedMg)'>공지</li><li onclick='important(clickedMg)'>중요표시</li></ul></div>")
						.appendTo("body")
						.css({top: event.pageY + "px", left: event.pageX + "px"});
				}
			});
		}
		mg_cnt++;
		$("#msg")[0].innerHTML = "";
		$("view")[0].scrollTop = $("view")[0].scrollHeight;
	}
	$("#msg").focus();
}

function noticeClose(ele){
	if(confirm("공지사항을 삭제하시겠습니까?") == true){
		ele.parentNode.style.display = "none";
	}else{return;}
}

function removeMg(ele){
	ele.parentNode.removeChild(ele);
}
function Notice(ele){
	$("#notice_area").css('display','block');
	var contents = (ele.innerHTML).split('<');
	$("#notice_con")[0].innerHTML = contents[0];
}
function important(ele){
	if(ele.classList.contains('imp')){
		ele.classList.remove("imp");
	}else{
		ele.classList.add("imp");
	}
}

function importantShow(checked){
	if(checked){
		$(".message").each(function(){
			if(!this.classList.contains('imp')){
				this.style.display = "none";
			}
		});
	}else{
		$(".message").each(function(){
			this.style.display = "block";
		});
	}
}