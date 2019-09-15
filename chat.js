$(document).ready(function () {

mysound=document.getElementById("sound");
function play() {mysound.play()}
var page_number = 1;
$.ajaxSetup({cache: false});
function checkchanges(){
	
	
	//$('#info').append(page_number  + "<br>");
	$.get(
        "getchat.php?page="+page_number,
        {},
        getChat
    );
}

function getChat(textchat) {
	$lots=$("lot", textchat);
	//alert($lots.length);
	for (var i = 0; i < $lots.length; i++){
		var amount = $lots.eq(i).find("item").attr("amount");
		//alert(amount);
		var price = $lots.eq(i).attr("buyout_price");
		var price1 = price/amount;
		var str1 = amount + " - " + price + "<br>";
		
		var ms = new Date();
		var etime= $lots.eq(i).attr("etime") - ms.getTime()/1000;
		etime = etime;
		//var etime = $lots.eq(i).attr("etime") + " - " + ms.getTime() + "<br>";
		hours = Math.floor(etime / (60 * 60));
    	etime = etime % (60 * 60);
	    minutes = Math.floor(etime / 60);
	    etime = hours +":"+ minutes;

		if ((price1<28100)&&(price>0)){
			play();
			//$('body').append(str1);
			$('#info').html(etime+"<br>");
			document.title=etime;
			//return;
		}
		
	}
	if (page_number===1){
		page_number=2;
		checkchanges();
		return
		
	}
	if (page_number===2){
		page_number=25;
		checkchanges();
		return
	}
	if (page_number===25){
		page_number=1;
		setTimeout(checkchanges, 2000);
	}
	
	/*if(~textchat.indexOf("ларец")){
		play();
		//alert("скрабб");
	}else{
		alert(textchat);
	}*/
	//setTimeout(checkchanges, 2000);
	/*alert(textchat.indexOf("Молодой скрабб"));
	alert(textchat);*/
}
setTimeout(checkchanges, 1000);
});
