function req(){
    //这个浏览器ajax是否能用
    if(window.XMLHttpRequest){
        var request = new XMLHttpRequest();
    } else {
        var request = new ActiveXObject('Microsoft.XMLHTTP');
    }   
    return request;
}
function show(value){
    var ajax = req();  
//    alert(showCode);
//    alert(ajax);
//    alert(value);
    
    ajax.open("post","save",true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("value="+value);
    
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4 && ajax.status == 200){
            var data = ajax.responseText;   //responseText获取字符串类型的影响结果
            //以xml方式接收返回的数据，并保存在Data变量里           
        }
    
    };
}





