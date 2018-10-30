$(function(){
    $(".checkbtn").click(function(){
            if($(this).attr("data-val")=="on"){
                $("#passwd").attr("type","text");
                $(this).attr("data-val","off");
            }else{
                $("#passwd").attr("type","password");
                $(this).attr("data-val","on");  
            }
    })
    $("#passwd").keyup(function(){
        if($(this).val()!=""){
            $("#sureBtn").attr("class","btn J_ping btn-active");
            $(this).siblings(".icon-clear").show();
        }else{
            $("#sureBtn").attr("class","btn J_ping");
            $(this).siblings(".icon-clear").hide();
        }
    })
    $(".icon-clear").click(function(){
        $("#passwd").val("");
        $(this).hide();
        $("#sureBtn").attr("class","btn J_ping");
    })
    $("#form").submit(function(){
        if($("#passwd").val()==""){
            $(".toast-mask").fadeIn("slow");
            $(".toast").html("请输入新的登录密码");
            var Timer = setInterval(time,2000);
                function time(){
                    $(".toast-mask").fadeOut("slow");
                    clearInterval(Timer);
                }
            return false;
        }else if($("#passwd").val().length<6||$("#passwd").val().length>20){
            $(".toast-mask").fadeIn("slow");
            $(".toast").html("登录密码长度不符合");
            var Timer2 = setInterval(time2,2000);
                function time2(){
                    $(".toast-mask").fadeOut("slow");
                    clearInterval(Timer2);
                }
            return false;
        }
    })
    $(".toast-mask").click(function(){
        $(this).fadeOut("slow");
    })
})