<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>我的购物车</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/v3.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/cart.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/chanpin.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/index.css">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/gouwuchejs.js"></script>
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
        <style>
            .ys > ul > li{
                float:left;margin-right: 4px;
                margin-top: 5px;
            }
            .ys > ul > li:hover{
                
            }
        </style>
    </head>
    <body class="root1200">
        <form id="form" method="post">
         <div class="ng-toolbar">
            <div class="ng-toolbar-con wrapper">
                <div class="ng-toolbar-left">
                    <a class="ng-bar-node ng-site-nav-box" href="/3.2.0/index.php/Home/Index/index">
                        <!--<i class="ng-iconfont ng-backhome"></i>-->
                        <span>返回官网首页</span>
                        <i class="ng-line ng-iconfont ml10"></i>
                    </a>
                    <div class="ng-bar-node-box ng-site-nav-box">
                        <a class="ng-bar-node ng-site-nav-box" href="/3.2.0/index.php/Home/Index/shop_index">
<!--                        <i class="ng-iconfont ng-backhome"></i>-->
                        <span>返回商城首页</span>
                        <i class="ng-line ng-iconfont ml10"></i>
                    </a>
                    </div>
                </div>
                <div class="ng-toolbar-right">
                    <a class="ng-bar-node username-bar-node username-bar-node-showside">
                        <span></span>
                        <em class="hasmsg ng-iconfont"></em>
                    </a>
                    <?php if($find != ""): ?><div class="ng-bar-node-box username-handle"  id="username-node-slide">
                        <a class="ng-bar-node username-bar-node username-bar-node-noside">
                            <span id="usernameHtml02"><?php echo ($find["real_name"]); ?></span>
                            <em class="hasmsg ng-iconfont"></em>
                            <em class="ng-iconfont down"></em>
                        </a>
                        <div class="ng-d-box ng-down-box ng-username-slide" style="display: none" id="guanli">
                            <a class="ng-vip-union" href="/3.2.0/index.php/Home/Index/myhome" target="_blank">账号管理</a>
                            <a class="ng-vip-union" href="/3.2.0/index.php/Home/Index/member" target="_blank">资质管理</a>
                            <a href="/3.2.0/index.php/Home/Index/signOut">退出登录</a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="ng-bar-node reg-bar-node" id="username-node">
                        <a class="login" href="/3.2.0/index.php/Home/Index/login">登录</a>
                        <a class="login reg-bbb" href="/3.2.0/index.php/Home/Index/register" target="_blank">注册</a>
                    </div><?php endif; ?>
                    <?php if($find != ""): ?><!--                    <div class="ng-bar-node-box myorder-handle">
                        <a class="ng-bar-node ng-bar-node-fix touch-href ng-bar-node-pr5" href="/3.2.0/index.php/Home/Index/my">
                            <span>我的订单</span>
                            <em class="ng-iconfont down"></em>
                        </a>
                        <div class="ng-down-box ng-d-box myorder-child" style="display: none">
                            <a href='/3.2.0/index.php/Home/Index/member#dingdanxiangqing'>未发货</a>
                            <a>已发货</a>
                        </div>
                    </div>--><?php endif; ?>
                    <?php if($find != ""): ?><a class="ng-bar-node ng-bar-node-mini-cart" href="/3.2.0/index.php/Home/Index/gouwuchejs">
                        <span>购物车</span>
                        <em class="ng-iconfont cart"></em>
                        <span class="total-num-box">
                            <b class="total-num J_cart_total_num" style="background:#db0638"><?php echo ($gouwunum); ?></b>
                            <span class="total-num-bg-box">
                                <em></em>
                                <i></i>
                            </span>
                        </span>
                    </a><?php endif; ?>
                </div>
                <div class="ng-minicart-slide-box"></div>
            </div>
        </div>
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
                           <li>
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
               <div class="head-delivery wrapper clearfix" id="tishitiao" style="display: none">
                   <div class="login-tips fl ml20">
                       <p>
                           现在<a class="cart-btn login-btn" href="/3.2.0/index.php/Home/Index/login">登录</a>，您的商品将被永久保存
                       </p>
                   </div>
               </div>
           </div>
           <div class="cart-bg">
               <!--购物车无商品(已登录)-->
               <div class="wrapper cart cart-wrapper" style="display: none" id="yidenglu">
                   <div class="cart-empty" style="background:url('')">
                       <h2 class="c3">
                           购物车还是空空的呢，快去<a class="link-btn cart-btn" href="/3.2.0/index.php/Home/Index/shop_index" target="_blank" style='background-color:#db0638'>首页</a>逛逛吧~~
                       </h2>
                       <p class="link-wrap lh28 clearfix"></p>
                   </div>
               </div>
               <!--购物车无商品(未登录)-->
               <div class="wrapper cart cart-wrapper" style="display: none" id="weidenglu">
                   <div class="cart-empty">
                       <h2 class="c3">
                           购物车还是空空的呢，马上 <a class="link-btn cart-btn" href="/3.2.0/index.php/Home/Index/login" target="_blank">登录</a>查看您之前加入的商品
                       </h2>
                       <p class="link-wrap lh28 clearfix"></p>
                   </div>
               </div>
               <!--购物车有商品-->
               <div class="wrapper cart cart-wrapper" style="display: none" id="yousp">
                   <div class="m-cart-header">
                       <div class="cart-table-header">
                           <div class="inner-box c6">
                               <div class="th th-chk form th-chk-chkd">
<!--                                   <div class="cart-checkbox cart-checkbox-checked">
                                       <input type="checkbox" id="chooseAllCheckBox" class="J-AllCheckBox">
                                       <label class="chooseAllCheckBox"></label>
                                   </div>全选-->
                               </div>
                               <div class="th th-item">商品信息</div>
                               <div class="th th-specs">规格</div>
                               <div class="th th-price">单价（元）</div>
                               <div class="th th-amount">数量</div>
                               <div class="th th-sum">小计（元）</div>
                               <div class="th th-op">操作</div>
                           </div>
                       </div>
                   </div>
                   <div class="m-cart-body">
                       <div class="m-store">
                           <div class="cart-list">
                               <div class="meet-suit meet-suit-selected">
                                   <div class="meet-suit-line">&nbsp;</div>
                                   <?php if(is_array($item)): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="item  item-checked">
                                       <span class="line-this"></span>
                                       <span class="main-line"></span>
                                       <span class="main-line main-line-01"></span>
                                       <div class="item-main  clearfix">
                                           <div class="td td-chk form">
                                               <div class="cart-checkbox ck" data-id='<?php echo ($val["item_id"]); ?>' data-val='<?php echo ($val["shop_biaoji"]); ?>' style='display:none'>
                                                   <input name="duoxuan[]" type="checkbox" checked="checked" class="checkbox chk-item" value="<?php echo ($val["item_id"]); ?>">
                                                   <input type="hidden" value="<?php echo ($val["goumai"]); ?>" class="jiesuansl">                       
                                                   <label></label>
                                               </div>
                                           </div>
                                           <div class="td td-item">
                                               <div class="item-pic">
                                                   <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank" data-val="<?php echo ($val["yanse"]); ?>">
                                                       <img src="<?php echo ($val["img_url"]); ?>">
                                                   </a>
                  
                                               </div>
                                               <div class="item-info">
                                                   <a class="item-title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                               </div>
                                               <div class="item-service">
                                                   <span class="service-icon service-zheng"></span>
                                               </div>
                                               <div class="item-remark"></div>
                                           </div>
                                           <div class="td td-specs">
                                               <div class="specs-line" style="display: block">
                                                   <p>颜色:&nbsp;&nbsp;<?php echo ($val["yanse"]); ?></p>
                                                   <input type="hidden" value="<?php echo ($val["yanse"]); ?>" class="yz_ys">
                                                   <input type="hidden" value="<?php echo ($val["item_id"]); ?>" class="yz_id">
                                               </div>
                                               <div class="ys" style="position: absolute; width: 240px;left:-80px;display: none">
                                                   <center><?php echo ($val["unit_id"]); ?></center>
                                               </div>
                                           </div>
                                           <div class="td td-price">
                                               <div class="price-line">
                                                   <span class="price-now sn-price">
                                                       <i><?php if($val["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i>
                                                       <em><?php if($val["eMoney"] > 0): echo ($val["eMoney"]); else: echo ($val["sMoney"]); endif; ?></em>
                                                   </span>
                                               </div>
                                           </div>
                                           <div class="td td-amount">
                                               <div class="item-amount">
                                                   <a class="minus no-minus"></a>
                                                   <input type="text" class="ui-text text-amount" autocomplete="off" data-max="99" value="<?php echo ($val["goumai"]); ?>"  maxlength="2" style="color:rgb(102,102,102)" name="gmsl[]" data-id='<?php echo ($val["item_id"]); ?>'>
                                                   <a class="plus"></a>
                                                   <input type="checkbox" name="dx[]" style="display: none" checked="checked" data-jia="">
                                                   <input type="hidden" value="<?php echo ($val["number"]); ?>" class="kc">
                                                   <?php if($val["eMoney"] > 0): ?><input type="hidden" value="<?php echo ($val["eMoney"]); ?>" class="jg"><?php else: ?><input type="hidden" value="<?php echo ($val["sMoney"]); ?>" class="jg"><?php endif; ?>
                                                   
                                                   <input type="hidden" class="danjia">
                                               </div>
                                               <div class="amount-msg"></div>
                                           </div>
                                           <div class="td td-sum">
                                               <b class="sn-price price-color">
                                                   <input type="hidden" value="<?php echo ($val["goumai"]); ?>" class="gwsl">
                                                   <?php if($val["eMoney"] > 0): ?><input type="hidden" value="<?php echo ($val["eMoney"]); ?>" class="cpjg"><?php else: ?><input type="hidden" value="<?php echo ($val["sMoney"]); ?>" class="cpjg"><?php endif; ?>
                                                   
                                                   <i><?php if($val["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i>
                                                   <em><?php if($val["eMoney"] > 0): echo ($val[eMoney]*$val[goumai]); else: echo ($val[sMoney]*$val[goumai]); endif; ?></em>.00
                                               </b>
                                           </div>
                                           <div class="td td-op">
                                               <a class="add-fav tip-common-click-fn-btn shoucang"  data-id="<?php echo ($val["item_id"]); ?>">移入收藏</a>
                                               <input type="hidden" value="<?php echo ($val["item_id"]); ?>">
                                               <a class="del tip-common-click-fn-btn delbtn" data-id="<?php echo ($val["item_id"]); ?>">删除</a>
                                               <p class="tip-look-alike">查找相似<i class="alike-arr"></i></p>
                                               <input type="hidden" class="leibie" value="<?php echo ($val["bar_code"]); ?>">
                                               <div class="hide"></div>
                                           </div>
                                       </div>
                                   </div><?php endforeach; endif; else: echo "" ;endif; ?>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="cart-toolbar-box">
                       <div class="cart-toolbar rel clearfix" id="jiesuanbox">
                           <div class="toolbar-box">
                               <i class="had-buy-arr"></i>
                               <div class="l-column l form rel">
                                   <div class="cart-checkbox cart-checkbox-checked" id="qx">
<!--                                       <input type="checkbox" class="J-AllCheckBox">
                                       <label class="mr10 clearfix">
                                           <i class="icon l"></i>
                                           <span class="l">全选</span>
                                       </label>-->
                                   </div>
                                   <!--<a class="del-selected ml20 tip-common-click-fn-btn" id="quandel">删除选中商品</a>-->
                                   <div class="ui-tooltip ui-tooltip-top" style="top: -18px; left: 44px;opacity: 0;display: none" id="wqz">
                                       <div class="ui-tooltip-arrow">
                                           <i class="ui-tooltip-arrow-front">◆</i>
                                           <i class="ui-tooltip-arrow-back">◆</i>
                                       </div>
                                       <div class="ui-tooltip-inner">
                                           <p style="width: 160px;padding: 6px 8px;line-height: 15px;">
                                               <i class="tip-icon tip-warning mr5" style="vertical-align:middle;"></i>
                                               您还未选中要删除的商品
                                           </p>
                                       </div>
                                   </div>
                                   <div class="ui-tooltip ui-tooltip-top" style="top: -54px; left: 46px; display: none" id="scts">
                                       <div class="ui-tooltip-arrow">
                                           <i class="ui-tooltip-arrow-front">◆</i>
                                           <i class="ui-tooltip-arrow-back">◆</i>
                                       </div>
                                       <div class="ui-tooltip-inner">
                                           <div style="padding: 12px 8px 4px;width:156px;">
                                               <i class="tip-icon tip-warning mr5" style="vertical-align:middle;"></i>
                                               <span>确定要删除选中商品吗？</span>
                                           </div>
                                           <div style="text-align:center;padding:5px 0;">
                                               <a class="cart-btn-ok cart-btn mr10" id="delqd">确定</a>
                                               <a class="cart-btn-cancel">取消</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="r-column r  clearfix">
                                   <div class="cart-collect fl">
                                       <div class="cart-total-price">
                                           <span>总价（含运费）：</span>
                                           <b class="sn-price price-color" id="cpzj">
                                               <i>¥</i><em></em>.00
                                           </b>
                                       </div>
                                       <div class="save-ship">
                                           <p class="cart-sub-total fl mr20">
                                               为您节省：<span class="sn-price"><i>¥</i><em>0.00</em></span>
                                           </p>
                                           <p class="cart-sub-total fl">
                                               运费（以结算页为准）：<span class="sn-price"><i>¥</i><em>0.00</em></span>
                                           </p>
                                       </div>
                                   </div>
                                   <div class="cart-checkout l">
                                       <a class="checkout cart-btn" id="jiesuan">
                                           <b></b>
                                           去结算
                                       </a>
                                   </div>
                                   <script>
                                       $(function(){
                                          var ck = $(".ck");
                                          for(var i=0;i<ck.length;i++){
                                              if(ck.eq(i).attr("data-val")=="0"){
                                                    $(".specs-line").eq(i).hide();
                                                    $(".ys").eq(i).show();
                                                    $("input[name='yanse[]']").eq(i).removeAttr("checked");
                                                    $("input[name='duoxuan[]']").eq(i).removeAttr("checked");
                                                    $("input[name='dx[]']").eq(i).removeAttr("checked");
                                                    $(".ck > label").eq(i).attr("class","beijingyin");
                                                    $(".ck > label").eq(i).append("<i class='tubiao'></i>");
                                              }
                                          }
                                          $("#jiesuan").click(function(){
                $.ajax({
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/loginajax",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
//                        alert(data);
                        if(data == 1){
                             $("#shop_login").fadeIn(1000);
                        }else if(data == 2){
                            document.location.href="dingdan";
                      
                            
                        }
                    }
                })
                                          })
                                      })
                                   </script>
                               </div>
                               <div class="alchose rel">
<!--                                   <a class="now-select-goods">
                                       已选商品 <b class="c-f70 ff-tahoma price-color" id="yixuan"></b>件
                                   </a>-->
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="cart-recommend wrapper cart-recommend-auto">
                   <div class="recommend-header-box">
                        <ul class="recommend-header clearfix" id="biaoti">
                            <li class="recommend-name-box active">
                                <span class="recommend-name">猜你喜欢</span>
                            </li>
                            <li class="recommend-name-box">
                                <span class="recommend-name">我的收藏</span>
                            </li>
                        </ul>
                        <span class="slide-line"></span>
                    </div>
                   <div class="recommend-body recommend-body-rd">
<!--                       <div class="page-list sc" id="lunbo">
                           <ul>
                               <li class="current"></li>
                               <li></li>
                               <li></li>
                               <li></li>
                           </ul>
                       </div>-->
                       <ul class="recommend-box recommend-box-auto clearfix active" id="cnxh">
                           <?php if(is_array($lunbo)): $i = 0; $__LIST__ = $lunbo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="product-box">
                               <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                   <img class="product-img lazy-loading" src="<?php echo ($val["img_url"]); ?>">
                               </a>
                               <p class="product-name">
                                   <a class="product-content" href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                       <?php echo ($val["item_name"]); ?>
                                       <b></b>
                                   </a>
                               </p>
                               <p class="product-price sn-price clearfix">
                                   <i class="price-icon l"><?php if($val["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i>
                                   <em class="price-big l"><?php if($val["eMoney"] > 0): echo ($val["eMoney"]); else: echo ($val["sMoney"]); endif; ?></em>
                                   <em class="price-small l"></em>
                               </p>
                               <em class="add-cart" data-val="<?php echo ($val["item_id"]); ?>"></em>
                           </li><?php endforeach; endif; else: echo "" ;endif; ?>
                       </ul>
                       <ul class="recommend-box clearfix" id="scb">
                           <?php if(is_array($shoucang)): $i = 0; $__LIST__ = $shoucang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?><li class="product-box sc">
                               <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vvv["item_id"]); ?>" target="_blank">
                                   <img class="product-img lazy-loading" src="<?php echo ($vvv["img_url"]); ?>">
                               </a>
                               <p class="product-name">
                                   <a class="product-content" href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vvv["item_id"]); ?>" target="_blank"><?php echo ($vvv["item_name"]); ?></a>
                               </p>
                               <p class="product-price sn-price clearfix">
                                   <i class="price-icon l"><?php if($vvv["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i>
                                   <em class="price-big l"><?php if($vvv["eMoney"] > 0): echo ($vvv["eMoney"]); else: echo ($vvv["sMoney"]); endif; ?></em>
                                   <em class="price-small l"></em>
                               </p>
                               <em class="add-cart" data-val="<?php echo ($vvv["item_id"]); ?>"></em>
                           </li><?php endforeach; endif; else: echo "" ;endif; ?>
                       </ul>
                       <ul class="recommend-box clearfix"></ul>
                       <a class="tj-arr tj-arr-prev" style="display: inline;">
                           <i class="arr"></i>
                       </a>
                       <a class="tj-arr tj-arr-next" style="display: inline;">
                           <i class="arr"></i>
                       </a>
                   </div>
               </div>
           </div>
           <!--查找相似-->
           <div class="ui-tooltip ui-tooltip-bottom alike-prolist-tip" style="display: none;">
               <div class="ui-tooltip-close">×</div>
               <div class="ui-tooltip-arrow">
                   <i class="ui-tooltip-arrow-front">◆</i>
                   <i class="ui-tooltip-arrow-back">◆</i>
               </div>
               <div class="ui-tooltip-inner" style="width: auto;">
                   <div class="alike-container">
                       <div class="alike-prolist J-alike-pro">
                           <a class="prev" style="display: inline;"></a>
                           <a class="next" style="display: inline;"></a>
                           <div class="list-container">
                               <ul class="list-box">
                               </ul>
                           </div>
                           <div class="page-list">
                               <ul>
                                   <li class="current"></li>
                                   <li></li>
                                   <li></li>
                                   <li></li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!--快速登录-->
        <div class="denglutishi">
            <img src="/3.2.0/Public/shopping/image/shizi.png" id="shizi">
            <div class="denglutishi_top">
                <div class="denglutishi_top_left">
                    <span class="denglu_tishi">欢迎您登录会员</span>
                </div>
                <div class="denglutishi_top_right">
                    <span class="denglutishi_cha">×</span>
                </div>
            </div>
            <div class="denglutishi_bot">
                <div class="denglutishi_bot_top">
                    <div class="denglutishi_bot_top_left"></div>
                    <div class="denglutishi_bot_top_mid">
                        <div class="denglutishi_bot_top_mid_top"></div>
                        <div class="denglutishi_bot_top_mid_bot">
                            <div class="denglutishi_bot_top_mid_left"></div>
                            <div class="denglutishi_bot_top_mid_login">
                                <span class="tishi_denglu">登&nbsp;录</span>
                            </div>
                            <div class="denglutishi_bot_top_mid_ge"></div>
                            <div class="denglutishi_bot_top_mid_zhuce">
                                <span class="tishi_denglu">注&nbsp;册</span>
                            </div>
                            <div class="denglutishi_bot_top_mid_right"></div>
                        </div>
                    </div>
                    <div class="denglutishi_bot_top_right"></div>
                </div>
                <div class="denglutishi_bot_bot">
                    <center>
                        <br><br>
                        <span class="user_tishi"></span>
                        <input name="username" type="text" class="dengluti_user" placeholder="请输入您的用户名" id="username" autofocus="autofocus"><br><br>
                    <input name="password" type="password" class="dengluti_pass" placeholder="请输入您的密码" id="password"><br><span class="dengluti_tishi" id="dengluti_tishi">账号或密码输入错误!</span><br>
                    <input type="button" name="login_sub" class="dengluti_login" value="登&nbsp;录" onclick="login('<?php echo ($val["id"]); ?>')"><br><br><br>
                    <a href="#" class="pass_zhaohui">忘记密码?</a>
                    <script>
//                        function login(id){
//                            var user = document.getElementById("username").value;
//                            var pass = document.getElementById('password').value;
//                            var id = id;
//                            var ajax = req();
//                                ajax.open("post","/3.2.0/index.php/Home/Index/chanpin_login",true);
//                                ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
//                                ajax.send("user=" + user + "&pass=" + pass);
//                                ajax.onreadystatechange=function(){
//                                    if(ajax.readyState==4 && ajax.status == 200){
//                                        var data = ajax.responseText;
//                                        if(data == 123){
//                                            var frm = document.getElementById('form');
//                                                frm.action='/3.2.0/index.php/Home/Index/chanpin_login_dl2/id/'+id;
//                                                frm.submit();
//                                        }else{
//                                            document.getElementById('dengluti_tishi').style.display='block';
//                                        }
//                                    }
//                                }
//                        }
                    </script>
                    </center>
                </div>
                <div class="denglutishi_bot_bot_two">
                    <center>
                        <br><br>
                         <span class="user_tishi"></span>
                            <input name="zhuce_username" type="text" class="dengluti_user" placeholder="请设置您的用户名" id="zhuce_username"  autofocus="autofocus"><br><br>
                            <img class='ks_tu1'><span class='ks_tishi'></span><br><br>
                            <input name="zhuce_password" type="password" class="dengluti_pass" placeholder="请设置您的密码" id="zhuce_password"><br><br>
                            <img class='ks_tu2'><span class='ks_tishi2'></span><br><br>
                            <input type="button" name="zhuce_sub" class="dengluti_login" value="同意协议并注册" onclick="zhuce('<?php echo ($val["id"]); ?>')" id="zhuceval"><br><br><br>
                    </center>
                </div>
            </div>
        </div>
        <script>
                        function req(){
                                if(window.XMLHttpRequest){
                                    var request = new XMLHttpRequest();
                                } else {
                                    var request = new ActiveXObject('Microsoft.XMLHTTP');
                                }
                                return request;
                        }
                            var user_yz = 2;
                            var pass_yz = 2;
                            $(document).ready(function(e){
                                    $("#zhuce_username").blur(function(){
                                        var userval = $("#zhuce_username").val();
                                        userval = $.trim(userval);
                                        $.ajax({
                                            type:"post",
                                            url:"/3.2.0/index.php/Home/Index/regAjax",
                                            dataType: "text",
                                            data:"userval="+ userval,
                                            success:
                                            function(data){
                                                if(userval == ""){
                                                    $(".ks_tishi").text("用户名不能为空!");
                                                    $(".ks_tu1").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                                }else if(data == 123){
                                                    $(".ks_tishi").text("用户名已存在");
                                                    $(".ks_tu1").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                                }else if(/^([\u4e00-\u9fa5])*$/.test(userval)){
                                                    $(".ks_tishi").text("用户名不能为中文!");
                                                    $(".ks_tu1").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                                }else if(userval.length < 6||userval.length >12){
                                                    $(".ks_tishi").text("用户名长度不符合!请输入6-12位英文数字组合");
                                                    $(".ks_tu1").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                                }else{
                                                    $(".ks_tu1").attr("src","/3.2.0/Public/shopping/image/dui.png");
                                                    $(".ks_tishi").text("");
                                                    user_yz = 1;
                                                }
                                            }
                                        })
                                    });
                                    $("#zhuce_password").blur(function(){
                                        var passval = $("#zhuce_password").val();
                                        passval = $.trim(passval);
                                        if(passval==""){
                                            $(".ks_tishi2").text("密码不能为空!");
                                            $(".ks_tu2").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                        }else if(!/^([a-z]|[A-Z]|[0-9])*$/.test(passval)){
                                            $(".ks_tishi2").text("密码不能为特殊符号");
                                            $(".ks_tu12").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                        }else if(passval.length < 6||passval.length >12){
                                            $(".ks_tishi2").text("密码长度符合!请输入6-12位英文数字组合");
                                            $(".ks_tu2").attr("src","/3.2.0/Public/shopping/image/cuo.png");
                                        }else{
                                            $(".ks_tu2").attr("src","/3.2.0/Public/shopping/image/dui.png");
                                            $(".ks_tishi2").text("");
                                            pass_yz = 1;
                                        }
                                    }) 
                            })
                            function zhuce(id){
                                if(user_yz == 1&&pass_yz == 1){
                                    var id = id;
                                    var frm = document.getElementById('form');
                                        frm.action='/3.2.0/index.php/Home/Index/zhuce_chanpin2/id/'+id;
                                        frm.submit();
                                }
                            }
                            $(document).ready(function(e){
                                $(".denglutishi_cha").click(function(){
                                    $(".denglutishi").fadeOut("slow");
                                    $("#modalOverlay").fadeOut("slow");
                                })
                                $(".denglutishi_bot_top_mid_login").click(function(){
                                    $(".denglutishi_bot_bot").show();
                                    $(".denglutishi_bot_bot_two").hide();
                                     $(".denglutishi_bot_top_mid_login").css("color","rgb(255,153,0)");
                                    $(".denglutishi_bot_top_mid_login").css("border-top-color","rgb(255,153,0)");
                                    $(".denglutishi_bot_top_mid_login").css("font-weight","800");
                                    $(".denglutishi_bot_top_mid_login").css("border-bottom","0px");
                                    $(".denglutishi_bot_top_mid_zhuce").css("color","#000");
                                    $(".denglutishi_bot_top_mid_zhuce").css("border-top-color","#ccc");
                                    $(".denglutishi_bot_top_mid_zhuce").css("font-weight","400");
                                    $(".denglutishi_bot_top_mid_zhuce").css("border-bottom","1px solid #ccc");
                                })
                                $(".denglutishi_bot_top_mid_zhuce").click(function(){
                                    $("input[name='zhuce_username']").focus(); 
                                    $(".denglutishi_bot_bot").hide();
                                    $(".denglutishi_bot_bot_two").show();
                                    $(".denglutishi_bot_top_mid_zhuce").css("color","rgb(255,153,0)");
                                    $(".denglutishi_bot_top_mid_zhuce").css("border-top-color","rgb(255,153,0)");
                                    $(".denglutishi_bot_top_mid_zhuce").css("font-weight","800");
                                    $(".denglutishi_bot_top_mid_zhuce").css("border-bottom","0px");
                                    $(".denglutishi_bot_top_mid_login").css("color","#000");
                                    $(".denglutishi_bot_top_mid_login").css("border-top-color","#ccc");
                                    $(".denglutishi_bot_top_mid_login").css("font-weight","400");
                                    $(".denglutishi_bot_top_mid_login").css("border-bottom","1px solid #ccc");
                                })
                            })
        </script>
        <!--隔离层-->
        <div id="modalOverlay" style="opacity: 0.3; position:fixed; border: 0px none; width: 100%; height: 100%; top: 0px; left: 0px; z-index: 1000097; background: none 0px 0px repeat scroll rgb(0, 0, 0); display: none;"></div>
        </form>
        <script>
            function winshow(){
                    openWin = window.open('/3.2.0/index.php/Home/Index/show_two','_blank','width=550,height=530,left=800,top=400,location=yes,menubar=1,status=1');
            }     
            $(document).ready(function(e){
                $('html').bind("selectstart", function () { return false; });
                $("#modalOverlay").height($(document).height());
//                var sc = $(".shoucang");
//                for(var i=0;i<sc.length;i++){
//                    if(sc.eq(i).attr("data-val")==""){
//                        $(".specs-line").eq(i).hide();
//                        $(".ys").eq(i).show();
//                        $("input[name='yanse[]']").eq(i).removeAttr("checked");
//                        $("input[name='duoxuan[]']").eq(i).removeAttr("checked");
//                        $("input[name='dx[]']").eq(i).removeAttr("checked");
//                        $(".ck > label").eq(i).attr("class","beijingyin");
//                        $(".ck > label").eq(i).append("<i class='tubiao'></i>");
//                    }else{
//                        
//                    }
//                }
//                var nu = $("input[name='gmsl[]']");
//                for(var i=0;i<nu.length;i++){
//                    if(nu.eq(i).val()*1==0){
//                        $(".item-amount").eq(i).text("库存不足!");
//                        $(".item-amount").eq(i).css("color","red");
//                        $(".ck").eq(i).empty();
//                    }
//                }
                var div = $(".item-checked");
                if(div.length>=7){
                   $("#jiesuanbox").attr("class","cart-toolbar rel clearfix cart-toolbar-fix"); 
                }
                var divH = 30*div.length;
                $(document).scroll(function(){
                    if(div.length>=7){
                        if($(document).scrollTop()>=divH){
                            $("#jiesuanbox").attr("class","cart-toolbar rel clearfix");
                        }else if($(document).scrollTop()<divH){
                            $("#jiesuanbox").attr("class","cart-toolbar rel clearfix cart-toolbar-fix"); 
                        }
                    }
                })
                var gmsl = $(".text-amount");
                var sjsl = $("input[name='dx[]']");
                for(var i=0;i<gmsl.length;i++){
                    sjsl.eq(i).val(gmsl.eq(i).val());
                }
                $(".add-cart").live("click",function(){
                    var id = $(this).attr("data-val");
                    $(this).parent().append("<div class='add-num' style='left:141px;display:block;top:220px;opacity:1'></div>");
                    $(this).siblings(".add-num").animate({
                        top:'185px',opacity:'0',
                    },"slow",function(){
                        $(this).parent().children(".add-num").remove();
                    })
                        $.ajax({
                            type:"post",
                            url:"/3.2.0/index.php/Home/Index/gonggong",
                            dataType: "text",
                            data:"id="+ id,
                            success:
                            function(data){
                                if(data!=""){
                                    alert("添加购物车成功!");
                                    window.location.href='/3.2.0/index.php/Home/Index/gouwuchejs';
                                }else{
                                    alert("添加失败!购物车已存在此商品!");
                                }  
                            }
                        })
                });
                $(".tip-look-alike").click(function(){
                    var value = $(this).siblings(".leibie").val();
                    var top = $(this).offset().top + 58;
                    var left = $(this).offset().left - 64.5;
                    $(".alike-prolist-tip").css({top:top,left:left});
                    $(".alike-prolist-tip").show("slow");
                    $.ajax({
                            type:"post",
                            url:"/3.2.0/index.php/Home/Index/xiangsi",
                            dataType: "text",
                            data:"value="+value,
                            success:
                            function(data){
                                eval("var obj="+data);
                                for(var i=0;i<obj.length;i++){
                                    if(obj[i].eMoney>0){
                                        num = obj[i].eMoney;
                                        bi = "电子币";
                                    }else{
                                        num = obj[i].sMoney;
                                        bi = "积分";
                                    }
                                   $(".list-box").append("<li class='list'>\n\
                                            <a target='_blank' href='/3.2.0/index.php/Home/Index/product_details/id/"+obj[i].item_id+"'>\n\
                                            <img class='product-img' src='"+obj[i].img_url+"'></a>\n\
                                            <p><a class='product-content' target='_blank' href='/3.2.0/index.php/Home/Index/product_details/id/"+obj[i].item_id+"'>"+obj[i].item_name+"</a></p>\n\
                                            <p class='product-price sn-price clearfix'>\n\
                                            <i class='price-icon l'>"+bi+"</i>\n\
                                            <em class='price-big l'>"+num+"</em><em class='price-small l'></em></p>\n\
                                            <em class='add-cart' data-val='"+obj[i].item_id+"'></em></li>") 
                                }
                            }
                    })
                })
                var zj = $(".danjia");
                var zjnum = 0;
                for(var i=0;i<zj.length;i++){
                    zjnum+=zj.eq(i).val()*1;
                }
                var sl  = $(".text-amount");
                var jg = $(".cpjg");
                var xszj = 0;
                var cpsl = 0;
                var yss = 0;
                var dx = $("input[name='duoxuan[]']");
                for(var i=0;i<dx.length;i++){
                    if(dx.eq(i).is(':checked')){
                        yss = 1;
                    }else{
                        yss = 0; 
                    }
                }
                if(yss==1){
                    $("#jiesuan").attr("class","checkout cart-btn");
                }else{
                    $("#jiesuan").attr("class","checkout cart-btn checkout-disable-tip");
                }
                for(var i=0;i<sl.length;i++){
                    $("input[name='dx[]']").eq(i).attr("data-jia",(sl.eq(i).val()*1*jg.eq(i).val()*1));
                    if(dx.eq(i).is(':checked')){
                        xszj+=sl.eq(i).val()*1*jg.eq(i).val()*1;
                        cpsl+=sl.eq(i).val()*1;
                    }
                }
                $("#yixuan").text(cpsl);
                $("#cpzj > em").text(xszj);
                $.ajax({
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/loginpd",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
                        var  ge = $(".item-checked").length;
                        if(data ==123){
                            if(ge>0){
                                $("#yousp").show();
                                $("#tishitiao").hide();
                            }else{
                                $("#yidenglu").show();
                                $("#tishitiao").hide();
                            }
                        }else{
                            if(ge>0){
                                $("#yousp").show();
                                $("#tishitiao").show();
                            }else{
                                $("#weidenglu").show();
                                $("#tishitiao").show();
                            }
                        }  
                    }
                })
//                $.ajax({
//                    type:"post",
//                    url:"/3.2.0/index.php/Home/Index/gouwuchesl",
//                    dataType: "text",
//                    data:null,
//                    success:
//                    function(data){
//                        $(".J_cart_total_num").text(data);
//                        if(data > 0){
//                            $("#myCart_wu").hide();
//                            $("#myCart").show();
//                        }else{
//                            $("#myCart_wu").show();
//                            $("#myCart").hide();
//                        }
//                    }
//                })
//                $.ajax({
//                    type:"post",
//                    url:"/3.2.0/index.php/Home/Index/cook",
//                    dataType: "text",
//                    data:null,
//                    success:
//                    function(data){
//                      eval("var obj="+data);
//                        if(data!=""){
//                            $("#username-node-slide").show();
//                            $("#username-node").hide();
//                            $("#usernameHtml02").text(obj.username);
//                            if(obj.touxiang=="null"){
//                                $(".headimg > img").attr("src","/3.2.0/Public/shopping/images/0000000000_01_60x60.jpg");
//                                $("#zujing_img").attr("src","/3.2.0/Public/shopping/images/0000000000_01_60x60.jpg");
//                            }else{
//                                $(".headimg > img").attr("src","/ShoppingSite/"+obj.touxiang);
//                                $("#zujing_img").attr("src","/ShoppingSite/"+obj.touxiang);
//                            }
//                            $(".mysuning-detail > .login").hide();
//                            $(".mysuning-detail > .username").css("display","block");
//                            $(".mysuning-detail > .username").text(obj.username);
//                            $(".pls-login").hide();
//                            $("#zujing").show();
//                            $("#zujing > a").eq(0).text(obj.username);
//                            $(".desc").empty().append("按下键盘上的<i>G</i>即可快速打开/关闭购物车功能");
//                            if(obj.quanxian=="超级管理员"||obj.quanxian=="管理员"){
//                                $("#hguanli").show();
//                            }else{
//                                $("#hguanli").hide();
//                            }
//                        }
//                    }
//                })
                var num = 0;
                $(document).keydown(function(event){
                    if(event.keyCode == 71){ 
                        if(num %2==0){
                            $(".sn-sidebar-contents").attr("class","sn-sidebar-contents sn-sidebar-contents-show");
                            $(".sn-sidebar-contents").animate({right : '35px'},"slow"); 
                            $(".sn-sidebar-cart").show();
                        }else{
                            $(".sn-sidebar-contents").attr("class","sn-sidebar-contents");
                            $(".sn-sidebar-contents").animate({right : '-400px'},"slow"); 
                            $(".sn-sidebar-cart").hide();
                        }
                    }
                    num++;
                }); 
                $("#delqd").click(function(){
                    var frm = document.getElementById('form');
                        frm.action='/3.2.0/index.php/Home/Index/jsgou_del';
                        frm.submit();
                })
                $(".delbtn").click(function(){
                    var id = $(this).attr("data-id");
                    $.post("/3.2.0/index.php/Home/Index/gddsc",{id:id},function(res){
                        if(res==1){
                            alert("删除成功!");
                            window.location.href='/3.2.0/index.php/Home/Index/gouwuchejs';
                        }else{
                            alert("系统忙,请稍后再试!");
                        }
                    },"text")
                })
                $(".shoucang").click(function(){
                    var id = $(this).attr("data-id");
                    $.post("/3.2.0/index.php/Home/Index/yrsc",{id:id},function(res){
                        if(res==1){
                            alert("此商品已经收藏过了!");
                        }else if(res==2){
                            alert("收藏成功!");
                            window.location.href='/3.2.0/index.php/Home/Index/gouwuchejs';
                        }else{
                            alert("收藏失败!");
                        }
                    },"text")
                })
            })
        </script>
    </body>
</html>