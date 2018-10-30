$(function(){
    $(window).load(function(){ 
        //判断是否拥有收货地址
        var address = $(".status");
        if(address.length>0){
            $("#status").val("0")
        }else{
            $("#status").val("1")
        }
        if($("#status").val()=="1"){
            $("#tan2").show();
            $("#tan1").show();
        }else{
            $("#tan2").hide();
            $("#tan1").hide();
        }
    })
//    关闭弹出层
    $(".mc").click(function(){
        $("#tan2").fadeOut("slow");
        $("#tan1").fadeOut("slow");
    })
    
    //选择默认地址
    $(".ia-m78").click(function(){
        var id = $(this).children(".address_id").val();
        var status = $(this).attr("data-val");
        $.post("address_upt",{id:id,status:status},function(res){
            if(res==1){
                document.location.href='myorder';
            }else{
                alert("发生错误");
            }
        },"text")
    })
})