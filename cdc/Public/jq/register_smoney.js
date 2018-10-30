$(function(){
    $(".J_ping").on("keyup",function(){
            if($("#telphone").val()!=""&&$("#telCode").val()!=""&&$("#password").val()!=""&&$("#FullName").val()!=""&&$("#CodeID").val()!=""&&$("#fc_TwoPassword").val()!=""){
                $("#regBtn").attr("class","btn J_ping btn-active");
            }else{
                $("#regBtn").attr("class","btn J_ping");
            }
    })
        $("#telphone").keyup(function(){
            if($(this).val()!=""){
                $("#changeUserName").attr("class","mesg-code J_ping");
                $(this).siblings(".icon-clear").show();
            }else{
                $("#changeUserName").attr("class","mesg-code mesg-disable J_ping");
                $(this).siblings(".icon-clear").hide();
            }
        }).focus(function(){
            $(".icon-clear").hide();
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }
        })
        $(".icon-clear").eq(0).click(function(){
            $(this).siblings("#telphone").val("");
            $(this).hide();
            $("#changeUserName").attr("class","mesg-code mesg-disable J_ping");
        })
        var num = 60;
        $("#changeUserName").click(function(){
            if($.trim($("#telphone").val())!=""&&$.trim($("#telphone").val()).length==11&&$.trim(!isNaN($("#telphone").val()))){
                var phone = $("#telphone").val();
                var rand = "";
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
                                    url:"verificationCode",
                                    dataType: "text",
                                    data:{number:rand,user:phone},
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
                                        $("#changeUserName").attr("class","mesg-code mesg-disable J_ping");
                                        $("#changeUserName").attr("disabled","disabled");
                                        $("#yzmyz").val(data);
                                    }
                                })
                            }else{
                                $(".notice").html("手机号码已被注册!请更换手机号码!");
                                $("#telphone").attr("class","acc-input telphone txt-input J_ping");
                                $("#telphone").parent(".input-container").attr("class","input-container input-error");
                                $("#changeUserName").attr("class","mesg-code J_ping");
                            }
                        }
                    })
            }else{
                $(".notice").html("请输入正确的手机号码");
                $("#telphone").attr("class","acc-input telphone txt-input J_ping");
                $("#telphone").parent(".input-container").attr("class","input-container input-error");
                $("#changeUserName").attr("class","mesg-code J_ping");
            }
        })
        $("#telCode").keyup(function(){
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }else{
                $(this).siblings(".icon-clear").hide();
            }
        }).focus(function(){
            $(".icon-clear").hide();
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }
        })
        $(".icon-clear").eq(1).click(function(){
            $(this).siblings("#telCode").val("");
            $(this).hide();
        })
        $("#password").keyup(function(){
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }else{
                $(this).siblings(".icon-clear").hide();
            }
        }).focus(function(){
            $(".icon-clear").hide();
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }
        })
        $(".icon-clear").eq(2).click(function(){
            $(this).siblings("#password").val("");
            $(this).hide();
        })
        $(".checkbtn").click(function(){
            if($(this).attr("data-val")=="on"){
                $("#password").attr("type","password");
                $(this).attr("data-val","off");
            }else{
                $("#password").attr("type","text");
                $(this).attr("data-val","on");
            }
        })
        $("#FullName").keyup(function(){
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }else{
                $(this).siblings(".icon-clear").hide();
            }
        }).focus(function(){
            $(".icon-clear").hide();
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }
        })
        $(".icon-clear").eq(3).click(function(){
            $(this).siblings("#FullName").val("");
            $(this).hide();
        })
        $("#fc_TwoPassword").keyup(function(){
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }else{
                $(this).siblings(".icon-clear").hide();
            }
        }).focus(function(){
            $(".icon-clear").hide();
            if($(this).val()!=""){
                $(this).siblings(".icon-clear").show();
            }
        })
        $(".icon-clear").eq(4).click(function(){
            $(this).siblings("#fc_TwoPassword").val("");
            $(this).hide();
        })
        $("#form0").submit(function(){
            var result;
            if($.trim($("#telphone").val())==""){
                $(".notice").html("请输入您的手机号码");
                $("#telphone").attr("class","acc-input telphone txt-input J_ping");
                $("#telphone").parent(".input-container").attr("class","input-container input-error");
                $("#changeUserName").attr("class","mesg-code J_ping");
                return false;
            }else if(isNaN($("#telphone").val())){
                $(".notice").html("请输入数字");
                $("#telphone").attr("class","acc-input telphone txt-input J_ping");
                $("#telphone").parent(".input-container").attr("class","input-container input-error");
                $("#changeUserName").attr("class","mesg-code J_ping");
                return false;
            }else if($.trim($("#telphone").val()).length!=11){
                $(".notice").html("请输入正确的11位手机号码");
                $("#telphone").attr("class","acc-input telphone txt-input J_ping");
                $("#telphone").parent(".input-container").attr("class","input-container input-error");
                $("#changeUserName").attr("class","mesg-code J_ping");
                return false;
            }else{
                $(".notice").html("");
                $("#telphone").parent(".input-container").attr("class","input-container");
            }
            if($("#yzmyz").val()==""){
                $(".notice").html("请发送手机短信验证码");
                $("#telCode").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#telCode").val()==""){
                $(".notice").html("请输入手机短信验证码");
                $("#telCode").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#telCode").val()!=$("#yzmyz").val()){
                $(".notice").html("手机短信验证码错误或失效，请重新发送");
                $("#telCode").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else{
                $(".notice").html("");
                $("#telCode").parent(".input-container").attr("class","input-container");
            }
            if($("#password").val()==""){
                $(".notice").html("请输入您的登录密码");
                $("#password").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#password").val().length<6||$("#password").val().length>20){
                $(".notice").html("请输入6-20位登录密码");
                $("#password").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if(!/^([a-z]|[A-Z]|[0-9])*$/.test($("#password").val())){
                $(".notice").html("登录密码不能包含特殊符号");
                $("#password").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#fc_TwoPassword").val()!=""){
                if($("#password").val()==$("#fc_TwoPassword").val()){
                    $(".notice").html("登录密码不能与安全密码相同!");
                    $("#password").parent(".input-container").attr("class","input-container input-error");
                    return false;
                }else{
                    $(".notice").html("");
                    $("#password").parent(".input-container").attr("class","input-container");
                }
            }else{
                $(".notice").html("");
                $("#password").parent(".input-container").attr("class","input-container");
            }
            var pattern = /^[\u4e00-\u9fa5]+$/;
            var reg=/^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;  //正则身份证
            if($("#FullName").val()==""){
                $(".notice").html("请输入您的真实姓名");
                $("#FullName").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if(!pattern.test($("#FullName").val())){
                $(".notice").html("请输入您的真实姓名");
                $("#FullName").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else{
                $(".notice").html("");
                $("#FullName").parent(".input-container").attr("class","input-container");
            }
                        if($("#fc_TwoPassword").val()==""){
                $(".notice").html("请输入您的安全密码");
                $("#fc_TwoPassword").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#fc_TwoPassword").val().length<6||$("#fc_TwoPassword").val().length>8){
                $(".notice").html("请输入6-8位安全密码");
                $("#fc_TwoPassword").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if(!/^([a-z]|[A-Z]|[0-9])*$/.test($("#fc_TwoPassword").val())){
                $(".notice").html("安全密码不能包含特殊符号");
                $("#fc_TwoPassword").parent(".input-container").attr("class","input-container input-error");
                return false;
            }else if($("#password").val()!=""){
                if($("#password").val()==$("#fc_TwoPassword").val()){
                    $(".notice").html("安全密码不能与登录密码相同!");
                    $("#fc_TwoPassword").parent(".input-container").attr("class","input-container input-error");
                    return false;
                }else{
                    $(".notice").html("");
                    $("#fc_TwoPassword").parent(".input-container").attr("class","input-container");
                }
            }else{
                $(".notice").html("");
                $("#fc_TwoPassword").parent(".input-container").attr("class","input-container");
            }
            if (!reg.test($("#CodeID").val())) {
                $(".notice").html("请输入您的正确身份证");
                $("#CodeID").parent(".input-container").attr("class","input-container input-error");
                return false;
            } else { 
                 if ($("#CodeID").attr("data-status") == "on") {
                    $.ajax({
                        async:false,
                        type:"post",
                        url:"CodeId",
                        dataType: "text",
                        data:{CodeID:$("#CodeID").val(),FullName:$("#FullName").val(),phone:$("#telphone").val()},
                        success:
                        function(data){
                           if (data == 1) {         //后端验证身份证格式
                                $(".notice").html("请输入您的正确身份证");
                                $("#CodeID").parent(".input-container").attr("class","input-container input-error");
                                result = false;
                           } else if(data == 123){
                               $(".notice").html("您验证的身份证次数过多,请更换手机号重试");
                                $("#CodeID").parent(".input-container").attr("class","input-container input-error");
                                result = false;
                           }else {
                                var s = data.substring(0,data.length-1); //返回json格式数据多个1
                                eval("var obj=" + s);   
                                var codeResult = obj.result.isok;      //验证身份证号码和人名是否匹配
                                if (codeResult == true) {
                                    $(".notice").html("");
                                    $("#CodeID").parent(".input-container").attr("class","input-container");
                                    $("#CodeID").attr("data-status","off");
                                } else {
                                    $(".notice").html("您的身份证与您的姓名不符");
                                    $("#CodeID").parent(".input-container").attr("class","input-container input-error");
                                }
                           }
                        }
                    });
                }
            }
             if ($("#CodeID").attr("data-status") == "on") {
                 return false;
             }         
        })
})


