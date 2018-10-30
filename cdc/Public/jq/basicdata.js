$(function(){
    //显示性别
    if($("#sex").val()=="0"){
        $("#sex2").attr("checked","checked");
    }else if($("#sex").val()=="1"){
        $("#sex1").attr("checked","checked");
    }
    
    //表单验证
    $("#form").submit(function(){
        if($("#email").val().indexOf("@")<=0||$("#email").val().indexOf(".com")<=0){
            $("#email_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            $("#email_tishi").html("请输入正确的电子邮箱。例如：mymail@domain.com");
            return false;
        }else{
            $("#email_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
            $("#email_tishi").html("电子邮箱");
        }
        if($("#address").val()==""){
            $("#address_tishi").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            $("#address_tishi").html("请输入您的常居住地址");
            return false;
        }else{
            $("#address_tishi").attr("class","pos-ab col-359df5 ui-form-lable");
            $("#address_tishi").html("地址");
        }
        var result;
        if($("#pass").val()!=""){
            $("#password").attr("class","pos-ab col-359df5 ui-form-lable");
            $("#password").html("安全密码");
            var pass = $("#pass").val();
            $.ajax({
                async:false,
                type:"post",
                url:"securityVerification",
                dataType: "text",
                data:{pass:pass},
                success:
                function(data){
                    if(data!=1){
                        $("#password").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
                        $("#password").html("安全密码错误");
                        result=false;
                    }
                }
            })
        }else{
            $("#password").attr("class","pos-ab ft-30px ft-col-ccc ui-form-lable colorRed");
            $("#password").html("请输入您的安全密码");
            return false;
        }
        return result;
    })
    
    //动态表单验证
    $("#pass").keyup(function(){
        $("#password").attr("class","pos-ab col-359df5 ui-form-lable");
        $("#password").html("安全密码");
    })
})