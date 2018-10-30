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
//    var a = 0;
//    var i = 0;
//    $(".banner > li").mouseover(function(){
//        $(".prev-btn").css("opacity","0.6");
//        $(".prev-btn").show();
//        $(".next-btn").css("opacity","0.6");
//        $(".next-btn").show();
//    }).mouseout(function(){
//        $(".next-btn").hide();
//        $(".prev-btn").hide();
//    })
//    $(".banner-nav > a").mouseover(function(a){
//        $(".prev-btn").css("opacity","0.6");
//        $(".prev-btn").show();
//        $(".next-btn").css("opacity","0.6");
//        $(".next-btn").show();
//        $(this).attr("class","page-item current").siblings("a").attr("class","page-item");
//        if($(this).text()=="1"){
//            $(this).parent().parent().siblings().children("li").eq(0).show();
//            $(this).parent().parent().siblings().children("li").eq(1).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).hide();
//            $(this).parent().parent().siblings().children("li").eq(5).hide();
//            $(this).parent().parent().siblings().children("li").eq(0).css("background","rgb(255, 10, 80)");
//            $(this).parent().parent().siblings().children("li").eq(0).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(0).animate({opacity : '1'},"slow");
//            clearInterval(Timer);
//            i = 0;
//            return i;
//        }
//        if($(this).text()=="2"){
//            $(this).parent().parent().siblings().children("li").eq(0).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).show();
//            $(this).parent().parent().siblings().children("li").eq(2).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).hide();
//            $(this).parent().parent().siblings().children("li").eq(5).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).css("background","rgb(251, 67, 1)");
//            $(this).parent().parent().siblings().children("li").eq(1).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(1).animate({opacity : '1'},"slow");
//            clearInterval(Timer);
//            i = 1;
//            return i;
//        }
//        if($(this).text()=="3"){
//            $(this).parent().parent().siblings().children("li").eq(0).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).show();
//            $(this).parent().parent().siblings().children("li").eq(3).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).hide();
//            $(this).parent().parent().siblings().children("li").eq(5).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).css("background","rgb(85, 8, 150)");
//            $(this).parent().parent().siblings().children("li").eq(2).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(2).animate({opacity : '1'},"slow");
//            clearInterval(Timer);
//            i = 2;
//            return i;
//        }
//        if($(this).text()=="4"){
//            $(this).parent().parent().siblings().children("li").eq(0).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).show();
//            $(this).parent().parent().siblings().children("li").eq(4).hide();
//            $(this).parent().parent().siblings().children("li").eq(5).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).css("background","rgb(48, 174, 248)");
//            $(this).parent().parent().siblings().children("li").eq(3).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(3).animate({opacity : '1'},"slow");
//            clearInterval(Timer);
//            i = 3;
//            return i;
//        }
//        if($(this).text()=="5"){
//            $(this).parent().parent().siblings().children("li").eq(0).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).show();
//            $(this).parent().parent().siblings().children("li").eq(5).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).css("background","rgb(1, 188, 231)");
//            $(this).parent().parent().siblings().children("li").eq(4).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(4).animate({opacity : '1'},"slow"); 
//            clearInterval(Timer);
//            i = 4;
//            return i;
//        }
//        if($(this).text()=="6"){
//            $(this).parent().parent().siblings().children("li").eq(0).hide();
//            $(this).parent().parent().siblings().children("li").eq(1).hide();
//            $(this).parent().parent().siblings().children("li").eq(2).hide();
//            $(this).parent().parent().siblings().children("li").eq(3).hide();
//            $(this).parent().parent().siblings().children("li").eq(4).hide();
//            $(this).parent().parent().siblings().children("li").eq(5).show();
//            $(this).parent().parent().siblings().children("li").eq(5).css("background","rgb(15, 159, 255)");
//            $(this).parent().parent().siblings().children("li").eq(5).css("opacity","0.5");
//            $(this).parent().parent().siblings().children("li").eq(5).animate({opacity : '1'},"slow");  
//            clearInterval(Timer);
//            i = 5;
//            return i;
//        }
//    }).mouseout(function(){
//        $(".next-btn").hide();
//        $(".prev-btn").hide();
//        Timer = setInterval(showtime,5000);
//    })
//    var Timer = setInterval(showtime,5000);
//    function showtime(){
//        var length = $(".banner-nav > a").length;
//        if(i<length){
//            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
//            if(i==0){
//            $(".banner > li").eq(0).show();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
//            $(".banner > li").eq(0).css("opacity","0.5");
//            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
//        }
//        if(i==1){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).show();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
//            $(".banner > li").eq(1).css("opacity","0.5");
//            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
//        }
//        if(i==2){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).show();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
//            $(".banner > li").eq(2).css("opacity","0.5");
//            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
//        }
//        if(i==3){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).show();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
//            $(".banner > li").eq(3).css("opacity","0.5");
//            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
//        }
//        if(i==4){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).show();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
//            $(".banner > li").eq(4).css("opacity","0.5");
//            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
//        }
//        if(i==5){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).show();
//            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
//            $(".banner > li").eq(5).css("opacity","0.5");
//            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
//        }
//            i++;
//        }else{
//            i = 0;
//        }
//        return i;
//    }
//    $(".next-btn").mouseover(function(){
//        $(".next-btn").show();
//        $(".next-btn").css("opacity","1");
//        $(".prev-btn").show();
//        $(".prev-btn").css("opacity","1");
//    }).click(function(){
//        clearInterval(Timer);
//        var length = $(".banner-nav > a").length;
//        if(i<length){
//            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
//            if(i==0){
//            $(".banner > li").eq(0).show();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
//            $(".banner > li").eq(0).css("opacity","0.5");
//            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
//        }
//        if(i==1){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).show();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
//            $(".banner > li").eq(1).css("opacity","0.5");
//            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
//        }
//        if(i==2){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).show();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
//            $(".banner > li").eq(2).css("opacity","0.5");
//            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
//        }
//        if(i==3){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).show();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
//            $(".banner > li").eq(3).css("opacity","0.5");
//            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
//        }
//        if(i==4){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).show();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
//            $(".banner > li").eq(4).css("opacity","0.5");
//            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
//        }
//        if(i==5){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).show();
//            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
//            $(".banner > li").eq(5).css("opacity","0.5");
//            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
//        }
//            i++;
//        }else{
//            i = 0;
//        }
//        return i;
//    }).mouseout(function(){
//        Timer = setInterval(showtime,5000);
//    })
//    var a = 0;
//    $(".prev-btn").mouseover(function(){
//        $(".next-btn").show();
//        $(".next-btn").css("opacity","1");
//        $(".prev-btn").show();
//        $(".prev-btn").css("opacity","1");
//    }).click(function(){
//        clearInterval(Timer);
//        i--;
//        if(i >= 0){
//            $(".banner-nav > a").eq(i).attr("class","page-item current").siblings("a").attr("class","page-item"); 
//            if(i==0){
//            $(".banner > li").eq(0).show();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(0).css("background","rgb(255, 10, 80)");
//            $(".banner > li").eq(0).css("opacity","0.5");
//            $(".banner > li").eq(0).animate({opacity : '1'},"slow");
//        }
//        if(i==1){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).show();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(1).css("background","rgb(251, 67, 1)");
//            $(".banner > li").eq(1).css("opacity","0.5");
//            $(".banner > li").eq(1).animate({opacity : '1'},"slow");
//        }
//        if(i==2){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).show();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(2).css("background","rgb(85, 8, 150)");
//            $(".banner > li").eq(2).css("opacity","0.5");
//            $(".banner > li").eq(2).animate({opacity : '1'},"slow");
//        }
//        if(i==3){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).show();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(3).css("background","rgb(48, 174, 248)");
//            $(".banner > li").eq(3).css("opacity","0.5");
//            $(".banner > li").eq(3).animate({opacity : '1'},"slow");
//        }
//        if(i==4){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).show();
//            $(".banner > li").eq(5).hide();
//            $(".banner > li").eq(4).css("background","rgb(1, 188, 231)");
//            $(".banner > li").eq(4).css("opacity","0.5");
//            $(".banner > li").eq(4).animate({opacity : '1'},"slow"); 
//        }
//        if(i==5){
//            $(".banner > li").eq(0).hide();
//            $(".banner > li").eq(1).hide();
//            $(".banner > li").eq(2).hide();
//            $(".banner > li").eq(3).hide();
//            $(".banner > li").eq(4).hide();
//            $(".banner > li").eq(5).show();
//            $(".banner > li").eq(5).css("background","rgb(15, 159, 255)");
//            $(".banner > li").eq(5).css("opacity","0.5");
//            $(".banner > li").eq(5).animate({opacity : '1'},"slow"); 
//        }
//            
//        }else{
//            i = 6;
//        }
//        return i;
//    }).mouseout(function(){
//        Timer = setInterval(showtime,5000);
//    })
//    $(".infor-nav > li").eq(0).mouseover(function(){
//        $(this).attr("class","left current").siblings("li").attr("class","right");
//        $(".item-tell").show();
//        $(".item-soccer").hide();
//    })
//    $(".infor-nav > li").eq(1).mouseover(function(){
//        $(this).attr("class","right current").siblings("li").attr("class","left");
//        $(".item-tell").hide();
//        $(".item-soccer").show();
//    })
    $(".g-tab-list > li").mouseover(function(){
        $(this).children("div").show();
    }).mouseout(function(){
        $(this).children("div").hide();
    })
////    $(".sort-list > li").eq(0).mouseover(function(){
//        setTimeout(function(){
//            $(this).parent().siblings(".ng-sort-detail").css("width","0px");
//            $(this).attr("class","hover").siblings("li").removeClass();
//            $(this).parent().siblings(".ng-sort-detail").css("top","40px");
//            $(this).parent().siblings(".ng-sort-detail").css("width","998px");
//            $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail ng-sort-detail-border");
//        },100);
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
//    }).mouseleave(function(){
//        $(this).removeClass();
//        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
//        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
//        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail");
//    })
//    $(".sort-list > li").eq(1).mouseover(function(){
//        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
//        $(this).attr("class","hover").siblings("li").removeClass();
//        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
//        $(this).parent().siblings(".ng-sort-detail").css("width","998px");
//        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail ng-sort-detail-border");
//        $(this).parent().siblings(".ng-sort-detail").mousemove(function(){
//            $(this).siblings().children("li").eq(1).attr("class","hover");
//            $(this).css("top","40px");
//            $(this).css("width","998px");
//            $(this).attr("class","ng-sort-detail ng-sort-detail-border");
//        }).mouseleave(function(){
//            $(this).siblings().children("li").eq(1).removeClass();
//            $(this).css("top","40px");
//            $(this).css("width","0px");
//            $(this).attr("class","ng-sort-detail");
//        })
//    }).mouseleave(function(){
//        $(this).removeClass();
//        $(this).parent().siblings(".ng-sort-detail").css("top","40px");
//        $(this).parent().siblings(".ng-sort-detail").css("width","0px");
//        $(this).parent().siblings(".ng-sort-detail").attr("class","ng-sort-detail");
//    })
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
//    $("#f1 > li").eq(0).mouseover(function(){
//        $("#f1-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f1 > li").eq(1).mouseover(function(){
//        $("#f1-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f1 > li").eq(2).mouseover(function(){
//        $("#f1-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f1 > li").eq(3).mouseover(function(){
//        $("#f1-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f1 > li").eq(4).mouseover(function(){
//        $("#f1-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f2 > li").eq(0).mouseover(function(){
//        $("#f2-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f2 > li").eq(1).mouseover(function(){
//        $("#f2-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f2 > li").eq(2).mouseover(function(){
//        $("#f2-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f2 > li").eq(3).mouseover(function(){
//        $("#f2-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f3 > li").eq(0).mouseover(function(){
//        $("#f3-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f3 > li").eq(1).mouseover(function(){
//        $("#f3-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f3 > li").eq(2).mouseover(function(){
//        $("#f3-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f3 > li").eq(3).mouseover(function(){
//        $("#f3-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f3 > li").eq(4).mouseover(function(){
//        $("#f3-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(0).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(1).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(2).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(3).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(4).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f4 > li").eq(5).mouseover(function(){
//        $("#f4-main > .g-tab-list").eq(5).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(0).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(1).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(2).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(3).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(4).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f5 > li").eq(5).mouseover(function(){
//        $("#f5-main > .g-tab-list").eq(5).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(0).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(1).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(2).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(3).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(4).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f6 > li").eq(5).mouseover(function(){
//        $("#f6-main > .g-tab-list").eq(5).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(0).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(0).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(1).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(1).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(2).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(2).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(3).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(3).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(4).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(4).show().siblings(".g-tab-list").hide();
//    })
//    $("#f7 > li").eq(5).mouseover(function(){
//        $("#f7-main > .g-tab-list").eq(5).show().siblings(".g-tab-list").hide();
//    })
    $("#gundong > li").mouseover(function(){
        if($(this).attr("class")!="on"){
            $(this).attr("class","hover").siblings("li").removeClass("hover");
        }
    }).mouseout(function(){
        $(this).removeClass("hover");
    })
})
$(document).ready(function(e){
    var height = $(".ng-fix-bar").height();
        $(document).scroll(function(){
            var t = $(document).scrollTop();
            if(t>=$(".first-screen").offset().top){
                $(".ng-fix-bar").show();
                $(".g-search").attr("class","g-search g-search-fixed");
                $(".reg-bar-node").attr("class","ng-bar-node reg-bar-node reg-bar-node-fixed");
                $(".ng-bar-node-mini-cart").attr("class","ng-bar-node ng-bar-node-mini-cart ng-bar-node-mini-cart-fixed");
                $("#username-node-slide").attr("class","ng-bar-node-box username-handle reg-bar-node-fixed");
            }else{
                $(".ng-fix-bar").hide();
                $(".g-search").attr("class","g-search");
                $(".reg-bar-node").attr("class","ng-bar-node reg-bar-node");
                $(".ng-bar-node-mini-cart").attr("class","ng-bar-node ng-bar-node-mini-cart");
                $("#username-node-slide").attr("class","ng-bar-node-box username-handle");
            }
            var chang = $("#gundong li").length*1;
            for(var i=0;i<chang;i++){
                if(t>=$("#tiao"+(i+1)).offset().top-height&&t<$("#tiao"+(i+1)).offset().top+$("#tiao2"+(i+1)).height()/1.5){
                   $(".ECode-floatBar").show();
                   $("#gundong > li").eq(i).attr("class","on").siblings("li").removeClass("on"); 
                }else if(t<$(".first-screen").offset().top){
                    $(".ECode-floatBar").hide();
                }
            }

            if($(document).scrollTop()+10 >= $(document).height()-$(window).height()){
                $(".ECode-floatBar").hide();
            }
        })
        $("#gundong > li").click(function(){
            var id = $(this).attr("data-id");
            $("html,body").animate({scrollTop:$("#"+id).offset().top-height}, 800);
        })
        $("#ding").click(function(){
            $('html,body').animate({scrollTop:'0px'}, 800);
        })  
})

    