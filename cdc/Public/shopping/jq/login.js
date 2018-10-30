$(function(e){
    $(".check-arrow").click(function(){
        $(".check-arrow").hide();
        $(".check-pc").show();
        $(".form-code").show();
        $(".form-code").css("transform","scale(1)");
        $(".form-code").animate({
            left: '24px',
            opacity: '1',
            top: '30px',
        },"slow");
    })
    $(".check-pc").click(function(){
        $(".check-arrow").show();
        $(".check-pc").hide();
        $(".form-code").css("transform","scale(0)");
        $(".form-code").animate({
            left: '181px',
            opacity: '0',
            top: '-186px',
        },"slow");
    })
    $(".qrcode-block").hover(function(e){
        t = setTimeout(function(){
            if($(".form-code").css("left")=="24px"){
               $("#qrCodesId").animate({
               left:'-76px'
               },"slow");
               $(".qrcode-way").animate({
                   left:'81px',
                   opacity:'1'
               },"slow")
            }
        },100);
    },function(e){
        $("#qrCodesId").animate({
            left:'0px'
        },"slow");
        $(".qrcode-way").animate({
            left:'0px',
            opacity:'0'
        },"slow")
        clearTimeout(t); 
    })
})

