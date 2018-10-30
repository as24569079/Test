$(document).ready(function(){
    $(".xuan").click(function(){
        $(this).attr("class","btn xuan btn-warning").siblings(".xuan").removeClass("btn-warning");
        $(".buan").removeClass("btn-warning");
        $("#zizhi").val($(this).val());
    })
    $(".buan").click(function(){
        $(this).attr("class","btn buan btn-warning").siblings(".buan").removeClass("btn-warning");
        $(".xuan").removeClass("btn-warning");
        $("#zizhi").val($(this).val());
    })
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
    $("#Fc_HTdatetime").val(newStr); 
    var data = GetDateStr2(-1);
    var arr2 = data.split('-');
    var newStr2 = arr2[0] + "-"+(arr2[1].length > 1 ? '' : '0') +arr2[1]+ "-"+(arr2[2].length > 1 ? '' : '0')+arr2[2];
    $("#Fc_HTDateArea").val(newStr+"至"+newStr2);
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
                $(".go-up").eq(0).html(str+"****"+str2);
                $(".go-up").eq(1).html(obj.emoney);
                $(".go-up").eq(2).html(obj.smoney);
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
                        $(".field-validation-valid").eq(5).html("已找到"+obj.real_name);
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
                        $(".field-validation-valid").eq(5).html($("#RefUserId").attr("data-val-required"));
                        $("#RefUserName").attr("data-val","false");
                    }
                }
            })
        }else{
            var li = $(".zhi_op");
            for(var i=0;i<li.length;i++){
                li.eq(i).detach();
            }
            $(".field-validation-valid").eq(7).html("");
            $("#RefUserSubName").attr("data-open","off");
            $(".field-validation-valid").eq(5).html($(this).attr("data-val-required"));
        }
    })
      $("#RefUserSubName").change(function(){
          if($(this).val()!="0"){
              $(".field-validation-valid").eq(7).html("已选择"+$(this).val());
          }else{
              $(".field-validation-valid").eq(7).html("");
          }
      })
   
})