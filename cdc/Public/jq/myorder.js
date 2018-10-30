$(function(){
    //显示商品总数量
    var emoney_li = $(".emoney_num");
    var smoney_li = $(".smoney_num");
    $("#gong_num").html(emoney_li.length + smoney_li.length);
    //实际付款
    var emoney = $("#emoney_zj").val();
    var smoney = $("#smoney_zj").val();
    $("#payMoney > span").html(emoney*1 + smoney*1);
    
    //收货地址验证
    if($("#user_address").val()==""){
        $("#address-default").hide();
    }else{
        $("#address-default").show();
    }
    //头部导航
    $("#m_common_header_jdkey").click(function(){
        if($(this).attr("data-val")=="off"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","on");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","off");
        }
    })
    
    //提交表单验证
    $("#submit").click(function(){
        if($("#user_address").val()==""){
            $("#message-dialog").fadeIn("slow");
        }else{
            $("#message-dialog2").fadeIn("slow");
            $("#title_tishi").html("确定要使用此收货地址吗？" + $("#user_address").val())
        }
    }) 
    //关闭更换地址提示
    $("#address_close").click(function(){
        $("#message-dialog2").fadeOut("slow");
    })
    //更换地址
    $("#address_geng").click(function(){
        window.location.href='address';
    })
    //继续支付
    $("#address_zhifu").click(function(){
        if($("#user_address").val()==""){
            $("#message-dialog").fadeIn("slow");
        }else{
            var frm = document.getElementById('form');
            frm.action='order_add';
            frm.submit();
        }
    })
    $("#address_zhifu2").click(function(){
        if($("#user_address").val()==""){
            $("#message-dialog").fadeIn("slow");
        }else{
            var frm = document.getElementById('form');
            frm.action='menpiao_add';
            frm.submit();
        }
    })
    //关闭提示
    $("#check-btn22").click(function(){
        $("#message-dialog").fadeOut("slow");
    })
    
    //添加地址跳转
    $("#check-btn11").click(function(){
        window.location.href='address';
    })
    
//    //跳转产品详情
//    $("#commodityInfoDivID").click(function(){
//        window.location.href='shop_xq';
//    })
})