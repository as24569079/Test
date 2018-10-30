$(function(){
    //通用头js
    $("#m_common_header_jdkey").click(function(){
        if($(this).attr("data-val")=="off"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","on");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","off");
        }
    })
    
    //弹出手机短信隔离层并发送短信
    var num = 60;
   
    $("#bindphone").click(function(){
        if($("#sendBtn").attr("data-val")=="off"){
            $("#geli").fadeIn("slow");
            var rand = "";
            for(var i = 0; i < 4; i++){
                var r = Math.floor(Math.random() * 10);
                rand += r;
            }
            $.post("anquanpassupt",{rand:rand},function(data){
                    $("#sendBtn").attr("disabled","disabled");
                    var Timer = setInterval(time,1000);
                    $("#yanzheng").val(data);
                    function time(){
                        num--;
                        $("#sendBtn").html(num+"秒后重发");
                        if(num==0){
                            $("#sendBtn").removeAttr("disabled");
                            num = 60;
                            $("#sendBtn").html("重新发送验证码");
                            $("#sendBtn").attr("data-val","on");
                            clearInterval(Timer);
                        }
                    }
                    //关闭隔离层
                    $("#confirmCancle").click(function(){
                        $("#geli").fadeOut("slow");
                        clearInterval(Timer);
                    })
            },"text")
        }
    })
    //重新发送短信
    $("#sendBtn").click(function(){
        if($("#sendBtn").attr("data-val")=="on"){
            $("#sendBtn").attr("data-val","off");
            var rand = "";
            for(var i = 0; i < 4; i++){
                var r = Math.floor(Math.random() * 10);
                rand += r;
            }
            $.post("anquanpassupt",{rand:rand},function(data){
                var Timer = setInterval(time,1000);
                    $("#sendBtn").attr("disabled","disabled");
                    $("#yanzheng").val(data);
                    function time(){
                        num--;
                        $("#sendBtn").html(num+"秒后重发");
                        if(num==0){
                            $("#sendBtn").removeAttr("disabled");
                            num = 60;
                            $("#sendBtn").html("重新发送验证码");
                            $("#sendBtn").attr("data-val","on");
                            clearInterval(Timer);
                        }
                    }
            },"text")
        }
    })
    
    //短信表单动态输入
    $("#codeInput").keyup(function(){
        if($(this).val()!=""){
            if($(this).val().length==4){
                $("#confirmBtnn").attr("class","btnn col-359df5");
            }else{
                $("#confirmBtnn").attr("class","btnn col-999999");
                $("#alertMsg").attr("class","box_foot_hasTxt");
                $("#alertMsg").html("输入手机接收到的短信验证码");
            }
        }else{
            $("#confirmBtnn").attr("class","btnn col-999999");
            $("#alertMsg").attr("class","box_foot_hasTxt");
            $("#alertMsg").html("输入手机接收到的短信验证码");
        }
    })
    
    //短信验证码验证
    $("#confirmBtnn").click(function(){
        if($("#codeInput").val()!=""){
            if($("#codeInput").val()!=$("#yanzheng").val()){
                $("#alertMsg").attr("class","box_foot_hasTxt colorRed");
                $("#alertMsg").html("短信验证码错误");
            }else{
                window.location.href='tosetnewpage';
            }
        }else{
            $("#alertMsg").attr("class","box_foot_hasTxt colorRed");
            $("#alertMsg").html("请输入短信验证码");
        }
    })
})