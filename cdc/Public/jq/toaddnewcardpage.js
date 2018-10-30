$(function(){
    //通用头js
    $("#m_common_header_jdkey").click(function(){
        if($(this).attr("data-val")=="off"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","on");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","off");
        }
    })
    //动态表单验证
    $("#card-num").keyup(function(){
        if($(this).val()!=""){
            $("#sportCard").show();
            if(isNaN($(this).val())){
                $("#bankcard > p").html("银行卡卡号错误");
                $("#bankcard > p").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
                $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
            }else{
                $("#bankcard > p").html("卡号");
                $("#bankcard > p").attr("class","pos-ab col-359df5 ui-form-lable ft-30px ft-col-ccc");
                $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
                $("#confirmBtn").attr("class","makeSurebtn col-btnBlue");
            }
        }else{
            $("#sportCard").hide();
            $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
        }
    }).focus(function(){
        $(".dn").hide();
        if($(this).val()!=""){
            $("#sportCard").show();
        }else{
            $("#sportCard").hide();
        }
    })
    
    $("#phone-num").keyup(function(){
        if($(this).val()!=""){
            $("#phoneNumCan").show();
            $("#confirmBtn").attr("class","makeSurebtn col-btnBlue");
        }else{
            $("#phoneNumCan").hide();
            $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
        }
    }).focus(function(){
        $(".dn").hide();
        if($(this).val()!=""){
            $("#phoneNumCan").show();
        }else{
            $("#phoneNumCan").hide();
        }
    })
    
    //一键清除
    $("#sportCard").click(function(){
        $("#card-num").val("");
        $(this).hide();
        $("#bankcard > p").html("卡号");
        $("#bankcard > p").attr("class","pos-ab col-359df5 ui-form-lable ft-30px ft-col-ccc");
        $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
    })
    
    $("#phoneNumCan").click(function(){
        $("#phone-num").val("");
        $(this).hide();
        $("#confirmBtn").attr("class","makeSurebtn col-btn1Gray");
    })
    
    //提交表单
    $("#confirmBtn").click(function(){
        var pattern = /^[\u4e00-\u9fa5]+$/;
        if($("#sel").val()=="0"){
            $("#xuanze").html("请选择银行");
            $("#xuanze").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if($("#card-num").val()==""){
            $("#bankcard > p").html("请填写银行卡");
            $("#bankcard > p").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if(isNaN($("#card-num").val())){
            $("#bankcard > p").html("银行卡卡号错误");
            $("#bankcard > p").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if($("#k_name").val()==""){
            $("#chikaren > p").html("请输入持卡人姓名");
            $("#chikaren > p").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if(!pattern.test($("#k_name").val())){
            $("#chikaren > p").html("请输入正确的持卡人姓名");
            $("#chikaren > p").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if($("#phone-num").val()==""){
            $("#zhihang").html("请填写支行名称");
            $("#zhihang").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else if($("#phone-num").val().indexOf("支行")<0){
            $("#zhihang").html("请填写正确的支行名称");
            $("#zhihang").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
        }else{
            var value = $("#sel").val();
            $.ajax({
                async:false,
                type:"post",
                url:"yinhangkasel",
                dataType: "text",
                data:{val:value},
                success:
                function(data){
                    if(data==1){
                        $("#xuanze").html("已经添加过此银行银行卡!请重新选择!");
                        $("#xuanze").attr("class","pos-ab ui-form-lable ft-30px ft-col-ccc colorRed");
                    }else{
                        var frm = document.getElementById('form');
                            frm.action='yinhangadd';
                            frm.submit();
                    }
                }
            })
            
        }
    })
})