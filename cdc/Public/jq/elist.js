$(function(){
    //表单验证
    $("#form").submit(function(){
        if($("#money").val()==""){
            $("#emoney_tishi").html("请填写充值金额");
            $("#emoney_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if(isNaN($("#money").val())){
            $("#emoney_tishi").html("请输入数字");
            $("#emoney_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }
        if($("#password").val()==""){
            $("#pass_tishi").html("请填写安全密码");
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
    
    //输入事件
    $("#money").keyup(function(){
        if($(this).val()!=""){
            $("#emoney_tishi").html("充值金额");
            $("#emoney_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }else{
            $("#emoney_tishi").html("请填写充值金额");
            $("#emoney_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
        }
    })
    $("#password").keyup(function(){
        if($(this).val()!=""){
            $("#pass_tishi").html("安全密码");
            $("#pass_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
        }else{
            $("#pass_tishi").html("请填写安全密码");
            $("#pass_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
        }
    })
})