$(document).ready(function(){
    $.ajax({
        type:"post",
        url:"cookSelect",
        dataType: "text",
        data:null,
        success:
        function(data){
//            alert(data);
            if(data != ""){
                eval("var obj="+data);
//                    alert(obj.real_name);
                $(".navigation > ul > li ").eq(1).children("a").html(obj.name);
            }
        }
    })
})