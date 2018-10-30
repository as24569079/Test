$(document).ready(function(){
$("#nav li").mouseover(function(){
switch($(this).index()){}
	$(this).find('.subnavbox_index').css("display","block");	
	$(this).find(".btn_index").attr("style","background:#034199;color:#fff");
	})
  
$("#nav").mouseout(function(){
	$(this).find('.subnavbox_index').css("display","none");
	$(this).find("a").removeAttr("style");
	})

/*最新公告*/
function testMove(){
	$(".noticetitle").animate({marginTop:"-=32"},500,function(){
		$(this).css({marginTop:"0px"}).find("li:first").appendTo(this)
	})
}
//setInterval(testMove,3000);
var noticeroll=new String();
noticeroll=setInterval(testMove,3000);

$(".noticetitle").mouseover(function(){
		clearInterval(noticeroll);
	}).mouseout(function(){
		noticeroll=setInterval(testMove,3000);
	});
/*最新公告end*/

//end
});