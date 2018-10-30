$(function(){
        $(document).scroll(function(){
            var t = $(document).scrollTop();
            if(t>=$("#news").offset().top-100&&t<$("#news").offset().top+$("#news").height()/2){
                $(".ECode-floatBar").show();
                $("#gundong > li").eq(0).attr("class","on").siblings("li").removeClass("on");
            }else if(t>=$("#sheji").offset().top-100&&t<$("#sheji").offset().top+$("#sheji").height()/2){
                $(".ECode-floatBar").show();
                $("#gundong > li").eq(1).attr("class","on").siblings("li").removeClass("on");
            }else if(t>=$("#services").offset().top&&t<$("#services").offset().top+$("#services").height()/2){
                $(".ECode-floatBar").show();
                $("#gundong > li").eq(2).attr("class","on").siblings("li").removeClass("on");
            }else if(t>=$("#about").offset().top-100&&t<$("#about").offset().top+$("#about").height()/2){
                $(".ECode-floatBar").show();
                $("#gundong > li").eq(3).attr("class","on").siblings("li").removeClass("on");
            }else if(t>=$("#contact").offset().top-100&&t<$("#contact").offset().top+$("#contact").height()/2){
                $(".ECode-floatBar").show();
                $("#gundong > li").eq(4).attr("class","on").siblings("li").removeClass("on");
            }else if(t<=630){
                $(".ECode-floatBar").hide();
            }
        })
        $("#gundong > li").eq(0).click(function(){
            $('html,body').animate({scrollTop:$("#news").offset().top}, 800);   
        })
        $("#gundong > li").eq(1).click(function(){
            $('html,body').animate({scrollTop:$("#sheji").offset().top}, 800); 
        })
        $("#gundong > li").eq(2).click(function(){
            $('html,body').animate({scrollTop:$("#services").offset().top}, 800); 
        })
        $("#gundong > li").eq(3).click(function(){
            $('html,body').animate({scrollTop:$("#about").offset().top}, 800); 
        })
        $("#gundong > li").eq(4).click(function(){
            $('html,body').animate({scrollTop:$("#contact").offset().top}, 800); 
        })
        $("#gundong > li").eq(5).click(function(){
            $('html,body').animate({scrollTop:'0px'}, 800);
        }) 
        $("#gundong > li").mouseover(function(){
        if($(this).attr("class")!="on"){
            $(this).attr("class","hover").siblings("li").removeClass("hover");
        }
        }).mouseout(function(){
            $(this).removeClass("hover");
        })
        $('.flash').imgtransition({

		speed:5000,  //图片切换时间

		animate:1000 //图片切换过渡时间

	});
       

})
 //图片轮播
        $.fn.imgtransition = function(o){

	var defaults = {

		speed : 5000,

		animate : 1000

	};

	o = $.extend(defaults, o);



	return this.each(function(){

		var arr_e = $("li", this);

		arr_e.css({position: "absolute"});

		arr_e.parent().css({margin: "0", padding: "0", "list-style": "none", overflow: "hidden"});



		function shownext(){

			var active = arr_e.filter(".active").length ? arr_e.filter(".active") : arr_e.first();

			var next =  active.next().length ? active.next() : arr_e.first();

			active.css({"z-index": 9});

			next.css({opacity: 0.0, "z-index": 10}).addClass('active').animate({opacity: 1.0}, o.animate, function(){

				active.removeClass('active').css({"z-index": 8});

			});
                        

		}



		arr_e.first().css({"z-index": 9});

		setInterval(function(){

			shownext();

		},o.speed);

		

	});
};
