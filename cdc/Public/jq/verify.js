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
    
    //表单动态验证
    $("#payPwd").keyup(function(){
        if($(this).val()!=""){
            $(".mg-t-40").attr("class","btn mg-t-40 col-btnBlue");
            $(".dn").show();
        }else{
            $(".mg-t-40").attr("class","btn col-btn1Gray mg-t-40");
            $(".dn").hide();
            $("#tishi").html("安全密码");
            $("#tishi").attr("class","pos-ab col-359df5 ft-30px ft-col-ccc ui-form-lable");
        }
    })
    
    //清除按钮
    $(".dn").click(function(){
        $("#payPwd").val("");
        $(this).hide();
        $(".mg-t-40").attr("class","btn col-btn1Gray mg-t-40");
        $("#tishi").html("安全密码");
        $("#tishi").attr("class","pos-ab col-359df5 ft-30px ft-col-ccc ui-form-lable");
    })
    
    //验证安全密码
    $(".mg-t-40").click(function(){
        if($("#payPwd").val()!=""){
            var pass = $("#payPwd").val();
            $.post("anquanmima_yanzheng",{pass:pass},function(data){
                if(data!=1){
                    $("#tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                    $("#tishi").html($("#payPwd").attr("data-info"));
                }else{
                    window.location.href='loginpage';
                }
            },"text")
        }
    })
})