$(function(){
    $("#UserName").focus(function(){
        $(this).attr("placeholder","请输入您的手机号码");
        $(".field-validation-valid").eq(0).text(""); 
        $("#select-regName").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($(this).val()==""){
            $(".field-validation-valid").eq(0).text("手机为必填项!"); 
            $("#select-regName").css("border","1px solid red");
        }else if(isNaN($(this).val())){
            $(".field-validation-valid").eq(0).text("手机号码只能为数字!");
            $("#select-regName").css("border","1px solid red");
        }else if($(this).val().length<11){
            $(".field-validation-valid").eq(0).text("请输入正确的11位手机号码!");
            $("#select-regName").css("border","1px solid red");
        }
    })
    $("#fc_YZM").focus(function(){
        $(this).attr("placeholder","请输入手机验证码");
        $(".field-validation-valid").eq(1).text("");
        $("#dphone").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($(this).val()==""){
            $(".field-validation-valid").eq(1).text("验证码为必填项!");
            $("#dphone").css("border","1px solid red");
        }else if(isNaN($(this).val())){
            $(".field-validation-valid").eq(1).text("验证码只能为数字!");
            $("#dphone").css("border","1px solid red");
        }else{
            if($(this).val()!=$("#yzmyz").val()){
                $(".field-validation-valid").eq(1).text("验证码不正确或已过期!请重新输入!");
                $("#dphone").css("border","1px solid red");
            }
        }
    })
    $("#FullName").focus(function(){
        $(this).attr("placeholder","请输入您的真实姓名");
        $(".field-validation-valid").eq(2).text("");
        $("#select-realName").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        var pattern = /^[\u4e00-\u9fa5]+$/;
        if($(this).val()==""){
            $(".field-validation-valid").eq(2).text("姓名为必填项!");
            $("#select-realName").css("border","1px solid red");
        }else if(!pattern.test($(this).val())){
            $(".field-validation-valid").eq(2).text("请输入您的真实姓名!");
            $("#select-realName").css("border","1px solid red");
        }
    })
    $("#CodeID").focus(function(){
        $(this).attr("placeholder","请输入15或18位身份证号码");
        $(".field-validation-valid").eq(3).text(""); 
        $("#select-CodeID").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($(this).val()==""){
            $(".field-validation-valid").eq(3).text("身份证号码为必填项!"); 
            $("#select-CodeID").css("border","1px solid red");
        }else if($(this).val().length!=15&&$(this).val().length!=18){
            $(".field-validation-valid").eq(3).text("身份证长度不符合!请输入15或18位身份证号码!"); 
            $("#select-CodeID").css("border","1px solid red");
        }
//        else if(isNaN($(this).val())){
//            $(".field-validation-valid").eq(3).text("请输入数字!"); 
//            $("#select-CodeID").css("border","1px solid red");
//        }
    })
    $("#UserPassword").focus(function(){
        $(this).attr("placeholder","请设置6-32位登陆密码");
        $(".field-validation-valid").eq(4).text(""); 
        $("#pswd").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($(this).val()==""){
            $(".field-validation-valid").eq(4).text("登录密码为必填项!"); 
            $("#pswd").css("border","1px solid red");
        }else if($(this).val().length<6){
            $(".field-validation-valid").eq(4).text("请输入6-32位的登陆密码!"); 
            $("#pswd").css("border","1px solid red");
        }else if(!/^([a-z]|[A-Z]|[0-9])*$/.test($(this).val())){
            $(".field-validation-valid").eq(5).text("登录密码不能包含特殊符号!"); 
            $("#pswd").css("border","1px solid red");
        }else if($("#fc_TwoPassword").val()!=""){
            if($("#UserPassword").val()==$("#fc_TwoPassword").val()){
                $(".field-validation-valid").eq(4).text("登录密码不能与安全密码相同!"); 
                $("#pswd").css("border","1px solid red");
            }
        }
    })
    $("#UserPassword1").focus(function(){
        $(this).attr("placeholder","请再次输入登陆密码");
        $(".field-validation-valid").eq(5).text(""); 
        $("#pswd2").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($("#UserPassword").val()!=""){
            if($(this).val()==""){
                $(".field-validation-valid").eq(5).text("请再次输入登陆密码!"); 
                $("#pswd2").css("border","1px solid red");
            }else if($(this).val()!=$("#UserPassword").val()){
                $(".field-validation-valid").eq(5).text("两次输入的登陆密码不相同!请再次输入!"); 
                $("#pswd2").css("border","1px solid red");
            }
        }else{
          $(".field-validation-valid").eq(4).text("请先输入登录密码!"); 
          $("#pswd").css("border","1px solid red");  
        }
    })
    $("#fc_TwoPassword").focus(function(){
        $(this).attr("placeholder","请设置6-8位安全密码");
        $(".field-validation-valid").eq(6).text(""); 
        $("#anquan").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($(this).val()==""){
            $(".field-validation-valid").eq(6).text("安全密码为必填项!"); 
            $("#anquan").css("border","1px solid red");
        }else if($(this).val().length<6){
            $(".field-validation-valid").eq(6).text("请输入6-8位的安全密码!"); 
            $("#anquan").css("border","1px solid red");
        }else if(!/^([a-z]|[A-Z]|[0-9])*$/.test($(this).val())){
            $(".field-validation-valid").eq(6).text("安全密码不能包含特殊符号!"); 
            $("#anquan").css("border","1px solid red");
        }else if($("#UserPassword").val()!=""){
            if($("#UserPassword").val()==$("#fc_TwoPassword").val()){
                $(".field-validation-valid").eq(6).text("登录密码不能与安全密码相同!"); 
                $("#anquan").css("border","1px solid red");
            }
        }
    })
    $("#fc_TwoPassword1").focus(function(){
        $(this).attr("placeholder","请再次输入安全密码");
        $(".field-validation-valid").eq(7).text(""); 
        $("#anquan2").css("border","1px solid #ddd");
    }).blur(function(){
        $(this).removeAttr("placeholder");
        if($("#fc_TwoPassword").val()!=""){
            if($(this).val()==""){
                $(".field-validation-valid").eq(7).text("请再次输入安全密码!"); 
                $("#anquan2").css("border","1px solid red");
            }else if($("#fc_TwoPassword").val()!=$(this).val()){
                $(".field-validation-valid").eq(7).text("两次输入的安全密码不相同!请再次输入!"); 
                $("#anquan2").css("border","1px solid red");
            }
        }else{
            $(".field-validation-valid").eq(6).text("请先输入安全密码!"); 
            $("#anquan").css("border","1px solid red");
        }
    })
    var num = 60;
    $("#changeUserName").click(function(){
        if($("#UserName").val()!=""&&$("#UserName").val().length==11){
            $("#dang").fadeIn("slow");
            $("#captcha-container").fadeIn("slow");       
        }else{
            $(".field-validation-valid").eq(0).text("请填入正确的手机号码!");
            $("#select-regName").css("border","1px solid red");
        }
    })
    
        $("#quxiao").click(function(){
            $("#dang").fadeOut("slow");
            $("#captcha-container").fadeOut("slow");  
        })
        $("#yan_sub").click(function(){
            var yyy = $("#tuwen").val();
            if(yyy==""){
                alert("请输入验证码");
            }else{
            $.post("tuwenyanzheng",{value:yyy},function(res){
                if(res == 1){
                    alert("验证码错误！请重新输入！");
                }else{
                    if($("#UserName").val()!=""&&$("#UserName").val().length==11){
                        $("#dang").fadeOut("slow");
            $("#captcha-container").fadeOut("slow"); 
            var phone = $("#UserName").val();
            var rand = "";
            $("#dxyz").val("true");
            for(var i = 0; i < 4; i++){
                var r = Math.floor(Math.random() * 10);
                rand += r;
            }
                    $.ajax({
                        type:"post",
                        url:"phoneSelect",
                        dataType: "text",
                        data:{user:phone},
                        success:
                        function(data){
                            if(data!=1){
                                $.ajax({
                                    type:"post",
                                    url:"verificationCode233",
                                    dataType: "text",
                                    data:{number:rand,user:phone,value:$("#tuwen").val()},
                                    success:
                                    function(data){
                                        var Timer = setInterval(time,1000);
                                        function time(){
                                            num--;
                                            $("#changeUserName").val(num+"秒后可重新发送");
                                            if(num==0){
                                                $("#changeUserName").removeAttr("disabled");
                                                num = 60;
                                                $("#changeUserName").val("获取短信验证码");
                                                clearInterval(Timer);
                                            }
                                        }
                                        $("#changeUserName").attr("disabled","disabled");
                                        $("#dphone").fadeIn("slow");
                                        $("#yzmyz").val(data);
                                        $(".field-validation-valid").eq(0).text("");
                                        $("#select-regName").css("border","1px solid #ddd");
                                    }
                                })
                            }else{
                                $(".field-validation-valid").eq(0).text("手机号码已被注册!请更换手机号码!");
                                $("#select-regName").css("border","1px solid red");
                            }
                        }
                    })
        }else{
            $(".field-validation-valid").eq(0).text("请填入正确的手机号码!");
            $("#select-regName").css("border","1px solid red");
        }
                }
            },"text")
        }
        })
})


