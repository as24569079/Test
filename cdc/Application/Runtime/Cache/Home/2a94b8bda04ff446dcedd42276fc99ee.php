<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>
        天津诚兑城电子商务有限公司
    </title>
    <meta name="description">
    <meta charset="UTF-8">
     <meta name="keywords" content="诚兑城,诚兑城联盟,诚兑城商城,诚兑城平台,诚兑城官网"/>
    <meta name="description" content="天津诚兑城电子商务有限公司(电话022-88274018)天津诚兑城官网是聚焦商品,返利,商务合作,加盟,金融理财,o2o的电商平台,是具有特点的商城,口碑好,评价高,地址天津"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/luara.css">
    <link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/luara.left.css">
    <link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/icons-core.css">
    
    <link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/style.css">
    
<link rel="shortcut icon" href="/3.2.0/Public/images/bitbug_favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/3.2.0/Public/lunbo/css/slide.css">
    <!--<script src="/3.2.0/Public/js/jquery.min.js"></script>-->
    <!--<script src="/3.2.0/Public/js/bootstrap.min.js"></script>-->
    <!--<script src="/3.2.0/Public/js/nav_index.js"></script>-->
    <script src="/3.2.0/Public/js/jquery-1.8.3.min.js"></script>
    <script src="/3.2.0/Public/js/jquery.luara.0.0.1.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/3.2.0/Public/shopping/css/index.css">
    <style>
    .content{width:500px;height:30px;padding-left:8%;padding-top: 10px;padding-bottom: 10px;overflow:hidden;} 
    dl{width:400px;height:30px;} 
    .ck-slide { width: 100%; height: 340px;}
		.ck-slide ul.ck-slide-wrapper { height: 340px;}
    </style>
</head>
<body>
    <form method="post" id="form">
        <div id="header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-md-3 hidden-xs" style="float:left">
                        <a href="/3.2.0/index.php/Home/Index/index"><img src="/3.2.0/Public/images/chengcuicheng.png" width="248" height="74"></a>
                    </div>
                    <div class="col-xs-6 col-sm-9 col-md-9 fr hidden-xs" style="float:left">
                        <ul class="topnav fr">
                            <li id="login_li">
                                <a id="p_lt_ctl00_TopSignOutButton_btnSignOutLink" class="signoutLink" href="/3.2.0/index.php/Home/Index/login">[登陆]</a>
                            </li>
                            <li id="register_li">
                                <a href="/3.2.0/index.php/Home/Index/register">[注册]</a>
                            </li>
                            <li style="display: none" id="zhongxin">
                                <a href="/3.2.0/index.php/Home/Index/member">个人中心</a>

                            </li>
                        </ul>

                        <ul class="nav nav-pills">
                            <li class="dropdown"><a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/index">首页</a></li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/guanyu">关于诚兑城</a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/shop_index">诚兑城商城</a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/jiaruwomen">加入我们</a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/kefuzhongxin">客服中心</a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/xinwenzhongxin">新闻中心</a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" href="/3.2.0/index.php/Home/Index/gonggao">公告</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       <!--Luara图片切换骨架begin-->
       <div class="ck-slide">
			<ul class="ck-slide-wrapper">
				<?php if(is_array($url)): $i = 0; $__LIST__ = $url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; if($val["banner_id"] == 68): ?><li><a href="/3.2.0/index.php/Home/Index/business_shop2/id/4"><img src="<?php echo ($val["images_url"]); ?>" style="height:340px"></a></li>
                                    <?php else: ?><li><a href="javascript:"><img src="<?php echo ($val["images_url"]); ?>" style="height:340px;width:100%"></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<a href="javascript:;" class="ctrl-slide ck-prev">上一张</a> <a href="javascript:;" class="ctrl-slide ck-next">下一张</a>
			<div class="ck-slidebox">
				<div class="slideWrap">
					<ul class="dot-wrap">
                                <?php if(is_array($url)): $k = 0; $__LIST__ = $url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><li><em><?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></em></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
		</div>
    <!--Luara图片切换骨架end-->
    <script src="/3.2.0/Public/lunbo/js/jquery-1.8.3.min.js"></script>
    <script src="/3.2.0/Public/lunbo/js/slide.js"></script>
		<script>
			$('.ck-slide').ckSlide({
				autoPlay: true,//默认为不自动播放，需要时请以此设置
				dir: 'x',//默认效果淡隐淡出，x为水平移动，y 为垂直滚动
				interval:3000//默认间隔2000毫秒
				
			});
		</script>
    <!--<div class="row">-->
        <div class="col-sm-4 col-md-4"></div>
        <div class="col-sm-4 col-md-4">
             <div class="content"> 
                 <?php if(is_array($row)): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dl>
                         <dt>
                             <a  href="/3.2.0/index.php/Home/Index/kaiye/id/<?php echo ($val["new_id"]); ?>" target="_blank" style=" cursor: pointer"><span style="color:red;margin-right: 5px">·</span><?php echo ($val["title"]); ?>&nbsp;&nbsp;<?php echo ($val["time"]); ?></a>          
                         </dt>
                     </dl><?php endforeach; endif; else: echo "" ;endif; ?>
            </div> 
        </div>
        <div class="col-sm-4 col-md-4"></div> 
    <!--</div>-->
    <script>
        //新闻标题上线滚动
      $(function(){ 
            $('.content dl').hide(); 
            $('.content dl:gt('+($('.content dl').length - 2)+')').show(); 
            window.setInterval(function(){ 
            $('.content dl:visible:first').prev().slideDown("fast",function(){ 
            $(this).animate({opacity:1},2000,function(){ 
            if($('.content dl:hidden').length == 0){ 
            $('.content dl').hide(); 
            $('.content dl:gt('+($('.content dl').length - 2)+')').show(); 
            } 
            }); 
            }); 
            },3000); 
}); 
    </script>
    <div class="container">
        <div class="row" style="margin:auto">
            <div class="col-sm-4 col-md-4 hidden-xs">
                <div class="new fl">
                    <div class="s">
                        <div class="newtitle fl">
                            <h1>名优新品</h1>
                            <em>FAMOUS NEWS</em>
                        </div>
                                                <div class="newmore fr"><a href="" target="_blank"><img src="/3.2.0/Public/images/more.gif" width="18" height="17"></a></div>

                    </div>
                    <div class="x fr">
                            <a href="" target="_blank"><img src="<?php echo ($goom[0]["images_url"]); ?>" width="314" height="186"></a>
                        </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4 hidden-xs">
              <div class="new fl">
                  <div class="s">
                  <div class="newtitle fl"><h1>新闻中心</h1><em>NEWS</em></div>
                  <div class="newmore fr">
                  	<a href="/3.2.0/index.php/Home/Index/xinwenzhongxin" target="_blank">
                  		<img src="/3.2.0/Public/images/more.gif" width="18" height="17">
                    </a>
                  </div>
                  </div>
                  <div class="x fr">
<!--                      <ul class="newlist">
                    	<li><span>·</span>
                            <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/kaiye_si" target="_blank">诚兑城武清旗舰店盛大开业</a></h1>
                                <div class="fr">2016/11/08</div>
                            </div>
                        </li>
                        <li><span>·</span>
                            <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/shitou.html" target="_blank">长白山松花石上新</a></h1>
                                <div class="fr">2016/11/02</div>
                            </div>
                        </li>
                    	<li><span>·</span>
                            <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/lanmeijiu.html" target="_blank">长白山野生蓝莓酒</a></h1>
                                <div class="fr">2016/10/28</div>
                            </div>
                        </li>
                    	<li><span>·</span>
                            <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/changbaishan.html" target="_blank">长白山山参上新</a></h1>
                                <div class="fr">2016/10/27</div>
                            </div>
                        </li>
                        
                        <li><span>·</span>
                            <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/xin.html" target="_blank">致会员的一封信</a></h1>
                                <div class="fr">2016/10/25</div>
                            </div>
                        </li>
                        
                        
                     </ul>-->
                    <ul class="newlist">
                        <?php if(is_array($row)): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><span>·</span>
                                <div class="title"><h1><a href="/3.2.0/index.php/Home/Index/kaiye/id/<?php echo ($val["new_id"]); ?>" target="_blank"><?php echo ($val["title"]); ?></a></h1>
                                    <div class="fr"><?php echo ($val["time"]); ?></div>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        
                        
                     </ul>
                  </div>
            </div>
    </div>
            
            <div class="col-sm-4 col-md-4 hidden-xs">
                <div class="new fl">
                    <div class="s">
                        <div class="newtitle fl">
                            <h1>名优新品</h1>
                            <em>FAMOUS NEWS</em>
                        </div>
                        <div class="newmore fr"><a href="" target="_blank"><img src="/3.2.0/Public/images/more.gif" width="18" height="17"></a></div>
                    </div>
                    <div class="x fr"> <a href="" target="_blank"><img src="<?php echo ($goom[1]["images_url"]); ?>" width="314" height="186"></a></div>
                </div>
            </div>
        </div>
        </div>
<iframe width="100%" height="250" src="/3.2.0/index.php/Home/Index/footer.html"></iframe>

    <script>
            $(document).ready(function(){
                $.ajax({
                    type:"post",
                    url:"/3.2.0/index.php/Home/Index/cookSelect",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
                        if(data != ""){
                            eval("var obj="+data);
                            var str = obj.tel.substring(0,3);
                            var str2 = obj.tel.substring(7);
                            $("#login_li").html("用户："+str+"****"+str2);
                            $("#register_li").html("<a href='/3.2.0/index.php/Home/Index/signOut'>[退出]</a>");
                            $("#zhongxin").show();
                        }else{
                            $("#login_li").html("<a href='/3.2.0/index.php/Home/Index/login'>[登录]</a>");
                            $("#register_li").html("<a href='/3.2.0/index.php/Home/Index/register'>[注册]</a>");
                            $("#zhongxin").hide();
                        }
                    }
                })
            })
        </script>
<!--        <script type="text/javascript">
	$(function(){
	   $("#global-sidebar").hover(function(){
		   $(".side-other").removeClass("slide-out").addClass("slide-in");
	   },function(){
		   $(".side-other").removeClass("slide-in").addClass("slide-out");
	   });
	});
        </script>-->
    </form>
</body>
</html>