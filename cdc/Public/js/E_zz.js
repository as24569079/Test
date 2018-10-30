$(document).ready(function(){
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
})