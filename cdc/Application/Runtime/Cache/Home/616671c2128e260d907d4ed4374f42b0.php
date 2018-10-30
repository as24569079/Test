<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>天津诚兑城电子商务控股有限公司</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/index.css">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/index.js"></script>
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
        <style>
            .entrances li a :hover{
                color:red;
            }
        </style>
    </head>
    <body class="root1200">
        <!--登录条-->
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
                        <!--<i class="ng-iconfont ng-backhome"></i>-->
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
        <div class="ng-header">
            <div class="code-maintain">
                <div class="code-maintain-bg" style="background: #fff"></div>
            </div>
            <div class="ng-header-con">
                <div class="ng-header-box">
                    <a class="logo-set"  href="/3.2.0/index.php/Home/Index/index">
                        <img src="/3.2.0/Public/images/chengcuicheng.png" width="248" height="74" style="width:248px;height:74px;margin-top:10px">
                    </a>
<!--                    <a class="ng-gif-logo">
                        <img src="/3.2.0/Public/shopping/image/giflogo.gif">
                    </a>-->
                </div>
                <div class="ng-search">
                    <div class="g-search">
                        <i class="ng-iconfont search-icon"></i>
                            <div class="search-keyword-box" style="border-color:#db0638">
                                <input type="text" class="search-keyword" placeholder="请输入查询商品信息" id='sea' autocomplete="off">
                            </div>
                        <form id="form" method="post">
                            <a id="bnt_tiao"><input type="button" class="search-btn" value="搜索" style="background:#db0638;color:#fff"></a>
                            <input type="hidden" id="ssz">
                            <div id="snKeywordNew" class="g-search-hotwords" style='color:#000'>
                                <?php if(is_array($category_tj)): $i = 0; $__LIST__ = $category_tj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a  target="_blank" href="/3.2.0/index.php/Home/Index/business_shop?category_id=<?php echo ($val["category_id"]); ?>&id=" style='color:#999'><?php echo ($val["category_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </form>
                        <div class="g-ac-results hide" id="sea_jilu" style="height:270px;overflow: hidden">
                            <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        <script>
                            $(document).ready(function(event){
                             $("#bnt_tiao").click(function(){
                                    var value = $.trim($("#ssz").val());
//                                    var qb = "所有商品";
                                    if(value != ""){
                                        $("#bnt_tiao").attr("href","/3.2.0/index.php/Home/Index/business_shop/mc/"+value);
                                    }
                                })
                                var last;
                                var i = 0;
                                $("#sea").keyup(function(event){
                                    last = event.timeStamp;
                                    var value = $.trim($("#sea").val());
                                    $("#ssz").val(value);
//                                    setTimeout(function(){ 
                                        if(last-event.timeStamp==0)
                                        {
                                          if(event.which!=40&&event.which!=8&&event.which!=32&&event.which!=38&&event.which!=39&&event.which!=37&&event.which!=13){  
                                            $("#sea_jilu").show();
                                            $.ajax({
                                                type:"post",
                                                url:"/3.2.0/index.php/Home/Index/seaajax",
                                                dataType: "text",
                                                data:"value="+ value,
                                                success:
                                                function(data){
//                                                    alert(data);
                                                    eval("var obj="+data);
                                                    if(obj.length>0){
                                                        for(var i=0;i<obj.length;i++){
                                                            $("#sea_jilu > ul > li").eq(i).text(obj[i].item_name).attr("data-val",obj[i].item_name);
                                                        }
                                                    }
                                                }
                                            })
                                        }
                                    }
//                                        },1000);
                                    if(event.which==8){
                                           $("#sea_jilu > ul > li").empty().removeAttr("data-val");
                                           $("#ssz").val("");
                                           $(".sea_jilu").hide();
                                    } 
                                    if(event.which==40){
                                        var length = $("#sea_jilu > ul > li").length;
                                        if(i<length){
                                            $("#sea_jilu > ul > li").eq(i).attr("class","xuanzeyan").siblings().removeAttr("class");
                                        }
                                        i++;
                                        if(i == length){
                                            i=0;
                                        }
                                    }
                                    if(event.which==38){
                                        var length = $("#sea_jilu > ul > li").length;
                                        i--;
                                        if(i<length){
                                            $("#sea_jilu > ul > li").eq(i).attr("class","xuanzeyan").siblings().removeAttr("class");
                                        }
                                        if(i == 0){
                                            i = length;
                                        }
                                    }
                                    if(event.which==13){
                                        $("#sea").val($(".xuanzeyan").text());
                                        $("#sea_jilu > ul > li").empty().removeAttr("data-val");
                                        $("#sea_jilu").hide();
                                        i=0;
                                    }
                                })
                                $("#sea_jilu > ul > li").mouseover(function(){
                                    $(this).attr("class","xuanzeyan").siblings().removeAttr("class");
                                }).click(function(){
                                    var val = $(this).attr("data-val");
                                    $("#sea").val(val);
                                    $("#ssz").val(val);
                                    $("#sea_jilu > ul > li").empty().removeAttr("data-val");
                                    $("#sea_jilu").hide();
                                })
                                $("#sea_jilu").mouseleave(function(){
                                    $("#sea_jilu > ul > li").empty().removeAttr("data-val");
                                    $("#sea_jilu").hide();
                                })
                            })
                        </script>
                        <div class="g-rec-results hide"></div>
                    </div>
                </div>
                <div style="float:right;margin-top: 5px;">
                        <img src="/Public/images/erwei.jpg" width="100" height="100">
                    </div>
                <div class="index-head-active"></div>
            </div>
        </div>
        <!--导航-->
        <div class="ng-nav-bar">
            <div class="ng-sort ng-sort-index">
                <a class="ng-all-hook">
                    <span>全部商品分类</span>
                    <span class="angle"></span>
                </a>
                <div class="ng-sort-list-box">
                    <ul class="sort-list" >
                        <?php if(is_array($ren)): $i = 0; $__LIST__ = $ren;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vel): $mod = ($i % 2 );++$i;?><li>
                            <?php if(is_array($vel["parent"])): $i = 0; $__LIST__ = $vel["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><a href="/3.2.0/index.php/Home/Index/business_shop?category_id=<?php echo ($va["category_id"]); ?>&id=<?php echo ($getid); ?>"><?php echo ($va["category_name"]); ?></a>
                                        <!--<span></span>--><?php endforeach; endif; else: echo "" ;endif; ?>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        <div class="clear"></div>
                    </ul>
                    <div class="ng-sort-detail">
                        <div class="sort-btn">
                            <a></a>
                            <a></a>
                            <a></a>
                            <a></a>
                            <a></a>
                            <a></a>
                            <a></a>
                        </div>
                        <div class="cate-list">
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <a></a>
                                </dt>
                                <dd>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                    <a></a>
                                </dd>
                            </dl>
                        </div>
                        <div class="actShow">
                            <div class="brandList">
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                            </div>
                            <div class="actList">
                                <a>
                                    <img>
                                </a>
                                <a>
                                    <img>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ng-nav-index">
                <h4 class="ng-title">
                    <span></span>
                </h4>
                <ul class="ng-nav">
<!--                    <li>
                        <a href="/3.2.0/index.php/Home/Index/shop_index">返回首页</a>
                    </li>-->
                    <li>
                        <a href="/3.2.0/index.php/Home/Index/business_shop/id/2">购物商城</a>
                    </li>
                    <li>
                        <a href="/3.2.0/index.php/Home/Index/business_shop/id/1">积分商城</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <!--轮播-->
        <div class="first-screen">
            <div class="banner-wrapper" style="overflow:hidden">
                <ul class="banner" style="overflow:hidden">
                    <?php if(is_array($banner)): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li style="display:block; background:#db0638;width:100%">
                        <a style='width:100%;left:0'>
                            <img src="<?php echo ($va["images_url"]); ?>" style="width:100%">
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <a class="angle-btn prev-btn">
                    <i></i>
                </a>
                <a class="angle-btn next-btn">
                    <i></i>
                </a>
                <div class="banner-nav-wrapper">
                    <div class="banner-nav">
                        <?php if(is_array($banner)): $k = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($k % 2 );++$k;?><a class="page-item"><?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
            <!--<script src="/3.2.0/Public/lunbo/js/jquery-1.8.3.min.js"></script>-->
            <script src="/3.2.0/Public/lunbo/js/slide_2.js"></script>
            <script>
                    $('.banner-wrapper').ckSlide({
                            autoPlay: true,//默认为不自动播放，需要时请以此设置
                            dir: 'x',//默认效果淡隐淡出，x为水平移动，y 为垂直滚动
                            interval:3000//默认间隔2000毫秒

                    });
            </script>
            <div class="show-case" style="height:455px;top:0px">
                <ul class="infor-nav-narrow">
                    <li class="left">
                        <a>公告</a>
                        <span class="border"></span>
                    </li>
                </ul>
                <div class="infor-content" style="height:440px">
                    <ul class="infor-nav">
                        <li class="left current">
                            <a>新闻公告</a> 
                            <span class="border"></span>
                        </li>
                        <li class="left current">
                            <a href="/3.2.0/index.php/Home/Index/xinwenzhongxin">更多</a> 
                            <span class="border"></span>
                        </li>
                    </ul>
                    <div class="infor-list">
                        <div class="infor-item item-tell" style="margin-bottom:59px">
                            <?php if(is_array($new)): $i = 0; $__LIST__ = $new;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><p class="red-show">
                                <a href="/3.2.0/index.php/Home/Index/xinwenzhongxin/id/<?php echo ($val["new_id"]); ?>" target="blank">
                                    <i>[公告]</i>
                                    <?php echo ($val["title"]); ?>
                                </a>
                            </p><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    <ul class="infor-nav">
                        <li class="left current">
                            <a>新品上市</a>
                            <span class="border"></span>
                        </li>
                    </ul>
<!--                 <div class="infor-item item-tell" style="margin-bottom:59px">-->
                          <img src="<?php echo ($images["images_url"]); ?>">
                        <!--</div>-->
<!--                    <div class="app-down">
                        <p class="title">APP</p>
                        <ul class="applist">
                            <li class="snyg">
                                <span>
                                    <i></i>
                                </span>
                            </li>
                            <li class="yfb">
                                <span>
                                    <i></i>
                                </span>
                            </li>
                            <li class="redbaby">
                                <span>
                                    <i></i>
                                </span>
                            </li>
                            <li class="snts">
                                <span>
                                    <i></i>
                                </span>
                            </li>
                        </ul>
                    </div>-->
                </div>
                <a class="show-btn">
                    <i></i>
                </a>
            </div>
        </div>
        <?php if(is_array($ren)): $k = 0; $__LIST__ = $ren;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vel): $mod = ($k % 2 );++$k;?><div class="wrapper floor floor1 g-floor lazy-floor J-floor1 dalei" id="tiao<?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?>">
            <div class="floor-head clearfix">
                <div class="title">
                    <h3>
                        <b>F<?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></b>
                        <?php echo ($vel["category_name"]); ?>
                    </h3>
                </div>
                <ul class="floor-tab" id="f1">
                    <?php if(is_array($vel["parent"])): $i = 0; $__LIST__ = $vel["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li>
                        <a class='xiaolei' data-id='<?php echo ($va["category_id"]); ?>'>
                            <em><?php echo ($va["category_name"]); ?></em>
                        </a>
                        <span class="up-arrow"></span>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="floor-main" id="f1-main">
                <div class="side" style="margin-top:6px">
                    <a class="side-img">
                        <img class="lazy-loading" src="<?php echo ($vel["category_url"]); ?>">
                    </a>
                    <ul class="entrances" style='width:389px'>
                        <?php if(is_array($vel["parent"])): $i = 0; $__LIST__ = $vel["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li>
                        <a  href="/3.2.0/index.php/Home/Index/business_shop?category_id=<?php echo ($va["category_id"]); ?>" class='xiaolei' data-id='<?php echo ($va["category_id"]); ?>'>
                            <em><?php echo ($va["category_name"]); ?></em>
                        </a>
            
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>   
                         <ul class="prd-list">
                        <li style="float:left">
                            <?php if($vel["item_name1"] != ''): ?><a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vel["item_tj1"]); ?>" target="_blank">
                                    <img src="<?php echo ($vel["img_url1"]); ?>" width="180" height="180">
                                </a>
                            <p class="name">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vel["item_tj1"]); ?>" target="_blank"><?php echo ($vel["item_name1"]); ?></a>
                            </p><!--
-->                            <p class="price" style="color:red">
                        <?php if($vel["mall_id1"] == 2): ?><i>电子币</i>
                                <span><?php echo ($vel["qian1"]); ?>/<?php echo ($vel["unit_name1"]); ?></span>
                                <?php else: ?>
                                 <i>积分</i>
                                <span><?php echo ($vel["qian11"]); ?>/<?php echo ($vel["unit_name1"]); ?></span><?php endif; ?>
                            </p><?php endif; ?>
                        </li>
                         <li style="float:right">
                             <?php if($vel["item_name2"] != ''): ?><a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vel["item_tj2"]); ?>" target="_blank">
                                    <img src="<?php echo ($vel["img_url2"]); ?>" width="180" height="180">
                                </a>
                            <p class="name">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($vel["item_tj2"]); ?>" target="_blank"><?php echo ($vel["item_name2"]); ?></a>
                            </p><!--
-->                            <p class="price" style="color:red">
                        <?php if($vel["mall_id2"] == 2): ?><i>电子币</i>
                                <span><?php echo ($vel["qian2"]); ?>/<?php echo ($vel["unit_name2"]); ?></span>
                                <?php else: ?>
                                 <i>积分</i>
                                <span><?php echo ($vel["qian22"]); ?>/<?php echo ($vel["unit_name2"]); ?></span><?php endif; ?>
                            </p><?php endif; ?>
                        </li>
                    </ul>
                   
                </div>
                <div class="main-cont g-tab-list fenleis" style="display: block" >

                </div>
                <div class="main-cont g-tab-list fenlei <?php echo ($k); ?>">   
                </div>
                <div class="main-cont g-tab-list">
                    <ul class="prd-list">
                        <?php if(is_array($chanpin2)): $i = 0; $__LIST__ = $chanpin2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
                            <p class="prd-img">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank">
                                    <img src="<?php echo ($val["lujing2"]); ?>">
                                </a>
                            </p>
                            <p class="name">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank"><?php echo ($val["mingcheng"]); ?></a>
                            </p>
                            <p class="price">
                                <i>¥</i>
                                <span><?php echo ($val["jiage"]); ?>.00</span>
                            </p>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="main-cont g-tab-list">
                    <ul class="prd-list">
                        <?php if(is_array($chanpin3)): $i = 0; $__LIST__ = $chanpin3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
                            <p class="prd-img">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank">
                                    <img src="<?php echo ($val["lujing2"]); ?>">
                                </a>
                            </p>
                            <p class="name">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank"><?php echo ($val["mingcheng"]); ?></a>
                            </p>
                            <p class="price">
                                <i>¥</i>
                                <span><?php echo ($val["jiage"]); ?>.00</span>
                            </p>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="main-cont g-tab-list">
                    <ul class="prd-list" >
                        <?php if(is_array($chanpin4)): $i = 0; $__LIST__ = $chanpin4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li >
                            <p class="prd-img">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank">
                                    <img src="<?php echo ($val["lujing2"]); ?>">
                                </a>
                            </p>
                            <p class="name">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["id"]); ?>" target="_blank"><?php echo ($val["mingcheng"]); ?></a>
                            </p>
                            <p class="price">
                                <i>¥</i>
                                <span><?php echo ($val["jiage"]); ?>.00</span>
                            </p>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="clear"></div>
        <!--版权区-->
        <div class="ng-footer" style="height:auto">
            <div class="ng-new-pro" style='height:80px'>
                <div class="ng-new-pro-con" style="width:1290px;over-flow:hidden">
                    <div class="ng-new-pro-list" style="width:850px;margin-left:50px">
                        <dl style="width:425px;border-right:0px;padding:0 ">
                            <dt>
                                <a>
                                    <img src="/3.2.0/Public/shopping/images/f1.png" style='width:40px;height:40px'>
                                </a>
                            </dt>
                            <dd>
                                <p class="ng-title">
                                    <a>咨询热线</a>
                                </p>
                                <p class="ng-intro">
                                    <a>022-88274018</a>
                                </p>
                            </dd>
                        </dl>
                        <dl style="width:425px;border-right:0px;padding:0">
                            <dt>
                                <a>
                                    <img src="/3.2.0/Public/shopping/images/f2.png" style='width:40px;height:40px'>
                                </a>
                            </dt>
                            <dd>
                                <p class="ng-title">
                                    <a>客服热线</a>
                                </p>
                                <p class="ng-intro">
                                    <a>4006-116-226</a>
                                </p>
                            </dd>
                        </dl>
                    </div>
                    <div class="ng-serch-suning" style="width:390px">
                        <dl>
                            <dt style='background:url(/3.2.0/Public/shopping/images/npbg.png) no-repeat;background-size:40px 40px;background-position-x: 20px'></dt>
                            <dd>
                                <p class="ng-title">地址</p>
                                <p class="ng-intro">
                             天津市河西区友谊路友谊大厦3楼
                                </p>
                            </dd>
                        </dl>
                    </div>
                    <div class="footer-egg-con"></div>
                </div>
                <div class="footer-egg-btn"></div>
            </div>
            <div class="ng-s-footer">
                <div class="ng-s-f-con" style="position: relative;width:1190px">
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
                    
                    <p class="ng-copyright">                        
                        <!--Copyright© 2002-2016 ，天津天软公司版权所有-->
                    </p>
                    <p class="ng-copyright ng-copyright-2">
                        备案号:<a href="http://www.miitbeian.gov.cn/" style="color:#fff">津ICP备16004932号-2</a>
                    </p>
                    <p></p>
                    <div class="ng-app-down" style="position: absolute;right:20px;bottom:20px">
                        <p>扫一扫</p>
                        <a>
                            <img width="87" height="87" src="/3.2.0/Public/images/erwei.jpg">
                        </a>
                    </div>
                </div>
            </div>
            <div class="ng-fix-bar"></div>
        </div>
        <div class="ECode-floatBar" style="position: fixed;top: 50%;left: 50%;z-index: 10000;right: auto;margin-left: -670px;margin-top: -187px;display: none;">
            <ul class="floor-guide" id="gundong">
                <?php if(is_array($ren)): $k = 0; $__LIST__ = $ren;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vel): $mod = ($k % 2 );++$k; if($vel["fenleis"] == 69310): else: ?>
                        <li data-id="tiao<?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?>">
                            <a class="name"><?php echo ($vel["category_name"]); ?></a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div id="fuzhi" style="display:none"></div>
<!--    </form>-->
        <script>
//            function winshow(){
////                    openWin = window.open('/3.2.0/index.php/Home/Index/show_two','_blank','width=550,height=530,left=800,top=400,location=yes,menubar=1,status=1');
//                      window.location.href='/3.2.0/index.php/Home/Index/liaotian_qian';
//            }
 

            $(document).ready(function(e){
                for(var a=0;a<$(".dalei").length;a++){
                    var m =0;
                    var name = $(".dalei").eq(a).children().find("a").attr("data-id"); 
                     var ths = $(".dalei").eq(a).children().find(".fenlei"); 
                     futu(name,ths);
                }
               
                $(".xiaolei").mouseover(function(){
                    var category_id = $(this).attr("data-id");
                    var th = $(this);
                    $.post("/3.2.0/index.php/Home/Index/seaxiaolei",{"category_id":category_id},function(data){
                        eval("var obj =" +data);
                        var html = '';
                            html += '<ul class="prd-list" >';
                          if(obj){
                          for(var i =0; i<obj.length;i++){
                                html +='<li>'; 
                                html += '<p class="prd-img">';
                                html += '<a href="/3.2.0/index.php/Home/Index/product_details/id/'+obj[i]['item_id']+'"target="_blank">';
                                html +='<img src="'+obj[i]['img_url'] + '">'; 
                                html += '</a>';
                                html += '</p>';
                                html += '<p class="name">';
                                html += ' <a href="/3.2.0/index.php/Home/Index/product_details/id/'+obj[i]['item_id']+'" target="_blank">'+obj[i]['item_name']+'</a>';
                                html += '</p>';
                                html += '<p class="price">';
                                if(obj[i]['mall_id'] == 2){
                                    html += '<i style="font-size:14px">电子币</i>';
                                    html += '<span style="font-size:14px">'+obj[i]['eMoney']+'/'+obj[i]['unit_name']+'</span>';
                                }else{
                                     html += '<i style="font-size:14px">积分</i>';
                                    html += '<span style="font-size:14px">'+obj[i]['sMoney']+'/'+obj[i]['unit_name']+'</span>';
                                }
                                html +='</li>'; 
                          } 
                      }
                          html += '</ul>'
                          th.parent().parent().parent().next().find(".fenlei").html(html);
                          th.parent().parent().parent().next().find(".fenlei").show();
                          th.parent().parent().parent().next().find(".fenlei").prev().hide();
                    })
                })
                $('html').bind("selectstart", function () { return false; });
//                var jia = 0;
//                var l = $("input[name='duoxuan[]']").length;
//                $(".J_cart_checked_num").text(l);
//                for(var i=0;i<l;i++){
//                  jia +=$("input[name='duoxuan[]']").eq(i).val()*1;  
//                }
//                $("#zongjia").text(jia);
//                $("#zongjia_i").val(jia);
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
//                            if(obj.touxiang==""){
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
//                            $("#zujing_img").attr("src","/ShoppingSite/"+obj.touxiang);
//                            $(".desc").empty().append("按下键盘上的<i>G</i>即可快速打开/关闭购物车功能");
//                            if(obj.quanxian=="超级管理员"||obj.quanxian=="管理员"){
//                                $("#hguanli").show();
//                            }else{
//                                $("#hguanli").hide();
//                            }
//                        }
//                    }
//                })
//                var num = 0;
//                $(document).keydown(function(event){
//                    if(event.keyCode == 71){ 
//                        if(num %2==0){
//                            $(".sn-sidebar-contents").attr("class","sn-sidebar-contents sn-sidebar-contents-show");
//                            $(".sn-sidebar-contents").animate({right : '35px'},"slow"); 
//                            $(".sn-sidebar-cart").show();
//                        }else{
//                            $(".sn-sidebar-contents").attr("class","sn-sidebar-contents");
//                            $(".sn-sidebar-contents").animate({right : '-400px'},"slow"); 
//                            $(".sn-sidebar-cart").hide();
//                        }
//                    }
//                    num++;
//                }); 
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
            })
            function futu(obj,name){
                $.post("/3.2.0/index.php/Home/Index/seaxiaolei",{"category_id":obj},function(data){
                        eval("var obj =" +data);
                        var html = '';
                            html += '<ul class="prd-list" >';
                          for(var i =0; i<obj.length;i++){
                                html +='<li>'; 
                                html += '<p class="prd-img">';
                                html += '<a href="/3.2.0/index.php/Home/Index/product_details/id/'+obj[i]['item_id']+'"target="_blank">';
                                html +='<img src="'+obj[i]['img_url'] + '">'; 
                                html += '</a>';
                                html += '</p>';
                                html += '<p class="name">';
                                html += ' <a href="/3.2.0/index.php/Home/Index/product_details/id/'+obj[i]['item_id']+'" target="_blank">'+obj[i]['item_name']+'</a>';
                                html += '</p>';
                                html += '<p class="price">';
                                if(obj[i]['mall_id'] == 2){
                                    html += '<i style="font-size:14px">电子币</i>';
                                    html += '<span style="font-size:14px">'+obj[i]['eMoney']+'/'+obj[i]['unit_name']+'</span>';
                                }else{
                                     html += '<i style="font-size:14px">积分</i>';
                                    html += '<span style="font-size:14px">'+obj[i]['sMoney']+'/'+obj[i]['unit_name']+'</span>';
                                }
                                html +='</li>'; 
                          } 
                          html += '</ul>';      
                          name.html(html);
                          name.show();
                          name.prev().hide();                      

                    })
            }
        </script>
        <div class="sn-sidebar" style="display: block">
            <div class="sn-sidebar-bg"></div>
            <div class="sn-sidebar-tabs sn-sidebar-middle-tabs">
                <div class="sn-sidebar-tabs sn-sidebar-middle-tabs-top">
                    <div class="sn-sidebar-tab sn-sidebar-tab-member sn-sidebar-tab-js" style="visibility: visible;">
                        <a>
                            <i class="tab-icon tab-icon-member"></i>
                            <i class="tab-icon-tip"></i>
                        </a>
                    </div>
                    <div class="sn-sidebar-tab sn-sidebar-tab-cart sn-sidebar-tab-js" id="go">
                        
                            <div class="tab-cart-tip-warp-box" >
                                <div class="tab-cart-tip-warp">
                                    
                                    <i class="tab-icon  tab-icon-cart"></i>
                                    <i class="tab-icon-tip tab-icon-cart-tip"></i>
                                    <span class="tab-cart-tip" id="gwc">购物车</span>
                                    <span class="tab-cart-num J_cart_total_num"><?php echo ($gouwunum); ?></span>
                                </div>
                            </div>

                    </div>
                    <div class="sn-sidebar-tab sn-sidebar-tab-message sn-sidebar-tab-js">
                        <a href="/3.2.0/index.php/Home/Index/mail" target="blank">
                            <i class="tab-icon tab-icon-msg"></i>
                            <i class="tab-icon-tip"></i>
                            <span class="tab-tip">消息</span>
                        </a>
                    </div>
                </div>
                <div class="sn-sidebar-tabs sn-sidebar-middle-tabs-bottom">
                </div>
            </div>
            <div class="sn-sidebar-tabs sn-sidebar-bottom-tabs">
                
                <div class="sn-sidebar-tab sn-sidebar-wider-tab sn-sidebar-to-top sn-sidebar-tab-js" id="ding">
                    <a>
                        <i class="tab-icon tab-icon-to-top"></i>
                        <span class="tab-tip tab-tip-wider" >返回顶部</span>
                    </a>
                </div>
            </div>
            <div class="tab-tip-code-warp">
                <a>
                    <img class="tab-tip-code-warp-img" src="/3.2.0/Public/images/aoyun-code-img.png">
                </a>
            </div>
            <div class="sn-sidebar-member-wrap member-white">
                <div class="ng-sidebar-head">
                    <dl class="userinfo">
                        <dt>
                            <a>
                                <?php if($find["head_portrait"] != ""): ?><img class="custHeadImg" src="<?php echo ($find["head_portrait"]); ?>" id="zujing_img">
                                    <?php else: ?>
                                    <img class="custHeadImg" src="/3.2.0/Public/images/1.jpg" id="zujing_img"><?php endif; ?>
                                
                            </a>
                            <a></a>
                        </dt>
                        <dd>
                            <input type="hidden" value="<?php echo ($find["real_name"]); ?>" id="mingzi">
                        <?php if($find["real_name"] != ''): ?><p class="username" style='display:block'>
                                <a href='/3.2.0/index.php/Home/Index/member'>尊敬的会员,<?php echo ($find["real_name"]); ?></a>
                                <i class="sep">|</i>
                                <a class="logout" href="/3.2.0/index.php/Home/Index/signOut">退出</a>
                            </p>
                            <?php else: ?>
                            <p class="pls-login">
                                您好，请先<a class="login" href="/3.2.0/index.php/Home/Index/login">登录</a>!
                            </p><?php endif; ?>
                            <p class="links">
                                <a>会员联盟</a>
                                <i class="sep">|</i>
                                <a>诚兑城</a>
                            </p>
                        </dd>
                    </dl>
                </div>
                <div class="ng-sidebar-notices">
                    <p class="ng-sidebar-notice">
                        <i class="member-laba"></i>
                        <a class="torenxin"></a>
                    </p>
                </div>
                <a class="ng-sidebar-close"></a>
            </div>
                <div class="sn-sidebar-content sn-sidebar-recharge"></div>
                <div class="sn-sidebar-content sn-sidebar-activity"></div>
                <div class="sn-sidebar-content sn-sidebar-quality"></div>
                <div class="sn-sidebar-content sn-sidebar-member"></div>
                <div class="sn-sidebar-content sn-sidebar-history"></div>
                <div class="sn-sidebar-content sn-sidebar-finance"></div>
                <div class="sn-sidebar-content sn-sidebar-servicebox"></div>
                <div class="sn-sidebar-all-loading">
                    <p class="loading-content">加载中...</p>
                </div>
                <script>
                    $(function(){
                        $("#go").click(function(){
                            window.location.href='/3.2.0/index.php/Home/Index/gouwuchejs'
                        })
                        $("#gwc").click(function(){
                           if($("#mingzi").val() == ''){
                                window.location.href="/3.2.0/index.php/Home/Index/login";
                           }else{
                                window.location.href="/3.2.0/index.php/Home/Index/gouwuchejs";
                           }
                        })
                    })
                </script>
            </div>
    </body>
</html>