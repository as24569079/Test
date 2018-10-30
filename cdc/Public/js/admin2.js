$(document).ready(function(){
    $.ajax({
        type:"post",
        url:"cookSelect",
        dataType: "text",
        data:null,
        success:
        function(data){
//            alert(data)//;
            if(data != ""){
                eval("var obj="+data);
                $("#guanli").html(obj.username);
            }
        }
    })
})