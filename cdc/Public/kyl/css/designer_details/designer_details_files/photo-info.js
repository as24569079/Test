/* ================================================================ 
This copyright notice must be untouched at all times.
Copyright (c) 2009 Stu Nicholls - stunicholls.com - all rights reserved.
=================================================================== */
//首页设计师图片浮动层
$(document).ready(function(){

$(".wrap div").hover(function() {
	$(this).animate({"top": "-30px"}, 400, "swing");
},function() {
	$(this).stop(true,false).animate({"top": "0px"}, 400, "swing");
});

});//结束


//弹出框关闭
function turnoff(obj){document.getElementById(obj).style.display="none";}

   var IsMousedown, LEFT, TOP, scroll_body;
   
   document.getElementById("Mdown").onmousedown=function(e) {
    scroll_body = document.getElementById("loginBox");
    IsMousedown = true;
    e = e||event;
    LEFT = e.clientX - parseInt(scroll_body.style.left);
    TOP = e.clientY - parseInt(scroll_body.style.top);
    
    document.onmousemove = function(e) {
     e = e||event;
     if (IsMousedown) {
      scroll_body.style.left = e.clientX - LEFT + "px";
      scroll_body.style.top = e.clientY - TOP + "px";
     }
    }
    
    document.onmouseup=function(){
     IsMousedown=false;
    }
   }
	
	
