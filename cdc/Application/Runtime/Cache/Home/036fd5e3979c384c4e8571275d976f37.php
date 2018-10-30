<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="/3.2.0/Public/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/mobilemain.css" type="text/css" rel="stylesheet">
    <link href="/3.2.0/Public/css/main.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php if(is_array($ka)): $i = 0; $__LIST__ = $ka;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; ?>
    <div class="container body-content">
        <div id="load" style="display:none;z-index:60;">正在加载请稍后....</div>
        <div class="fanhuian mobileyc"><a class="ui-button fleft" href="/3.2.0/index.php/Home/Index/bankCard">返回列表</a></div>
        <form action="/3.2.0/index.php/Home/Index/updateyinhangka/uid/<?php echo ($val["y_id"]); ?>" data-ajax="true" onSubmit="return confirm();" id="form0" method="post">
            <input name="__RequestVerificationToken" value="q9KsVeybYdBhzFGIcZZAFzaYBYhIGZcZCwk2eHGQvV5PHaKYOBS0zlTaY_sQEpkwvNswTE1j5wej8AjlGMCrlRMCDQAegA2FYwzHRcj51JMcL45r0" type="hidden"><!--防止跨越提交-->
            
            <div class="form-horizontal cms-bootstrap">
                <!--显示错误验证信息-->
               <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fc_BankName">选择银行</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <select name="yinhang" id="yinhang" style="width:320px">
                            <option value="0">请选择</option>
                            <option value="中国工商银行">中国工商银行</option>
                            <option value="中国农业银行">中国农业银行</option>
                            <option value="中国建设银行">中国建设银行</option>
                            <option value="中国招商银行">中国招商银行</option>
                        </select>
                        <span class="field-validation-error" data-valmsg-for="fc_BankName" data-valmsg-replace="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fc_BankName">开户行名称</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input class="form-control input-validation-error" data-val="true" data-val-required="开户行名称是必填项！" id="fc_BankName" name="fc_BankNamefc_BankName" value="<?php echo ($val["name"]); ?>" type="text">
                        <span class="field-validation-error" data-valmsg-for="fc_BankName" data-valmsg-replace="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fc_CardNumber">开户行卡号</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input class="form-control input-validation-error" data-val="true" data-val-required="开户行卡号是必填项！" id="fc_CardNumber" name="fc_CardNumber" value="<?php echo ($val["card"]); ?>" type="text">
                        <span class="field-validation-error" data-valmsg-for="fc_CardNumber" data-valmsg-replace="true"></span>
                    </div>
                </div>
                <div class="form-group redbutton">
                    <div class="form-group-submit col-md-10">
                        <input value="修改信息" id="save" class="btn btn-default" type="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script>window.parent.scrollTo(0,0);</script>
    <script>
        function confirm(){
            reg=/^[0-9]{16,19}$/;
            if($("#yinhang").val()=="0"){
                $(".field-validation-error").eq(0).html("请选择银行！");
                return false;
            }
            if($("#fc_BankName").val()==""){
                $(".field-validation-error").eq(1).html("开户行名称是必填项！");
                return false;
            }else if($("#fc_BankName").val().length>10){
                $(".field-validation-error").eq(1).html("开户行名称过长！");
                return false;
            }else{
                $(".field-validation-error").eq(1).html("");
            }
            if($("#fc_CardNumber").val()==""){
                $(".field-validation-error").eq(2).html("银行卡卡号是必填项！");
                return false;
            }else if(!reg.test(($("#fc_CardNumber").val()))){
                $(".field-validation-error").eq(2).html("请填写正确的银行卡号！");
                return false;
            }else{
                $(".field-validation-error").eq(2).html("");
            }
        }
    </script>
</body>
</html>