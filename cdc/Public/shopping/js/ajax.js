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
    showCode.innerHTML="校验中。。";
    showCode.style.display="block ";
    showCode.style.fontStyle="italic";
    
    
//    alert(showCode);
//    alert(ajax);
//    alert(value);
    
    ajax.open("post","sel",true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("value="+value);
    
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4 && ajax.status == 200){
            var data = ajax.responseText;   //responseText获取字符串类型的影响结果
            //以xml方式接收返回的数据，并保存在Data变量里
//            alert(data);
            if(data == 1){
//                alert(2222);
                showCode.style.border = "1px solid red";
                showCode.style.background = "#ffcccc";
                showCode.style.fontStyle = "";
                showCode.innerHTML="<img src='../../Public/pic/no.png' height=20px align='texttop'> 用户名已存在！";
                document.getElementById("sub").type = "button";
                
            }else{
//                alert("1111");
                showCode.style.border = "1px solid green";
                showCode.style.background= "#99ff99";
                showCode.style.fontStyle = "";
                showCode.innerHTML="<img src='../../Public/pic/yes.png' height=20px align='texttop'>用户名可以使用！";
                document.getElementById("sub").type = "submit";
            }            
        }
    
    };
}



