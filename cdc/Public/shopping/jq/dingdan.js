$(document).ready(function(e){
    var l = $(".gouwu");
    for(var i=0;i<l.length;i++){
        $(".booking_price_total > em").eq(i).text($(".gouwu").eq(i).val()*$(".jiage").eq(i).val()+".00");
        $(".zongjia").eq(i).val($(".gouwu").eq(i).val()*$(".jiage").eq(i).val());
    }
    var zongjia = $(".zongjia");
    var sl = $(".gouwu");
    var slz = 0;
    var zj = 0;
    var zh = 0;
    for(var i=0;i<zongjia.length;i++){
        zj+=zongjia.eq(i).val()*1;
        slz+=sl.eq(i).val()*1;
        zh +=$(".zongjia").eq(i).val()*1;
    }
//    $(".booking_price_amount").text(zj+".00");
    $("#cart2_qty").text(slz);
    $("#cmmdyTotalID").text(zh+".00");
    $("#payAmountID").text(zh+".00");
    var moren = $(".morendizhi");
    for(var i=0;i<moren.length;i++){
        if(moren.eq(i).val()=="1"){
            moren.parent(".addr").eq(i).attr("class","addr addr-selected addr-default");
            moren.parent(".addr").find(".set-default").eq(i).attr("class","default-addr c9").text("默认地址").show(); 
        }else{
            moren.parent(".addr").eq(i).attr("class","addr ws");
        }
    }
    $(".addr-default").mouseenter(function(){
        if($(this).attr("class")=="addr addr-default addr-selected"){
            $(this).attr("class","addr addr-default addr-selected");
        }else if($(this).attr("class")=="addr addr-default"){
            $(this).attr("class","addr addr-default addr-cur");
        }else{
            $(this).attr("class","addr addr-selected addr-default addr-cur");
        }
        $(this).find(".del").show();
    }).mouseleave(function(){
        $(this).removeClass("addr-cur");
        $(this).find(".del").hide();
    })
    $(".ws").mouseenter(function(){
        if($(this).attr("class")=="addr addr-default addr-selected"){
            $(this).attr("class","addr addr-default addr-selected addr-cur");
        }else{
            $(this).attr("class","addr addr-cur");
        }
        $(this).find(".set-default").show();
        $(this).find(".del").show();
    }).mouseleave(function(){
        $(this).removeClass("addr-cur");
        $(this).find(".set-default").hide();
        $(this).find(".del").hide();
    })
    $(".addr:not(:last-child)").dblclick(function(){
        if($(this).children(".morendizhi").val()=="1"){
            $(this).attr("class","addr addr-selected addr-default").siblings().removeClass("addr-selected");
        }else{
            $(this).attr("class","addr addr-default addr-selected").siblings().removeClass("addr-selected");
        }
        var diqu = $(this).children(".uptdiqu2");
        var dizhi = $(this).children(".uptdizhi2");
        var tjdd = $(this).children(".tjdd");
        $("#tjd").val(tjdd.val());
    })
    $("#liuyan").focus(function(){
        $(this).val("");
    }).blur(function(){
        if($(this).val()==""){
            $(this).val("选填：对本次交易的补充说明（所填内容建议已经和卖家达成一致意见）");
        }
    })
    $("#liuyan").keyup(function(){
        $(".current-length").text($(this).val().length);
    })
})