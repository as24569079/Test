$(function(){
    var num = 60;
    $("#getcode").click(function(){
        if($("#code").val()!=""){
            var phone = $("#code").val();
            $.ajax({
                type:"post",
                url:"UuserRepeat",
                dataType: "text",
                data:{user:phone},
                success:
                function(data){
                    if(data == 1){
                        alert("手机号码已存在!请更换手机号码!");
                    }else{
                        var Timer = setInterval(time,1000);
                        var rand = "";
                        $("#getcode").attr("disabled","disabled");
                        for(var i = 0; i < 4; i++){
                            var r = Math.floor(Math.random() * 10);
                            rand += r;
                        }
                        $.ajax({
                            type:"post",
                            url:"forgetCode",
                            dataType: "text",
                            data:{number:rand,user:phone},
                            success:
                            function(data){
                                $("#yzmyz").val(data);
                            }
                        })
                        function time(){
                            num--;
                            $("#getcode").val(num+"秒后可重新发送");
                            if(num==0){
                                $("#getcode").removeAttr("disabled");
                                num = 60;
                                $("#getcode").val("获取短信验证码");
                                clearInterval(Timer);
                            }
                        }
                    }
                }
            })
        }else{
            alert("请填写手机号码!");
        }
    })
})


