$(document).ready(function(){
    $.ajax({
        type:"post",
        url:"information",
        dataType: "text",
        data:null,
        success:
        function(data){
            if(data!=""){
                eval("var obj="+data);
                var str = obj.tel.substring(0,3);
                var str2 = obj.tel.substring(7);
                $("#p_lt_ctl04_pageplaceholder_p_lt_ctl00_MyProfile_plcUp_myProfile_editProfileForm_ctl00_iUserName_fcUserName_label").html(str+"****"+str2);
                $("#p_lt_ctl04_pageplaceholder_p_lt_ctl00_MyProfile_plcUp_myProfile_editProfileForm_ctl00_iFullName_fcFullName_label").html(obj.real_name);
//                $("#phone").val(obj.tel);
                if(obj.sex==1){
                    $("#nan").attr("checked","checked");
                }else if(obj.sex==0){
                    $("#nv").attr("checked","checked");
                }
                $("#email").val(obj.email);
                $("#address").val(obj.address);
                $("#codeId").val(obj.identity_card);
            }
        }
    })
})


