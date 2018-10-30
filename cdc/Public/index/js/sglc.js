$(function(){
    $("#sg li a").click(function(){
        var foreach = $(".foreach");
        $(this).attr("class","active").parent().siblings().children("a").removeClass("active");
        var id = $(this).attr("data-id");
        $('#'+id).show().animate({right:'0px',opacity:'1'},1000,function(){
            for(var i=0;i<foreach.length;i++){
                if(foreach.eq(i).attr("id")!=id){
                    foreach.eq(i).css({right:'-600px',opacity:'0'}).hide();
                }
            }
        });
        for(var i=0;i<foreach.length;i++){
            if(foreach.eq(i).attr("id")!=id){
                foreach.eq(i).hide();
            }
        }
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
    $(".navigation-item a").click(function(){
        $('html,body').animate({scrollTop:$("#news").offset().top}, 800);   
    })
})