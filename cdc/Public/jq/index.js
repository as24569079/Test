$(function(){
    $("#myhome").click(function(){
        $.post("cookSelect",
            function(data){
               if(data != ""){
                    window.location.href='myhome';
                }else{
                    window.location.href='login';
                }
            },"text");
    })
    
})