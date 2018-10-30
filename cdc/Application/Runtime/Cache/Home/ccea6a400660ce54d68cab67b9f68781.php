<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>用户登录</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/login.css">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/login.js"></script> 
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
        <link href="/3.2.0/Public/shopping/css/slide-unlock.css" rel="stylesheet">
    </head>
    <body onkeydown="run()">
        <form method="post" id="form">
        <!--头部内容-->
        <div class="lg-h">
            <div class="lg-wrapper clearfix">
                <a href="/3.2.0/index.php/Home/Index/index" target="_blank">
                    <img class="lg-logo" src="/3.2.0/Public/images/chengcuicheng.png" style="width:248px;height:74px;margin-top:10px">
                </a>
                <a class="r-word">
                    <span class="ico-edit"></span>
                    我想对“登录”提意见
                </a>
            </div>
        </div>
        <!--登录表单-->
        <div class="lg-b" style="background-image: url(/3.2.0/Public/images/login.jpg)">
            <div class="lg-wrapper clearfix">
                <a class="pic" target="_blank" href="/3.2.0/index.php/Home/Index/login"></a>
                <div class="form">
                    <div class="form-cont">
                        <p class="form-title">欢迎登录</p>
                        <div class="err-msg hide" id="kuang">
                            <p>
                                <i class="nms-ico nms-ico-error16"></i>
                                <span id="tishi"></span>
                                <a></a>
                            </p>
                        </div>
                        <div class="login-txtbox mb20" id="user">
                            <label class="input-label">用户名</label>
                            <i class="ico"></i>
                            <input class="txt-input text-email" type="text" autocomplete="off" tabindex="1" id="username" name="UserName" maxlength="11">
                        </div>
                        <div class="login-txtbox mb20" id="pass">
                            <label class="input-label">密码</label>
                            <i class="ico ico-psw"></i>
                            <input class="txt-input" type="password" autocomplete="off" maxlength="20" tabindex="2" id="password" name="Password">
                            <input name="status" value="<?php echo ($_GET['status']); ?>" type="hidden">
                        </div>
                        <div class="mb18">
                                <div id="slider">
                                    <div id="slider_bg"></div>
                                    <div id="label">>></div> 
                                    <div id="labelTip">请按住滑块拖到最右边</div> 
                                </div>
                            <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.12.1.min.js"></script> 
                            <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery.slideunlock.js"></script> 
                            <script>
                            $(function () {
                                var num = 0;
                                var slider = new SliderUnlock("#slider",{
                                                        successLabelTip : "验证成功!"	
                                                },function(){
                                            var slider=document.getElementById("slider");
                                            slider.val = 1;
                                            num = 1
                                        });
                                slider.init();
                                $("#username").focus(function(){
                                    $(this).parent(".mb20").attr("class","login-txtbox mb20 input-focus");
                                    $(this).siblings(".input-label").hide();
                                }).blur(function(){
                                    if($(this).val()==""){
                                        $(this).siblings(".input-label").show();
                                    }
                                    $(this).parent(".mb20").attr("class","login-txtbox mb20");
                                })
                                $("#password").focus(function(){
                                     $(this).parent(".mb20").attr("class","login-txtbox mb20 input-focus");
                                     $(this).siblings(".input-label").hide();
                                }).blur(function(){
                                    if($(this).val()==""){
                                        $(this).siblings(".input-label").show();
                                    }
                                    $(this).parent(".mb20").attr("class","login-txtbox mb20");
                                })
                                $(".login-submit").click(function(){
                                    var user = $("#username").val();
                                    var pass = $("#password").val();
                                    if($("#username").val()==""){
                                        $("#kuang").show();
                                        $("#tishi").text("请输入用户名！");
                                        $("#user").attr("class","login-txtbox mb20 input-error");
                                    }else if($("#password").val()==""){
                                        $("#kuang").show();
                                        $("#tishi").text("请输入6-20位密码！");
                                        $("#pass").attr("class","login-txtbox mb20 input-error");
                                    }else if($("#password").val().length<6||$("#password").val().length>20){
                                        $("#kuang").show();
                                        $("#tishi").text("请输入6-20位密码！");
                                        $("#pass").attr("class","login-txtbox mb20 input-error");
                                    }else if(num == 0){
                                        $("#kuang").show();
                                        $("#tishi").text("请完成滑动验证！");
                                    }else{
                                        $.ajax({
                                            type:"post",
                                            url:"/3.2.0/index.php/Home/Index/loginajax2",
                                            dataType: "text",
                                            data:"user="+user,
                                            success:
                                            function(data){
                                                if(data!=1){
                                                    $("#kuang").show();
                                                    $("#tishi").text("该账户不存在,");
                                                    $("#tishi").siblings("a").attr("href","/3.2.0/index.php/Home/Index/register");
                                                    $("#tishi").siblings("a").text("注册新账号");
                                                    $("#user").attr("class","login-txtbox mb20 input-error");
                                                }else{
                                                    $.ajax({
                                                        type:"post",
                                                        url:"/3.2.0/index.php/Home/Index/loginVerificationAjax",
                                                        dataType: "text",
                                                        data:{user:user,pass:pass},
                                                        success:
                                                        function(data){
                                                            if(data!=0){
                                                                var frm = document.getElementById('form');
                                                                    frm.action='/3.2.0/index.php/Home/Index/loginVerification';
                                                                    frm.submit();
                                                            }else{
                                                                $("#kuang").show();
                                                                $("#tishi").text("您输入的账户名与密码不匹配，请重新输入！");
                                                                $("#tishi").siblings("a").attr("href","/3.2.0/index.php/Home/Index/forget");
                                                                $("#tishi").siblings("a").text("忘记密码");
                                                                $("#pass").attr("class","login-txtbox mb20 input-error");
                                                            }
                                                        }
                                                    })
                                                }
                                            }
                                        })
                                        
                                    } 
                                })
                            })
                            function run(){
                                var x = event.keyCode;
                                    if(x == '13'){
                                        if(slider.val == 1){
                                            var frm = document.getElementById('form');
                                                 frm.action='/3.2.0/index.php/Home/Index/loginVerification';
                                                 frm.submit();
                                         }else{
                                            alert("请完成滑动验证!");
                                         }
                                    }
                            }
                            $(document).ready(function(){
                                $('html').bind("selectstart", function () { return false; });
                            })
                            </script>
                        </div>
                        <div class="clearfix mb18 hide"></div>
                        <div class="auto-login mb20 clearfix"></div>
                        <p class="mb10">
                            <a class="login-submit" style="background:#0074cc">登录</a>
                        </p>
                        <div class="links-text clearfix">
                            <a class="link-left" href="/3.2.0/index.php/Home/Index/register">免费注册></a>
                            <a class="link-right" href="/3.2.0/index.php/Home/Index/forget">忘记密码?</a>
                        </div>
<!--                        <div class="net-cooperation">
                            <p class="show-text">
                                <span>使用以下账号登录</span>
                            </p>
                            <p class="account-list clearfix">
                                <a>门店会员卡</a>
                                <a>易付宝</a>
                                <a>微信</a>
                                <a>QQ</a>
                                <a class="a-last">PPTV</a>
                            </p>
                        </div>-->
                        <div class="email-list hide"></div>
                    </div>
                    <div class="form-code" style="opacity: 0">
                        <p class="code-title">诚兑城公众号</p>
                        <div class="err-msg hide"></div>
                        <div class="qrcode-area">
                            <div class="qrcode-block">
                                <img class="qrcode" src="/3.2.0/Public/images/erwei.jpg" id="qrCodesId">
                                <img class="qrcode-way" src="/3.2.0/Public/shopping/images/qrcode-way.jpg">
                            </div>
                        </div>
                        <p class="mb10 tc">请扫描二维码</p>
                    </div>
                    <span class="check-arrow"></span>
                    <span class="check-pc"></span>
                </div>
            </div>
        </div>
            <div class="clear"></div>
            <!--版权区-->
            <div class="ng-footer">
                <div class="ng-s-footer">
                    <div class="ng-s-f-con">
                        <p class="ng-url-list">
                            <a href="/3.2.0/index.php/Home/Index/qiye.html" target="_blank" >企业联盟</a>
                                <span>|</span>
                                <a href="/3.2.0/index.php/Home/Index/qiye.html" target="_blank">加入我们</a>
                                <span>|</span>
                                <a href="/3.2.0/index.php/Home/Index/kefuzhongxin.html" target="_blank">客服中心</a>
                                <span>|</span>
                                <a href="/3.2.0/index.php/Home/Index/xinwenzhongxin.html" target="_blank">新闻中心</a>
                                <span>|</span>
                                <a href="/3.2.0/index.php/Home/Index/guanyu.html" target="_blank">关于我们</a>
                                <span>|</span>
                                <a href="/3.2.0/index.php/Home/Index/gonggao.html" target="_blank">公告</a>
                                </p>
                                <p class="ng-copyright ng-copyright-2">
                        备案号:<a href="http://www.miitbeian.gov.cn/" style="color:#000">津ICP备16004932号-2</a>
                    </p>
                        <div class="ng-authentication">
                            
                        </div>
                    </div>
                </div>
                <div class="ng-fix-bar"></div>
            </div>
        </form>
    </body>
</html>