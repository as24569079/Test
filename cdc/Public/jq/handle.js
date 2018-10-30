$(function(){
    //无刷新显示用户名称
    $("#exampleInputEmail1").blur(function(){
        $("#zizhi_ti").detach();
        if($(this).attr("data-kai")=="off"){
            var value = $(this).val();
            $.post("peoselect",{value:value},
            function(data){
                if(data!=233&&data!="false"){
                    eval("var obj="+data);
                    $("#user").html("已找到客户"+obj.real_name+",客户电子币余额为<em class='color'>"+obj.emoney+"元</em>");
                    $("#user_emoney").val(obj.emoney);
                    $("#exampleInputEmail1").attr("data-val","ture");
                    var tel = obj.tel;
                    $.post("option_ucca",{tel:tel},function(data){
                        if(data!="null"){
                            eval("var res ="+data);
                            var yucun;
                            for(var i=0;i<res.length;i++){
                                if(res[i].tiaojia == "1"){
                                    if(res[i].goods_id=="99000"){
                                        yucun = 40600;
                                    }else if(res[i].goods_id=="149000"){
                                        yucun = 60900;
                                    }else if(res[i].goods_id=="199000"){
                                        yucun = 81200;
                                    }
                                    $("#select").append("<div class='checkbox'><label><input type='checkbox' class='op' value='"+res[i].crdentials_id+"' data-val='"+res[i].goods_id+"' name='check[]' data-kai='off'  data-tiaojia='"+res[i].tiaojia+"'>子账户："+res[i].zizhanghu+"，用户资质："+res[i].goods_id+"</label></div>");
                                }else{
                                    if(res[i].goods_id=="99000"){
                                        yucun = 36000;
                                    }else if(res[i].goods_id=="149000"){
                                        yucun = 55000;
                                    }else if(res[i].goods_id=="199000"){
                                        yucun = 73000;
                                    }
                                    $("#select").append("<div class='checkbox'><label><input type='checkbox' class='op' value='"+res[i].crdentials_id+"' data-val='"+res[i].goods_id+"' name='check[]' data-kai='off' data-tiaojia='"+res[i].tiaojia+"'>子账户："+res[i].zizhanghu+"，用户资质："+res[i].goods_id+"</label></div>");
                                }
                            }
                            $("#sel_lab").show();
                            $("#exampleInputEmail1").attr("data-kai","on");
                        }else{
                            $(".op").detach();
                            $("#select").append("<span id='zizhi_ti'>此账户尚未签约家装资质</span>");
                        }
                    },"text")
                }else{
                    $("#user").html("未找到该用户");
                    $("#exampleInputEmail1").attr("data-val","false");
                    $(".op").detach();
                }
            },"text");
        }
    })
    var number = 0;
    //多选显示金额
    $(".op").live("click",function(){
        if($(this).attr("data-tiaojia")=="1"){
            var num1 = 40600;
            var num2 = 60900;
            var num3 = 81200; 
        }else{
            var num1 = 36000;
            var num2 = 55000;
            var num3 = 73000; 
        }
        if($(this).attr("checked")=="checked"){
            $("#zhifuxiangqing").show();
            if($(this).attr("data-val")=="99000"){
                $("#em").html($("#em").text()*1+num1*1);
                $("#em2").html($("#em2").text()*1+num1*1);
                var zongji = $("#em").text()*1 ;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1+num1*1);
                $("#jiancai").val($("#jiancai").val()*1+num1*1);
                $("#jine").removeAttr("disabled");
            }else if($(this).attr("data-val")=="149000"){
                $("#em").html($("#em").text()*1+num2*1);
                $("#em2").html($("#em2").text()*1+num2*1);
                var zongji = $("#em").text()*1;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1+num2*1);
                $("#jiancai").val($("#jiancai").val()*1+num2*1);
                $("#jine").removeAttr("disabled");
            }else if($(this).attr("data-val")=="199000"){
                $("#em").html($("#em").text()*1+num3*1);
                $("#em2").html($("#em2").text()*1+num3*1);
                var zongji = $("#em").text()*1;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1+num3*1);
                $("#jiancai").val($("#jiancai").val()*1+num3*1);
                $("#jine").removeAttr("disabled");
            }
//            var yue = parseInt($("#user_emoney").val()) - parseInt($("#em3").text()*1);
//            if(yue > 0){
//                $("#emoney").html($("#em3").text());
//                $("#xianjin").html(0);
//            }else{
//                $("#emoney").html($("#user_emoney").val());
//                yue = 0-yue;
//                $("#xianjin").html(yue);
//            }
        }else{
            if($(this).attr("data-val")=="99000"){
                $("#em").html($("#em").text()*1-num1*1);
                $("#em2").html($("#em2").text()*1-num1*1);
                var zongji = $("#em").text()*1 ;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1-num1*1);
                $("#jiancai").val($("#jiancai").val()*1-num1*1);
                $("#jine").removeAttr("disabled");
            }else if($(this).attr("data-val")=="149000"){
                $("#em").html($("#em").text()*1-num2*1);
                $("#em2").html($("#em2").text()*1-num2*1);
                var zongji = $("#em").text()*1 ;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1-num2*1);
                $("#jiancai").val($("#jiancai").val()*1-num2*1);
                $("#jine").removeAttr("disabled");
            }else if($(this).attr("data-val")=="199000"){
                $("#em").html($("#em").text()*1-num3*1);
                $("#em2").html($("#em2").text()*1-num3*1);
                var zongji = $("#em").text()*1 ;
//                $("#em3").html(zongji);
                $("#zong").val(zongji); 
                $("#money").val($("#money").val()*1-num3*1);
                $("#jiancai").val($("#jiancai").val()*1-num3*1);
                $("#jine").removeAttr("disabled");
            }
//            var yue = $("#user_emoney").val()*1 - $("#em3").text()*1;
//            if(yue > 0){
//                $("#emoney").html($("#em3").text());
//                $("#xianjin").html(0);
//            }else{
//                $("#emoney").html($("#user_emoney").val());
//                yue = 0-yue
//                $("#xianjin").html(yue);
//            }
        }
//        for(var i=0;i<$(".op").length;i++){
//            if($(".op").eq(i).attr("checked")=="checked"){
//                $("#xianshi").show();
//            }
//        }
    })
    //无刷新显示店长名称
    $("#dianzhang").blur(function(){
        var value = $(this).val();
        $.post("peoselect",{value:value},
        function(data){
            if(data!=233&&data!="false"){
                eval("var obj="+data);
                $("#user2").html("已找到店长"+obj.real_name);
                $("#dianzhang").attr("data-val","ture");
            }else{
                $("#user2").html("未找到该用户");
                $("#dianzhang").attr("data-val","false");
            }
        },"text");
    })
    //无刷新显示设计师名称
    $("#sheji").blur(function(){
        var value = $(this).val();
        $.post("peoselect",{value:value},
        function(data){
            if(data!=233&&data!="false"){
                eval("var obj="+data);
                $("#user3").html("已找到设计师"+obj.real_name);
                $("#sheji").attr("data-val","ture");
            }else{
                $("#user3").html("未找到该用户");
                $("#sheji").attr("data-val","false");
            }
        },"text");
    })
    //显示超出金额运算
    $("#jine").keyup(function(){
        if($(this).val()!=""){
            var jieguo = $(this).val()*1-$("#zong").val()*1;
            var jieguo2 = $(this).val()*1 + $("#zong").val()*1;
            var jieguo3 = jieguo*1 - $("#user_emoney").val()*1;
            if(jieguo>=0){
                $("#youhui").html("已享受装修优惠<em>"+$("#em2").text()+"</em><em>.00</em><span>元</span>")
                $("#chaochu").html("科艺隆合同超出金额<em>"+jieguo+"</em><em>.00</em><span>元</span>");
                $("#jiaona").html("支付电子币<em class='color'>"+$("#user_emoney").val()+"</em><span class='color'>元</span>");
                $("#shiji").html("支付现金<em class='color'>"+jieguo3+"</em><em class='color'>.00</em><span class='color'>元</span>");
                $("#em3").html(jieguo2);
                $("#input").val(jieguo);
            }else{
                $("#chaochu").html("金额错误");
            }
        }
    })
    //隔离层获取高
    $("#div").height($(document).height());
    //点击隐藏隔离层
    $("#div").click(function(){
        $(this).fadeOut("slow");
    })  
    //表单验证
    $("#form").submit(function(){
        if($("#exampleInputEmail1").val()==""){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入客户手机号码");
            var Timer = setInterval(time,2000);
            return false;
        }else if(isNaN($("#exampleInputEmail1").val())){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#exampleInputEmail1").val().length!=11){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的11位手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#exampleInputEmail1").attr("data-val")=="false"){
            $("#div").fadeIn("slow");
            $("#div > div").html("未找到该用户,请重新核对手机号码");
            Timer = setInterval(time,2000);
            return false;
        }
        if($("#danhao").val()==""){
            $("#div").fadeIn("slow");
            $("#div > div").html("请填写合同单号");
            Timer = setInterval(time,2000);
            return false;
        }
        var op_yanzheng;
        for(var i=0;i<$(".op").length;i++){
            if($(".op").eq(i).attr("checked")=="checked"){
                op_yanzheng = 1;
            }
        }
        if(op_yanzheng!=1){
            $("#div").fadeIn("slow");
            $("#div > div").html("请选择用户资质");
            Timer = setInterval(time,2000);
            return false;
        }
        if(isNaN($("#jine").val())){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入数字!");
            Timer = setInterval(time,2000);
            return false;
        }
        if($("#dianzhang").val()==""){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入客户经理手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if(isNaN($("#dianzhang").val())){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#dianzhang").val().length!=11){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的11位手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#dianzhang").attr("data-val")=="false"){
            $("#div").fadeIn("slow");
            $("#div > div").html("未找到该用户,请重新核对手机号码");
            Timer = setInterval(time,2000);
            return false;
        }
        if($("#sheji").val()==""){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入设计师手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if(isNaN($("#sheji").val())){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#sheji").val().length!=11){
            $("#div").fadeIn("slow");
            $("#div > div").html("请输入正确的11位手机号码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#sheji").attr("data-val")=="false"){
            $("#div").fadeIn("slow");
            $("#div > div").html("未找到该用户,请重新核对手机号码");
            Timer = setInterval(time,2000);
            return false;
        }
        if($("#number").val()==""){
            $("#div").fadeIn("slow");
            $("#div > div").html("请填写客户手机短信验证码");
            Timer = setInterval(time,2000);
            return false;
        }else if($("#number").val()!=$("#yzm").val()){
            $("#div").fadeIn("slow");
            $("#div > div").html("客户手机短信验证码不正确或已过期");
            Timer = setInterval(time,2000);
            return false;
        }
        function time(){
            $("#div").fadeOut("slow");
            clearInterval(Timer);
        }
    })
    
    //发送手机短信验证码
    var num = 60;
    $("#send").click(function(){
        var rand = "";
        for(var i = 0; i < 4; i++){
            var r = Math.floor(Math.random() * 10);
            rand += r;
        }
        if($("#exampleInputEmail1").attr("data-val")=="ture"){
            var tel = $("#exampleInputEmail1").val();
            $.post("send_phone",{rand:rand,tel:tel},function(data){
                var Time = setInterval(timer,1000);
                function timer(){
                    num--;
                    $("#send").val(num+"秒后可重新发送");
                    if(num==0){
                        $("#send").removeAttr("disabled");
                        num = 60;
                        $("#send").val("重新发送");
                        clearInterval(Time);
                    }
                }
                $("#send").attr("disabled","disabled");
                $("#yzm").val(data);
            },"text");
        }else{
            var Timer;
            $("#div").fadeIn("slow");
            $("#div > div").html("未找到该用户,请重新核对手机号码");
            Timer = setInterval(time,2000);
        }
        function time(){
            $("#div").fadeOut("slow");
            clearInterval(Timer);
        }
    })
})