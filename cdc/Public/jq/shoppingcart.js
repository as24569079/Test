$(function(){
    //查询信息
    
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
    
    //商品数量操作
    //新增一个商品
    $(".quantity-increase").click(function(){
        //ajax查询数据表此商品库存为多少
        var add_this = $(this);
        var num = add_this.siblings(".quantity");
        var jian = add_this.siblings(".quantity-decrease");
        $.post("shop_num_add",{id:$(this).attr("data-id")},function(res){
            if(num.val()*1<res*1){
                num.val(num.val()*1+1);
                jian.attr("class","quantity-decrease");
                //商品价格变化
                var price = add_this.attr("data-val");//定义商品价格
                var type = add_this.attr("data-type");//定义商品类别
                if(type==2||type==3){//类别不同显示的总价不一样
                    add_this.parent().siblings(".shp-cart-item-price").children("strong").html(price*num.val());
                    add_this.parent().siblings(".shp-cart-item-price").children(".emoney_price").val(price*num.val());
                    var eprice_zong = 0;
                    var eprice = $(".emoney_price");//电子币总价
                    for(var i=0;i<eprice.length;i++){
                        if(eprice.eq(i).attr("data-val")=="on"){
                            eprice_zong += eprice.eq(i).val()*1;
                        }
                    }
                    $("#cart_oriPrice").html(eprice_zong);
                    $("#emoney_zong").val(eprice_zong);
                }else{
                    add_this.parent().siblings(".shp-cart-item-price").children("strong").html(price*num.val());
                    add_this.parent().siblings(".shp-cart-item-price").children(".smoney_price").val(price*num.val());
                    var sprice = $(".smoney_price");//购物币总价
                    var sprice_zong = 0;
                    for(var i=0;i<sprice.length;i++){
                        if(sprice.eq(i).attr("data-val")=="on"){
                            sprice_zong += sprice.eq(i).val()*1;4
                        }
                    }
                    $("#cart_rePrice").html(sprice_zong);
                    $("#smoney_zong").val(sprice_zong);
                } 
                $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + $("#smoney_zong").val()*1));
            }else{
                alert("此商品库存不足");
                num.val(res);
                add_this.attr("class","quantity-increase  disabled");
                jian.attr("class","quantity-decrease");
            }
        },"text")
    })
    //减少一个商品
    $(".quantity-decrease").click(function(){
        var jian = $(this);
        var add_this = jian.siblings(".quantity-increase");
        var num = add_this.siblings(".quantity");
        if(num.val()*1>1){
            num.val(num.val()*1-1);
            add_this.attr("class","quantity-increase");
            var price = jian.attr("data-val");
            var type = jian.attr("data-type");//定义商品类别
            if(type==2||type==3){//类别不同显示的总价不一样
                jian.parent().siblings(".shp-cart-item-price").children("strong").html(price*num.val());
                jian.parent().siblings(".shp-cart-item-price").children(".emoney_price").val(price*num.val());
                var eprice_zong = 0;
                var eprice = $(".emoney_price");//电子币总价
                for(var i=0;i<eprice.length;i++){
                    if(eprice.eq(i).attr("data-val")=="on"){
                        eprice_zong += eprice.eq(i).val()*1;
                    }
                }
                $("#cart_oriPrice").html(eprice_zong);
                $("#emoney_zong").val(eprice_zong);
            }else{
                jian.parent().siblings(".shp-cart-item-price").children("strong").html(price*num.val());
                jian.parent().siblings(".shp-cart-item-price").children(".smoney_price").val(price*num.val());
                var sprice = $(".smoney_price");//购物币总价
                var sprice_zong = 0;
                for(var i=0;i<sprice.length;i++){
                    if(sprice.eq(i).attr("data-val")=="on"){
                        sprice_zong += sprice.eq(i).val()*1;
                    }
                }
                $("#cart_rePrice").html(sprice_zong);
                $("#smoney_zong").val(sprice_zong);
            } 
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + $("#smoney_zong").val()*1));
        }else{
            alert("修改商品数量失败");
            num.val(1);
            jian.attr("class","quantity-decrease disabled");
        }
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
    
    //大众创业标题显示
    var smoney = $(".smoney");
    var emoney = $(".emoeny");
    if(smoney.length>0){
        $("#chuangye").show();
    }else{
        $("#chuangye").hide();
    }
    if(emoney.length>0){
        $("#dazhong").show();
    }else{
        $("#dazhong").hide();
    }
    
    //多选(大众商城)
    $(".emoney_c").click(function(){
        var num = 0;
        var number = 0;
        var zhi = $(this).parent().parent().find(".emoney_price");
        if($(this).attr("data-val")=="on"){
            zhi.attr("data-val","off");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("class","quantity-increase disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("disabled","disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("class","quantity-decrease disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("disabled","disabled");
            $(this).attr("class","cart-checkbox group-165367 emoney_c");
            $(this).siblings(".emoney_check").removeAttr("checked");
            $(this).attr("data-val","off");
            var smoney_c = $(".smoney_c");
            var emoney_check = $(".emoney_check");
            var emoney_c = $(".emoney_c");
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="off"){
                    num+=1;
                }
            }
            for(var i=0;i<smoney_c.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="off"){
                    number+=1;
                }
            }
            if(num==emoney_c.length){
                $("#emoney_ck").attr("class","cart-checkbox group-165367");
                $("#emoney_ck").attr("data-val","off");
            }
            if(num==emoney_c.length&&number==smoney_c.length){
                $("#checkIcon-1").attr("class","cart-checkbox group-165367");
                $("#checkIcon-1").attr("data-val","off");
            }
            //计算结果
            $("#cart_oriPrice").html($("#cart_oriPrice").html()*1-zhi.val()*1);
            $("#emoney_zong").val($("#emoney_zong").val()*1-zhi.val()*1);
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1+$("#emoney_zong").val()*1));
        }else{
            zhi.attr("data-val","on");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("class","quantity-increase");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").removeAttr("disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("class","quantity-decrease");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").removeAttr("disabled");
            $(this).attr("class","cart-checkbox group-8888 checked emoney_c");
            $(this).siblings(".emoney_check").attr("checked","checked");
            $(this).attr("data-val","on");
            var smoney_c = $(".smoney_c");
            var emoney_check = $(".emoney_check");
            var emoney_c = $(".emoney_c");
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="on"){
                    num+=1;
                }
            }
            for(var i=0;i<smoney_c.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="on"){
                    number+=1;
                }
            }
            if(num==emoney_c.length){
                $("#emoney_ck").attr("class","cart-checkbox group-8888 checked");
                $("#emoney_ck").attr("data-val","on");
            }
            if(num==emoney_c.length&&number==smoney_c.length){
                $("#checkIcon-1").attr("class","cart-checkbox group-8888 checked");
                $("#checkIcon-1").attr("data-val","on");
            }
            //计算结果
            $("#cart_oriPrice").html($("#cart_oriPrice").html()*1+zhi.val()*1);
            $("#emoney_zong").val($("#emoney_zong").val()*1+zhi.val()*1);
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1+$("#emoney_zong").val()*1));
        }
    })
    
    //全选(大众商城)
    $("#emoney_ck").click(function(){   
        var price = $(".emoney_price");
            var jijia = 0;
            for(var i=0;i<price.length;i++){
                jijia += price.eq(i).val()*1;
            }
        if($(this).attr("data-val")=="on"){
            $(this).attr("class","cart-checkbox group-165367");
            $(this).attr("data-val","off");
            if($(this).attr("data-val")=="off"&&$("#smoney_ck").attr("data-val")=="off"){
                $("#checkIcon-1").attr("class","cart-checkbox group-165367");
                $("#checkIcon-1").attr("data-val","off");
            }
            var emoney_c = $(".emoney_c");
            var emoney_check = $(".emoney_check");
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="on"){
                    emoney_check.eq(i).removeAttr("checked");
                    emoney_c.eq(i).attr("data-val","off");
                    emoney_c.eq(i).attr("class","cart-checkbox group-165367 emoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                if($(".quantity-increase").eq(i).attr("data-shop")=="2"){
                    $(".quantity-increase").eq(i).attr("class","quantity-increase disabled");
                    $(".quantity-increase").eq(i).attr("disabled","disabled");
                    $(".quantity-decrease").eq(i).attr("class","quantity-decrease disabled");
                    $(".quantity-decrease").eq(i).attr("disabled","disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".emoney_price");//电子币总价
            var eprice_zong = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
            $("#cart_oriPrice").html(eprice_zong*1 - jijia*1);
            $("#emoney_zong").val(eprice_zong - jijia*1);
            $("#checkedNum").html($(".quantity-increase").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1));
        }else{
            $(this).attr("class","cart-checkbox group-8888 checked");
            $(this).attr("data-val","on");
            if($(this).attr("data-val")=="on"&&$("#smoney_ck").attr("data-val")=="on"){
                $("#checkIcon-1").attr("class","cart-checkbox group-8888 checked");
                $("#checkIcon-1").attr("data-val","on");
            }
            var emoney_c = $(".emoney_c");
            var emoney_check = $(".emoney_check");
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="off"){
                    emoney_check.eq(i).attr("checked","checked");
                    emoney_c.eq(i).attr("data-val","on");
                    emoney_c.eq(i).attr("class","cart-checkbox group-8888 checked emoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                if($(".quantity-increase").eq(i).attr("data-shop")=="2"){
                    $(".quantity-increase").eq(i).attr("class","quantity-increase");
                    $(".quantity-increase").eq(i).removeAttr("disabled");
                    $(".quantity-decrease").eq(i).attr("class","quantity-decrease");
                    $(".quantity-decrease").eq(i).removeAttr("disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".emoney_price");//电子币总价
            var eprice_zong = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
            $("#cart_oriPrice").html(eprice_zong);
            $("#emoney_zong").val(eprice_zong);
            $("#checkedNum").html($(".quantity-increase").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1 + jijia*1));
        }
    })
    
    //多选(创业商城)
    
    $(".smoney_c").click(function(){
        var num = 0;
        var number = 0;
        var zhi = $(this).parent().parent().find(".smoney_price");
        if($(this).attr("data-val")=="on"){
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("class","quantity-increase disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("disabled","disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("class","quantity-decrease disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("disabled","disabled");
            $(this).attr("class","cart-checkbox group-165367 smoney_c");
            $(this).siblings(".smoney_check").removeAttr("checked");
            $(this).attr("data-val","off");
            zhi.attr("data-val","off");
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            var emoney_c = $(".emoney_c");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="off"){
                    num+=1;
                }
            }
            for(var i=0;i<emoney_c.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="off"){
                    number+=1;
                }
            }
            if(num==smoney_c.length){
                $("#smoney_ck").attr("class","cart-checkbox group-165367");
                $("#smoney_ck").attr("data-val","off");
            }
            if(num==smoney_c.length&&number==emoney_c.length){
                $("#checkIcon-1").attr("class","cart-checkbox group-165367");
                $("#checkIcon-1").attr("data-val","off");
            }
            //计算结果
            $("#cart_rePrice").html($("#cart_rePrice").html()*1-zhi.val()*1);
            $("#smoney_zong").val($("#smoney_zong").val()*1-zhi.val()*1);
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1+$("#emoney_zong").val()*1));
        }else{
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").attr("class","quantity-increase");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-increase").removeAttr("disabled");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").attr("class","quantity-decrease");
            $(this).parent().siblings(".shop-cart-display").children(".edit-pro-mode").find(".quantity-decrease").removeAttr("disabled");
            $(this).attr("class","cart-checkbox group-8888 checked smoney_c");
            $(this).siblings(".smoney_check").attr("checked","checked");
            $(this).attr("data-val","on");
            zhi.attr("data-val","on");
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            var emoney_c = $(".emoney_c");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="on"){
                    num+=1;
                }
            }
            for(var i=0;i<emoney_c.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="on"){
                    number+=1;
                }
            }
            if(num==smoney_c.length){
                $("#smoney_ck").attr("class","cart-checkbox group-8888 checked");
                $("#smoney_ck").attr("data-val","on");
            }
            if(num==smoney_c.length&&number==emoney_c.length){
                $("#checkIcon-1").attr("class","cart-checkbox group-8888 checked");
                $("#checkIcon-1").attr("data-val","on");
            }
            //计算结果
            $("#cart_rePrice").html($("#cart_rePrice").html()*1+zhi.val()*1);
            $("#smoney_zong").val($("#smoney_zong").val()*1+zhi.val()*1);
            $("#cart_realPrice").html("¥"+ ($("#smoney_zong").val()*1+$("#emoney_zong").val()*1));
        }
    })
    
    //全选（创业商城）
    $("#smoney_ck").click(function(){
        var price = $(".smoney_price");
            var jijia = 0;
            for(var i=0;i<price.length;i++){
                jijia += price.eq(i).val()*1;
            }
        if($(this).attr("data-val")=="on"){
            $(this).attr("class","cart-checkbox group-165367");
            $(this).attr("data-val","off");
            if($(this).attr("data-val")=="off"&&$("#emoney_ck").attr("data-val")=="off"){
                $("#checkIcon-1").attr("class","cart-checkbox group-165367");
                $("#checkIcon-1").attr("data-val","off");
            }
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="on"){
                    smoney_check.eq(i).removeAttr("checked");
                    smoney_c.eq(i).attr("data-val","off");
                    smoney_c.eq(i).attr("class","cart-checkbox group-165367 smoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                if($(".quantity-increase").eq(i).attr("data-shop")=="1"){
                    $(".quantity-increase").eq(i).attr("class","quantity-increase disabled");
                    $(".quantity-increase").eq(i).attr("disabled","disabled");
                    $(".quantity-decrease").eq(i).attr("class","quantity-decrease disabled");
                    $(".quantity-decrease").eq(i).attr("disabled","disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".smoney_price");//电子币总价
            var eprice_zong = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
            $("#cart_rePrice").html(eprice_zong*1 - jijia*1);
            $("#smoney_zong").val(eprice_zong - jijia*1);
            $("#checkedNum").html($(".quantity-increase").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1));
        }else{
            $(this).attr("class","cart-checkbox group-8888 checked");
            $(this).attr("data-val","on");
            if($(this).attr("data-val")=="on"&&$("#emoney_ck").attr("data-val")=="on"){
                $("#checkIcon-1").attr("class","cart-checkbox group-8888 checked");
                $("#checkIcon-1").attr("data-val","on");
            }
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="off"){
                    smoney_check.eq(i).attr("checked","checked");
                    smoney_c.eq(i).attr("data-val","on");
                    smoney_c.eq(i).attr("class","cart-checkbox group-8888 checked smoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                if($(".quantity-increase").eq(i).attr("data-shop")=="1"){
                    $(".quantity-increase").eq(i).attr("class","quantity-increase");
                    $(".quantity-increase").eq(i).removeAttr("disabled");
                    $(".quantity-decrease").eq(i).attr("class","quantity-decrease");
                    $(".quantity-decrease").eq(i).removeAttr("disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".smoney_price");//电子币总价
            var eprice_zong = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
            $("#cart_rePrice").html(eprice_zong);
            $("#smoney_zong").val(eprice_zong);
            $("#checkedNum").html($(".quantity-increase").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + jijia*1));
        }
    })
    
    //全选（全部商品-总计）
    
    $("#checkIcon-1").click(function(){
        if($(this).attr("data-val")=="on"){
            $(this).attr("class","cart-checkbox group-165367");
            $(this).attr("data-val","off");
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            var emoney_c = $(".emoney_c");
            var emoney_check = $(".emoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="on"){
                    smoney_check.eq(i).removeAttr("checked");
                    smoney_c.eq(i).attr("data-val","off");
                    smoney_c.eq(i).attr("class","cart-checkbox group-165367 smoney_c");
                }
            }
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="on"){
                    emoney_check.eq(i).removeAttr("checked");
                    emoney_c.eq(i).attr("data-val","off");
                    emoney_c.eq(i).attr("class","cart-checkbox group-165367 emoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                $(".quantity-increase").eq(i).attr("class","quantity-increase disabled");
                $(".quantity-increase").eq(i).attr("disabled","disabled");
                $(".quantity-decrease").eq(i).attr("class","quantity-decrease disabled");
                $(".quantity-decrease").eq(i).attr("disabled","disabled");
            }
            $("#smoney_ck").attr("class","cart-checkbox group-165367");
            $("#smoney_ck").attr("data-val","off");
            $("#emoney_ck").attr("class","cart-checkbox group-165367");
            $("#emoney_ck").attr("data-val","off");
            //清空总计价格
            $("#cart_oriPrice").html("0");
            $("#emoney_zong").val("0");
            $("#cart_rePrice").html("0");
            $("#smoney_zong").val("0");
            $("#cart_realPrice").html("0");
            $("#checkedNum").html("0");
        }else{
            $(this).attr("class","cart-checkbox group-8888 checked");
            $(this).attr("data-val","on");
            var smoney_c = $(".smoney_c");
            var smoney_check = $(".smoney_check");
            var emoney_c = $(".emoney_c");
            var emoney_check = $(".emoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="off"){
                    smoney_check.eq(i).attr("checked","checked");
                    smoney_c.eq(i).attr("data-val","on");
                    smoney_c.eq(i).attr("class","cart-checkbox group-8888 checked smoney_c");
                }
            }
            for(var i=0;i<emoney_check.length;i++){
                if(emoney_c.eq(i).attr("data-val")=="off"){
                    emoney_check.eq(i).attr("checked","checked");
                    emoney_c.eq(i).attr("data-val","on");
                    emoney_c.eq(i).attr("class","cart-checkbox group-8888 checked emoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increase").length;i++){
                $(".quantity-increase").eq(i).attr("class","quantity-increase");
                $(".quantity-increase").eq(i).removeAttr("disabled");
                $(".quantity-decrease").eq(i).attr("class","quantity-decrease");
                $(".quantity-decrease").eq(i).removeAttr("disabled");
            }
            $("#smoney_ck").attr("class","cart-checkbox group-8888 checked");
            $("#smoney_ck").attr("data-val","on");
            $("#emoney_ck").attr("class","cart-checkbox group-8888 checked");
            $("#emoney_ck").attr("data-val","on");
            //重新定义商品价格
            var eprice = $(".emoney_price");//电子币总价
            var eprice_zong = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
            $("#cart_oriPrice").html(eprice_zong);
            $("#emoney_zong").val(eprice_zong);
            var sprice = $(".smoney_price");//购物币总价
            var sprice_zong = 0;
            for(var i=0;i<sprice.length;i++){
                sprice_zong += sprice.eq(i).val()*1;
            }
            $("#cart_rePrice").html(sprice_zong);
            $("#smoney_zong").val(sprice_zong);
            $("#checkedNum").html($(".quantity-increase").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + $("#smoney_zong").val()*1));
        }
    })
    
    //显示总计价格
    var eprice = $(".emoney_price");//电子币总价
    var eprices = $(".emoney_prices");//电子币总价
    var eprice_zong = 0;
    var eprice_zongs = 0;
    for(var i=0;i<eprice.length;i++){
        eprice_zong += eprice.eq(i).val()*1;
    }
     for(var i=0;i<eprices.length;i++){
        eprice_zongs += eprices.eq(i).val()*1;
    }
    $("#cart_oriPrice").html(eprice_zong + eprice_zongs);
    $("#emoney_zong").val(eprice_zong + eprice_zongs);
    var sprice = $(".smoney_price");//购物币总价
    var sprices = $(".ssmoney_price");//购物币总价
    var sprice_zong = 0;
    var sprice_zongs = 0;
    for(var i=0;i<sprice.length;i++){
        sprice_zong += sprice.eq(i).val()*1;
    }
    for(var i=0;i<sprices.length;i++){
        sprice_zongs += sprices.eq(i).val()*1;
    }
    $("#cart_rePrice").html(sprice_zong + sprice_zongs);
    $("#smoney_zong").val(sprice_zong +sprice_zongs);
    
    //总计
    $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + $("#smoney_zong").val()*1));
    
    //提交按钮
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
     //全选（年货nmoney_ck商城）
    $("#nmoney_ck").click(function(){
        var price = $(".ssmoney_price");
        var prices = $(".emoney_prices");
        
            var jijia = 0;
            var jiae = 0;
            for(var i=0;i<price.length;i++){
                jijia += price.eq(i).val()*1;
            }
              for(var s=0;s<prices.length;s++){
                jiae += prices.eq(s).val()*1;
            }
       
        if($(this).attr("data-val")=="on"){
            $(this).attr("class","cart-checkbox group-165367");
            $(this).attr("data-val","off");
            if($(this).attr("data-val")=="off"&&$("#nmoney_ck").attr("data-val")=="off"){
                $("#checkIcon-1").attr("class","cart-checkbox group-165367");
                $("#checkIcon-1").attr("data-val","off");
            }
            var smoney_c = $(".nmoney_c");
            var smoney_check = $(".nmoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="on"){
                    smoney_check.eq(i).removeAttr("checked");
                    smoney_c.eq(i).attr("data-val","off");
                    smoney_c.eq(i).attr("class","cart-checkbox group-165367 nmoney_c");
                }
            }
            for(var i=0;i<$(".quantity-increasess").length;i++){
                if($(".quantity-increasess").eq(i).attr("data-shop")=="1"){
                    $(".quantity-increasess").eq(i).attr("class","quantity-increasess disabled");
                    $(".quantity-increasess").eq(i).attr("disabled","disabled");
                    $(".quantity-decrease").eq(i).attr("class","quantity-decrease disabled");
                    $(".quantity-decrease").eq(i).attr("disabled","disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".ssmoney_price");//电子币总价
            var eprices = $(".emoney_prices");//电子币总价
        
            var eprice_zong = 0; //购物比
            var eprice_zongs = 0;//电子币
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
             for(var i=0;i<eprices.length;i++){
                eprice_zongs += eprices.eq(i).val()*1;
            }
          
            $("#cart_rePrice").html($("#smoney_zong").val() *1 - eprice_zong*1);
            $("#cart_oriPrice").html( $("#emoney_zong").val()*1 - eprice_zongs*1);
            $("#smoney_zong").val($("#smoney_zong").val() *1 - eprice_zong*1);
            $("#emoney_zong").val($("#emoney_zong").val()*1 - eprice_zongs*1);
            $("#checkedNum").html($(".quantity-increasess").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1));
        }else{
            $(this).attr("class","cart-checkbox group-8888 checked");
            $(this).attr("data-val","on");
            if($(this).attr("data-val")=="on"&&$("#nmoney_ck").attr("data-val")=="on"){
                $("#checkIcon-1").attr("class","cart-checkbox group-8888 checked");
                $("#checkIcon-1").attr("data-val","on");
            }
            var smoney_c = $(".nmoney_c");
            var smoney_check = $(".nmoney_check");
            for(var i=0;i<smoney_check.length;i++){
                if(smoney_c.eq(i).attr("data-val")=="off"){
                    smoney_check.eq(i).attr("checked","checked");
                    smoney_c.eq(i).attr("data-val","on");
                    smoney_c.eq(i).attr("class","cart-checkbox group-8888 checked nmoney_c");
                }
            }
             
            for(var i=0;i<$(".quantity-increasess").length;i++){
                if($(".quantity-increasess").eq(i).attr("data-shop")=="1"){
                    $(".quantity-increasess").eq(i).attr("class","quantity-increasess");
                    $(".quantity-increasess").eq(i).removeAttr("disabled");
                    $(".quantity-decreasess").eq(i).attr("class","quantity-decrease");
                    $(".quantity-decreasess").eq(i).removeAttr("disabled");
                }
            }
            //重新定义商品价格
            var eprice = $(".ssmoney_price");//电子币总价
            var eprice_zong = 0;
              var eprices = $(".emoney_prices");//电子币总价
       
            var eprice_zongs = 0;
            for(var i=0;i<eprice.length;i++){
                eprice_zong += eprice.eq(i).val()*1;
            }
             for(var i=0;i<eprices.length;i++){
                eprice_zongs += eprices.eq(i).val()*1;
            }
            $("#cart_rePrice").html(eprice_zong *1 + $("#smoney_zong").val()*1);
             $("#cart_oriPrice").html(eprice_zongs*1 + $("#emoney_zong").val()*1);
            $("#smoney_zong").val(eprice_zong *1 + $("#smoney_zong").val()*1);
              $("#emoney_zong").val(eprice_zongs*1 + $("#emoney_zong").val()*1);
            $("#checkedNum").html($(".quantity-increasess").length);
            //总计
            $("#cart_realPrice").html("¥"+ ($("#emoney_zong").val()*1 + jijia*1 + jiae*1));
        }
    })
})