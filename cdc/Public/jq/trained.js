$(function(){
    //查询用户信息
    $.ajax({
        type:"post",
        url:"cookSelect",
        dataType: "text",
        data:null,
        success:
        function(data){
            if(data != ""){
                eval("var obj="+data);
                var str = obj.tel.substring(0,3);
                var str2 = obj.tel.substring(7);
                $("#username").html(str+"****"+str2);
                $("#emoney").html(obj.emoney);
                $("#username_input").val(obj.tel);
            }
        }
    })
    
    //显示下拉菜单
    $("#change").click(function(){
        $("#form").hide();
        $("#chooseAddressPage").show();
        $("#header").hide();
        $("#chanpin_zizhi").show();
    })
    
    //返回
    $("#forget").click(function(){
        $("#form").show();
        $("#chooseAddressPage").hide();
        $("#header").show();
        $("#chanpin_zizhi").hide();
    })
    
    //选择资质
    $("#chanpin_zizhi > li").click(function(){
        $("#shangpin").val($(this).attr("data-val"));
        $("#form").show();
        $("#chooseAddressPage").hide();
        $("#header").show();
        $("#chanpin_zizhi").hide();
        if($(this).attr("data-val")==2900){
            $(this).attr("data-val","3200");
        }else if($(this).attr("data-val") == 29000){
            $(this).attr("data-val","32000");
        }else if($(this).attr("data-val") == 290000){
            $(this).attr("data-val","320000");
        }
        $("#zizhi_xuanze").html("已选择"+$(this).attr("data-val")+"产品");
        $("#zizhi_tishi").html("选择商品");
        $("#zizhi_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
    })
    
    //合同时间
    function GetDateStr(AddDayCount) { 
        var dd = new Date(); 
        dd.setDate(dd.getDate()+AddDayCount);
        var y = dd.getFullYear(); 
        var m = dd.getMonth()+1;
        var d = dd.getDate(); 
        return y+"-"+m+"-"+d; 
    } 
    function GetDateStr2(AddDayCount) { 
        var dd = new Date(); 
        dd.setDate(dd.getDate()+AddDayCount);
        var y = dd.getFullYear()+1; 
        var m = dd.getMonth()+1; 
        var d = dd.getDate(); 
        return y+"-"+m+"-"+d; 
    } 
    var str = GetDateStr(0);
    var arr = str.split('-');
    var newStr = arr[0] + "-"+(arr[1].length > 1 ? '' : '0') +arr[1]+ "-"+(arr[2].length > 1 ? '' : '0')+arr[2];
    $("#Fc_HTdatetime").html(newStr); 
    $("#time1").val(newStr);
    var data = GetDateStr2(-1);
    var arr2 = data.split('-');
    var newStr2 = arr2[0] + "-"+(arr2[1].length > 1 ? '' : '0') +arr2[1]+ "-"+(arr2[2].length > 1 ? '' : '0')+arr2[2];
    $("#Fc_HTDateArea").html(newStr+"至"+newStr2);
    $("#time2").val(newStr+"至"+newStr2);
    
    //无刷新查询推荐人名称
    $("#phone").keyup(function(){
        if($(this).val()!=""){
            var value = $(this).val();
            $("#RefUserSubName").children(".zhi_op").detach();
            $("#jingli_tishi").html("选择服务经理");
            if(isNaN($(this).val())){
                $("#phone_tishi").html("请输入数字");
                $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            }else if($(this).val().length!=11){
                $("#phone_tishi").html("请输入正确的11位手机号");
                $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            }else{
                $.post("peopleSelect",{value:value},function(data){
                     if(data!=""){
                        eval("var obj="+data);
                        $("#phone_tishi").html("已找到用户"+obj.real_name);
                        $("#phone_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
                        $.post("managerSelect",{value:value},function(data){
                            eval("var zhi="+data);
                            for(var i=0;i<zhi.length;i++){
                                $("#RefUserSubName").append("<option value='"+zhi[i].zizhanghu+"' class='zhi_op'>"+zhi[i].zizhanghu+"</option>");
                            }
                        },"text")
                     }else{
                        $("#phone").attr("data-yan","false");
                        $("#phone_tishi").html("未找到该用户");
                        $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                     }
                },"text")
            }
        }else{
            $("#phone_tishi").html("请输入推荐人手机号码");
            $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
        }
    })
    
    //下拉菜单
    $("#RefUserSubName").change(function(){
        if($(this).val()!="0"){
            $("#jingli_tishi").html("已选择"+$(this).val());
            $("#jingli_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }else{
            $("#jingli_tishi").html("选择服务经理");
            $("#jingli_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }
    });
    
    //表单验证
    $("#form").submit(function(){
        var result = false;
        if($("#shangpin").val()==""){
            $("#zizhi_tishi").html("请选择协议资质");
            $("#zizhi_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#phone").val()==""){
            $("#phone_tishi").html("请填写推荐人手机号码");
            $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if($("#phone").attr("data-yan")=="false"){
            $("#phone_tishi").html("推荐人不存在，请重新填写");
            $("#phone_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#RefUserSubName").val()=="0"){
            $("#jingli_tishi").html("请选择服务经理");
            $("#jingli_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#emoney").text()*1<$("#shangpin").val()*1){
            $("#emoney_tishi").html("电子币余额不足，请先充值");
            $("#emoney_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#qijianname").val()=="0"){
            $("#qijian_tishi").html("请选择招商经理");
            $("#qijian_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#pass").val()==""){
           $("#pass_tishi").html("请输入安全密码");
           $("#pass_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed"); 
        }else{
            var pass = $("#pass").val();
            $.ajax({
                async:false,
                type:"post",
                url:"anquan_pass_yan",
                dataType: "text",
                data:{pass:pass},
                success:
                function(data){
                    if(data!=1){
                        $("#pass_tishi").html("安全密码错误");
                        $("#pass_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed"); 
                        result=false;
                    }else{
                        result=true;
                    }
                }
            })
        }
        return result;
    })
})