$(function(){
    $("#username").keyup(function(){
        if($(this).val()!=""){
            $("#sureBtn").attr("class","btn J_ping btn-active");
            $(this).siblings(".icon-clear").show();
        }else{
            $("#sureBtn").attr("class","btn J_ping");
            $(this).siblings(".icon-clear").hide();
        }
    })
     $(".icon-clear").click(function(){
        $("#username").val("");
        $(this).hide();
        $("#sureBtn").attr("class","btn J_ping");
    })
    $("#sureBtn").click(function(){
        if($("#username").val()!=""){
            var phone = $("#username").val();
            $.ajax({
                type:"post",
                url:"phoneSelect",
                dataType: "text",
                data:{user:phone},
                success:
                function(data){
                    if(data==1){
                        window.location.href='session_forget/user_phone/'+phone;
                    }else{
                        $(".toast-mask").fadeIn("slow");
                        $(".toast").html("手机号码不存在");
                        var Timer = setInterval(time,2000);
                            function time(){
                                $(".toast-mask").fadeOut("slow");
                                clearInterval(Timer);
                            }
                    }
                }
            })
        }else{
           alert("请填写您的手机号码");
        }
    })
    $(".toast-mask").click(function(){
        $(this).fadeOut("slow");
    })
})