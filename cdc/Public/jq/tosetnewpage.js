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
    
    //表单动态输入
    $("#payPwd").keyup(function(){
        if($(this).val()!=""){
            $(".dn").eq(0).show();
        }else{
            $(".dn").eq(0).hide();
        }
        if($("#payPwd").val()!=""&&$("#payPwdA").val()!=""){
            if($("#payPwdA").val()!=$("#payPwd").val()){
                $("#finishBtn").attr("class","make-btn col-btn1Gray p-line");
            }else{
                $("#finishBtn").attr("class","make-btn p-line col-btnBlue");
            }
        }
    })
    
    $("#payPwdA").keyup(function(){
        if($(this).val()!=$("#payPwd").val()){
            $("#anquan").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
            $("#anquan").html("两次密码不一致");
            $("#finishBtn").attr("class","make-btn col-btn1Gray p-line");
        }else{
            $("#anquan").attr("class","pos-ab col-359df5 ui-form-lable ft-30px ft-col-ccc");
            $("#anquan").html("确认安全密码");
            $("#finishBtn").attr("class","make-btn p-line col-btnBlue");
        }
        if($(this).val()!=""){
            $(".dn").eq(1).show();
        }else{
            $(".dn").eq(1).hide();
            $("#anquan").attr("class","pos-ab col-359df5 ui-form-lable ft-30px ft-col-ccc");
            $("#anquan").html("确认安全密码");
        }
    })
    
    //一键清除
    $(".dn").eq(0).click(function(){
        $("#payPwd").val("");
        $("#payPwd").focus();
        $(this).hide();
        $("#finishBtn").attr("class","make-btn col-btn1Gray p-line");
    })
    $(".dn").eq(1).click(function(){
        $("#payPwdA").val("");
        $("#payPwdA").focus();
        $("#anquan").attr("class","pos-ab col-359df5 ui-form-lable ft-30px ft-col-ccc");
        $("#anquan").html("确认安全密码");
        $(this).hide();
        $("#finishBtn").attr("class","make-btn col-btn1Gray p-line");
    })
    
    //提交验证
    $("#finishBtn").click(function(){
        if($(this).attr("class")=="make-btn p-line col-btnBlue"){
            var frm = document.getElementById('form');
                frm.action='anquanpass_upt';
                frm.submit();
        }
    })
})