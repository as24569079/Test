$(function(){
    //查询手机号码
    $.post("cookSelect",
    function(data){
       if(data != ""){
            eval("var obj="+data);
            $("#user").html(obj.tel);
        }
    },"text");
    
    //表单动态验证
    $("#password").focus(function(){
        $("#pwdError").attr("class","paypw-msg");
        $("#pwdError").html($(this).attr("tip"));
    }).blur(function(){
        if($(this).val().length<6||$(this).val().length>20){
            $("#pwdError").attr("class","paypw-err");
            $("#pwdError").html("密码长度不正确，请重新设置");
        }else{
            $("#pwdError").html("");
        }
    })
    $("#checkPassword").blur(function(){
        if($(this).val()!=$("#password").val()){
           $("#confirmError").attr("class","paypw-err");
           $("#confirmError").html($(this).attr("matchfortxt")); 
        }
    })
    
    //表单提交验证
    $("#frm_resetPassword").submit(function(){
        var pattern = /^[\u4e00-\u9fa5]+$/;
        var password = $.trim($("#password").val());
        if(password==""){
            $("#pwdError").attr("class","paypw-err");
            $("#pwdError").html("密码不能为空");
            return false;
        }else if(password.length<6||password.length>20){
            $("#pwdError").attr("class","paypw-err");
            $("#pwdError").html("密码长度不正确，请重新设置");
            return false;
        }else if(pattern.test(password)){
            $("#pwdError").attr("class","paypw-err");
            $("#pwdError").html("密码不能包含中文，请重新设置");
            return false;
        }else{
            $("#pwdError").attr("class","paypw-err");
            $("#pwdError").html("");
        }
        if($("#checkPassword").val()==""){
           $("#confirmError").attr("class","paypw-err");
           $("#confirmError").html($("#checkPassword").attr("valuemissingtxt"));
           return false;
        }else if($.trim($("#checkPassword").val())!=$.trim($("#password").val())){
           $("#confirmError").attr("class","paypw-err");
           $("#confirmError").html($("#checkPassword").attr("matchfortxt"));
           return false;
        }
    })
})