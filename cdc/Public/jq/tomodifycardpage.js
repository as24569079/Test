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
    
    //输入事件
    
    $("#card-num").focus(function(){
        $(".dn").hide();
        if($(this).val()!=""){
            $(".dn").eq(0).show();
        }
    }).keyup(function(){
        if($(this).val()!=""){
            $("#confirmBtn").attr("class","btn col-btnBlue");
            if(isNaN($(this).val())){
                $(".ui-form-lable").eq(0).html("请输入正确的银行卡卡号");
                $(".ui-form-lable").eq(0).attr("class","pos-ab ui-form-lable colorRed");
            }else{
                $(".ui-form-lable").eq(0).html("银行卡");
                $(".ui-form-lable").eq(0).attr("class","pos-ab col-359df5 ui-form-lable");
            }
        }else{
            $(".ui-form-lable").eq(0).html("银行卡");
            $(".ui-form-lable").eq(0).attr("class","pos-ab col-359df5 ui-form-lable");
            $("#confirmBtn").attr("class","btn col-btn1Gray");
        }
    })
    
    $("#phone-num").focus(function(){
      $(".dn").hide();
        if($(this).val()!=""){
            $(".dn").eq(1).show();
        }
    }).keyup(function(){
        if($(this).val()!=""){
            $("#confirmBtn").attr("class","btn col-btnBlue");
        }else{
            $(".ui-form-lable").eq(1).html("支行名称");
            $(".ui-form-lable").eq(1).attr("class","pos-ab col-359df5 ui-form-lable");
            $("#confirmBtn").attr("class","btn col-btn1Gray");
        }
    })
    
    //一键清除
    $(".dn").eq(0).click(function(){
        $("#card-num").val("");
        $(this).hide();
        $(".ui-form-lable").eq(0).html("银行卡");
        $(".ui-form-lable").eq(0).attr("class","pos-ab col-359df5 ui-form-lable");
        $("#confirmBtn").attr("class","btn col-btn1Gray");
    })
    $(".dn").eq(1).click(function(){
        $("#phone-num").val("");
        $(this).hide();
        $(".ui-form-lable").eq(1).html("支行名称");
        $(".ui-form-lable").eq(1).attr("class","pos-ab col-359df5 ui-form-lable");
        $("#confirmBtn").attr("class","btn col-btn1Gray");
    })
    
    //提交表单
//    $("#confirmBtn").click(function(){
//        if(!isNaN($("#card-num").val())&&$("#card-num").val()!=""&&$("#phone-num").val()!=""){
//            var frm = document.getElementById('form');
//                frm.action='card_upt';
//                frm.submit();
//        }
//    })
})