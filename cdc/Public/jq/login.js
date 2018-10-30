$(function(){
    $(".J_ping").on("keyup",function(){
            if($("#username").val()!=""&&$("#password").val()!=""){
                $("#loginBtn").attr("class","btn J_ping btn-active");
            }else{
                $("#loginBtn").attr("class","btn J_ping");
            }
    })
    $("#username").keyup(function(){
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
    $(".icon-clear").eq(0).click(function(){
        $(this).siblings("#username").val("");
        $(this).hide();
    })
    $(".icon-clear").eq(1).click(function(){
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
    
    //表单验证
    $("#form").submit(function(){
        var result;
        if($("#username").val()==""){
            $(".notice").html("请输入您的手机号码");
            $("#username").parent(".input-container").attr("class","input-container input-error");
            return false;
        }else{
            $(".notice").html("");
            $("#username").parent(".input-container").attr("class","input-container");
        }
        if($("#password").val()==""){
            $(".notice").html("请输入您的登录密码");
            $("#password").parent(".input-container").attr("class","input-container input-error");
            return false;
        }else{
            $(".notice").html("");
            $("#password").parent(".input-container").attr("class","input-container");
        }
        if($("#username").val()!=""&&$("#password").val()!=""){
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({
                async:false,
                type:"post",
                url:"loginVerificationAjax",
                dataType: "text",
                data:{user:username,pass:password},
                success:
                function(data){
                    if(data == 0){
                        $(".notice").html("账号或密码错误！请重新输入！");
                        $("#username").parent(".input-container").attr("class","input-container input-error");
                        $("#password").parent(".input-container").attr("class","input-container input-error");
                        result=false;
                    }else if(data == 1){
                        $(".notice").html("");
                        $("#password").parent(".input-container").attr("class","input-container");
                        $("#username").parent(".input-container").attr("class","input-container");
                    }
                }
            })
        }
        //记住密码执行
        if($("#remberme").attr("checked")=="checked"){
            if($("#username").val()!=""&&$("#password").val()!=""){
                var username = $("#username").val();
                var password = $("#password").val();
                $.cookie("username", username, { expires: 7 }); 
                $.cookie("password", password, { expires: 7 }); 
            }
        }else{
            $.cookie("username", "", { expires: -1 }); 
            $.cookie("password", "", { expires: -1 }); 
        }
        return result;
    })
    //记住密码开关
    $("#remberlab").change(function(){
        if($(this).attr("data-val")=="on"){
            $("#remberme").removeAttr("checked");
            $(this).attr("data-val","off");
        }else{
            $("#remberme").attr("checked","checked");
            $(this).attr("data-val","on");
        }
    })
    if($.cookie("username")){
        $("#username").val($.cookie("username"));
        $("#password").val($.cookie("password"));
        $("#loginBtn").attr("class","btn J_ping btn-active");
    }
})