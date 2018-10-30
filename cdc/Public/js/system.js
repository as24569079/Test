function req(){
    if(window.XMLHttpRequest){
        var request = new XMLHttpRequest();
    } else {
        var request = new ActiveXObject('Microsoft.XMLHTTP');
    }
    return request;
}
$(function(){
    $(".collapse > li").click(function(){
        $(this).attr("class","active").siblings("li").removeClass("active");
    })
    $("#side-menu > li > a ").eq(0).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
    $("#side-menu > li > a ").eq(1).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
    $("#side-menu > li > a ").eq(2).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
    $("#side-menu > li > a ").eq(3).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
    $("#side-menu > li > a ").eq(4).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
     $("#side-menu > li > a ").eq(5).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
 	 $("#side-menu > li > a ").eq(6).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
 $("#side-menu > li > a ").eq(7).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
$("#side-menu > li > a ").eq(8).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
$("#side-menu > li > a ").eq(9).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
$("#side-menu > li > a ").eq(10).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })
$("#side-menu > li > a ").eq(11).toggle(function(){
        $(this).parent("li").attr("class","active").siblings("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideDown("slow");
    },function(){
        $(this).parent("li").removeClass("active");
        $(this).parent("li").children(".collapse").slideUp("slow")
    })





    
    
    
    
    $(".chanpin-zs").mouseenter(function(){
        $(this).children(".jingguo").show();
        $(this).children(".jingguo").animate({
            top:'0'
        },"fast")
    }).mouseleave(function(){
        $(this).children(".jingguo").animate({
            top:'120px'
        },"fast")
    })
})
$(document).ready(function(){
//    var H = $("html").height();
//    $(".page-content").css("min-height",H+"px");
//    $("#sidebar").css("min-height",H+"px");
//    var zxl = $("input[name='zxl[]']");
//        var zsl = $("input[name='zsl[]']");
//        var zjg = $("input[name='zjg[]']");
//        var zpl = $("input[name='zpl[]']");
//        var renshu = $("input[name='renshu[]']");
//        var zxlnum = 0;
//        var zslnum = 0;
//        var zjgnum = 0;
//        var zxjnum = 0;
//        var zplnum = 0;
//        for(var i =0;i<zxl.length;i++){
//            zxlnum += zxl.eq(i).val()*1;
//            zslnum += zsl.eq(i).val()*1;
//            zjgnum += zsl.eq(i).val()*zjg.eq(i).val();
//            zxjnum += zxl.eq(i).val()*zjg.eq(i).val();
//            zplnum += zpl.eq(i).val()*1;
//        }
//        $("#zxl").text(zxlnum);
//        $("#zsl").text(zslnum);
//        $("#zl").text(zsl.length);
//        $("#zjg").text(zjgnum);
//        $("#zxj").text(zxjnum);
//        $("#zpj").text(zplnum);
//        $("#zrs").text(renshu.length);
})