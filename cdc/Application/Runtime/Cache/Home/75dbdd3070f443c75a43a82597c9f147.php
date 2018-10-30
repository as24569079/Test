<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo ($chan["item_name"]); ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/index.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/shop.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/fourth-min.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/snt1001.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/cousu.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/review.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/chanpin.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/fourth-min.css">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/chanpin.js"></script>
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
        <style>
        </style>
    </head>
    <body class="root1200" style="out-line:none;">
        <form method="post" id="form">
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
        <div class="g-header-wrapper">
            <div class="g-header">
                <div class="wrapper wrapper2">
                    <div class="g-search">
                        <div class="search-inner clearfix">
                            <span class="left-sidebar"></span>
                            <input tabindex="0" id="sea" type="text" class="search-keyword" value="" autocomplete="off">
                            <a id="bnt_tiao"><input class="search-btn" type="button" style="padding:0px;background:rgb(219, 6, 56);color:#fff;font-family:'微软雅黑'" value='搜索'></a>
                            <input type="hidden" id="ssz">
                            
                            <div id="snKeywordNew" class="g-search-hotwords" style='color:#000'>
                                <?php if(is_array($category_tj)): $i = 0; $__LIST__ = $category_tj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a  target="_blank" href="/3.2.0/index.php/Home/Index/business_shop?category_id=<?php echo ($val["category_id"]); ?>&id=" style='color:#999'><?php echo ($val["category_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                            <span class="right-sidebar"></span>
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
                        </div>
                        <div class="g-search-hotwords"></div>
                        <div class="g-ac-results hide" id="sea_jilu" style="height:270px;overflow: hidden;width: 458px">
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
                    </div>
                    <div class="g-logo">
                        <a href="/3.2.0/index.php/Home/Index/index" target="_blank" class="ng-logo">
                        <img src="/3.2.0/Public/images/chengcuicheng.png"  style="width:190px;height:60px;margin-top:7px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--类别详细-->
        <div class="wrapper">
            <div class="breadcrumb">
                <a><?php echo ($fenlei["category_name"]); ?></a>
                <span class="sep">></span>
                <span class="breadcrumb-title"><?php echo ($chan["item_name"]); ?></span>
            </div>
        </div>
        <!--产品介绍-->
        <div class="wrapper proinfo">
            <div class="proinfo-container clearfix">
                <div class="proinfo-left">
                    <div class="imgzoom">
                        <div class="imgzoom-main">
                            <a class="view-img">
                                <img src="<?php echo ($chan["img_url"]); ?>" id="bian">
                            </a>
                            <div class="imgzoom-shot"></div>
                            <i class="g-sticker-80">
                                <b></b>
                            </i>
                            <i class="oversea-logo hide"></i>
                        </div>
                        <div class="imgzoom-thumb">
                            <a class="prev prev-disable" style="visibility:hidden;"></a>
                            <div class="imgzoom-thumb-main">
                                <ul>
                                    <li class="current">
                                        <a>
                                            <img src="<?php echo ($chan["img_url"]); ?>">
                                        </a>
                                    </li>
                                    <?php if(is_array($futu)): $i = 0; $__LIST__ = $futu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; if($val["futu_url"] != '' ): ?><li class="current">
                                            <a>
                                                <img src="<?php echo ($val["futu_url"]); ?>">
                                            </a>
                                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                            <a class="next next-disable" style="visibility:hidden;"></a>
                        </div>
                        <div class="imgzoom-pop">
                            <img>
                        </div>
                    </div>
                    <div class="imgzoom-memo">
                        <div class="favorite">
                            <a id="shoucang" data-id="<?php echo ($chan["item_id"]); ?>">
                                <i></i>收藏
                            </a>
                        </div>
                        <script>
                            $(function(){
                               $("#shoucang").click(function(){
                                        var id = $(this).attr("data-id");
                                    $.post("/3.2.0/index.php/Home/Index/yrsc",{id:id},function(res){
                                        if(res==1){
                                            alert("此商品已经收藏过了!");
                                        }else if(res==2){
                                            alert("收藏成功!");
                                            window.location.href='/3.2.0/index.php/Home/Index/product_details/id/'+id;
                                        }else{
                                            alert("收藏失败!");
                                        }
                                    },"text")
                                }) 
                            })   
                        </script>
                        <div class="share">
                            <span class="label">
                                <!--<i class="sh-i"></i>分享-->
                            </span>
                        </div>
                        <label>商品上架时间</label>：<em><?php echo ($chan["created_date"]); ?></em>
                    </div>
                </div>
                <div class="proinfo-main">
                    <div class="proinfo-title">
                        <h1><?php echo ($chan["item_name"]); ?></h1>
                    </div>
                    <div class="proinfo-focus clearfix" style='background:#db0638'>
                        <div class="clearfix">
                            <dl class="price-sn">
                                <dt>
                                    <span class="w3">原价</span>
                                </dt>
                                <dd>
                                    <del class="small-price">
                                        <i>¥</i>
                                        <?php if($chan["eMoney"] > 0 ): echo ($chan["original_price"]); ?>
                                        <?php else: echo ($chan["ygwb"]); endif; ?>
                                    </del>
                                </dd>
                            </dl>
                            <dl class="price-promo">
                                <dt>
                                    <span class="w3"><?php if($chan["eMoney"] > 0): ?>现价<?php else: ?>积分<?php endif; ?></span>
                                </dt>
                                <dd>
                                    <span class="mainprice">
                                        <i></i>
                                        <?php if($chan["eMoney"] > 0 ): echo ($chan["eMoney"]); else: echo ($chan["sMoney"]); endif; ?><span>/<?php echo ($danwei["unit_name"]); ?></span>
                                    </span>
                                </dd>
                            </dl>
                            <dl class="proinfo-comments-store">
                                <div class="v-div-line"></div>
                                <div>
                                    <span>近期销量</span>&nbsp;<span><?php if($chan["rale"] != ''): echo ($chan["rale"]); else: ?>0<?php endif; ?></span>
                                </div>
                                <i>></i>
                            </dl>
                        </div>
                    </div>
                    <div class="proinfo-deliver">
                        <dl>
                            <dt>
                                <span class="w2">库存</span>
                            </dt>
                            <dd>
                                <span class="l" id="zsl"><?php echo ($chan["number"]); ?></span>
                                <div class="proinfo-deliver-tip"></div>
                            </dd>
                            <dd class="supplier-row">
                                <span>由&nbsp;<a href="/3.2.0/index.php/Home/Index/index" target="_blank">本网站</a>&nbsp;销售和发货，并提供售后服务</span>
                                <!--<a class="contact-me ml10"><i></i>联系卖家</a>-->
                            </dd>
                        </dl>
                    </div>
                    <div class="dash-line"></div>
                    <div class="tzm">
                        <br><br>
                        <div class="tzm-border">
                            <div class="tip">请选择颜色、数量</div>
                        </div>
                        <a class="close" id="gouguan">><</a>
                        <dl class="proinfo-num">
                            <dt><span class="w2">数量</span></dt>
                            <dd>
                                <a class="minus minus-disable btn-reduce "></a>
                                <input id="zhi" type="text" value="1" max="99" disabled="disabled">
                                <a class="plus btn-add"></a>
                            </dd>
                        </dl>
                    </div>
                    <br><br><br><br><br><br><br><br><br>
                    <input type="hidden" value="{chan.number}" id="cpsl">
                    <div class="mainbtns clearfix">
                        <?php if($chan["menpiao"] != 1): ?><a class="btn-dark-buy" id="goumai">立即购买</a>
                        <?php else: ?>
                        <a class="btn-dark-buy" id="menpiao_goumai">立即购买</a><?php endif; ?>
                        <span style="display: none" id="item_id2"><?php echo ($chan["item_id"]); ?></span>
                        <?php if($find != ""): ?><input type='hidden' id='login_pan' value='1'>
                            <input type="hidden" id="menpiao" value="<?php echo ($chan["menpiao"]); ?>">
                            <a class="btn-orange-buy" style='background:#db0638' id="lo" data-id="<?php echo ($chan["item_id"]); ?>"><i></i>加入购物车</a><?php endif; ?>
                    </div>
                    <script>
                                                    $(document).ready(function(){
                                                        if($("#menpiao").val()=="1"){
                                                            $("#lo").hide();
                                                        }
                                                        $("#lo").click(function(){
                                                            var id = $(this).attr("data-id");
                                                            var num =  $("#zhi").val();
                                                            window.location.href='/3.2.0/index.php/Home/Index/gouwuchecg/item_id/'+id+'/num/'+num;
                                                        })
                                                        $(".btn-add").click(function(){
                                                            var value = $("#zhi").val();
                                                            if($("#zhi").val()<99){
                                                                $("#zhi").val(value*1+1*1);
                                                            }else{
                                                                alert("最大数量为99!");
                                                            }
                                                        })
                                                        $(".btn-reduce").click(function(){
                                                            var value = $("#zhi").val();
                                                            if($("#zhi").val()>1){
                                                                $("#zhi").val(value*1-1*1)
                                                            }else{
                                                                alert("最小数量为1!")
                                                            }
                                                        })
                                                        $("#zhi").keyup(function(){
                                                            if(isNaN($(this).val())){
                                                                alert("请输入数字!");
                                                                $(this).val("1");
                                                            }else if($(this).val()<1){
                                                                alert("最小数量为1!");
                                                                $(this).val("1");
                                                            }else if($(this).val()>99){
                                                                alert("最大数量为99!");
                                                                $(this).val("99");
                                                            }
                                                        })
                                                                                                    var num = 0;
        $(".l-arrow").click(function(){
            var v_width = $("#lunbo > ul").width();
            num--;
            if(num < 0){
                num=4;
                $("#lunbo").animate({left:-796},"slow")
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
               
            }else{
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
                $("#lunbo").animate({left :'+='+ v_width},"slow")
            };
        })
        $(".r-arrow").click(function(){
            var v_width = $("#lunbo > ul").width();
            num++;
            if(num>4){
                num = 0;
                $("#lunbo").animate({left:0},"slow")
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
            }else{
                $(".pages-dot > span").eq(num).attr("class","page-dot current").siblings("span").attr("class","page-dot");
                $("#lunbo").animate({left :'-='+ v_width},"slow")
            }
        })
                                                    })
        
                                                </script>   
                    <script>
                        $(function(){
                        $("#goumai").click(function(){
                            if($("#login_pan").val()!="1"){
                                alert("请先登录!");
                                var item_id = $("#item_id2").text();
                                window.location.href='/3.2.0/index.php/Home/Index/login/item_id/'+item_id;
                            }else{
                            var data={
                                zhi:$("#zhi").val(),
                                item_id:$("#item_id2").text(),
                            }
//                            alert(data.item_id);
                            $.ajax({
                                type:"post",
                                url:"/3.2.0/index.php/Home/Index/loading",
                                dataType: "text",
                                data:JSON.stringify(data),
                                success:
                                function(data){
//                                    alert(data);
                                    if(data == 1){
                                         var frm = document.getElementById('form');
                                           frm.action='/3.2.0/index.php/Home/Index/dingdan';
                                           frm.submit();
                                    }else if(data==3){
                                            alert("商品数量不足!");                  
                                    }
                                }
                            })
                        }
                            })
                        $("#menpiao_goumai").click(function(){
                            if($("#login_pan").val()!="1"){
                                alert("请先登录!");
                                var item_id = $("#item_id2").text();
                                window.location.href='/3.2.0/index.php/Home/Index/login/item_id/'+item_id;
                            }else{
                            var data={
                                zhi:$("#zhi").val(),
                                item_id:$("#item_id2").text(),
                            }
//                            alert(data.item_id);
                            $.ajax({
                                type:"post",
                                url:"/3.2.0/index.php/Home/Index/loading",
                                dataType: "text",
                                data:JSON.stringify(data),
                                success:
                                function(data){
//                                    alert(data);
                                    if(data == 1){
                                         var frm = document.getElementById('form');
                                           frm.action='/3.2.0/index.php/Home/Index/menpiao_dingdan';
                                           frm.submit();
                                    }else if(data==3){
                                            alert("商品数量不足!");                  
                                    }
                                }
                            })
                            }
                        })
                       
        })
                    </script>
                    <dl class="pro-serv-panel">
                        <dt>特色服务</dt>
                        <dd class="proinfo-serv clearfix">
                            <span>
                                <a class="wly no-link">
                                    <i class="icon"></i>
                                    7天无理由退货　满<em style="color:red">3200.00</em>包邮
                                </a>
                            </span>
                        </dd>    
                    </dl>
                    <div class="proinfo-side">
                        <div class="proinfo-side-inner">
                            <div class="customer-rec">
                                <div class="customer-rec-title">
                                    <h3>
                                        <span>看了又看</span>
                                    </h3>
                                </div>
                                <div class="customer-rec-list">
                                    <div class="scroll-wrapper clearfix" id="lunbo">
                                        <ul>
                                            <?php if(is_array($chanpin1)): $i = 0; $__LIST__ = $chanpin1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style='padding-top:5px'>
                                                <a class="product-img"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                    <img src="<?php echo ($val["img_url"]); ?>">
                                                </a>
                                                <p>
                                                    <span class="price">
                                                        <i>¥</i><em><?php echo ($val["eMoney"]); ?></em>
                                                    </span>
                                                    <a class="title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                </p>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <ul>
                                            <?php if(is_array($chanpin2)): $i = 0; $__LIST__ = $chanpin2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style='padding-top:5px'>
                                                <a class="product-img"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                    <img src="<?php echo ($val["img_url"]); ?>">
                                                </a>
                                                <p>
                                                    <span class="price">
                                                        <i>¥</i><em><?php echo ($val["eMoney"]); ?></em>
                                                    </span>
                                                    <a class="title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                </p>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <ul>
                                            <?php if(is_array($chanpin3)): $i = 0; $__LIST__ = $chanpin3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style='padding-top:5px'>
                                                <a class="product-img"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                    <img src="<?php echo ($val["img_url"]); ?>">
                                                </a>
                                                <p>
                                                    <span class="price">
                                                        <i>¥</i><em><?php echo ($val["eMoney"]); ?></em>
                                                    </span>
                                                    <a class="title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                </p>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <ul>
                                            <?php if(is_array($chanpin4)): $i = 0; $__LIST__ = $chanpin4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style='padding-top:5px'>
                                                <a class="product-img"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                    <img src="<?php echo ($val["img_url"]); ?>">
                                                </a>
                                                <p>
                                                    <span class="price">
                                                        <i>¥</i><em><?php echo ($val["eMoney"]); ?></em>
                                                    </span>
                                                    <a class="title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                </p>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <ul>
                                            <?php if(is_array($chanpin5)): $i = 0; $__LIST__ = $chanpin5;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style='padding-top:5px'>
                                                <a class="product-img"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                                    <img src="<?php echo ($val["img_url"]); ?>">
                                                </a>
                                                <p>
                                                    <span class="price">
                                                        <i>¥</i><em><?php echo ($val["eMoney"]); ?></em>
                                                    </span>
                                                    <a class="title"  href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                                </p>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        
                                    </div>
                                    <div class="pages-container" style='margin-top:7px'>
                                        <a class="l-arrow"></a>
                                        <span class="pages-dot">
                                            <span class="page-dot current"></span>
                                            <span class="page-dot"></span>
                                            <span class="page-dot"></span>
                                            <span class="page-dot"></span>
                                            <span class="page-dot"></span>
                                        </span>
                                        <a class="r-arrow"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nopro"></div>
            </div>
        </div>
        <!--底部商品详情-->
        <div class="wrapper mt15">
            <div class="procon-side">
                <div class="lazy-ajax area mt10">
                    <div class="area-head">
                        <h3>看了最终买</h3>
                    </div>
                    <ul class="exprec">
                        <?php if(is_array($zui)): $i = 0; $__LIST__ = $zui;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
                            <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                <img class="image" src="<?php echo ($val["img_url"]); ?>">
                            </a>
                            <p class="title">
                                <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                    <center><?php echo ($val["item_name"]); ?></center>
                                </a>
                            </p>
                            <p class="price">
                                <span>
                                    <i>电子币</i><?php echo ($val["eMoney"]); ?>
                                </span>
                            </p>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="lazy-ajax area mt10">
                    <div class="area-head">
                        <h3 style="cursor: pointer;">销量排行榜</h3>
                    </div>
                    <ul class="toppro-tab clearfix">
                        <li class="no-comparecheck current">
                            <a style='color:rgb(219, 6, 56);border-color:rgb(219, 6, 56)'>同类别</a>
                        </li>
                    </ul>
                    <ul class="toppro-list">
                        <?php if(is_array($xiao)): $k = 0; $__LIST__ = $xiao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><li>
                            <a href='/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>'><img src='<?php echo ($val["img_url"]); ?>'></a>
                            <p class='title' href='/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>'><a><?php echo ($val["item_name"]); ?></a></p>
                            <p class="price"><i><?php if($val["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i><?php if($val["eMoney"] > 0): echo ($val["eMoney"]); else: echo ($val["sMoney"]); endif; ?></p>
                            <span class='num highlight'><?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></span>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
<!--                    <script>
                        $(document).ready(function(e){
                            var value = $("#leibie").val();
                            var length = $(".toppro-list > li").length;
                            $.ajax({
                                type:"post",
                                url:"/3.2.0/index.php/Home/Index/paiming",
                                dataType: "text",
                                data:"id="+ value,
                                success:
                                function(data){
                                    eval("var obj="+data);
                                    for(var i=0;i<length;i++){
                                        $(".toppro-list > li").eq(i).append(
                                        "<a target='_blank' href='/3.2.0/index.php/Home/Index/chanpin/id/"+obj[i].item_id+"'><img src='"+obj[i].img_url+"'></a>\n\
                                        <p class='title'><a target='_blank' href='/3.2.0/index.php/Home/Index/chanpin/id/"+obj[i].item_id+"'>"+obj[i].item_name+"</a></p>\n\
                                        <p class='price'><i>¥</i>"+obj[i].item_eMoney+".00</p>\n\
                                        <span class='num highlight'>"+(i*1+1*1)+"</span>"        
                                        )
                                    }
                                }
                            })
                        })
                    </script>-->
                </div>
            </div>
            <div class="procon">
                <div class="tabarea">
                    <div class="procon-toolbar">
                        <div class="handle"></div>
                        <ul class="tabarea-items">
                            <li class="current">
                                <a>商品详情</a>
                            </li>
<!--                            <li>
                                <a>咨询（0）</a>
                            </li>-->
                            <li>
                                <a>售后保障</a>
                            </li>
                        </ul>
                    </div>
                    <div class="J-procon-desc">
                        <div class="prod-detail-container not-anchor">
                            <div class="pro-detail-pics">
                                <p>
                                    <?php echo ($chan["remarks"]); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lazy-ajax mt10" id="mt9" style="display: none">
                    <div class="rv-wrap">
                        <div class="rv-container db">
                            <div class="rv-main">
                                <div class="rv-main-wrap">
                                    <div class="rv-main-target">
                                        <div class="rv-target-item">
                                            <?php if(is_array($pjxx)): $i = 0; $__LIST__ = $pjxx;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="rv-target-list">
                                                <div class="rv-target-topic clearfix">
                                                    <div class="topic-avatar l">
                                                        <div class="avatar">
                                                            <img src="/3.2.0/Public/shopping/images/defaulHead.jpg">
                                                        </div>
                                                        <div class="username">
                                                            <span><?php echo ($val["user"]); ?></span>
                                                        </div>
                                                    </div>
<!--                                                    <div class="topic-right">
                                                        <div class="topic-main l">
                                                            <div class="topic-title clearfix">
                                                                    满意度:<?php echo ($val["manyidu"]); ?>
                                                            </div>
                                                            <div class="topic-body">
                                                                <p class="body-content"><?php echo ($val["pinglun"]); ?></p>
                                                                <div class="body-info clearfix">
                                                                    <div class="date l">
                                                                        <span><?php echo ($val["time"]); ?></span>
                                                                    </div>
                                                                    <div class="add r">
                                                                        <a class="rv-maidian pjnr_huifu">回复<em>(0)</em></a>
                                                                    </div>
                                                                    <div class="rv-spring like r">
                                                                        <a class="rv-maidian pjnr_youyong">
                                                                            <span class="rv-spring">
                                                                                <i class="rv-spring"></i>有用<em>(0)</em>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="topic-label l">
                                                            <ul>
                                                                <li>
                                                                    <p>
                                                                        <span class="key">评价:</span>
                                                                        <span class="value"><?php echo ($val["pingjia"]); ?></span>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>-->
                                                </div>
                                                <div class="rv-target-reply"></div>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="lazy-ajax mt10" id="mt10">
                    <div class="cs-wrap">
                        <div class="cs-main">
                            <div class="cs-main-wrap">
                                <div class="cs-main-item">
                                    <ul class="cs-place-item clearfix">
                                        <li class="l now">
                                            <p>全部咨询<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>产品咨询<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>库存配送<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>发票保修<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>支付信息<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>促销优惠<span>(0)</span></p>
                                        </li>
                                        <li class="l">
                                            <p>其他问题<span>(0)</span></p>
                                        </li>
                                    </ul>
                                    <div class="cs-place-goto">
                                        <span>如有问题，请联系</span>
                                        <a class="cs-online-server">在线客服</a>
                                    </div>
                                </div>
                                <div class="cs-main-target">
                                    <p class="cs-hasNoConsultation">暂无咨询</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="lazy-ajax area mt10" id="mt11">
                    <div class="area-head">
                        <h3>售后保障</h3>
                    </div>
                    <div class="after-market">
                        <div class="after-market-hd">
                            <h4>售后服务</h4>
                        </div>
                        <div class="after-market-cnt">
                            <div class="guarantees">
                                <p>7天无理由退货</p>
                            </div>
                        </div>
                        <div class="after-market-hd">
                            <h4>退货流程</h4>
                            <span class="opt">
                                <a>退货细则及服务</a>
                            </span>
                        </div>
                        <div class="after-market-cnt">
                            <div class="return-process">
                                发起退货申请---等待退货审核---退货成功
                            </div>
                        </div>
                        <div class="after-market-hd">
                            <h4>温馨提示</h4>
                        </div>
                        <div class="after-market-cnt">
                            <div class="declare">
                                <p>亲爱的顾客，为保障您的权益，请您对配送商品查验确认合格后签收，如有问题，请及时与客服联系。如需退货，请将包装一并寄回哦。</p>
                            </div>
                        </div>
<!--                        <div class="after-market-hd">
                            <h4>特别声明</h4>
                        </div>-->
<!--                        <div class="after-market-cnt">
                            <div class="declare">
                                <p>
                                    本站商品信息均来自于苏宁云台商家，其真实性、准确性和合法性由信息发布者（商家）负责。本站不提供任何保证，并不承担任何法律责任。因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本站不能确保客户收到的货物与网站图片、产地、附件说明完全一致，网站商品的功能参数仅供参考，请以实物为准。若本站没有及时更新，请您谅解！
                                </p>
                            </div>
                        </div>-->
<!--                        <div class="after-market-hd">
                            <h4>价格声明</h4>
                        </div>
                        <div class="after-market-cnt">
                            <div class="declare">
                                <p>易购价：易购价为商品的销售价，是您最终决定是否购买商品的依据。</p>
                                <p>参考价：商品展示的参考价（或划横线价），可能是品牌专柜标价、商品吊牌价或由品牌供应商提供的正品零售价（如厂商指导价、建议零售价等）或该商品在苏宁易购平台或销售商门店曾经展示过的挂牌价；由于地区、时间的差异性和市场行情波动，品牌专柜标价、商品吊牌价、销售商门店挂牌价等可能会与您购物时展示的不一致，该价格仅供您参考。</p>
                                <p>折扣：如无特殊说明，折扣指销售商在参考价或划横线价（如品牌专柜标价、商品吊牌价、厂商指导价、厂商建议零售价、销售商门店挂牌价）等某一价格基础上计算出的优惠比例或优惠金额；如有疑问，您可在购买前联系销售商进行咨询。</p>
                                <p>异常问题：商品促销信息以商品详情页“促销”信息为准；商品的具体售价以订单结算页价格为准；如您发现活动商品售价或促销信息有异常，建议购买前先联系销售商咨询。</p>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <!--查看大图-->
        <div class="imgview">
            <div class="imgview-head">查看大图</div>
            <div class="imgview-main">
                <img src="">
                <div class="mask-l"></div>
                <div class="mask-r"></div>
                <div class="imgview-count">
                    <em>1</em>/<span>1</span>
                </div>
            </div>
            <div class="imgview-thumb imgview-thumb-single">
                <a class="btn-dir prev prev-disable"></a>
                <div class="imgview-thumb-main">
                    <ul>
                       
                            <li class="current" alt="1">
                                <a>
                                    <img src="<?php echo ($chan["img_url"]); ?>">
                                </a>
                            </li>
                           
                    </ul>
                </div>
                <a class="btn-dir next"></a>
            </div>
            <a class="close" id="close" style='top:40px;right:5px'>×</a>
        </div>
        <div class="clear"></div>
        <!--版权区-->
<iframe width="99%" height="250" src="/3.2.0/index.php/Home/Index/footer.html"></iframe>
        </form>
        <script>
            function winshow(){
                    openWin = window.open('/3.2.0/index.php/Home/Index/show_two','_blank','width=550,height=530,left=800,top=400,location=yes,menubar=1,status=1');
            }
            $(document).ready(function(e){
                $('html').bind("selectstart", function () { return false; });
            })
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
                        </a>
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