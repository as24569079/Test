$(function(){
    $("#username-node-slide").mouseover(function(){
        $(this).children(".ng-username-slide").slideDown("fast");
        $(this).children(".username-bar-node-noside").attr("class","ng-bar-node username-bar-node username-bar-node-noside ng-bar-node-hover");
    }).mouseleave(function(){
        $(this).children(".ng-username-slide").slideUp("fast");
        $(this).children(".username-bar-node-noside").attr("class","ng-bar-node username-bar-node username-bar-node-noside");
    })
    $(".myorder-handle").mouseover(function(){
        $(this).children(".myorder-child").slideDown("fast");
        $(this).children(".ng-bar-node-pr5").attr("class","ng-bar-node ng-bar-node-fix touch-href ng-bar-node-pr5 ng-bar-node-hover");
    }).mouseleave(function(){
        $(this).children(".myorder-child").slideUp("fast");
        $(this).children(".ng-bar-node-pr5").attr("class","ng-bar-node ng-bar-node-fix touch-href ng-bar-node-pr5");
    })
    $(".myorder-child").mousemove(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).slideUp("fast");
    })
    $(".mysuning-handle").mouseover(function(){
        $(this).children(".mysuning-child").slideDown("fast");
        $(this).children(".ng-bar-node-pr5").attr("class","ng-bar-node ng-bar-node-fix touch-href ng-bar-node-pr5 ng-bar-node-hover");
    }).mouseleave(function(){
        $(this).children(".mysuning-child").slideUp("fast");
        $(this).children(".ng-bar-node-pr5").attr("class","ng-bar-node ng-bar-node-fix touch-href ng-bar-node-pr5");
    })
    $(".mysuning-child").mousemove(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).slideUp("fast");
    })
    $(".app-down-box").mouseover(function(){
        $(this).children(".mb-down-child").slideDown("fast");
        $(this).children(".touch-href").attr("class","ng-bar-node mb-suning touch-href ng-bar-node-hover");
    }).mouseleave(function(){
        $(this).children(".mb-down-child").slideUp("fast");
        $(this).children(".touch-href").attr("class","ng-bar-node mb-suning touch-href");
        
    })
    var a = 0;
    var i = 0;
    $(".banner > li").mouseover(function(){
        $(".prev-btn").css("opacity","0.6");
        $(".prev-btn").show();
        $(".next-btn").css("opacity","0.6");
        $(".next-btn").show();
    }).mouseout(function(){
        $(".next-btn").hide();
        $(".prev-btn").hide();
    })
    $(".banner-nav > a").mouseover(function(a){
        $(".prev-btn").css("opacity","0.6");
        $(".prev-btn").show();
        $(".next-btn").css("opacity","0.6");
        $(".next-btn").show();
        $(this).attr("class","page-item current").siblings("a").attr("class","page-item");
        if($(this).text()=="1"){
            $(this).parent().parent().siblings().children("li").eq(0).show();
            $(this).parent().parent().siblings().children("li").eq(1).hide();
            $(this).parent().parent().siblings().children("li").eq(2).hide();
            $(this).parent().parent().siblings().children("li").eq(3).hide();
            $(this).parent().parent().siblings().children("li").eq(4).hide();
            $(this).parent().parent().siblings().children("li").eq(5).hide();
            $(this).parent().parent().siblings().children("li").eq(0).css("background","rgb(255, 10, 80)");
            $(this).parent().parent().siblings().children("li").eq(0).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(0).animate({opacity : '1'},"slow");
            clearInterval(Timer);
            i = 0;
            return i;
        }
        if($(this).text()=="2"){
            $(this).parent().parent().siblings().children("li").eq(0).hide();
            $(this).parent().parent().siblings().children("li").eq(1).show();
            $(this).parent().parent().siblings().children("li").eq(2).hide();
            $(this).parent().parent().siblings().children("li").eq(3).hide();
            $(this).parent().parent().siblings().children("li").eq(4).hide();
            $(this).parent().parent().siblings().children("li").eq(5).hide();
            $(this).parent().parent().siblings().children("li").eq(1).css("background","rgb(251, 67, 1)");
            $(this).parent().parent().siblings().children("li").eq(1).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(1).animate({opacity : '1'},"slow");
            clearInterval(Timer);
            i = 1;
            return i;
        }
        if($(this).text()=="3"){
            $(this).parent().parent().siblings().children("li").eq(0).hide();
            $(this).parent().parent().siblings().children("li").eq(1).hide();
            $(this).parent().parent().siblings().children("li").eq(2).show();
            $(this).parent().parent().siblings().children("li").eq(3).hide();
            $(this).parent().parent().siblings().children("li").eq(4).hide();
            $(this).parent().parent().siblings().children("li").eq(5).hide();
            $(this).parent().parent().siblings().children("li").eq(2).css("background","rgb(85, 8, 150)");
            $(this).parent().parent().siblings().children("li").eq(2).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(2).animate({opacity : '1'},"slow");
            clearInterval(Timer);
            i = 2;
            return i;
        }
        if($(this).text()=="4"){
            $(this).parent().parent().siblings().children("li").eq(0).hide();
            $(this).parent().parent().siblings().children("li").eq(1).hide();
            $(this).parent().parent().siblings().children("li").eq(2).hide();
            $(this).parent().parent().siblings().children("li").eq(3).show();
            $(this).parent().parent().siblings().children("li").eq(4).hide();
            $(this).parent().parent().siblings().children("li").eq(5).hide();
            $(this).parent().parent().siblings().children("li").eq(3).css("background","rgb(48, 174, 248)");
            $(this).parent().parent().siblings().children("li").eq(3).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(3).animate({opacity : '1'},"slow");
            clearInterval(Timer);
            i = 3;
            return i;
        }
        if($(this).text()=="5"){
            $(this).parent().parent().siblings().children("li").eq(0).hide();
            $(this).parent().parent().siblings().children("li").eq(1).hide();
            $(this).parent().parent().siblings().children("li").eq(2).hide();
            $(this).parent().parent().siblings().children("li").eq(3).hide();
            $(this).parent().parent().siblings().children("li").eq(4).show();
            $(this).parent().parent().siblings().children("li").eq(5).hide();
            $(this).parent().parent().siblings().children("li").eq(4).css("background","rgb(1, 188, 231)");
            $(this).parent().parent().siblings().children("li").eq(4).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(4).animate({opacity : '1'},"slow"); 
            clearInterval(Timer);
            i = 4;
            return i;
        }
        if($(this).text()=="6"){
            $(this).parent().parent().siblings().children("li").eq(0).hide();
            $(this).parent().parent().siblings().children("li").eq(1).hide();
            $(this).parent().parent().siblings().children("li").eq(2).hide();
            $(this).parent().parent().siblings().children("li").eq(3).hide();
            $(this).parent().parent().siblings().children("li").eq(4).hide();
            $(this).parent().parent().siblings().children("li").eq(5).show();
            $(this).parent().parent().siblings().children("li").eq(5).css("background","rgb(15, 159, 255)");
            $(this).parent().parent().siblings().children("li").eq(5).css("opacity","0.5");
            $(this).parent().parent().siblings().children("li").eq(5).animate({opacity : '1'},"slow");  
            clearInterval(Timer);
            i = 5;
            return i;
        }
    }).mouseout(function(){
        $(".next-btn").hide();
        $(".prev-btn").hide();
        Timer = setInterval(showtime,5000);
    })
    var Timer = setInterval(showtime,5000);
    function showtime(){
        var length = $(".banner-nav > a").length;
        if(i<length){
            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
            if(i==0){
            $(".banner > li").eq(0).show();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
            $(".banner > li").eq(0).css("opacity","0.5");
            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
        }
        if(i==1){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).show();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
            $(".banner > li").eq(1).css("opacity","0.5");
            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
        }
        if(i==2){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).show();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
            $(".banner > li").eq(2).css("opacity","0.5");
            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
        }
        if(i==3){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).show();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
            $(".banner > li").eq(3).css("opacity","0.5");
            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
        }
        if(i==4){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).show();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
            $(".banner > li").eq(4).css("opacity","0.5");
            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
        }
        if(i==5){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).show();
            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
            $(".banner > li").eq(5).css("opacity","0.5");
            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
        }
            i++;
        }else{
            i = 0;
        }
        return i;
    }
    $(".next-btn").mouseover(function(){
        $(".next-btn").show();
        $(".next-btn").css("opacity","1");
        $(".prev-btn").show();
        $(".prev-btn").css("opacity","1");
    }).click(function(){
        clearInterval(Timer);
        var length = $(".banner-nav > a").length;
        if(i<length){
            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
            if(i==0){
            $(".banner > li").eq(0).show();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
            $(".banner > li").eq(0).css("opacity","0.5");
            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
        }
        if(i==1){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).show();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
            $(".banner > li").eq(1).css("opacity","0.5");
            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
        }
        if(i==2){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).show();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
            $(".banner > li").eq(2).css("opacity","0.5");
            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
        }
        if(i==3){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).show();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
            $(".banner > li").eq(3).css("opacity","0.5");
            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
        }
        if(i==4){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).show();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
            $(".banner > li").eq(4).css("opacity","0.5");
            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
        }
        if(i==5){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).show();
            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
            $(".banner > li").eq(5).css("opacity","0.5");
            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
        }
            i++;
        }else{
            i = 0;
        }
        return i;
    }).mouseout(function(){
        Timer = setInterval(showtime,5000);
    })
    var a = 0;
    $(".prev-btn").mouseover(function(){
        $(".next-btn").show();
        $(".next-btn").css("opacity","1");
        $(".prev-btn").show();
        $(".prev-btn").css("opacity","1");
    }).click(function(){
        clearInterval(Timer);
        i--;
        if(i >= 0){
            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
            if(i==0){
            $(".banner > li").eq(0).show();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
            $(".banner > li").eq(0).css("opacity","0.5");
            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
        }
        if(i==1){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).show();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
            $(".banner > li").eq(1).css("opacity","0.5");
            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
        }
        if(i==2){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).show();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
            $(".banner > li").eq(2).css("opacity","0.5");
            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
        }
        if(i==3){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).show();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
            $(".banner > li").eq(3).css("opacity","0.5");
            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
        }
        if(i==4){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).show();
            $(".banner > li").eq(5).hide();
            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
            $(".banner > li").eq(4).css("opacity","0.5");
            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
        }
        if(i==5){
            $(".banner > li").eq(0).hide();
            $(".banner > li").eq(1).hide();
            $(".banner > li").eq(2).hide();
            $(".banner > li").eq(3).hide();
            $(".banner > li").eq(4).hide();
            $(".banner > li").eq(5).show();
            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
            $(".banner > li").eq(5).css("opacity","0.5");
            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
        }
            
        }else{
            i = 6;
        }
        return i;
    }).mouseout(function(){
        Timer = setInterval(showtime,5000);
    })
    $(".infor-nav > li").eq(0).mouseover(function(){
        $(this).attr("class","left current").siblings("li").attr("class","right");
        $(".item-tell").show();
        $(".item-soccer").hide();
    })
    $(".infor-nav > li").eq(1).mouseover(function(){
        $(this).attr("class","right current").siblings("li").attr("class","left");
        $(".item-tell").hide();
        $(".item-soccer").show();
    })
    $(".g-tab-list > li").mouseover(function(){
        $(this).children("div").show();
    }).mouseout(function(){
        $(this).children("div").hide();
    })
    $(".sort-list > li").eq(0).mouseover(function(){
        setTimeout(function(){
            $(this).parent().siblings(".ng-sort-detail").css("width","0px");
            $(this).attr("class","hover").siblings("li").removeClass();
            $(this).parent().siblings(".ng-sort-detail").css("top","40px");
            $(this).parent().siblings(".ng-sort-detail").css("width","998px");
            $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail ng-sort-detail-border");
        },100);
//        $(this).parent().siblings(".ng-sort-detail").mousemove(function(){
//            $(this).siblings().children("li").eq(0).attr("class","hover");
//            $(this).css("top","40px");
//            $(this).css("width","998px");
//            $(this).attr("class","ng-sort-detail ng-sort-detail-border");
//        }).mouseleave(function(){
//            $(this).siblings().children("li").eq(0).removeClass();
//            $(this).css("top","40px");
//            $(this).css("width","0px");
//            $(this).attr("class","ng-sort-detail");
//        })
    }).mouseleave(function(){
        $(this).removeClass();
        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail");
    })
    $(".sort-list > li").eq(1).mouseover(function(){
        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
        $(this).attr("class","hover").siblings("li").removeClass();
        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
        $(this).parent().siblings(".ng-sort-detail").css("width","998px");
        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail ng-sort-detail-border");
        $(this).parent().siblings(".ng-sort-detail").mousemove(function(){
            $(this).siblings().children("li").eq(1).attr("class","hover");
            $(this).css("top","40px");
            $(this).css("width","998px");
            $(this).attr("class","ng-sort-detail ng-sort-detail-border");
        }).mouseleave(function(){
            $(this).siblings().children("li").eq(1).removeClass();
            $(this).css("top","40px");
            $(this).css("width","0px");
            $(this).attr("class","ng-sort-detail");
        })
    }).mouseleave(function(){
        $(this).removeClass();
        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail");
    })
    $(".tab-icon-member").toggle(function(){
        $(".member-white").animate({right : '35px'},"slow");     
        $(".member-white").attr("class","sn-sidebar-member-wrap member-white sn-sidebar-member-show");   
    },function(){
        $(".member-white").animate({right : '-400px'},"slow");     
        $(".member-white").attr("class","sn-sidebar-member-wrap member-white");   
    })
    $(".tab-cart-tip-warp").toggle(function(){
        $(".sn-sidebar-contents").attr("class","sn-sidebar-contents sn-sidebar-contents-show");
        $(".sn-sidebar-contents").animate({right : '35px'},"slow"); 
        $(".sn-sidebar-cart").show();
    },function(){
        $(".sn-sidebar-contents").attr("class","sn-sidebar-contents");
        $(".sn-sidebar-contents").animate({right : '-400px'},"slow"); 
        $(".sn-sidebar-cart").hide();
    })
    $(".sn-sidebar-middle-tabs-top > .sn-sidebar-tab-js").eq(2).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-message sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-47px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-message sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-middle-tabs-bottom > .sn-sidebar-tab-js").eq(0).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-finance sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-47px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-finance sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-middle-tabs-bottom > .sn-sidebar-tab-js").eq(1).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-history sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-47px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-history sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-middle-tabs-bottom > .sn-sidebar-tab-js").eq(2).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-sign sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-47px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-tab-sign sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-bottom-tabs > .sn-sidebar-tab-js").eq(0).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-service sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-73px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-service sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-bottom-tabs > .sn-sidebar-tab-js").eq(1).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-feedback sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-73px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-feedback sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".sn-sidebar-bottom-tabs > .sn-sidebar-tab-js").eq(2).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-code sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(".tab-tip-code-warp").animate({left : '-160px'},"slow"); 
        $(".tab-tip-code-warp").show();
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-code sn-sidebar-tab-js")
        $(".tab-tip-code-warp").animate({left : '0px'},"slow"); 
//        $(".tab-tip-code-warp").hide();
    })
    $(".sn-sidebar-bottom-tabs > .sn-sidebar-tab-js").eq(3).hover(function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-to-top sn-sidebar-tab-js sn-sidebar-tab-hover")
        $(this).children().children("span").animate({left : '-73px'},"slow"); 
    },function(){
        $(this).attr("class","sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-to-top sn-sidebar-tab-js")
        $(this).children().children("span").animate({left : '0px'},"slow"); 
    })
    $(".floor-tab > li").mouseover(function(){
        $(this).attr("class","on").siblings("li").removeClass();
        $(this).children().children("em").attr("class","hover-font").parent().parent().siblings("li").children().children("em").removeClass();
        $(this).children(".up-arrow").show().parent().siblings("li").children(".up-arrow").hide();
    })
    $("#f1 > li").eq(0).mouseover(function(){
        $("#f1-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
    })
    $("#f1 > li").eq(1).mouseover(function(){
        $("#f1-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
    })
    $("#f1 > li").eq(2).mouseover(function(){
        $("#f1-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
    })
    $("#f1 > li").eq(3).mouseover(function(){
        $("#f1-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
    })
    $("#f1 > li").eq(4).mouseover(function(){
        $("#f1-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
    })
    $("#f2 > li").eq(0).mouseover(function(){
        $("#f2-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
    })
    $("#f2 > li").eq(1).mouseover(function(){
        $("#f2-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
    })
    $("#f2 > li").eq(2).mouseover(function(){
        $("#f2-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
    })
    $("#f2 > li").eq(3).mouseover(function(){
        $("#f2-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
    })
    $("#f3 > li").eq(0).mouseover(function(){
        $("#f3-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
    })
    $("#f3 > li").eq(1).mouseover(function(){
        $("#f3-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
    })
    $("#f3 > li").eq(2).mouseover(function(){
        $("#f3-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
    })
    $("#f3 > li").eq(3).mouseover(function(){
        $("#f3-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
    })
    $("#f3 > li").eq(4).mouseover(function(){
        $("#f3-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(0).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(1).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(2).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(3).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(4).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
    })
    $("#f4 > li").eq(5).mouseover(function(){
        $("#f4-main > .g-tab-list").eq(5).show().siblings(".g-tab-list").hide();
    })
    $("#gundong > li").mouseover(function(){
        if($(this).attr("class")!="on"){
            $(this).attr("class","hover").siblings("li").removeClass("hover");
        }
    }).mouseout(function(){
        $(this).removeClass("hover");
    })
    $(".imgzoom-thumb-main > ul > li").mouseover(function(){
        $(this).attr("class","current").siblings("li").removeClass();
        $("#bian").attr("src",$(this).children().children("img").attr("src"));
    })
})
$(document).ready(function(e){
    $(".imgview-main > img").attr("src",$("#bian").attr("src"));
        $("#ding").click(function(){
            $('html,body').animate({scrollTop:'0px'}, 800);
        })
        $(".imgzoom-main").mousemove(function(e){
            $(".imgzoom-shot").show();
            $(".imgzoom-pop").fadeIn("slow");
            $(".imgzoom-pop > img").attr("src",$("#bian").attr("src"));
            var juli = $(".imgzoom-pop").width()- $(".imgzoom-shot").width();
            var width = $(".imgzoom-shot").width();
            var height = $(".imgzoom-shot").height();
            var iX = e.pageX - $(this).offset().left - width/2,
                iY = e.pageY - $(this).offset().top - height/2,	
                MaxX = $(".imgzoom-main").width()-162,
                MaxY = $(".imgzoom-main").height()-162;
//                alert(MaxY)
                iX = iX > 0 ? iX : 0;
                iX = iX < MaxX ? iX : MaxX;
                iY = iY > 0 ? iY : 0;
                iY = iY < MaxY ? iY : MaxY;
            $(".imgzoom-shot").css({left:iX+'px',top:iY+'px'});
            $(".imgzoom-pop > img").css({left:-iX*2+'px',top:-iY*2+'px'});
            $(".imgzoom-shot").animate({opacity:'0.5'},"slow");
        }).mouseleave(function(){
            $(".imgzoom-shot").animate({opacity:'0'},"slow");
            $(".imgzoom-shot").hide();
            $(".imgzoom-pop").fadeOut("slow");
        }).click(function(){
            $(".imgview").fadeIn("slow");
        });
        $("#close").click(function(){
            $(".imgview").fadeOut("slow");
        })
        var number = $(".imgview-count > em").text()*1;
        $(".imgview-thumb-main > ul > li").click(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".imgview-main > img").attr("src",$(this).children().children("img").attr("src"));
            $(".imgview-count").children("em").eq(0).text($(this).attr("alt"));
            number = $(this).attr("alt");
        })
        $(".mask-l").click(function(){
            var lenght = $(".imgview-thumb-main > ul > li").length;
            for(var i=0;i<lenght;i++){
                if($(".imgview-thumb-main > ul > li").eq(i).attr("alt")==number){
//                    number = $(".imgview-thumb-main > ul > li").eq(i).attr("alt");
                    $(".imgview-main > img").attr("src",$(".imgview-thumb-main > ul > li > a > img").eq(i).attr("src"));
                    $(".imgview-count").children("em").eq(0).text($(".imgview-thumb-main > ul > li").eq(i).attr("alt"));
                    $(".imgview-thumb-main > ul > li").eq(i).attr("class","current").siblings("li").removeClass();
                }
            }
            number --;
            if(number <0){
                number=5;
            }
        })
        $(".mask-r").click(function(){
            var lenght = $(".imgview-thumb-main > ul > li").length;
            for(var i=0;i<lenght;i++){
                if($(".imgview-thumb-main > ul > li").eq(i).attr("alt")==number){
//                    number = $(".imgview-thumb-main > ul > li").eq(i).attr("alt");
                    $(".imgview-main > img").attr("src",$(".imgview-thumb-main > ul > li > a > img").eq(i).attr("src"));
                    $(".imgview-count").children("em").eq(0).text($(".imgview-thumb-main > ul > li").eq(i).attr("alt"));
                    $(".imgview-thumb-main > ul > li").eq(i).attr("class","current").siblings("li").removeClass();
                }
            }
            number ++;
            if(number > 5){
                number=1;
            }
        })
        var num = 0;
        $(".l-arrow").click(function(){
            var v_width = $("#lunbo > ul").width();
            num--;
            if(num < 0){
                num=4;
                $("#lunbo").animate({left:-796},"slow")
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
               
            }else{
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
                $("#lunbo").animate({left :'+='+ v_width},"slow")
            };
        })
        $(".r-arrow").click(function(){
            var v_width = $("#lunbo > ul").width();
            num++;
            if(num>4){
                num = 0;
                $("#lunbo").animate({left:0},"slow")
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
            }else{
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
                $("#lunbo").animate({left :'-='+ v_width},"slow")
            }
        })
        $(".text-amount").keyup(function(){
            var num = 0;
            var zj = 0;
            var kc = $(this).siblings(".kc").val();
            if(kc==""){
                alert("商品库存不足!");
                $(this).val("0");
                $(this).siblings(".plus").attr("class","plus no-plus");
            }else{
               if($(this).val()*1>kc*1){
                   alert("商品库存不足!");
                   $(this).val(kc);
                   $(this).siblings("input[name='dx[]']").val(kc);
                   $(this).siblings(".no-minus").attr("class","minus");
                   $(this).siblings(".plus").attr("class","plus no-plus");
                   $(this).siblings("input[name='dx[]']").attr("data-jia",($(this).val()*$(this).siblings(".jg").val()));
                   $(this).parent().parent().siblings(".td-sum").children().children("em").text($(this).val()*$(this).siblings(".jg").val())
                   var l = $("input[name='dx[]']");
                   var duoxuan = $("input[name='dx[]']")
                   for(var i=0;i<duoxuan.length;i++){
                       if(duoxuan.eq(i).is(':checked')){
                            num+=l.eq(i).val()*1
                            zj+=duoxuan.eq(i).attr("data-jia")*1
                       }
                   }
                   $("#yixuan").text(num);
                   $("#cpzj > em").text(zj);
                   var jjj = $(this).val();
                   var jjj_id = $(this).attr("data-id");
                   $.post("upt_gouwuche",{jiage:jjj,id:jjj_id},function(res){
                      
                   },"text")
               } else{
                   if($(this).val()*1==1){
                       $(this).siblings(".minus").attr("class","minus no-minus");
                       $(this).siblings(".plus").attr("class","plus");
                   }else{
                       $(this).siblings(".no-minus").attr("class","minus");
                       $(this).siblings(".plus").attr("class","plus");
                   }
                   $(this).parent().parent().siblings(".td-sum").children().children("em").text($(this).val()*$(this).siblings(".jg").val())
                   $(this).siblings("input[name='dx[]']").attr("data-jia",($(this).val()*$(this).siblings(".jg").val()));
                   $(this).siblings("input[name='dx[]']").val($(this).val());
                   var l = $("input[name='dx[]']");
                   var duoxuan = $("input[name='dx[]']")
                   for(var i=0;i<duoxuan.length;i++){
                       if(duoxuan.eq(i).is(':checked')){
                            num+=l.eq(i).val()*1
                            zj+=duoxuan.eq(i).attr("data-jia")*1
                       }
                   }
                   $("#yixuan").text(num);
                   $("#cpzj > em").text(zj);
                   var jjj = $(this).val();
                   var jjj_id = $(this).attr("data-id");
     
                   $.post("upt_gouwuche",{jiage:jjj,id:jjj_id},function(res){
                  
                   },"text")
               }
            }
        })
        $(".plus").click(function(){
            var kc = $(this).siblings(".kc").val();
            var num = $(this).parent().parent().siblings(".td-sum").children().children("em").text()
            if($(this).parent().parent().siblings(".form").find(".chk-item").is(':checked')){
                $(this).siblings(".text-amount").css("color","#fff");
                if($(this).siblings(".text-amount").val()*1<kc*1){
                    $(this).siblings(".no-minus").attr("class","minus");
                    $(this).parent(".item-amount").css("position",'relative');
                    $(this).parent(".item-amount").append("<span style='position: absolute;left:98px;width: 26px;height: 22px;line-height: 22px;text-align: center;top:0;z-index: 2;' class='num-bian'></span>")
                    $(this).parent(".item-amount").append("<span style='position: absolute;left:98px;width: 26px;height: 22px;line-height: 22px;text-align: center;top:22px;z-index: 2;' class='num-xia'></span>")
                    $(this).siblings(".num-bian").text($(this).siblings(".text-amount").val()*1+1*1);
                    $(this).siblings(".num-xia").text($(this).siblings(".text-amount").val()*1+1*1);
                    $(this).siblings(".text-amount").val($(this).siblings(".text-amount").val()*1+1*1);
                    $(this).parent().parent().siblings(".td-sum").children().children("em").text(num*1+$(this).siblings(".jg").val()*1);
                    $(this).siblings("input[name='dx[]']").attr("data-jia",(num*1+$(this).siblings(".jg").val()*1));
                    $(this).siblings(".num-xia").animate({top:'0px'},"normal",function(){
                        $(this).parent(".item-amount").children(".num-xia").remove();
                        $(".item-amount").css("position",'');
                        $(".text-amount").css("color","rgb(102, 102, 102)");
                    })
                    $(this).siblings(".num-bian").animate({top:'-22px'},"normal",function(){
                        $(this).parent(".item-amount").children(".num-bian").remove();
                        $(".item-amount").css("position",'');
                        $(".text-amount").css("color","rgb(102, 102, 102)");
                    });
                    var zhi = $(this).siblings(".jg").val();
                    $("#cpzj > em").text($("#cpzj > em").text()*1 + zhi*1);
                    $("#yixuan").text($("#yixuan").text()*1+1);
                    $(this).siblings("input[name='dx[]']").val($(this).siblings(".text-amount").val());
                        var jjj = $(this).siblings(".text-amount").val()
                       var jjj_id = $(this).siblings(".text-amount").attr("data-id");

                       $.post("upt_gouwuche",{jiage:jjj,id:jjj_id},function(res){

                       },"text")
                }else{
                    alert("商品库存不足!");
                    $(this).attr("class","plus no-plus");
                    $(".text-amount").css("color","rgb(102, 102, 102)");
                    $(this).siblings(".no-minus").attr("class","minus");
                     var jjj = $(this).siblings(".text-amount").val()
                       var jjj_id = $(this).siblings(".text-amount").attr("data-id");

                       $.post("upt_gouwuche",{jiage:jjj,id:jjj_id},function(res){

                       },"text")
                }
            }
        })
        $(".no-minus").click(function(){
            var num = $(this).parent().parent().siblings(".td-sum").children().children("em").text();
            if($(this).parent().parent().siblings(".form").find(".chk-item").is(':checked')){
                $(this).siblings(".text-amount").css("color","#fff");
                if($(this).siblings(".text-amount").val()<=1){
                    $(this).attr("class","minus no-minus");
                    $(".text-amount").css("color","rgb(102, 102, 102)");
                }else{
                    $(this).parent(".item-amount").css("position",'relative');
                    $(this).parent(".item-amount").append("<span style='position: absolute;left:98px;width: 26px;height: 22px;line-height: 22px;text-align: center;top:0;z-index: 2;' class='num-bian'></span>")
                    $(this).parent(".item-amount").append("<span style='position: absolute;left:98px;width: 26px;height: 22px;line-height: 22px;text-align: center;top:-22px;z-index: 2;' class='num-xia'></span>")
                    $(this).siblings(".text-amount").val($(this).siblings(".text-amount").val()*1-1*1);
                    $(this).siblings(".num-bian").text($(this).siblings(".text-amount").val()*1);
                    $(this).siblings(".num-xia").text($(this).siblings(".text-amount").val()*1);
                    $(this).parent().parent().siblings(".td-sum").children().children("em").text(num*1-$(this).siblings(".jg").val()*1);
                    $(this).siblings("input[name='dx[]']").attr("data-jia",(num*1-$(this).siblings(".jg").val()*1));
                    $(this).siblings(".num-xia").animate({top:'0px'},"normal",function(){
                        $(this).parent(".item-amount").children(".num-xia").remove();
                        $(".item-amount").css("position",'');
                        $(".text-amount").css("color","rgb(102, 102, 102)");
                    })
                    $(this).siblings(".num-bian").animate({top:'22px'},"normal",function(){
                        $(this).parent(".item-amount").children(".num-bian").remove();
                        $(".item-amount").css("position",'');
                        $(".text-amount").css("color","rgb(102, 102, 102)");
                    });
                    var zhi = $(this).siblings(".jg").val();
                    $("#cpzj > em").text($("#cpzj > em").text()*1- zhi*1);
                    $("#yixuan").text($("#yixuan").text()*1-1);
                    $(this).siblings("input[name='dx[]']").val($(this).siblings(".text-amount").val());
                     var jjj = $(this).siblings(".text-amount").val()
                       var jjj_id = $(this).siblings(".text-amount").attr("data-id");

                       $.post("upt_gouwuche",{jiage:jjj,id:jjj_id},function(res){

                       },"text")
                }
            }
        })
        var num=0;
        $(".cart-checkbox-checked").eq(0).click(function(){
            var l = $(".chk-item");
            var ck = $(".ck > label");
            var ck2 = $(".ck > input[name='yanse[]']");
            var a = 0;
            if(num %2==0){
                $(this).children("label").attr("class","beijingyin");
                $(this).children("label").append("<i class='tubiao'></i>");
                $(this).children(".J-AllCheckBox").removeAttr("checked");
                $("#qx").attr("class","cart-checkbox");
                $("#qx").children(".J-AllCheckBox").removeAttr("checked");
                for(var i=0;i<l.length;i++){
                    l.eq(i).removeAttr("checked");
                    ck2.eq(i).removeAttr("checked");
                    ck.eq(i).attr("class","beijingyin");
                    ck.eq(i).append("<i class='tubiao'></i>");
                    $("input[name='dx[]']").eq(i).removeAttr("checked");
                }
                $("#cpzj > em").text("0");
                $("#yixuan").text("0");
            }else{
                $(this).children("label").children("i").remove();
                $(this).children("label").attr("class","beijing");
                $(this).children(".J-AllCheckBox").attr("checked","checked");
                $("#qx").children(".J-AllCheckBox").attr("checked","checked");
                $("#qx").attr("class","cart-checkbox cart-checkbox-checked");
                for(var i=0;i<l.length;i++){
                    l.eq(i).attr("checked","checked");
                    ck2.eq(i).attr("checked","checked");
                    ck.eq(i).attr("class","beijing");
                    ck.eq(i).children("i").remove();
                    $("input[name='dx[]']").eq(i).attr("checked","checked");
                }
                var zj = $("input[name='dx[]']");
                var zjnum = 0;
                for(var i=0;i<zj.length;i++){
                    zjnum+=zj.eq(i).attr("data-jia")*1;
                }
                $("#cpzj > em").text(zjnum);
                var sl = $(".text-amount");
                var slnum=0
                for(var i=0;i<sl.length;i++){
                    slnum+=sl.eq(i).val()*1;
                }
                $("#yixuan").text(slnum);
            }
            num++;
            for(var i=0;i<l.length;i++){
                    if(l.eq(i).is(':checked')){
                        a = 1;
                    }
            }
            if(a==1){
                $("#jiesuan").attr("class","checkout");
            }else{
               $("#jiesuan").attr("class","checkout cart-btn checkout-disable-tip");
            }
        })
        $(".cart-checkbox-checked").eq(1).click(function(){
            var l = $(".chk-item");
            var ck2 = $(".ck > input[name='yanse[]']");
            var ck = $(".ck > label");
            var a = 0;
            if(num %2==0){
                for(var i=0;i<l.length;i++){
                    l.eq(i).removeAttr("checked");
                    ck2.eq(i).removeAttr("checked");
                    ck.eq(i).attr("class","beijingyin");
                    ck.eq(i).append("<i class='tubiao'></i>");
                    $("input[name='dx[]']").eq(i).removeAttr("checked");
                }
                $(this).attr("class","cart-checkbox");
                $(this).children(".J-AllCheckBox").removeAttr("checked");
                $(".cart-checkbox-checked").eq(0).children("label").attr("class","beijingyin");
                $(".cart-checkbox-checked").eq(0).children("label").append("<i class='tubiao'></i>");
                $(".cart-checkbox-checked").eq(0).children(".J-AllCheckBox").removeAttr("checked");
                $("#yixuan").text("0");
                $("#cpzj > em").text("0");
            }else{
                $(this).attr("class","cart-checkbox cart-checkbox-checked");
                $(this).children(".J-AllCheckBox").attr("checked","checked");
                $(".cart-checkbox-checked").eq(0).children(".J-AllCheckBox").attr("checked","checked");
                $(".cart-checkbox-checked").eq(0).children("label").attr("class","beijing");
                $(".cart-checkbox-checked").eq(0).children("label").children("i").remove();
                for(var i=0;i<l.length;i++){
                    l.eq(i).attr("checked","checked");
                    ck2.eq(i).attr("checked","checked");
                    ck.eq(i).attr("class","beijing");
                    ck.eq(i).children("i").remove();
                    $("input[name='dx[]']").eq(i).attr("checked","checked");
                }
                var zj = $("input[name='dx[]']");
                var zjnum = 0;
                for(var i=0;i<zj.length;i++){
                    zjnum+=zj.eq(i).attr("data-jia")*1;
                }
                $("#cpzj > em").text(zjnum);
                var sl = $(".text-amount");
                var slnum=0
                for(var i=0;i<sl.length;i++){
                    slnum+=sl.eq(i).val()*1;
                }
                $("#yixuan").text(slnum);
            }
            num++;
            for(var i=0;i<l.length;i++){
                    if(l.eq(i).is(':checked')){
                        a = 1;
                    }
            }
            if(a==1){
                $("#jiesuan").attr("class","checkout");
            }else{
               $("#jiesuan").attr("class","checkout cart-btn checkout-disable-tip");
            }
        })
        $(".ck").click(function(){
            if($(this).children(".chk-item").is(":checked")){
                $(this).children("label").attr("class","beijingyin");
                $(this).children("label").append("<i class='tubiao'></i>");
                $(this).children(".chk-item").removeAttr("checked");
                $(this).children("input[name='yanse[]']").removeAttr("checked");
                $(this).parent().siblings(".td-amount").find("input[name='dx[]']").removeAttr("checked");
                $("#yixuan").text($("#yixuan").text()*1-$(this).parent().siblings(".td-amount").find(".text-amount").val()*1);
                var zhi = $(this).parent().siblings(".td-amount").find("input[name='dx[]']").attr("data-jia");
                $("#cpzj > em").text($("#cpzj > em").text()*1- zhi*1);
                var id = $(this).attr("data-id");
                var biao = 0;
                $.post("duoxuan_gai",{id:id,biao:biao},function(res){
                    
                })
            }else{
                $(this).children("label").children("i").remove();
                $(this).children("label").attr("class","beijing");
                $(this).children(".chk-item").attr("checked","checked");
                $(this).children("input[name='yanse[]']").attr("checked","checked");
                $(this).parent().siblings(".td-amount").find("input[name='dx[]']").attr("checked","checked");
                $("#yixuan").text($("#yixuan").text()*1+$(this).parent().siblings(".td-amount").find(".text-amount").val()*1);
                var zhi = $(this).parent().siblings(".td-amount").find("input[name='dx[]']").attr("data-jia");
                $("#cpzj > em").text($("#cpzj > em").text()*1 + zhi*1);
                var id = $(this).attr("data-id");
                var biao = 1;
                $.post("duoxuan_gai",{id:id,biao:biao},function(res){
                    
                })
            }
            var l = $(".chk-item");
            var a = 0;
            for(var i=0;i<l.length;i++){
                    if(l.eq(i).is(':checked')){
                        a = 1;
                    }
            }
            if(a==1){
                $("#jiesuan").attr("class","checkout");
            }else{
               $("#jiesuan").attr("class","checkout cart-btn checkout-disable-tip");
            }
        })
        $("#quandel").click(function(){
            var l = $(".chk-item");
            var num = 0;
            for(var i=0;i<l.length;i++){
                if(l.eq(i).is(':checked')){
                   num = 1;
                }
            }
            if(num==1){
                $("#scts").show();
            }else{
                $("#wqz").show();
                $("#wqz").animate({opacity:1},"slow",function(){
                     $("#wqz").animate({opacity:0},"slow",function(){
                         $("#wqz").hide();
                     });
                })
            }
        })
        $(".cart-btn-cancel").click(function(){
            $("#scts").hide();
        })
        $(".item-checked").mouseenter(function(){
            $(this).children(".clearfix").children(".td-op").children(".tip-common-click-fn-btn").eq(1).show();
            $(this).children(".clearfix").children(".td-op").children(".tip-look-alike ").show();
        }).mouseleave(function(){
            $(this).children(".clearfix").children(".td-op").children(".tip-common-click-fn-btn").eq(1).hide();
            $(this).children(".clearfix").children(".td-op").children(".tip-look-alike ").hide();
        })
        $(".clr-item").click(function(){
            $("#yanse").val($(this).attr("data-val"));
            $(this).attr("class","clr-item selected").siblings("li").attr("class","clr-item");
            $(".tzm-border").hide(); 
            $("#gouguan").hide();
        })
        $("#gouguan").click(function(){
            $(".tzm-border").hide(); 
            $("#gouguan").hide();
        })
        $(".tabarea-items > li").eq(0).click(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".J-procon-desc").show();
            $("#mt11").show();
            $("#mt10").show();
            $("#mt9").hide();
        })
        $(".tabarea-items > li").eq(1).click(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".J-procon-desc").hide();
            $("#mt11").show();
            $("#mt10").show();
            $("#mt9").show();
        })
        $(".tabarea-items > li").eq(2).click(function(){
            $("#mt10").show();
            $(this).attr("class","current").siblings("li").removeClass();
            $(".J-procon-desc").hide();
            $("#mt9").hide();
        })
        $(".tabarea-items > li").eq(3).click(function(){
            $("#mt11").show();
            $(this).attr("class","current").siblings("li").removeClass();
            $("#mt10").hide();
            $("#mt9").hide();
            $(".J-procon-desc").hide();
        })
        var page = 0;
        $(".page-list > ul > li").mouseenter(function(){
            $(this).attr("class","current").siblings("li").removeClass();
        })
        $(".page-list > ul > li").eq(0).mouseover(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".list-box").animate({left:'0px'},"slow");
            page = 0;
        })
        $(".page-list > ul > li").eq(1).mouseover(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".list-box").animate({left:'-1150px'},"slow");
            page = 1;
        })
        $(".page-list > ul > li").eq(2).mouseover(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".list-box").animate({left:'-2300px'},"slow");
            page = 2;
        })
        $(".page-list > ul > li").eq(3).mouseover(function(){
            $(this).attr("class","current").siblings("li").removeClass();
            $(".list-box").animate({left:'-3450px'},"slow");
            page = 3;
        })
        $(".prev").click(function(){
            page --;
            if(page < 0){
                page = 3;
                $(".list-box").animate({left:'-3450px'},"slow");
                $(".page-list > ul > li").eq(page).attr("class","current").siblings("li").removeClass();
            }else{
                $(".list-box").animate({left:'+=1150px'},"slow");
                $(".page-list > ul > li").eq(page).attr("class","current").siblings("li").removeClass();
            } 
        })
        $(".next").click(function(){
            page++;
            if(page < 4){
                $(".list-box").animate({left:'-=1150px'},"slow");
                $(".page-list > ul > li").eq(page).attr("class","current").siblings("li").removeClass();
            }else{
                $(".list-box").animate({left:'0px'},"slow");
                page = 0;
                $(".page-list > ul > li").eq(page).attr("class","current").siblings("li").removeClass();
            }
        })
        $(".ui-tooltip-close").click(function(){
            $(this).parent(".alike-prolist-tip").hide("slow");
            $(".list-box").children().remove();
        })
        $("#biaoti > li").eq(0).mouseover(function(){
            $(this).attr("class","recommend-name-box active").siblings("li").attr("class","recommend-name-box");
            $("#cnxh").show();
            $("#scb").hide();
            $(".tj-arr-prev").show();
            $(".tj-arr-next").show();
            $(".page-list").show();
        })
        $("#biaoti > li").eq(1).mouseover(function(){
            $(this).attr("class","recommend-name-box active").siblings("li").attr("class","recommend-name-box");
            $("#cnxh").hide();
            $("#scb").show();
            $(".tj-arr-prev").hide();
            $(".tj-arr-next").hide();
            $(".page-list").hide();
        })
        $(".tj-arr-prev").toggle(function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").show();
            $("#lunbo > ul > li").eq(3).attr("class","current").siblings("li").removeClass();
            
        },function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").show();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(2).attr("class","current").siblings("li").removeClass();
        },function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").show();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(1).attr("class","current").siblings("li").removeClass();
        },function(){
            $(".product-box:lt(10)").show(); 
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(0).attr("class","current").siblings("li").removeClass();
        })
        $(".tj-arr-next").toggle(function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").show();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(1).attr("class","current").siblings("li").removeClass();
        },function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").show();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(2).attr("class","current").siblings("li").removeClass();
        },function(){
            $(".product-box:lt(10)").hide();
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").show();
            $("#lunbo > ul > li").eq(3).attr("class","current").siblings("li").removeClass();
        },function(){
            $(".product-box:lt(10)").show(); 
            $(".product-box:lt(20):gt(9)").hide();
            $(".product-box:lt(30):gt(19)").hide();
            $(".product-box:lt(40):gt(29)").hide();
            $("#lunbo > ul > li").eq(0).attr("class","current").siblings("li").removeClass();
        })
})

    