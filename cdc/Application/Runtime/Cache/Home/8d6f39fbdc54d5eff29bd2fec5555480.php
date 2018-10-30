<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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

    <div class="container body-content">
        <div class="shuju">
            用户名：<span class="go-up"></span>
            电子币余额：<span class="go-up"></span>
        </div>
        <div class="fanhuian mobileyc">
            <a class="ui-button fleft" href="/3.2.0/index.php/Home/Index/cashManagement">返回列表</a>
        </div>
        <div id="load" style="display:none;z-index:60;">正在加载请稍后....</div>
        <form action="/3.2.0/index.php/Home/Index/tixianfang" onSubmit="return confirm();" id="form0" method="post">
            <input name="__RequestVerificationToken" value="JgScfy6T38_aGDKlPhp4OBUTyVph1wm7qa3ZCFDzgKaKku4Xm1jTezUWbtWBU1ndjeny_pYB2lzy5NzqGikkizzma6FJzMK_P3d6aP5jkWXbB1PY0" type="hidden"><!--防止跨越提交-->
            <div class="form-horizontal cms-bootstrap">
                <!--显示错误验证信息-->
                <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fn_AmountRequest">提款金额</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input class="text-box single-line valid" data-val="true" data-val-number="The field 提款金额 must be a number." data-val-range="最小提款金额为100!！" data-val-range-max="2147483647" data-val-range-min="100" data-val-required="安全密码必填项！" id="Fn_AmountRequest" name="Fn_AmountRequest" value="" type="text">
                        <span class="field-validation-valid" data-valmsg-for="Fn_AmountRequest" data-valmsg-replace="true"></span><br>
                        <span id="tishi">提款手续费为3%,100元封顶(每月提现不超过5万元,5工作日到账)</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fn_WithDraw_Bank">提款银行</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <select data-val="true" data-val-number="The field 提款银行 must be a number." data-val-required="提款银行必填项！" id="Fn_WithDraw_Bank" name="Fn_WithDraw_Bank">
                            <option value="0">请选择</option>
                            <?php if(is_array($op)): $i = 0; $__LIST__ = $op;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["card"]); ?>,<?php echo ($val["y_name"]); ?>,<?php echo ($val["name"]); ?>"><?php echo ($val["card"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span class="field-validation-valid" data-valmsg-for="Fn_WithDraw_Bank" data-valmsg-replace="true"></span><br>
                        <span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fc_TwoPassword">安全密码</label>
                    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                        <input class="form-control valid" data-val="true" data-val-required="安全密码必填项！" id="fc_TwoPassword" name="fc_TwoPassword" type="password">
                        <span class="field-validation-valid" data-valmsg-for="fc_TwoPassword" data-valmsg-replace="true"></span>
                    </div>
                </div>

                <div class="form-group redbutton">
                    <div class="form-group-submit col-md-10">
                        <input value="提交信息" id="save" class="btn btn-default" type="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script src="/3.2.0/Public/js/withdrawals.js"></script>
    <script>
        $(document).ready(function(){
            $("#Fn_AmountRequest").keyup(function(){
                if(isNaN($(this).val())){
                    $("#tishi").html("请输入数字!");
                }else{
                    var number = $(this).val()*0.03;
                    if(number>100){
                        number=100;
                        number=$(this).val()-number;
                    }else{
                        number=$(this).val()-number;
                    }
                    $("#tishi").html("实际提现金额为<span style='color:red'>"+number+"</span>,提款手续费为3%,100元封顶"); 
                }
            })
        })
        function confirm(){
            var result;
            if($("#Fn_AmountRequest").val()==""){
                $(".field-validation-valid").eq(0).html("提款金额为必填项!");
                return false;
            }else if($("#Fn_AmountRequest").val()<100){
                $(".field-validation-valid").eq(0).html("最小提款金额为100!");
                return false;
            }else{
                $.ajax({
                    async:false,
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/moneyyanzheng3",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
                        if(data == 0){
                            if($("#Fn_AmountRequest").val()>50000){
                                $(".field-validation-valid").eq(0).html("最大提款金额为50000!");
                                result=false;
                            }
                        }else if(data==1){
                            if($("#Fn_AmountRequest").val()>200000){
                                $(".field-validation-valid").eq(0).html("最大提款金额为200000!");
                                result=false;
                            }
                        }else if(data==3){
                            if($("#Fn_AmountRequest").val()>50000){
                                $(".field-validation-valid").eq(0).html("最大提款金额为50000!");
                                result=false;
                            }
                        }
                            var value = $("#Fn_AmountRequest").val();
                            $.ajax({
                                async:false,
                                type:"post",
                                url:"/3.2.0/index.php/Home/Index/moneyyanzheng2",
                                dataType: "text",
                                data:{money:value},
                                success:
                                function(data){
                                    if(data != 1){
                                        $(".field-validation-valid").eq(0).html("账户金额不足!");
                                        result=false;
                                    }else{
//                                        $(".field-validation-valid").eq(0).html("");
                                    }
                                }
                            })
                    }
                })
            }
            if($("#Fn_WithDraw_Bank").val()=="0"){
                $(".field-validation-valid").eq(1).html("请选择银行卡,如未添加银行卡请到银行卡管理选项进行添加!");
                return false;
            }else{
                $(".field-validation-valid").eq(1).html("");
            }
            if($("#fc_TwoPassword").val()==""){
                $(".field-validation-valid").eq(2).html("请填写您的安全密码!");
                return false;
            }else{
                var pass = $("#fc_TwoPassword").val();
                $.ajax({
                    async:false,
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/passyanzheng",
                    dataType: "text",
                    data:{pass:pass},
                    success:
                    function(data){
                        if(data != 1){
                            $(".field-validation-valid").eq(2).html("安全密码不正确!请重新填写!");
                            result=false;
                        }else{
                            $(".field-validation-valid").eq(2).html("");
                        }
                    }
                })
            }
            return result;
//            return result2;
        }
    </script>
<script>window.parent.scrollTo(0, 0);</script>

</body>
</html>