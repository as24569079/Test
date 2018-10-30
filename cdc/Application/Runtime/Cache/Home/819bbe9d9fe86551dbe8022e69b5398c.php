<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>确认订单</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/v3.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/cart-base.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/cart.css">
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/dingdan.js"></script> 
    </head>
    <body class="root1200">
        <!--头部内容-->
        <div class="cart-header">
               <div class="wrapper clearfix">
                   <div class="g-logo">
                       <a href="/3.2.0/index.php/Home/Index/index" target="_blank">
                        <img src="/3.2.0/Public/images/chengcuicheng.png"  style="width:190px;height:60px;margin-top:7px">
                       </a>
                   </div>
                   <div class="r cart-progress">
                       <ul>
                           <li class="finish finish-01">
                               <i>1</i>
                               <span>我的购物车</span>
                               <b></b>
                           </li>
                           <li class="finish finish-02">
                               <i>2</i>
                               <span>确认订单</span>
                               <b></b>
                           </li>
                           <li>
                               <i>3</i>
                               <span>付款</span>
                               <b></b>
                           </li>
                           <li>
                               <i>4</i>
                               <span>支付成功</span>
                               <b></b>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
        <form id="form" method="post">
            <!--地址管理-->
            <div class="wrapper checkout mt10">
                <div>
                    <div class="step" id="step1">
                        <div class="address-container address-finish">
                            <div class="step-title link-box">
                                <b class="l">配送信息</b>
                            </div>
                            <div class="step-content">
                                <div class="addr-list clearfix">
                                    <ul>
                                        <?php if(is_array($address)): $i = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="addr">
                                            <input type="hidden" value="<?php echo ($val["status"]); ?>" class="morendizhi">
                                            <input type="hidden" value="<?php echo ($val["address_id"]); ?>" class="tjdd">
                                            <input type="hidden" value="<?php echo ($val["address_details"]); ?>" class="uptdizhi2">
                                            <input type="hidden" value="<?php echo ($val["address_provinces"]); ?>" class="uptdiqu2">
                                            <div class="inner">
                                                <div class="addr-hd">
                                                    <span class="name fl"><?php echo ($val["address_people"]); ?></span>
                                                    <span class="addr-desc fl">
                                                        <span class="prov"></span><span class="city"></span>
                                                    </span>
                                                </div>
                                                <div class="addr-hd">
                                                    <span class="dist"><?php echo ($val["address_provinces"]); ?></span>
                                                    <span class="town"></span>
                                                    <span class="street"><?php echo ($val["address_details"]); ?></span>
                                                    <span class="phone"><?php echo ($val["address_tel"]); ?></span>
                                                </div>
                                                <div class="addr-toolbar">
                                                    <span class="addr-opt fr">
                                                        <a class="modify-addr">修改</a>
                                                        <input type="hidden" value="<?php echo ($val["address_id"]); ?>" class="uptid">
                                                        <input type="hidden" value="<?php echo ($val["address_people"]); ?>" class="uptname">
                                                        <input type="hidden" value="<?php echo ($val["address_provinces"]); ?>" class="uptdiqu">
                                                        <input type="hidden" value="<?php echo ($val["status"]); ?>" class="uptmoren">
                                                        <input type="hidden" value="<?php echo ($val["address_details"]); ?>" class="uptdizhi">
                                                        <input type="hidden" value="<?php echo ($val["address_tel"]); ?>" class="uptphone">
                                                        <!--<input type="hidden" value="<?php echo ($val["beiyong"]); ?>" class="uptbeiyong">-->
                                                        <a class="set-default" data-val="<?php echo ($val["address_id"]); ?>" style="display: none;">设为默认</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <a class="del hide gb" data-val="<?php echo ($val["address_id"]); ?>"></a>
                                            <a class="selected"></a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        <li class="addr add-addr" id="tjdz">
                                            <div class="inner">
                                                <p class="add-addr-text">添加地址</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="addr-about clearfix"></div>
                                <div class="nearby-self-pickup clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rel-zx" style="display: block;top:10%" id="xinxi">
                    <div class="step">
                        <div class="address-container new-user">
                            <div class="step-title link-box" id="peisong">
                                <b class="l">配送信息</b>
                            </div>
                            <div class="step-content">
                                <div class="content-title">新增配送信息</div>
                                <div class="content-box">
                                    <dl class="delivery-mode">
                                        <dt class="delivery-item-title">
                                            <div class="delivery-way-hd fl">
                                                <span><em>*</em>配送方式：</span>
                                            </div>
                                            <div class="delivery-way-bd delivery-way-checked fl">
                                                <div class="cart-radio">
                                                    <input type="radio" class="radio">
                                                    <label class="delivery01"></label>
                                                </div>
                                                <span>快递</span>
                                            </div>
                                            <div class="delivery-way-bd fl hide"></div>
                                        </dt>
                                        <dd class="delivery-item-content">
                                            <div class="address-form sh-address-form">
                                                <div class="row clearfix error-row">
                                                    <div class="label">
                                                        <em>*</em>收货人：
                                                    </div>
                                                    <div class="field">
                                                        <input type="text" class="ui-text user" maxlength="20" autocomplete="off" placeholder="姓名，如张三，Lily" style="color: rgb(187, 187, 187)" id="username" name="user">
                                                        <span class="tip-message">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="label">
                                                        <em>*</em>手机：
                                                    </div>
                                                    <div class="field">
                                                        <input type="text" class="ui-text mobile" maxlength="11" autocomplete="off" placeholder="请填写正确的11位手机号码"  style="color: rgb(187, 187, 187);" id="phone" name="phone">
                                                        <span class="tip-message">
                                                            
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="label">备用手机：</div>
                                                    <div class="field">
                                                        <input type="text" class="ui-text bakmobile" maxlength="25" autocomplete="off" placeholder="建议提供备用联系方式" style="color: rgb(187, 187, 187);" id="beiyong" name="beiyong">
                                                        <span class="tip-message"></span>
                                                    </div>
                                                </div>
                                                <div class="row rel zdx10 address-input-box clearfix">
                                                    <div class="label">
                                                        <em>*</em>所在地区：
                                                    </div>
                                                    <div class="field">
                                                        <div class="l mr10 citySelect">
                                                            <a class="cityboxbtn">
                                                                <span id="province2" style="color:#000"></span>
                                                            </a>
                                                        </div>
                                                        <span class="tip-message"></span>
                                                    </div>
                                                    <script type="text/javascript" src="/3.2.0/Public/shopping/js/city.js"></script>
                                                    <script type="text/javascript" src="/3.2.0/Public/shopping/js/provincesData.js"></script>
                                                    <script>
                                                        $(function(){
                                                            $("#tjdz").click(function(){
                                                                $("#xinxi").fadeIn("slow");
                                                                $("#xinxi").css("position","fixed").css("z-index","9999");
                                                                $("#geli").fadeIn("slow");
                                                                $("#peisong").hide();
                                                                $("#qx").show();
                                                            })
                                                            $("#qx").click(function(){
                                                                $("#qx").fadeOut("slow");
                                                                $("#xinxi").fadeOut("slow");
                                                                $("#geli").fadeOut("slow");
                                                                $("#peisong").show();
                                                                $("#xinxi").css("position","none").css("z-index","9999");
                                                            })
                                                            $("#province2").city();
                                                            $(".set-default").click(function(){
                                                                var id = $(this).attr("data-val");
                                                                var frm = document.getElementById('form');
                                                                  frm.action='/3.2.0/index.php/Home/Index/ghmr/id/'+id;
                                                                  frm.submit();
                                                            })
                                                            $(".gb").click(function(){
                                                                if(confirm("是否删除地址?")){
                                                                    var id= $(this).attr("data-val");
                                                                    var frm = document.getElementById('form');
                                                                        frm.action='/3.2.0/index.php/Home/Index/dzsc/id/'+id;
                                                                        frm.submit();
                                                                }
                                                            })
                                                            $("#upt_guanbi").click(function(){
                                                                $("#geli").fadeOut("slow");
                                                                $("#xiugai").fadeOut("slow");
                                                            })
                                                            $(".modify-addr").click(function(){
                                                                $("#geli").fadeIn("slow");
                                                                $("#xiugai").fadeIn("slow");
                                                                $("#sh_receive_name").val($(this).siblings(".uptname").val());
                                                                $("#sh_receive_mobile").val($(this).siblings(".uptphone").val());
                                                                $("#sh_receive_address").val($(this).siblings(".uptdizhi").val());
                                                                $("#sh_receive_bakMobile").val($(this).siblings(".uptbeiyong").val());
                                                                $("#tjid").val($(this).siblings(".uptid").val());
                                                            })
                                                         });
                                                    </script>
                                                </div>
                                                <div class="row zdx5 clearfix">
                                                    <div class="label">
                                                        <em>*</em>详细地址：
                                                    </div>
                                                    <div class="field">
                                                        <input type="text" class="ui-text detial-address verifica" disabled="disabled" maxlength="50" autocomplete="off" placeholder="街道、小区、楼牌号等，无须重复填写省市区" style="color: rgb(187, 187, 187);" id="dizhi" name="dizhi">
                                                        <span class="tip-message"></span>
                                                        <span class="tip-address-message"></span>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="label">&nbsp;</div>
                                                    <div class="field">
                                                        <div class="cart-checkbox">
                                                            <input type="checkbox" class="checkbox chk-item">
                                                            <input type="hidden" id="xuanze" name="moren">
                                                            <label>
                                                                <i class="check-icon l"></i>
                                                                <span class="l">设为默认收货地址</span>
                                                            </label>
                                                        </div>
                                                        <span class="c-f70 ml20 hide" id="set-default-tip">设置后我们将在您购物时自动选中该收货地址</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </dd>
                                        <dd class="save-addr">
                                            <a class="cart-btn" id="bc" style="background-color:#db0638">保存</a>
                                            <a class="cart-btn" id="qx" style="margin-left:40px;display: none;background-color:#db0638">取消</a>
                                        </dd>
                                        <dd class="save-addr save-addr-error hide mt5"></dd>
                                    </dl>
                                </div>
                                <script>
                                    $(function(){
                                        var num = 0;
                                        $("#username").focus(function(){
                                            $(this).attr("class","ui-text user focus");
                                            $(this).attr("placeholder","");
                                        }).blur(function(){
                                            $(this).attr("class","ui-text user");
                                            if($(this).val()==""){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>收货人姓名不能为空");
                                                $(this).attr("placeholder","姓名，如张三，Lily");
                                                num = 0;
                                            }else if(!/^([\u4e00-\u9fa5]|[a-z]|[A-Z]|[0-9])*$/.test($(this).val())){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的中文或者英文姓名");
                                                num = 0;
                                            }else{
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                                num = 1;
                                            }
                                        })
                                        $("#phone").focus(function(){
                                            $(this).attr("class","ui-text mobile focus");
                                            $(this).attr("placeholder","");
                                        }).blur(function(){
                                            $(this).attr("class","ui-text mobile");
                                            if($(this).val()==""){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>手机号码不能为空");
                                                $(this).attr("placeholder","请填写正确的11位手机号码");
                                                num = 0;
                                            }else if(isNaN($(this).val())){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入以1开头的11位手机号码");
                                                num = 0;
                                            }else if($(this).val().length!=11){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入以1开头的11位手机号码");
                                                num = 0;
                                            }else{
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                                num = 1;
                                            }
                                        })
                                        $("#beiyong").focus(function(){
                                            $(this).attr("class","ui-text bakmobile focus");
                                            $(this).attr("placeholder","");
                                        }).blur(function(){
                                            $(this).attr("class","ui-text bakmobile");
                                            if($(this).val()==""){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).attr("placeholder","建议提供备用联系方式");
                                                num = 1;
                                            }else if(isNaN($(this).val())){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的座机号或者手机号");
                                                num = 0;
                                            }else if($(this).val().length!=11){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的座机号或者手机号");
                                                num = 0;
                                            }else{
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                                num = 1;
                                            }
                                        })
                                        $(".c-f70").live("change",function(){
                                            $("#dizhi").attr("class","ui-text detial-address");
                                            $("#dizhi").removeAttr("disabled");
                                            if($(this).val()==""){
                                                $("#dizhi").attr("class","ui-text detial-address verifica");
                                                $("#dizhi").attr("disabled","disabled");
                                                num = 0;
                                            }    
                                        })
                                        $("#dizhi").focus(function(){
                                            $(this).attr("class","ui-text detial-address focus");
                                            $(this).attr("placeholder","");
                                        }).blur(function(){
                                            $(this).attr("class","ui-text detial-address");
                                            if($(this).val()==""){
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>详细地址不能为空");
                                                $(this).attr("placeholder","街道、小区、楼牌号等，无须重复填写省市区");
                                                num = 0;
                                            }else{
                                                $(this).siblings(".tip-message").children().remove();
                                                $(this).siblings(".tip-message").text("");
                                                $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                                num = 1;
                                            }
                                        })
                                        $(".cart-checkbox").eq(0).toggle(function(){
                                            $(this).attr("class","cart-checkbox cart-checkbox-checked");
                                            $(this).children(".chk-item").attr("checked","checked");
                                            $("#set-default-tip").show();
                                            $("#xuanze").val("1");
                                        },function(){
                                            $(this).attr("class","cart-checkbox");
                                            $(this).children(".chk-item").removeAttr("checked");
                                            $("#set-default-tip").hide();
                                            $("#xuanze").val("0");
                                        })
                                        $("#bc").click(function(){
                                            if(num==1){
                                                if($("#username").val()!=""&&$("#phone").val()!=""&&$("#dizhi").val()!=""){
                                                   var frm = document.getElementById('form');
                                                       frm.action='/3.2.0/index.php/Home/Index/adddizhi';
                                                       frm.submit();
                                                }
                                            }
                                        })
                                        
                                    })
                                </script>
                                <div class="addr-about clearfix hide"></div>
                                <div class="nearby-self-pickup clearfix hide"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="step">
                        <div class="payment-container">
                            <div class="step-title link-box">
                                <b class="l">支付方式</b>
                            </div>
                            <div class="step-content pay-benefits clearfix">
                                <div class="pay-list">
                                    <ul class="clearfix">
                                        <li class="pay-item short-icon-item pay-checked">
                                            <span class="pay-way">在线支付</span>
                                            <i class="tip-icon tip-help-16"></i>
                                            <i class="check"></i>
<!--                                            <p class="benefits">
                                                <span>减</span>领任性付十二期免息券，分期更实惠
                                            </p>-->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="step">
                        <div class="goods-info-container">
                            <div class="step-title link-box">
                                <b class="l">商品及服务信息</b>
                                <a class="l edit goods-edit" href="/3.2.0/index.php/Home/Index/gouwuchejs">返回我的购物车修改</a>
                                <span class="l"></span>
                            </div>
                            <div class="step-content">
                                <div class="store mt20 c-store">
                                    <table class="cart-table three-column store-item">
                                        <tr class="store-title">
                                            <th class="first-column">
                                                <span class="store-name l mr10">订单信息</span>
                                            </th>
                                            <th class="second-column" colspan="2">服务信息</th>
                                            <th class="third-column tr">单价</th>
                                            <th class="fourth-column tr">数量</th>
                                            <th class="fifth-column tr">小计</th>
                                        </tr>
                                        <?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><!--                                            <input type="hidden" value="<?php echo ($val["mingcheng"]); ?>" name="valmc[]">
                                            <input type="hidden" value="<?php echo ($val["jiage"]); ?>" name="valjiage[]">
                                            <input type="hidden" value="<?php echo ($val["gouwu"]); ?>" name="sl[]">
                                            <input type="hidden" value="<?php echo ($val["lujing"]); ?>" name="lujing[]">
                                            <input type="hidden" value="<?php echo ($val["bianhao"]); ?>" name="bianhao[]">
                                            <input type="hidden" value="<?php echo ($val["lujing2"]); ?>" class="lu2" name="lujing2[]">
                                            <input type="hidden" value="<?php echo ($val["lujing3"]); ?>" class="lu3" name="lujing3[]">
                                            <input type="hidden" value="<?php echo ($val["lujing4"]); ?>" class="lu4" name="lujing4[]">
                                            <input type="hidden" value="<?php echo ($val["lujing5"]); ?>" class="lu5" name="lujing5[]">
                                            <input type="hidden" value="<?php echo ($val["lujing6"]); ?>" class="lu6" name="lujing6[]">
                                            <input type="hidden" value="<?php echo ($val["yanse"]); ?>" class="yan" name="y[]">-->
                                            <!--<input type="hidden" value="" name="yanse[]">-->
                                        <tr class="product">
                                            <td class="first-column ">
                                                <div class="product-box clearfix">
                                                    <a class="product-img-box" href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                        <img class="product-img l lazy-loading" src="<?php echo ($val["img_url"]); ?>">
                                                    </a>
                                                    <div class="product-detail l">
                                                        <p class="product-name">
                                                            <a class="pageSale" href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                        </p>
                                                        <p>
                                                            <span class="service-icon service-zheng"></span>
                                                        </p>
                                                        <p class="tui-content">
                                                            <a>7天无理由退货</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td colspan="2" rowspan="1" class="second-column tc">
                                                <p class="lh20">支付完成后尽快为您发货</p>
                                                <p class="cInstall"></p>
                                            </td>
                                            <td class="tr  col-td" colspan="3">
                                                <div class="col-td-box clearfix">
                                                    <div class="third-column l ">
							<div class="sn-price">
								<i><?php if($val["s_xj_price"] > 0): ?>积分<?php else: ?>电子币<?php endif; ?></i>
                                                                <em><?php if($val["s_xj_price"] > 0): echo ($val["s_xj_price"]); else: echo ($val["g_xj_price"]); endif; ?></em>
							</div>
                                                    </div>
						<div class="fourth-column l "><?php echo ($val["quantity"]); ?></div>
						<div class="fifth-column l ">
                                                    <span class="sn-price font-bold booking_price_total">
                                                        <i><?php if($val["s_xj_price"] > 0): ?>积分<?php else: ?>电子币<?php endif; ?></i>
                                                        <em><?php if($val["s_xj_price"] > 0): echo ($val[quantity]*$val[s_xj_price]); ?>.00<?php else: echo ($val[quantity]*$val[g_xj_price]); ?>.00<?php endif; ?></em>
                                                        <!--<input type="hidden" value="<?php echo ($val["gouwu"]); ?>" class="gouwu">-->
                                                        <!--<input type="hidden" value="<?php echo ($val["jiage"]); ?>" class="jiage">-->
                                                        <!--<input type="hidden" class="zongjia">-->
                                                    </span>
						</div>
                                                </div>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        <tr class="store-message-box">
                                            <td class="end-column " colspan="3" rowspan="2">
                                                <span class="l">给我们留言：</span>
                                                <div class="message-input-box ">
                                                    <textarea shop="0070092449" autocomplete="off" flag="0" class="c-store-message l" id="liuyan" maxlength="85">选填：对本次交易的补充说明（所填内容建议已经和我们达成一致意见）</textarea>
                                                </div>
                                                <div class="message-length l">
                                                    <span class="current-length">0</span>
                                                    <span class="max-length">/85</span>
                                                </div>
                                                <div class="tip-info"></div>
                                            </td>
                                        </tr>
                                        <tr class="store-message-box">
                                            <td class="third-column tr end-column-style">合计</td>
                                            <td class="fouth-column tr"></td>
                                            <td class="fifth-column tr">
                                                <span class="sn-price font-bold c-ff4400">
                                                        <i>电子币</i>
                                                        <em class="booking_price_amount"><?php echo ($qian["smoney"]); ?>.00</em><br>
                                                        <i>积分</i>
                                                        <em class="booking_price_amount"><?php echo ($qian["emoney"]); ?>.00</em>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="coupon-container coupon-original">
	<div class="step-title link-box">
		<b class="l">结算信息</b>
	</div>
	<div class="step-content">
<!--            <div id="coupon_ID">
		<div class="toggle-title " id="coupon_title">
			<a href="javascript:void(0)">
				<i></i><b>使用优惠券</b>
			</a>
			<span class="c9"> (无可用优惠券)</span>
		</div>
		<div class="toggle-content" id="coupon_finish_id" style="display:">
	        <div class="clearfix">
	        	<span class="yellow-info-box">您还没有优惠券，暂不能使用</span>
	        </div>
	
	        <div class="add-coupon-box mt10">
	        	<div class="add-coupon-btn link-box clearfix">
	            	<span>您有新的优惠券？</span><a href="javascript:;" class="1 btn" name="new_icart2_account_newticket">点击添加新的优惠券<i class="icon"></i></a>
					</div>
                <div class="form add-coupon-form mt5 clearfix" style="display:none">
                        <div class="row error-row" id="coupon_bind">
                                <span class="label">请输入优惠券号：</span>
                        <input type="text" class="ui-text" maxlength="" placetext="请输入优惠券号" id="coupon_num" data-is-enter="0" style="color: rgb(187, 187, 187);">
                        <input type="password" class="ui-text hide" maxlength="" placeholder="请输入密码" id="coupon_passw">
                        <a href="javascript:void(0)" class="add-coupon cart-btn mr10" id="add-coupon" name="new_icart2_account_addticket">添加</a>
                        <span class="l tip-message" id="coupon_error"></span>
                        </div>
                    </div>
	        </div>
	        
		</div>
            </div>-->
<!--		<div class="item other-coupon-item">
			<div class="toggle-title" id="other_coupon_title">
				<a href="javascript:void(0)" name="new_icart2_account_usenumber">
					<i></i><b>使用推荐号</b>
				</a>
			</div>
			<div class="toggle-content" id="other_coupon_content">
			</div>
		</div>-->
		<div class="checkout-promotion tr">
			<div class="checkout-promotion-item"><span class="c-ff6600"  qty="1"><?php echo ($qian["count"]); ?></span>件商品 
			总计：<span class="sn-price"><i></i><em><?php echo ($qian["zong"]); ?>.00 </em></span></div>
			<div class="checkout-promotion-item" id="energySubsidiesAmountDiv" style="display: none;">节能补贴减免：<span class="sn-price"><i>-¥</i><em id="energySubsidiesID">0.00</em></span></div>
			<!--<div class="checkout-promotion-item">运费：<span class="sn-price"><i>¥</i><em id="shippingChargeID">0.00</em></span></div>-->
			<!--<div class="checkout-promotion-item hide" id="taxFareDisplay">税费：<span class="sn-price"><i>¥</i><em id="taxFare">0.00</em></span></div>-->
			<!--<div class="checkout-promotion-item">优惠：<span class="sn-price"><i>-¥</i><em id="cmmdyDiscountID">0.00</em></span></div>-->
			<!--<div class="checkout-promotion-item">优惠券/卡：<span class="sn-price"><i>-¥</i><em id="freeAmountID">0.00</em></span></div>-->
				<div class="checkout-promotion-item checkout-promotion-input-item ">
<!--					<span class="cart-checkbox ">
						<input type="checkbox" class="checkbox" id="cloudDaimondInputId" name="new_icart2_account_yunzuan">
						<label for="cloudDaimondInputId" class="check-icon"></label>
					</span>-->
                                    <!--<span class="c-333333">使用云钻</span>-->
					<span class="diamond-check">：
						<input type="text" id="toatalPiontsId" class="input-box" data-max="0" value="">个
						<span class="sn-price-box">
							<span class="sn-price">
								<i>-¥</i><em id="cloudAccountId">0.00</em>
							</span>
						</span>
					</span>
				</div>
				<div class="checkout-promotion-item diamond-check clearfix">
					<span class="cloud-diamond-can-use r">（可用<span class="c-ff6600" id="toatalPiontsId2">0</span>个）</span>
				</div>
			<div class="checkout-promotion-item other-pay-box  clearfix">
				<span id="otherPayDesc"></span>
<!--				<span class="cart-checkbox ">
					<input type="checkbox" class="checkbox" id="otherPayCheck" name="new_icart2_account_daifu">
					<label for="otherPayCheck" class="check-icon"></label>
				</span>-->
				<!--<span class="spc-col">找人代付</span>-->
                            <i class="tip-icon tip-help tip-common-hover-fn-btn hide" id="otherPayTip1" data-flag="other-pay-help-tip" data-html="仅限在线支付"></i>
                            <i class="tip-icon tip-help tip-common-hover-fn-btn hide" id="otherPayTip2" data-flag="other-pay-help-tip2" data-html="订单中包含不支持代付的商品"></i>
                            <i class="tip-icon tip-help tip-common-hover-fn-btn hide" id="otherPayTip3" data-flag="other-pay-help-tip3" data-html="政企用户暂不支持代付"></i>
			</div>
                            </div>	
                        </div>
                </div>
                </div>
                <div class="checkout-bar-boxes">
                    <div class="checkout-bar-box">
                        <div class="checkout-bar clearfix">
		<div class="all-about-price">
	        <p class="sum-pay-price sum-pay-price-sp"><span id="sum-pay-text">应付金额：</span><span class="sn-price"><i></i><em><?php echo ($qian["zong"]); ?>.00</em></span></p>
                <p class="sum-pay-price sum-pay-price-sp">满<em style="color:red">3200.00</em>包邮</p>
	        <p class="capricious-pay  hide">任性付：期</p>
                        </div>
		<div class="order-address r hide">
		    <p class="content mt5">收货信息：<span class="c-333333" title="  ">  </span></p>
                    <p class="content">支付方式：<span class="c-333333 pay-name">在线支付</span></p>
                            </div>
                            <div class="checkout-float-warning r">
                                    <span class="checkout-float-warning-content booking-check-warning-content">您需先选择配送地址，再提交订单</span>
                                    <span class="checkout-float-warning-bg"></span>
                            </div>
                            <div class="checkout-bar-r r">
                                <div class="l"><p class="checkout-warning"><i class="tip-icon tip-warning mr5"></i>提交订单后尽快支付，商品才不会被人抢走哦！</p></div>
                                    <a name="new_icart2_account_submit" class="checkout-submit-btn l" style="display:none">提交订单</a>
                                    <input type="hidden" id="tjd" name="shdz">
                                    <a class="checkout-submit-btn cart-btn-disable l" id="submit-btn">提交订单</a>
                                    <a href="javascript:;" class="checkout-submit-btn-load checkout-submit-btn-load l" style="display:none"><span>提交中...</span></a>
                            </div>
                    </div>
            </div>
                </div>
            </div>
            <div style="width: 550px; height:150px; position: absolute; z-index: 10000; display: block; overflow: hidden; top: 500px; left: 450px; border:1px  solid #ccc; background:#FFF;display: block; border-radius: 5px;display: none" id="liulan_pay">
              
               
          	<div style="margin:40px 20px">
                        <div class="row clearfix">
                                <em style="color:red">*</em>请输入安全密码：
                                <input type="password" class="ui-text mobile" maxlength="8" autocomplete="off"  style="color: rgb(187, 187, 187);" id="liulan_mima" name="phone">
                                <span class="tip-message" id="liulan_shibai">

                                </span>
                </div>    
                    <a class="checkout-submit-btn cart-btn-disable l" id="liulan_z" style="margin:20px;margin-left:250px">提交</a>
                    <a class="checkout-submit-btn cart-btn-disable l"  style="margin-top:20px;" id="liulan_no">取消</a>
                </div>
             
          </div>
            <input type="hidden" id="order_id" value="<?php echo ($arr["0"]["order_id"]); ?>">
            <script>
                $(function(){
                    $("#submit-btn").click(function(){
                        $("#liulan_pay").fadeIn("slow");
                    })
                    $("#liulan_z").click(function(){
                         var value=$("#liulan_mima").val();
                          $.ajax({
                                      type:"post",
                                      url:"/3.2.0/index.php/Home/Index/pay_ajax",
                                      dataType: "text",
                                      data:{value:value},
                                    //   dataType: 'content', //这里修改为content
                                    success: function (res) {
                                          if(res==1){
                                              $("#liulan_shibai").text(" 密码不正确！")
                                              return;
                                          }else{
                                               var order_id=$("#order_id").val();
                                                var madress=$("#tjd").val(); 
                                                var data={
                                                    order_id:order_id,
                                                    madress:madress,

                                                }
                            //                    alert(JSON.stringify(data));return;
                                                $.ajax({
                                                url: "/3.2.0/index.php/Home/Index/pay_updatex",
                                                type: "post",
                                                data: JSON.stringify(data),
                                                contentType: "application/json; charset=UTF-8",
                                                //   dataType: 'content', //这里修改为content
                                                success: function (res) {
//                                                    alert(res);return;
//                                                    alert(res);
                                                      if(res==1){
                                                          
                            //                              var frm = document.getElementById('form');
                                                          window.location.href="/3.2.0/index.php/Home/Index/zhifu";
                            //                              frm.submit();window.location.href='List.aspx';
                                                      }else if(res==2){
                                                        alert("您的余额不足不能支付！")
                                                      }else if(res==3){
                                                          alert("建材电子币余额不足!");
                                                      }
                                                  }
                                             });
                                              
                                              
                                          }
                                       }
                               });      
                     })
                      $("#liulan_no").click(function(){
                         $("#liulan_pay").fadeOut();    
                     })
                })
            </script>
            <!--修改弹窗-->
            <div class="m-lion-dialog" style="width: 800px; position: fixed; margin-left: -400px; margin-top: -198.5px; top: 50%;display:none" id="xiugai"><i class="lion"></i><div class="container" style="overflow: visible; display: block;"><div class="title"><h3>修改配送信息</h3></div><a class="btn close" title="关闭" id="upt_guanbi"></a><i class="semi-circle"></i><div class="content">	<div class="new-user">
                <div class="step-content">
		    <div class="content-box">
                        <dl class="delivery-mode">
                            <dt class="delivery-item-title">
                                    <div class="delivery-way-hd fl">
                                        <span><em>*</em>配送方式：</span>
                                    </div>
                                    <div class="delivery-way-bd delivery-way-checked fl" id="delivery_tab" name="new_icart2_add_select03" townname="全区" towncode="4520299" townwcscode="4520299" smtowncode="4520299" addressid="2" provname="黑龙江" provcode="090" provwcscode="090" cityname="齐齐哈尔市" citycode="452" citywcscode="452" distname="建华区" distcode="45202" distwcscode="45202" deliveryregioncode="4520299">
                                        <div class="cart-radio">
                                            <input type="radio" name="adress" class="radio" id="delivery01">
                                            <label class="" for="delivery01"></label>
                                        </div>
                                        <span>快递</span>
                                    </div>
                                    <div class="delivery-way-bd fl hide" id="pickup_tab" name="new_icart2_add_select04">
                                        <div class="cart-radio">
                                            <input type="radio" name="adress" class="radio" id="delivery02">
                                            <label class="" for="delivery02"></label>
                                        </div>
                                        <span>顾客自提<a href="javascript:void(0);" class="no-fare">免运费</a></span>
                                        <span class="pickup-info">选择自提点并下单<i class="arr">&gt;</i>收到提货短信<i class="arr">&gt;</i>到自提点自提</span>
                                    </div>
                            </dt>
                            <dd class="delivery-item-content" style="display: block;">
                                <div class="address-form sh-address-form">
                                    <div class="row clearfix">
                                        <div class="label">
                                            <em>*</em>收货人：
                                        </div>
                                        <div class="field">
                                            <input type="text" id="sh_receive_name" class="ui-text user" maxlength="20" autocomplete="off" placetext="姓名，如张三，Lily" data-is-enter="1" style="color: rgb(51, 51, 51);" name="uptname">
                                            <span class="tip-message"><i class="tip-icon tip-ok" style="display:none"></i></span>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="label"><em>*</em>手机：</div>
                                        <div class="field">
                                            <input type="text" id="sh_receive_mobile" class="ui-text mobile" maxlength="11" autocomplete="off" placetext="请填写正确的11位手机号码" data-is-enter="0" style="color: rgb(51, 51, 51);" name="uptphone">
                                            <span class="tip-message"></span>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                            <div class="label">备用手机：</div>
                                            <div class="field">
                                                <input type="text" id="sh_receive_bakMobile" class="ui-text bakmobile" maxlength="25" autocomplete="off" placetext="建议提供备用联系方式" data-is-enter="0" style="color: rgb(187, 187, 187);" name="uptbeiyong">
                                                <span class="tip-message"></span>
                                            </div>
                                        </div>
                                    <div class="row rel zdx10 address-input-box clearfix">
                                        <div class="label"><em>*</em>所在地区：</div>
                                        <div class="field">
                                            <div id="city" class="l mr10 citySelect">
                                                <span id="province"></span>
                                            </div>
                                            <span class="tip-message"></span>
                                        </div>
                                    </div>
                                    <div class="row zdx5 clearfix">
                                        <div class="label"><em>*</em>详细地址：</div>
                                        <div class="field">
                                            <input type="text" id="sh_receive_address" class="ui-text detial-address" maxlength="50" autocomplete="off" placetext="街道、小区、楼牌号等，无须重复填写省市区" data-is-enter="1" style="color: rgb(51, 51, 51);" name="uptdizhi">
                                            <span class="tip-message"></span>
                                            <span id="village_tip" class="tip-address-message"></span>
                                        </div>
                                    </div>
                                    <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery.provincesCity.js"></script>
                                    <script type="text/javascript" src="/3.2.0/Public/shopping/js/provincesData.js"></script>
                                    <script>
                                        $("#province").ProvinceCity();
                                    </script>
                                <div class="row clearfix">
                                    <div class="label">
                                        &nbsp;
                                    </div>
                                    <div class="field">
                                        <div class="cart-checkbox" id="duo">
                                            <input type="checkbox" class="checkbox chk-item" id="set-default">
                                            <input type="hidden" id="uptmoren" name="uptmoren">
                                            <label for="set-default">
                                                <i class="check-icon"></i>
                                                <span>设为默认收货地址</span>
                                            </label>
                                        </div>
                                    <span id="set-default-tip2" class="c-f70 ml20">设置后我们将在您购物时自动选中该收货地址</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </dd><dd class="delivery-item-content" style="display: none;">
                                            <div class="address-form zt-address-form">
                                                <div class="row clearfix">
                                                    <div class="label"><em>*</em>收货人：</div>
                                                    <div class="field">
                                                        <input type="text" id="zt_receive_name" class="ui-text user" maxlength="20" autocomplete="off" placetext="姓名，如张三，Lily" data-is-enter="0" style="color: rgb(187, 187, 187);">
                                                                        <span class="tip-message"></span>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="label"><em>*</em>手机：</div>
                                                    <div class="field">
                                                        <input type="text" id="zt_receive_mobile" class="ui-text mobile" maxlength="11" autocomplete="off" placetext="请填写正确的11位手机号码" data-is-enter="0" style="color: rgb(187, 187, 187);">
                                                        <span class="tip-message"></span>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                        <div class="label">备用手机：</div>
                                                        <div class="field">
                                                            <input type="text" id="zt_receive_bakMobile" class="ui-text bakmobile" maxlength="25" autocomplete="off" placetext="建议提供备用联系方式" data-is-enter="0" style="color: rgb(187, 187, 187);">
                                                            <span class="tip-message"></span>
                                                        </div>
                                                    </div>
                                                <div class="row clearfix">
                                                    <div class="label"><em>*</em>自提地址：</div>
                                                    <div class="field">
                                                        <div id="city2" class="l mr10"></div>
                                                        <span class="tip-message"></span>
                                                    </div>
                                                </div>
                                                <div class="row pick-self-row clearfix">
                                                    <div class="label"><em>*</em>自提点：</div>
                                                    <div class="field">
                                                        <p id="sites_tip" class="c-f70 lh28">请选择自提地址</p>
                                                        <div id="pickUp" class="pick-self-box hide"></div>
                                                    </div>
                                                </div>
                                                                                            </div>
                                                       </dd>				    <dd class="save-addr">
                                                                                <a id="sava-addr-btn" class="cart-btn" name="new_icart2_add_save" id="upttj" style="background-color:#db0638">保存</a>
                                                                                <input type="hidden" id="tjid" name="tjid">
                                                                            </dd>
                                                                            <dd class="save-addr save-addr-error hide mt5"></dd>
                                                                    </dl>
                                                            </div>
                                                    </div>
                                                        </div>
                                                </div></div></div>
            <script>
                        $(function(){
                            var num = 0;
                            $("#sh_receive_name").focus(function(){
                                $(this).attr("class","ui-text user focus");
                                $(this).attr("placeholder","");
                            }).blur(function(){
                                $(this).attr("class","ui-text user");
                                if($(this).val()==""){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>收货人姓名不能为空");
                                    $(this).attr("placeholder","姓名，如张三，Lily");
                                    num = 0;
                                }else if(!/^([\u4e00-\u9fa5]|[a-z]|[A-Z]|[0-9])*$/.test($(this).val())){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的中文或者英文姓名");
                                    num = 0;
                                }else{
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                    num = 1;
                                }
                            })
                            $("#sh_receive_mobile").focus(function(){
                                $(this).attr("class","ui-text mobile focus");
                                $(this).attr("placeholder","");
                            }).blur(function(){
                                $(this).attr("class","ui-text mobile");
                                if($(this).val()==""){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>手机号码不能为空");
                                    $(this).attr("placeholder","请填写正确的11位手机号码");
                                    num = 0;
                                }else if(isNaN($(this).val())){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入以1开头的11位手机号码");
                                    num = 0;
                                }else if($(this).val().length!=11){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入以1开头的11位手机号码");
                                    num = 0;
                                }else{
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                    num = 1;
                                }
                            })
                            $("#sh_receive_bakMobile").focus(function(){
                                $(this).attr("class","ui-text bakmobile focus");
                                $(this).attr("placeholder","");
                            }).blur(function(){
                                $(this).attr("class","ui-text bakmobile");
                                if($(this).val()==""){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).attr("placeholder","建议提供备用联系方式");
                                    num = 1;
                                }else if(isNaN($(this).val())){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的座机号或者手机号");
                                    num = 0;
                                }else if($(this).val().length!=11){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>请输入正确的座机号或者手机号");
                                    num = 0;
                                }else{
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                    num = 1;
                                }
                            })
                            $(".city_xiala").live("change",function(){
                                $("#sh_receive_address").attr("class","ui-text detial-address");
                                $("#sh_receive_address").removeAttr("disabled");
                                if($(this).val()==""){
                                    $("#sh_receive_address").attr("class","ui-text detial-address verifica");
                                    $("#sh_receive_address").attr("disabled","disabled");
                                    num = 0;
                                }    
                            })
                            $("#sh_receive_address").focus(function(){
                                $(this).attr("class","ui-text detial-address focus");
                                $(this).attr("placeholder","");
                            }).blur(function(){
                                $(this).attr("class","ui-text detial-address");
                                if($(this).val()==""){
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-error'></i>详细地址不能为空");
                                    $(this).attr("placeholder","街道、小区、楼牌号等，无须重复填写省市区");
                                    num = 0;
                                }else{
                                    $(this).siblings(".tip-message").children().remove();
                                    $(this).siblings(".tip-message").text("");
                                    $(this).siblings(".tip-message").append("<i class='tip-icon tip-ok'></i>");
                                    num = 1;
                                }
                            })
                            $("#duo").toggle(function(){
                                $(this).attr("class","cart-checkbox cart-checkbox-checked");
                                $(this).children(".chk-item").attr("checked","checked");
                                $("#set-default-tip2").show();
                                $("#uptmoren").val("1");
                            },function(){
                                $(this).attr("class","cart-checkbox");
                                $(this).children(".chk-item").removeAttr("checked");
                                $("#set-default-tip2").hide();
                                $("#uptmoren").val("0");
                            })
                            $("#sava-addr-btn").click(function(){
                                if(num==1){
                                    if($("#sh_receive_name").val()!=""&&$("#sh_receive_mobile").val()!=""&&$("#sh_receive_address").val()!=""){
                                       var frm = document.getElementById('form');
                                           frm.action='/3.2.0/index.php/Home/Index/uptdizhi';
                                           frm.submit();
                                    }
                                }
                            })

                        })
                                </script>
            <!--隔离层-->
            <div class="m-lion-dialog-overlay" id="geli" style="display:none"><div class="close lay overlay" style="height: 1443px; opacity: 0.3; display: block; background: black;"></div><!--[if IE 6]><iframe class="close lay frame"  src="about:blank" frameborder="0" ></iframe><![endif]--></div>
        </form>
        <script>
            $(document).ready(function(event){
                $('html').bind("selectstart", function () { return false; });
                var diqu = $(".uptdiqu");
                var dizhi = $(".uptdizhi");
                for(var i=0;i<diqu.length;i++){
                    if($(".uptmoren").eq(i).val()=="1"){
                        $("#tjd").val($(".uptid").eq(i).val());
                    }
                }
                if($("#tjd").val()!=""){
                    $("#submit-btn").attr("class","checkout-submit-btn l");
                    $(".booking-check-warning-content").hide();
                }else{
                    $("#submit-btn").attr("class","checkout-submit-btn cart-btn-disable l");
                    $(".booking-check-warning-content").show();
                }
//                $("#submit-btn").click(function(){
//                    if($("#tjd").val()!=""){
//                        var frm = document.getElementById('form');
//                                frm.action='/3.2.0/index.php/Home/Index/duotjdd';
//                                frm.submit();
//                    }
//                })
                $.ajax({
                        type:"post",
                        url:"/3.2.0/index.php/Home/Index/dzajax",
                        dataType: "text",
                        data:null,
                        success:
                        function(data){
                            if(data*1 > 0){
                                $("#xinxi").hide();
                                $("#step1").show();
                            }else{
                                $("#step1").hide();
                                $("#xinxi").show();
                            }
                        }
                })
            })    
        </script>
    </body>
</html>