<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="/3.2.0/Public/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/mobilemain.css" type="text/css" rel="stylesheet"> 
    <link href="/3.2.0/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script src="/3.2.0/Public/js/Joined2.js"></script>
    <style>
/*        .xuan{
            background:#0033ff;color:#fff;
        }
        .buan{
            background:#0033ff;color:#fff;
        }*/
    </style>
</head>
<body marginwidth="0" marginheight="0">
 
    <div class="container body-content">
<!--<div class="shuju">-->
<!--        用户名：<span class="go-up"></span>
        电子币余额：<span class="go-up"></span>
        积分余额：<span class="go-up"></span>-->
        <!--冻结购物币：<span class="go-up" ></span>-->
<!--</div>-->
<form id="form0" method="post" onSubmit="return subb()" action="/3.2.0/index.php/Home/Index/qualifications">
    <?php if($user["biaoji"] == 1): ?><input type="hidden" id="user_id" name="user_id" value='13032270000'>
        <?php else: ?>
    <input type="hidden" id="user_id" name="user_id"><?php endif; ?>
    <input type="hidden" id="shop_id" name="shop_id" >
    <input type="hidden" id="assessor_id" name="assessor_id"> 
<div class="form-horizontal cms-bootstrap">
    <!--显示错误验证信息-->
    <div class="form-group">
    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fn_Type">商品</label>
    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><button type="button" class="btn xuan" name="selected_Type" title="<?php echo ($val["price"]); ?>" value="<?php echo ($val["price"]); ?>" style="margin-right: 10px;"><?php echo ($val["goods_name"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
        <input type="hidden" id="zizhi" name="zizhi">
        <span class="field-validation-valid" data-valmsg-for="fn_Type" data-valmsg-replace="true"></span>
    </div>
    </div>
    <div class="form-group">
    <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="fn_Type">特色家装</label>
    <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if(is_array($sp)): $i = 0; $__LIST__ = $sp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><button type="button" class="btn buan" name="selected_Type" title="<?php echo ($value["price"]); ?>" value="<?php echo ($value["price"]); ?>" style="margin-right: 10px;"><?php echo ($value["goods_name"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
        <span class="field-validation-valid" data-valmsg-for="fn_Type" data-valmsg-replace="true"></span>
    </div>
    </div>
    <div class="form-group">
           <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fc_HTdatetime">合同时间</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <!--<input type="text" placeholder="请输入合同时间" id="Fc_HTdatetime" name="Fc_HTdatetime">-->
            <input value="" class="form-control" data-val="true" data-val-required="合同时间不能为空！" id="Fc_HTdatetime" name="Fc_HTdatetime" readonly="readonly" type="text">
            <span class="field-validation-valid" data-valmsg-for="Fc_HTdatetime" data-valmsg-replace="true"></span>
        </div>
    </div>
    <div class="form-group">
            <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fc_HTDateArea">有效期</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <!--<input type="text" placeholder="请输入合同到期时间" id="Fc_HTDateArea" name="Fc_HTDateArea">-->
            <input value="" class="form-control" data-val="true" data-val-required="有效期不能为空！" id="Fc_HTDateArea" name="Fc_HTDateArea" readonly="readonly" type="text">
            <span class="field-validation-valid" data-valmsg-for="Fc_HTDateArea" data-valmsg-replace="true"></span>
        </div>
    </div>
    <div class="form-group">
         <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="RefUserName">推荐人</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if($user["biaoji"] == 1): ?><span>13032270000</span>
            <input class="form-control" data-val="true" data-val-required="推荐人不能为空！" id="RefUserName" name="RefUserName" type="hidden" value="13032270000" autocomplete="off" maxlength="11">
                <?php else: ?>
            <input class="form-control" data-val="true" data-val-required="推荐人不能为空！" id="RefUserName" name="RefUserName" type="text" value="" autocomplete="off" maxlength="11"><?php endif; ?>
            <span class="field-validation-valid" data-valmsg-for="RefUserName" data-valmsg-replace="true"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="RefUserId">推荐人名称</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if($user["biaoji"] == 1): ?><span id="RefFullName">黄兴隆</span>
                <input type='hidden' value='' name='RefUserId'>
                <?php else: ?>
                <input class="form-control" data-val="true" data-val-number="The field 信息来源姓名 must be a number." data-val-range="没有找到推荐人！" data-val-range-max="2147483647" data-val-range-min="1" data-val-required="没有找到推荐人！" id="RefUserId" name="RefUserId" style="width:0px;border-color:white;border:1px;border: solid 0px #ccc!important; padding: 0px 0px!important;" type="text" value="">
              <span id="RefFullName"></span><?php endif; ?>
                        
            <span class="field-validation-valid" data-valmsg-for="RefUserId" data-valmsg-replace="true"></span>
        </div>
    </div>
        <div class="form-group">
                            <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="RefUserSubName">服务经理</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if($user["biaoji"] == 1): ?><span>13032270000-1</span>
                <input type='hidden' value='13032270000-1' name='RefUserSubName'>
             <?php else: ?>
            <select id="RefUserSubName" name="RefUserSubName" style="width:320px" data-open="off">
                <option value="0">请选择</option>
            </select><?php endif; ?>
            <!--<input class="form-control" data-val="true" data-val-required="服务经理账号不能为空！" id="RefUserSubName" name="RefUserSubName" type="text" value="" autocomplete="off">-->
                        <span class="field-validation-valid" data-valmsg-for="RefUserSubName" data-valmsg-replace="true"></span>
        </div>
    </div>
    
    
    
    
   
    
    
    
        <div class="form-group">
        <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="RefUserSubId">服务经理名称</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if($user["biaoji"] == 1): ?><span id="Fc_Name">已选择13032270000-1</span>
               <?php else: ?>
               <span id="Fc_Name"></span>
                <input class="form-control" data-val="true" data-val-number="The field 服务经理名称 must be a number." data-val-range="没有找到服务经理！" data-val-range-max="2147483647" data-val-range-min="1" data-val-required="没有找到服务经理！" id="RefUserSubId" name="RefUserSubId" style="width:0px;border-color:white;border:1px;border: solid 0px #ccc!important; padding: 0px 0px!important;" type="text" value=""><?php endif; ?>
                        <span class="field-validation-valid" data-valmsg-for="RefUserSubId" data-valmsg-replace="true"></span>
        </div>
    </div>
    
    <div class="form-group">
                            <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" >招商经理名称</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
            <?php if($user["biaoji"] == 3): ?><input type='hidden' name='shopName' value='1'>
                <span>诚兑城</span>
            <?php else: ?>
            <select id="shopName" name="shopName" style="width:320px" >
                   <option value="0">请选择</option>
                <?php if(is_array($shopName)): $i = 0; $__LIST__ = $shopName;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shopNam): $mod = ($i % 2 );++$i;?><option value="<?php echo ($shopNam["manager_id"]); ?>"><?php echo ($shopNam["manager_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select><?php endif; ?>
            <!--<input class="form-control" data-val="true" data-val-required="服务经理账号不能为空！" id="RefUserSubName" name="RefUserSubName" type="text" value="" autocomplete="off">-->
                        <span class="field-validation-valid" id="shop_tishi"></span>
        </div>
    </div>
      <div class="form-group">
        <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="RefUserSubId">安全密码</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
               <span></span>
                <input class="form-control"  id="anquan_pass" name="anquan_pass" type="password" value="">
                <span class="field-validation-valid" data-valmsg-for="RefUserSubId" data-valmsg-replace="true" id="anquan_pass_ti"></span>
        </div>
    </div>
    
    
    
    
    
    
<!--        <div class="form-group">
                            <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fc_Flagship">所属旗舰店编号</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
              <input class="form-control" id="Fc_Flagship" name="Fc_Flagship" type="text" value="" autocomplete="off">
                <span class="field-validation-valid" data-valmsg-for="Fc_Flagship" data-valmsg-replace="true"></span>
        </div>
    </div>
    
    <div class="form-group">
        <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="Fc_FlagshipUserSubId">旗舰店名称</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
              <span id="Fc_FlagshipUserSubName"></span>
                        <input value="" class="form-control" data-val="true" data-val-number="旗舰店编号不能为空！" data-val-range="您输入的旗舰店编号有误！" data-val-range-max="2147483647" data-val-range-min="1" data-val-required="所属旗舰店姓名 字段是必需的。" id="Fc_FlagshipUserSubId" name="Fc_FlagshipUserSubId" style="width:0px;border-color:white;border:1px;border: solid 0px #ccc!important; padding: 0px 0px!important;" type="text">
                        <span class="field-validation-valid" data-valmsg-for="Fc_FlagshipUserSubId" data-valmsg-replace="true"></span>
        </div>
    </div>-->
    
    
    
     <div class="form-group">
                         <label class="editing-form-label-cell control-label col-md-2 col-xs-4 col-sm-4" for="IsAgreeTerm1">同意注册协议</label>
        <div class="editing-form-value-cell col-md-10 col-xs-8 col-sm-8">
                <input checked="True" data-val="true" data-val-checkboxselected="您必须同意协议，才能注册！" data-val-required="同意注册协议 字段是必需的。" id="IsAgreeTerm1" name="IsAgreeTerm1" type="checkbox" value="true"><input name="IsAgreeTerm1" type="hidden" value="false">
                        <a href="/3.2.0/index.php/Home/Index/xieyi" target="_blank">微商合作协议</a>
                        <span class="field-validation-valid" data-valmsg-for="IsAgreeTerm1" data-valmsg-replace="true"></span>
        </div>
    </div>
                    
    <div class="form-group redbutton">
        <div class="form-group-submit col-md-10">
            <input type="submit" value="提交信息" id="sub" class="btn btn-default" onclick="return confirm('确定吗？')">
        <!--<div id="cz" style="display:none">账户余额不足：<a href="">充值</a></div>-->
        </div>
    </div>
<input type="hidden" id="pass_hidden">
    
</div>
    <script type="text/javascript">
        $(document).ready(function(){
          $("#Fc_Flagship").blur(function(){
        if($(this).val()!=""){
            var value = $("#Fc_Flagship").val();
            $.ajax({
                type:"post",
                url:"flagSelect",
                dataType: "text",
                data:{value:value},
                success:
                function(data){
                    if(data!=""){
                        eval("var obj="+data);
                        $(".field-validation-valid").eq(8).html("");
                        $("#Fc_FlagshipUserSubName").text("已找到"+obj.shop_name);
                        $("#shop_id").val(obj.shop_id);
                        $("#Fc_Flagship").attr("data-val","true");
                    }else{
                        $(".field-validation-valid").eq(8).html($("#Fc_FlagshipUserSubId").attr("data-val-range"));
                        $("#Fc_Flagship").attr("data-val","false");
                         $("#Fc_FlagshipUserSubName").text("");
                    }
                }
            })
        }else{
            $(".field-validation-valid").eq(8).html($("#Fc_FlagshipUserSubId").attr("data-val-number"));
        }
    })
      })
        function subb(){
            var result = false;
            if($("#RefUserName").val()==""){
                $(".field-validation-valid").eq(5).html($("#RefUserName").attr("data-val-required"));
                return false;
            }
            if($("#RefUserSubName").val()=="0"){
                $(".field-validation-valid").eq(7).html("请选择产品经理!");
                return false;
            }
             if($("#shopName").val()=="0"){
                $("#shop_tishi").text("请选择招商经理!");
                return false;
            }
            if($("#IsAgreeTerm1").is(":checked")){
                $("#IsAgreeTerm1").val("true");
                $(".field-validation-valid").eq(9).text("");
            }else{
                $("#IsAgreeTerm1").val("false");
                $(".field-validation-valid").eq(9).text("您必须同意协议，才能注册！");
                return false;
            }
            if($("#zizhi").val()==""){
               $(".field-validation-valid").eq(0).html("请选择商品！");
               return false;
            }else{
                var zizhi = $("#zizhi").val();
                $.ajax({
                    async:false,
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/jineselect",
                    dataType: "text",
                    data:{qian:zizhi},
                    success:
                    function(data){
                        if(data==1){
                            $(".field-validation-valid").eq(0).html("");
                            result=true;
                        }else{
                            $(".field-validation-valid").eq(0).html("账户余额不足！请先充值！");
                            result=false;
                        }
                    }
                })
            }
            if($("#anquan_pass").val()==""){
                $("#anquan_pass_ti").html("请输入安全密码");
                return false;
            }else{
                var pass = $("#anquan_pass").val();
                $.ajax({
                    async:false,
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/anquan_pass_yan",
                    dataType: "text",
                    data:{pass:pass},
                    success:
                    function(data){
                        if(data!=1){
                            $("#anquan_pass_ti").html("安全密码错误");
                            result=false;
                        }else{
                            result=true;
                        }
                    }
                })
            }
            if($("#Fc_HTdatetime").val()==""){
                return false;
            }
            if($("#Fc_HTDateArea").val()==""){
                return false;
            }
            if($("#RefUserName").attr("data-val")=="false"){
                return false;
            }
            if($("#RefUserSubName").attr("data-val")=="false"){
                return false;
            }
            if($("#Fc_Flagship").attr("data-val")=="false"){
                return false;
            }
            return result;
        }
        
        
        
    </script>
</form>        
    </div>
    
</body></html>