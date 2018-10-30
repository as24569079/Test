$(function(){
    //隐藏添加银行卡
    var li = $(".li");
    if(li.length>=4){
        $("#add").hide();
    }else{
        $("#add").show();
    }
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
    
    //银行卡修改删除操作
    $(".li").click(function(){
        $("#hide").show();
        $("#tishi").html("您可对"+$(this).children(".type").val()+"尾号"+$(this).children(".weihao").val()+"的银行卡进行操作");
        $("#card").val($(this).children(".y_id").val());
        $("#del_id").val($(this).children(".y_id").val());
    })
    
    //关闭银行卡操作
    $("#close").click(function(){
        $("#hide").hide();
        $("#tishi").html("");
        $("#card").val("");
    })
    
    //修改银行卡操作
    $("#upt").click(function(){
        if($("#card").val()!=""){
            var card = $("#card").val();
            window.location.href='tomodifycardpage/y_id/'+card;
        }
    })
    
    //删除银行卡操作
    $("#del").click(function(){
        $("#del_div").show();
        $("#hide").hide();
    })
    
    //关闭删除银行卡操作
    $("#del_close").click(function(){
        $("#del_div").hide(); 
        $("#del_id").val("");
    })
    
    //确定删除
    $("#del_sub").click(function(){
        if($("#del_id").val()!=""){
            var id = $("#del_id").val();
            window.location.href='card_del/y_id/'+id;
        }
    })
})