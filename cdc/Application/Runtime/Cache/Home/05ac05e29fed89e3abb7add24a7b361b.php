<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head id="head"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="/3.2.0/Public/css/jibenziliao.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/3.2.0/Public/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/js/phoneUpdate.js"></script> 
        <title></title>
<style>
.password-strength-text{display:none;}
#p_lt_ctl04_pageplaceholder_p_lt_ctl00_MyProfile_myProfile_editProfileForm_ctl00_ifc_TwoPassword_fcfc_TwoPassword_passStrength_pnlPasswStrengthIndicator{display:none;}
#p_lt_ctl04_pageplaceholder_p_lt_ctl00_MyProfile_myProfile_editProfileForm_ctl00_ifc_TwoPassword_fcfc_TwoPassword_lblConfirmPassword{margin-top: 15px;}
#p_lt_ctl04_pageplaceholder_p_lt_ctl00_MyProfile_myProfile_editProfileForm_ctl00_ifc_TwoPassword_fcfc_TwoPassword_txtConfirmPassword{margin-top: 15px;}  
#p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_passStrength_pnlPasswStrengthIndicator{display:none;}
.FormButton{display:block;width: 98px;}
</style>
<body class="LTR Safari Chrome Safari50 Chrome50 ZHCN PCDevice ContentBody"><div id="WzTtDiV" style="visibility: hidden; position: absolute; overflow: hidden; padding: 0px; width: 0px; left: 0px; top: 0px;"></div>
    <form method="post" action="/3.2.0/index.php/Home/Index/phoneUpdat" onSubmit="return confirm();" id="form">
<div class="aspNetHidden">
</div>
<div class="aspNetHidden">
</div>

<div id="ctxM">

</div>
    
  <header class="header" role="banner">

    </header>
  <!--主菜单-->
<div class="kny">
<div class="m-content">
 <div class="p-rich">
          <!--<h2 class="mya-tip">密码修改</h2>-->
<ul class="nav nav-tabs ui-select-listBox">
       <li class="active"><a href="/3.2.0/index.php/Home/Index/phoneUpdate">修改绑定手机</a></li> 
       </ul><div class="cms-bootstrap AddUserForm">
 <div class="panel-body mima"><div id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_pnlWebPart" class="change-password" onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_btnOk&#39;)">
	
        
        
        <div class="form-horizontal cms-bootstrap">
            <ul>
                <li class="form-group">
                    <label for="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_txtOldPassword" id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_lblOldPassword" class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4">您的安全密码:</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input type="password" id="password" class="form-control" maxlength="8">
                        <span style="color:red" id="password_tt"></span>
                    </div>
                </li>
                <li class="form-group">
                    <label id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_lblNewPassword" class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_passStrength_txtPassword">新手机号码:</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
<div class="password-strength">
    <input name="newpassword1" type="text" id="code" class="form-control" maxlength="11"><input type="button" value="发送验证码" id="getcode"><input type="hidden" id="yzmyz">
    <div class="password-strength-text">
        <strong id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_passStrength_lblEvaluation"></strong>
    </div>
    <div id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_passStrength_pnlPasswStrengthIndicator" class="passw-strength-indicator">
		
        <div id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_passStrength_pnlPasswIndicator">
			
            &nbsp;
        
		</div>
    
	</div>
    <span id="password_nt" class="" style="color:red"></span>
</div>

                    </div>
                </li>
                <li class="form-group">
                    <label for="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_txtConfirmPassword" id="p_lt_ctl04_pageplaceholder_p_lt_ctl00_ChangePassword_lblConfirmPassword" class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4">验证码:</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input name="newpassword2" type="text" id="newpassword2" class="form-control" maxlength="4">
                        <span id="password_nt2" style="color:red"></span>
                    </div>
                </li>
            </ul>
            <div class="form-group redbutton"><div class="editing-form-label-cell"></div><div class="editing-form-value-cell">
                <input type="submit" value="更换绑定" id="sub" class="btn btn-primary">
            </div></div>
        </div>
    
</div>
</div></div></div>
  </div>
</div>
  <script>window.parent.scrollTo(0, 0);</script>
<script>
    function confirm(){
        var result=false;
        if($("#password").val()==""){
            $("#password_tt").html("请您输入安全密码!");
            return false;
        }else{
            var value = $("#password").val();
            $.ajax({
                async:false,
                type:"post",
                url:"/3.2.0/index.php/Home/Index/aPasswordAjax",
                dataType: "text",
                data:{password:value},
                success:
                function(data){
                    if(data!=1){
                        $("#password_tt").html("安全密码不正确!请重新输入!");
                        result = false;
                    }else{
                        $("#password_tt").html("");
                        result = true;
                    }
                }
            })
        }
        if($("#code").val()==""){
            $("#password_nt").html("请您输入新的手机号码!");
            return false;
        }else{
        }
        if($("#newpassword2").val()==""){
            $("#password_nt2").html("请您输入短信验证码!");
            return false;
        }else{
            if($("#newpassword2").val()!=$("#yzmyz").val()){
                $("#password_nt2").html("短信验证码不正确!请重新输入!");  
                return false;
            }else{
                $("#password_nt2").html("");
            }
        }
        return result;
    } 
</script>
 <div class="footer" id="footer">
     
 </div>
  </form>
</body></html>