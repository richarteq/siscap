$(document).ready(function(){
	function getdate(){
  	var today = new Date();
    var h = today.getHours();
    if( h<10 ){
    	h = "0"+h
  	}
    var m = today.getMinutes();
    if( m<10 ){
    	m = "0"+m
  	}
    var s = today.getSeconds();
   	if(s<10){
			s = "0"+s;
    }
    $("#reloj").text(h+":"+m+":"+s);
    setTimeout(function(){getdate()}, 500);
  }
	getdate();
});
