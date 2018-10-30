$(function(){
    var num = 60;
    var phone = $("#telphone").val();
    var rand = "";
    for(var i = 0; i < 4; i++){
        var r = Math.floor(Math.random() * 10);
        rand += r;
    }
    var Timer = setInterval(time,1000);
    function time(){
        num--;
        $("#changeUserName").val(num+"秒后可重新发送");
        if(num==0){
            $("#changeUserName").removeAttr("disabled");
            $("#changeUserName").attr("class","getMes-btn");
            num = 60;
            $("#changeUserName").val("重新发送");
            clearInterval(Timer);
        }
    }
    $("#changeUserName").attr("class","getMes-btn getMes-btn-disable");
    $("#changeUserName").attr("disabled","disabled");
    $.post("jieshou",{rand:rand,phone:phone},
    function(res){
        $("#yzmyz").val(res);
    },"text");
    $("#changeUserName").click(function(){
        var rand2 = "";
        for(var i = 0; i < 4; i++){
            var r = Math.floor(Math.random() * 10);
            rand2 += r;
        }
        $.post("jieshou",{rand:rand2,phone:phone},
        function(res){
            $("#yzmyz").val(res);
            var Timer = setInterval(time,1000);
            function time(){
                num--;
                $("#changeUserName").val(num+"秒后可重新发送");
                if(num==0){
                    $("#changeUserName").removeAttr("disabled");
                    $("#changeUserName").attr("class","getMes-btn");
                    num = 60;
                    $("#changeUserName").val("重新发送");
                    clearInterval(Timer);
                }
            }
        },"text"); 
        $("#changeUserName").attr("class","getMes-btn getMes-btn-disable");
        $("#changeUserName").attr("disabled","disabled");
    })

    $("#mesCode").keyup(function(){
        if($(this).val()!=""){
            $("#sureBtn").attr("class","btn J_ping btn-active");
            $(this).siblings(".icon-clear").show();
        }else{
            $("#sureBtn").attr("class","btn J_ping");
            $(this).siblings(".icon-clear").hide();
        }
    }).focus(function(){
        $(".icon-clear").hide();
        if($(this).val()!=""){
            $(this).siblings(".icon-clear").show();
        }
    })
    $(".icon-clear").click(function(){
        $("#mesCode").val("");
        $(this).hide();
        $("#sureBtn").attr("class","btn J_ping");
    })
    
    $("#sureBtn").click(function(){
        if($("#mesCode").val()==""){
            $(".toast-mask").fadeIn("slow");
            $(".toast").html("请输入手机短信验证码");
            var Timer = setInterval(time,2000);
                function time(){
                    $(".toast-mask").fadeOut("slow");
                    clearInterval(Timer);
                }
        }else if($("#mesCode").val()!=$("#yzmyz").val()){
            $(".toast-mask").fadeIn("slow");
            $(".toast").html("短信验证码不正确或过期");
            var Timer2 = setInterval(time2,2000);
                function time2(){
                    $(".toast-mask").fadeOut("slow");
                    clearInterval(Timer2);
                }
        }else{
            window.location.href='forget_end';
        }
    })
    $(".toast-mask").click(function(){
        $(this).fadeOut("slow");
    })
})