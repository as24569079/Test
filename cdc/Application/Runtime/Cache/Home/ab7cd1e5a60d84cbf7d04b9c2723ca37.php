<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>商品已成功加入购物车</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/v3.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/main.css">
        <link rel="stylesheet" href="/3.2.0/Public/shopping/css/index.css">
        <script type="text/javascript" src="/3.2.0/Public/shopping/js/jquery-1.8.2.min.js"></script> 
        <script type="text/javascript" src="/3.2.0/Public/shopping/jq/chanpin.js"></script>
        <link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
    </head>
    <body>
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
                            <span id="usernameHtml02"><?php echo ($find3["real_name"]); ?></span>
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
        <div class="ng-header ng-channel-header">
            <div class="ng-header-con">
                <div class="wrapper">
                    <div class="ng-logo-box">
                        <a class="ng-logo" href="/3.2.0/index.php/Home/Index/index" target="_blank">
                        <img src="/3.2.0/Public/images/chengcuicheng.png"  style="width:190px;height:60px;margin-top:7px">
                        </a>
                        <span class="channel-logo"></span>
                    </div>
                    <div class="ng-search channel-search">
                        <div class="g-search">
                            <i class="ng-iconfont search-icon"></i>
                            <div class="search-keyword-box" style="border-color:#db0638">
                                <input tabindex="0" id="sea" type="text" class="search-keyword" name="index1_none_search_ss2" value="" autocomplete="off" style="color: rgb(204, 204, 204);" placeholder="试试搜索商品吧">
                            </div>
                            <a id="bnt_tiao"><input type="button" value="搜索" class="search-btn" style="background:#db0638;color:#fff"></a>
                            <input type='hidden' id='ssz'>
                            <div id="snKeywordNew" class="g-search-hotwords" style='color:#000'>
                                <?php if(is_array($category_tj)): $i = 0; $__LIST__ = $category_tj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a  target="_blank" href="/3.2.0/index.php/Home/Index/business_shop?category_id=<?php echo ($val["category_id"]); ?>&id=" style='color:#999'><?php echo ($val["category_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
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
                        </div>
                    </div>
                    <div class="ng-top-act"></div>
                </div>
            </div>
        </div>
        <!--分类-->
        <div class="ng-nav-bar ng-nav-bar-chanel">
                    <div class="ng-sort">
                        <a class="ng-all-hook">
                            <span>全部商品分类</span>
                        </a>
                    </div>
                    <div class="ng-nav-index">
                        <ul class="ng-nav">
<!--                            <li>
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
                    <div class="ng-nav-right-txtact"></div>
                </div>
        <div class="suc_wrap">
            <!--成功加入购物车-->
            <div class="cart_suc clearfix">
                <h2 class="fl">
                    <i class="fl"></i>
                    <span class="fl"></span>
                    已成功加入购物车&nbsp;!
                </h2>
                <p class="fl">
                    <a class="bnt_balance fl" href="/3.2.0/index.php/Home/Index/gouwuchejs" style="background:#db0638;color:#fff">去结算</a>
                    <a class="fl go" href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($find["item_id"]); ?>">继续购物</a>
                </p>
            </div>
            <div class="cart_list">
                <div class="love">
                    <div class="tit clearfix">
                        <h3 class="text fl">
                            <i class="f1" style="float:left"></i>
                            <span class="fl">买了该商品的人还买了</span>
                        </h3>
                    </div>
                    <div class="cont love-list">
                        <div class="load-cont"></div>
                        <ul class="clearfix"  style="display: block">
                            <?php if(is_array($chan)): $i = 0; $__LIST__ = $chan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
                                <div class="pic">
                                    <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank">
                                        <img src="<?php echo ($val["img_url"]); ?>">
                                    </a>
                                </div>
                                <p class="text">
                                    <a href="/3.2.0/index.php/Home/Index/product_details/id/<?php echo ($val["item_id"]); ?>" target="_blank"><?php echo ($val["item_name"]); ?></a>
                                </p>
                                <p class="price">
                                    <i><?php if($val["eMoney"] > 0): ?>电子币<?php else: ?>积分<?php endif; ?></i><strong><?php if($val["eMoney"] > 0): echo ($val["eMoney"]); else: echo ($val["sMoney"]); endif; ?></strong>
                                </p>
                                <p class="ic-cart"></p>
                                <input type="hidden" value="<?php echo ($val["img_url"]); ?>" class="lujing">
                                <input type="hidden" value="<?php echo ($val["item_id"]); ?>" class="bianhao">
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <script>
                        var a = 0;
                        $(function(){
                            $(".ic-cart").click(function(){
                                var value = $(this).siblings(".bianhao").val();
                                var cart_this = $(this);
                                $.ajax({
                                    type:"post",
                                    url:"/3.2.0/index.php/Home/Index/gonggong",
                                    dataType: "text",
                                    data:"id="+ value,
                                    success:
                                    function(data){
                                        if(data!=""){
                                            alert("添加购物车成功!");
                                          
                                cart_this.parent("li").append("<img src='"+cart_this.siblings(".lujing").val()+"' width='140' height='140' style='position: absolute;bottom:85px;right:10px' class='dong'>");
                                cart_this.siblings(".dong").animate(
                                        {bottom:0,width:0,height:0},
                                500,function(){
                                        cart_this.parent("li").append("<p class='jiayi' style='width:40px'></p>")
                                        cart_this.siblings(".jiayi").show();
                                        cart_this.siblings(".jiayi").animate({
                                            bottom:'30px',opacity:0,
                                        },"slow",function(){
                                            cart_this.siblings(".jiayi").detach();
                                            cart_this.siblings(".dong").detach();
                                        });
                                });
                                        }else{
                                            alert("添加失败!购物车已存在此商品!");
                                        }  
                                    }
                                })
                            })
                        })
                    </script>
                </div>
                <div class="like"></div>
                <div class="sales"></div>
            </div>
        </div>
        <!--版权区-->
<iframe width="100%" height="250" src="/3.2.0/index.php/Home/Index/footer.html"></iframe>
        </form>
         <script>
            function winshow(){
                    openWin = window.open('/3.2.0/index.php/Home/Index/show_two','_blank','width=550,height=530,left=800,top=400,location=yes,menubar=1,status=1');
            }
            $(document).ready(function(e){
                $('html').bind("selectstart", function () { return false; });
                $.ajax({
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/cook",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
                      eval("var obj="+data);
                        if(data!=""){
                            $("#username-node-slide").show();
                            $("#username-node").hide();
                            $("#usernameHtml02").text(obj.username);
                            if(obj.touxiang=="null"){
                                $(".headimg > img").attr("src","/3.2.0/Public/shopping/images/0000000000_01_60x60.jpg");
                                $("#zujing_img").attr("src","/3.2.0/Public/shopping/images/0000000000_01_60x60.jpg");
                            }else{
                                $(".headimg > img").attr("src","/ShoppingSite/"+obj.touxiang);
                                $("#zujing_img").attr("src","/ShoppingSite/"+obj.touxiang);
                            }
                            $(".mysuning-detail > .login").hide();
                            $(".mysuning-detail > .username").css("display","block");
                            $(".mysuning-detail > .username").text(obj.username);
                            $(".pls-login").hide();
                            $("#zujing").show();
                            $("#zujing > a").eq(0).text(obj.username);
                            $(".desc").empty().append("按下键盘上的<i>G</i>即可快速打开/关闭购物车功能");
                            if(obj.quanxian=="超级管理员"||obj.quanxian=="管理员"){
                                $("#hguanli").show();
                            }else{
                                $("#hguanli").hide();
                            }
                        }
                    }
                })
                $.ajax({
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/gouwuchesl",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
                        $(".J_cart_total_num").text(data);
                    }
                })
            })
        </script>
    </body>
</html>