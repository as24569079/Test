$(function(){
    //输入事件
    $("#uersNameId").keyup(function(){
        if($(this).val()!=""){
             $("#submitId").attr("class","check-btn-red");
        }else{
            $("#submitId").attr("class","check-btn-grey");
        }
    })
    $("#mobilePhoneId").keyup(function(){
        if($(this).val()!=""){
             $("#submitId").attr("class","check-btn-red");
        }else{
            $("#submitId").attr("class","check-btn-grey");
        }
    })
    $("#address_where").keyup(function(){
        if($(this).val()!=""){
             $("#submitId").attr("class","check-btn-red");
        }else{
            $("#submitId").attr("class","check-btn-grey");
        }
    })
    //提交表单验证
    $("#editAddressForm").submit(function(){
        function time(){
            $("#fade").fadeOut("slow");
            clearInterval(Timer);
        }
        var uersNameId = $("#uersNameId");
        var mobilePhoneId = $("#mobilePhoneId");
        var select_province = $("#select_province");
        var select_city = $("#select_city");
        var select_area = $("#select_area");
        var address_where = $("#address_where");
        var re = /^[\u4e00-\u9fa5a-z]+$/gi;
        if(uersNameId.val()==""){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入收货人姓名");
            var Timer = setInterval(time,2000);
            return false;
        }else if(!re.test(uersNameId.val())){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入正确的收货人姓名");
            Timer = setInterval(time,2000);
            return false;
        }
        if(mobilePhoneId.val()==""){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入收货人手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if(isNaN(mobilePhoneId.val())){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入正确的号码");
            Timer = setInterval(time,2000);
            return false;
        }else if(mobilePhoneId.val().length!=11){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入正确的号码");
            Timer = setInterval(time,2000);
            return false;
        }
        if(select_province.val()=="请选择"||select_city.val()=="请选择"||select_area.val()=="请选择"){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请选择所在地区");
            Timer = setInterval(time,2000);
            return false;
        }
        if(address_where.val()==""){
            $("#fade").fadeIn("slow");
            $("#fade > div").html("请输入收货人详细地址");
            Timer = setInterval(time,2000);
            return false;
        }
    })
    
    //设为默认地址
    $(".myswitch").click(function(){
        var myswitch_this = $(this);
        var moren = $("#moren");
        if(myswitch_this.attr("data-val")=="on"){
            myswitch_this.attr("class","myswitch myswitched");
            myswitch_this.attr("data-val","off");
            moren.val("1");
        }else{
            myswitch_this.attr("class","myswitch");
            myswitch_this.attr("data-val","on");
            moren.val("0");
        }
    })
    
    //判断是否为默认地址
    if($("#status").val()=="0"){
        $("#deleteAddressId").show();
        $(".set-default").show();
    }else{
        $("#deleteAddressId").hide();
        $(".set-default").hide();
    }
    
    //删除提示弹层
    $("#tan1").height($(document).height());
    $("#deleteAddressId").click(function(){
        $("#tan1").fadeIn("slow");
        $("#tan2").fadeIn("slow");
    })
    
    //关闭删除弹层
    $("#cancelDeleteAddress").click(function(){
        $("#tan1").fadeOut("slow");
        $("#tan2").fadeOut("slow");
    })
    
    
})