$(function(){
    //查询手机号码
    $.post("cookSelect",
    function(data){
       if(data != ""){
            eval("var obj="+data);
            $("#phone").html("已验证手机："+obj.change_tel);
            $("#mobile").val(obj.change_tel);
            $("#user").html(obj.tel);
        }
    },"text");
    
    //获取短信验证码
    var num = 60;
    $("#btnCodesend").click(function(){
        $("#notify").show();
        var rand = "";
        for(var i = 0; i < 4; i++){
            var r = Math.floor(Math.random() * 10);
            rand += r;
        }
        var phone = $("#mobile").val();
        $.post("loginpass_yanzhengma",{rand:rand,phone:phone},function(data){
            if(data!=""){
                $("#notify_e").hide();
                var Timer = setInterval(time,1000);
                $("#btnCodesend").attr("disabled","disabled");
                $("#type").val(data);
                function time(){
                    num--;
                    $("#btnCodesend").val(num+"秒后可重新发送");
                    $("#second").html(num);
                    if(num==0){
                        $("#btnCodesend").removeAttr("disabled");
                        num = 60;
                        $("#btnCodesend").val("获取短信验证码");
                        $("#notify").hide();
                        $("#second").html("60");
                        clearInterval(Timer);
                    }
                }
            }else{
                $("#notify_e").show();
            }
        },"text");       
    })
    
    //验证短信验证码
    $("#btnValidateCode").click(function(){
        if($("#code").val()!=""){
            $("#codeError").html("");
            if($("#code").val()!=$("#type").val()){
                $("#codeError").html("短信验证码错误或失效，请重新填写");
            }else{
                window.location.href='modifyloginpassword';
            }
        }else{
            $("#codeError").html("请输入短信验证码");
        }
    })
})
