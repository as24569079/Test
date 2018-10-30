$(function(){
    $("#user").keyup(function(){
                var value = $("#user").val();
                $.ajax({
                    async:false,
                    type:"post",
                    url:"useryanzheng",
                    dataType: "text",
                    data:{user:value},
                    success:
                    function(data){
                         if(data == ""){
                            $("#user_tishi").html("收款人账号不存在,请重新输入");
                            $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                        }else{
                            eval("var obj = "+data);
                            $("#user_tishi").html("已找到收款人"+obj.real_name);
                            $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                        }
                    }
                })
            })
    //表单验证
    $("#form").submit(function(){
        var result;
        if($("#user").val()==""){
            $("#user_tishi").html("请填写收款人账号");
            $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else{
            var value = $("#user").val();
                $.ajax({
                    async:false,
                    type:"post",
                    url:"useryanzheng",
                    dataType: "text",
                    data:{user:value},
                    success:
                    function(data){
                        if(data == ""){
                            $("#user_tishi").html("收款人账号不存在,请重新输入");
                            $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                            result=false;
                        }else{
                            eval("var obj = "+data);
                            $("#user_tishi").html("已找到收款人"+obj.real_name);
                            $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                            result=true;
//                            var value2 = $("#user").val();
//                            $.ajax({
//                                async:false,
//                                type:"post",
//                                url:"useryanzheng2",
//                                dataType: "text",
//                                data:{user:value2},
//                                success:
//                                function(data){
//                                    if(data == 1){
//                                        $("#user_tishi").html("收款人账号不能为填本人账号");
//                                        $("#user_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
//                                        result=false;
//                                    }else{
//                                        $("#user_tishi").html("收款人账号");
//                                        $("#user_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
//                                    }
//                                }
//                            })
                        }
                    }
                })
        }
//        if($("#name").val()==""){
//            $("#name_tishi").html("请填写收款人姓名");
//            $("#name_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
//            return false;
//        }else{
//            var value = $("#user").val();
//            var val = $("#name").val();
//            $.ajax({
//                async:false,
//                type:"post",
//                url:"r_nameyanzheng",
//                dataType: "text",
//                data:{user:value,val:val},
//                success:
//                function(data){
//                    if(data != 1){
//                        $("#name_tishi").html("收款人姓名与账号不匹配");
//                        $("#name_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
//                        result=false;
//                    }else{
//                        $("#name_tishi").html("收款人姓名");
//                        $("#name_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
//                    }
//                }
//            })
//        }
        if($("#money").val()==""){
            $("#money_tishi").html("请填写转账金额");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if(isNaN($("#money").val())){
            $("#money_tishi").html("请填写数字");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else if($("#money").val()<=1){
            $("#money_tishi").html("转账金额必须大于1");
            $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            return false;
        }else{
            var value = $("#money").val();
            $.ajax({
                async:false,
                type:"post",
                url:"moneyyanzheng",
                dataType: "text",
                data:{money:value},
                success:
                function(data){
                    if(data == 1){
                        $("#money_tishi").html("账户金额不足");
                        $("#money_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                        result=false;
                    }else{
                        $("#money_tishi").html("转账金额");
                        $("#money_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
                    }
                }
            })
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