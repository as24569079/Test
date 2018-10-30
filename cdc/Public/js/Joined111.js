$(document).ready(function(){
    $(".xuan").click(function(){
        $(this).attr("class","btn xuan btn-warning").siblings(".xuan").removeClass("btn-warning");
        $("#zizhi").val($(this).val());
    })
    var mydate = new Date();
    var str = "" + mydate.getFullYear() + "-";
    str += (mydate.getMonth()+1) + "-";
    str += mydate.getDate();
    $("#Fc_HTdatetime").val(str);
    var data = "" + (mydate.getFullYear()+1) + "-";
    data += (mydate.getMonth()+1) + "-";
    data += mydate.getDate();
    $("#Fc_HTDateArea").val(str+"至"+data);
    $.ajax({
        type:"post",
        url:"cookSelect",
        dataType: "text",
        data:null,
        success:
        function(data){
            if(data != ""){
                eval("var obj="+data);
                $(".go-up").eq(0).html(obj.integral);
            }
        }
    })
    $("#RefUserName").blur(function(){
        if($(this).val()!=""){
            var value = $("#RefUserName").val();
            $.ajax({
                type:"post",
                url:"peopleSelect",
                dataType: "text",
                data:{value:value},
                success:
                function(data){
                    if(data!=""){
                        eval("var obj="+data);
                        $(".field-validation-valid").eq(4).html("已找到"+obj.real_name);
                        $("#user_id").val(obj.tel);
                        $("#RefUserName").attr("data-val","true");
                        var value = $("#RefUserName").val();
                        if($("#RefUserSubName").attr("data-open")=="off"){
                            $.ajax({
                                type:"post",
                                url:"managerSelect",
                                dataType: "text",
                                data:{value:value},
                                success:
                                function(data){
                                    eval("var zhi="+data);
                                    for(var i=0;i<zhi.length;i++){
                                        $("#RefUserSubName").append("<option value='"+zhi[i].zizhanghu+"' class='zhi_op'>"+zhi[i].zizhanghu+"</option>");
                                    }
//                                    $("#RefUserSubName").attr("data-open","on");
                                }
                            })
                        }
                    }else{
                        var li = $(".zhi_op");
                        for(var i=0;i<li.length;i++){
                            li.eq(i).detach();
                        }
                        $(".field-validation-valid").eq(4).html($("#RefUserId").attr("data-val-required"));
                        $("#RefUserName").attr("data-val","false");
                    }
                }
            })
        }else{
            var li = $(".zhi_op");
            for(var i=0;i<li.length;i++){
                li.eq(i).detach();
            }
            $(".field-validation-valid").eq(6).html("");
            $("#RefUserSubName").attr("data-open","off");
            $(".field-validation-valid").eq(4).html($(this).attr("data-val-required"));
        }
    })
      $("#RefUserSubName").change(function(){
          if($(this).val()!="0"){
              $(".field-validation-valid").eq(6).html("已选择"+$(this).val());
          }else{
              $(".field-validation-valid").eq(6).html("");
          }
      })
//    $("#RefUserSubName").keyup(function(){
//        if($(this).val()!=""&&$("#RefUserName").val()!=""){
//            var value = $("#RefUserSubName").val();
//            var phone = $("#RefUserName").val();
//            $.ajax({
//                type:"post",
//                url:"managerSelect",
//                dataType: "text",
//                data:{value:value,val:phone},
//                success:
//                function(data){
//                    if(data!=""){
//                        eval("var obj="+data);
//                        $(".field-validation-valid").eq(6).html("已找到"+obj.real_name);
//                        $("#assessor_id").val(obj.assessor_no);
//                        $("#RefUserSubName").attr("data-val","true");
//                    }else{
//                        $(".field-validation-valid").eq(6).html($("#RefUserSubId").attr("data-val-required"));
//                        $("#RefUserSubName").attr("data-val","false");
//                    }
//                }
//            })
//        }else{
//            $(".field-validation-valid").eq(6).html($(this).attr("data-val-required")); 
//        }
//    })
//    $("#Fc_Flagship").keyup(function(){
//        if($(this).val()!=""){
//            var value = $("#Fc_Flagship").val();
//            $.ajax({
//                type:"post",
//                url:"flagSelect",
//                dataType: "text",
//                data:{value:value},
//                success:
//                function(data){
//                    if(data!=""){
//                        eval("var obj="+data);
//                        $(".field-validation-valid").eq(8).html("已找到"+obj.shop_name);
//                        $("#shop_id").val(obj.shop_name);
//                        $("#Fc_Flagship").attr("data-val","true");
//                    }else{
//                        $(".field-validation-valid").eq(8).html($("#Fc_FlagshipUserSubId").attr("data-val-range"));
//                        $("#Fc_Flagship").attr("data-val","false");
//                    }
//                }
//            })
//        }else{
//            $(".field-validation-valid").eq(8).html($("#Fc_FlagshipUserSubId").attr("data-val-number"));
//        }
//    })
})