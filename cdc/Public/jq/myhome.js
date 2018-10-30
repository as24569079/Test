$(function(){
    $("#m_common_header_jdkey").click(function(){
        if($(this).attr("data-val")=="off"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","on");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","off");
        }
        
    })
    //跳转
    $("#m_common_header_goback").click(function(){
        window.location.href="myhome";
    })
    $.post("cookSelect",
    function(data){
       if(data != ""){
            eval("var obj="+data);
            var dengji;
            if(obj.dengji=="3"){
                dengji = "普通会员";
            }else if(obj.dengji=="0"){
                dengji = "营销顾问";
            }else if(obj.dengji=="1"){
                dengji = "营销专家";
            }
//            $(".my-jd-head-name").html(obj.real_name);
            $(".my-jd-head-type").html(dengji);
//            $("#emoney").html(obj.emoney);
//            $("#smoney").html(obj.smoney);
//            $("#integral").html(obj.integral);
//            $("#bean").html(obj.bean);
            $("#username").html(obj.tel);
//            if(obj.head_portrait!=null){
//                $(".my-img > img").attr("src",obj.head_portrait);
//            }else{
//                $(".my-img > img").attr("src","/Public/images/1.jpg");
//            }
        }
    },"text");
})