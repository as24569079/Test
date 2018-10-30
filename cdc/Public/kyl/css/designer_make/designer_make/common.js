$(function(){

	$(".city dl").hover(function(){
		$(this).find("dd").show();
		$(this).find("dt").addClass("hover");
		},function(){
		$(this).find("dd").hide();
		$(this).find("dt").removeClass("hover");
	})
	
	$(".menu li").hover(function(){
		$(this).find("p").show();
		$(this).find("strong a").addClass("hover");
		},function(){
		$(this).find("p").hide();
		$(this).find("strong a").removeClass("hover");
	})


	$(".sideNav li").hover(function(){
		$(this).find("p").show();
		$(this).find("a").addClass("hover");
		},function(){
		$(this).find("p").hide();
		$(this).find("a").removeClass("hover");
	})
	
	$(".apply em").click(function(){
		$(".apply").animate({width:"20px"});
		$(this).hide();
		$(".apply span").show();
	});
	$(".apply span").click(function(){
		$(".apply").animate({width:"100%"});
		$(this).hide();
		$(".apply em").show();
	});
	
	var elm = $('.apply'); 

    var startPos = $(elm).offset().top; 

    $.event.add(window, "scroll", function() { 

        var p = $(window).scrollTop(); 

        if(p>600){
			$(elm).show()
		}
		if(p<600){
			$(elm).hide()
		}

    }); 

})
