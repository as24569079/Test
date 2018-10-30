  $(function(){
    //查询信息
    var e = $(".dianzi");
    var m = $(".gouwu");
    var zong = 0;
    var zongs = 0;
    for(var i= 0;i<e.length;i++){
        zong+=(e.eq(i).text())*1;
    }
    for(var a= 0;a<m.length;a++){
        zongs+=(m.eq(a).text())*1;
    }
    $("#cart_oriPrice").text(zong);
    $("#cart_rePrice").text(zongs);
    $("#emoney_zong").val(zong);
    $("#smoney_zong").val(zongs);
    $("#cart_realPrice").text(zong*1+zongs*1);
    $.post("cookSelect",function(res){
        eval("var obj="+res);
        $(".jd-footer-links > li:eq(0)>a").html(obj.tel);
    },"text")
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
    
    //判断购物车是否有商品
    $.post("shopcart_true",{},function(res){
        if(res==1){
            $("#kong").hide();
            $("#notEmptyCart").show();
            $("#payment_p").show();
        }
    },"text");
    
    //判断购物车数量为多少
    $.post("shopcart_num",{},function(res){
            if(res!=""){
                $("#checkedNum").html(res);
            }
    },"text")
    
    //编辑商品按钮
    $(".main-pro-btns").click(function(){
        $(this).hide();
        $(this).siblings(".edit-pro-mode").find(".option-btns").show();
    })
    
    //商品完成编辑按钮
    $(".complete-edit-btn").click(function(){
        $(this).parent().parent(".option-btns").hide();
        $(this).parent().parent(".option-btns").parent(".edit-pro-mode").siblings(".main-pro-btns").show();
    })
      //删除商品操作
    $(".deldel").click(function(){
        $("#del_id").val($(this).attr("data-id"));
        $("#pop-delete").fadeIn("slow");
    })
    
    //取消删除商品操作
    $("#cancel").click(function(){
        $("#pop-delete").fadeOut("slow");
        $("#del_id").val("");
    })
    
    //确定删除商品操作
    $("#isok").click(function(){
        var frm = document.getElementById("form");
        frm.action='shopcart_del';
        frm.submit();
    })
    $(".quantity-decrease").click(function(){
       var th = $(this);
        var gou = th.attr("data-val");
        var dian = th.attr("data-em");
       var zhi = th.next().val();
      if(zhi -1 <= 0){
          alert("不可修改");
      }else{
          th.next().val(th.next().val()*1 -1)
        $("#cart_oriPrice").text($("#cart_oriPrice").text() *1 - dian*1);
        $("#cart_rePrice").text($("#cart_rePrice").text()*1 - gou*1);
        $("#emoney_zong").val( $("#emoney_zong").val()*1 - dian *1);
        $("#smoney_zong").val( $("#smoney_zong").val()*1 - gou*1);
        $("#cart_realPrice").text(($("#cart_realPrice").text()*1) - (gou*1 + dian*1)*1);
      }
    })
    $(".smoney_c").click(function(){
        var on = $(this).attr("data-val");
        var number =$(this).parent().next().find(".quantity").val();
        var obj = $(this).parent().next().find(".quantity-decrease");
        var jia = $(this).parent().next().find(".quantity-decrease");
        var jian = $(this).parent().next().find(".quantity-increase");
        var zhi = obj.attr("data-val");
        var sm = obj.attr("data-em");
        if(on == 'on'){
            jia.attr("disabled",true);
            jian.attr("disabled",true);
            $(this).attr("class","cart-checkbox group-8888 smoney_c");
            $(this).attr("data-val","off");
            $("#checkIcon-1").attr("class","cart-checkbox");
//            $("#checkIcon-1").attr("","cart-checkbox");
            $("#cart_oriPrice").text($("#cart_oriPrice").text() *1 - sm*1*number);
            $("#cart_rePrice").text($("#cart_rePrice").text()*1 - zhi*1*number);
            $("#emoney_zong").val( $("#emoney_zong").val()*1 - sm *1*number);
            $("#smoney_zong").val( $("#smoney_zong").val()*1 - zhi*1*number);
            $("#cart_realPrice").text(($("#cart_realPrice").text()*1) - (zhi*1 + sm*1)*number*1);
        }else{
              jian.attr("disabled",false);
              jia.attr("disabled",false);
              $(this).attr("class","cart-checkbox group-8888 checked smoney_c");
            $(this).attr("data-val","on");
             $("#checkIcon-1").attr("class","cart-checkbox checked");
              $("#cart_oriPrice").text($("#cart_oriPrice").text() *1 + sm*1*number);
            $("#cart_rePrice").text($("#cart_rePrice").text()*1 + zhi*1*number);
            $("#emoney_zong").val( $("#emoney_zong").val()*1 + sm *1*number);
            $("#smoney_zong").val( $("#smoney_zong").val()*1 + zhi*1*number);
            $("#cart_realPrice").text(($("#cart_realPrice").text()*1) + (zhi*1 + sm*1)*1*number);
        }
    })
    $(".quantity-increase").click(function(){
        var td = $(this);
        var id = td.attr("data-id");
          var zhi = td.prev().val();
        var gou = td.attr("data-val");
        var dian = td.attr("data-em");
        $.post("shop_num_add",{id:id},function(data){
            if(data){
               if(zhi <= data){
                    
                  td.prev().val(td.prev().val()*1+1);
                    $("#cart_oriPrice").text($("#cart_oriPrice").text() *1 + dian*1);
                    $("#cart_rePrice").text($("#cart_rePrice").text()*1 + gou*1);
                    $("#emoney_zong").val( $("#emoney_zong").val()*1 + dian *1);
                    $("#smoney_zong").val( $("#smoney_zong").val()*1 + gou*1);
                    $("#cart_realPrice").text(($("#cart_realPrice").text()*1) + (gou*1 + dian*1)*1);
               }else{
                   alert("库存不足");
               }
            }
        })
    })
     $("#submit").click(function(){
        var yan = 0;
        var emoney_check = $(".emoney_check");
        var smoney_check = $(".smoney_check");
        var number = 0;
        var num = 0;
        var quantity = $(".quantity");
        for(var i=0;i<emoney_check.length;i++){
            if(emoney_check.eq(i).attr("checked")!="checked"){
                number += 1;
            }
        }
        for(var i=0;i<smoney_check.length;i++){
            if(smoney_check.eq(i).attr("checked")!="checked"){
                num += 1;
            }
        }
        for(var i=0;i<quantity.length;i++){
            if(quantity.eq(i).val()<=0){
                yan += 1 ;
            }else if(isNaN(quantity.eq(i).val())){
                yan += 1;
            }
        }
        if(number == emoney_check.length && num == smoney_check.length){
            alert("请至少选择一件商品");
        }else if(yan > 0){
            alert("价格输入错误");
        }else{
            var frm = document.getElementById('form');
            frm.action='myorder_session';
            frm.submit();
        }
    })
    $("#checkIcon-1").click(function(){
        var s = $(".smoney_c");
        if($(this).attr("data-val")=="on"){
            $(this).attr("class","cart-checkbox");
            $(this).attr("data-val","off");
             $("#cart_oriPrice").text(0);
            $("#cart_rePrice").text(0);
            $("#emoney_zong").val(0);
            $("#smoney_zong").val(0);
            $("#cart_realPrice").text(0);
            for(var a =0;a<s.length;a++){
                s.eq(a).attr("class","cart-checkbox group-8888 smoney_c");
            s.eq(a).attr("data-val","off");
            }
            
        }else{
             $(this).attr("class","cart-checkbox checked");
            $(this).attr("data-val","on");
            for(var a =0;a<s.length;a++){
                s.eq(a).attr("class","cart-checkbox group-8888 smoney_c checked");
            s.eq(a).attr("data-val","on");
            }
        }
    })
    })


