$(function(){
    //动态表单验证
    $("#money").keyup(function(){
        if($(this).val()!=""){
            $("#money_tishi").html("提款金额(提款手续费为3%,100元封顶)");
            $("#money_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
            $("#shiji").val("");
            $("#shouxu").val("");
            if(isNaN($(this).val())){
                $("#money_tishi").html("请输入数字");
                $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            }else if($(this).val()*1>$("#checkmoney").val()*1){
                $("#money_tishi").html("电子币余额不足");
                $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            }else{
                var number = 0;
                number = $(this).val()*0.03;
                var shiji;
                if(number>100){
                    number=100;
                    shiji=$(this).val()-number;
                }else{
                    shiji=$(this).val()-number;
                }
                $("#money_tishi").html("实际提现金额为<span style='color:red'>"+shiji+"</span>,提款手续费为3%,100元封顶");
                $("#money_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
                $("#shiji").val(shiji);
                $("#shouxu").val(number);
            }
        }else{
            $("#money_tishi").html("提款金额(提款手续费为3%,100元封顶)");
            $("#money_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
            $("#shiji").val("");
            $("#shouxu").val("");
        }
    })
    
    //表单提交验证
    $("#form").submit(function(){
        if($("#money").val()==""){
            $("#money_tishi").html("请填写提现金额");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if(isNaN($("#money").val())){
            $("#money_tishi").html("请输入数字");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if($("#money").val()*1>$("#checkmoney").val()*1){
            $("#money_tishi").html("电子币余额不足");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if($("#money").val()<100){
            $("#money_tishi").html("最小提款金额为100");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");   
            return false;
        }else{
            $("#money_tishi").html("提款金额(提款手续费为3%,100元封顶)");
            $("#money_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }
        if($("#RefUserSubName").val()=="0"){
            $("#bank_tishi").html("请选择银行卡号");
            $("#bank_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");   
            return false;
        }else{
            $("#bank_tishi").html("选择银行卡");
            $("#bank_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }
        if($("#password").val()==""){
            $("#pass_tishi").html("请填写您的安全密码");
            $("#pass_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");   
            return false;
        }else{
            var result;
            var pass = $("#password").val();
            $.ajax({
                async:false,
                type:"post",
                url:"passyanzheng",
                dataType: "text",
                data:{pass:pass},
                success:
                function(data){
                    if(data != 1){
                        $("#pass_tishi").html("安全密码不正确，请重新填写");
                        $("#pass_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");   
                        $(".field-validation-valid").eq(2).html("安全密码不正确!请重新填写!");
                        result=false;
                    }else{
                        $("#pass_tishi").html("安全密码");
                        $("#pass_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
                    }
                }
            })
        }
        return result;
    })
})