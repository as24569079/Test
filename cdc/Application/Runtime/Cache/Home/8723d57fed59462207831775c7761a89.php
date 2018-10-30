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

    <style>
        #table3 tr:nth-child(3){
            background-color: yellow;
        }
        </style>
</head>
<body>

    <!--<div class="container body-content">-->

        <!--<div class="tabbable">-->
            <ul class="nav nav-tabs ui-select-listBox">
                <li class="active"><a href="/3.2.0/index.php/Home/Index/bonus_fenli" target="mm" id="tag1">消费分利</a></li>
                <li><a href="/3.2.0/index.php/Home/Index/bonus_tuijian" target="mm" id="tag2">推荐奖奖励</a></li>
                <li><a href="/3.2.0/index.php/Home/Index/bonus_tuandui" target="mm" id="tag3">团队奖励</a></li>
                <!--<li><a href="/3.2.0/index.php/Home/Index/bonus_fiagship"  target="mm" id="tag4">旗舰店奖励</a></li>-->
<!--                <li><a href="#tab4" data-toggle="tab" onclick="javascript: goUrl('/Fee/TeShuListByUser')">合作商补贴</a></li>
                <li><a href="#tab5" data-toggle="tab" onclick="javascript: goUrl('/Fee/QiJianListByUser')">旗舰店店补记录</a></li>-->
            </ul>
        <iframe name="mm" width="100%" height="1000" frameborder="0" id="win" scrolling="no" marginheight="0" marginwidth="0" src="/3.2.0/index.php/Home/Index/bonus_fenli"></iframe>
                    <table class="table" id="table1" style="display: none">
                            <tr class="fir-tr">
                                <th>奖金来源</th>
                                <th>结算时间</th>
                                <th>推荐消费奖</th>
                                <th>扣综合管理费</th>
                                <th>积分</th>
                                <th>实发奖金</th>
                                <th>审核状态</th>
                                <th>审核备注</th>
                            </tr>
                            <?php if(is_array($ding)): $i = 0; $__LIST__ = $ding;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="sec-tr">
                                <td><?php echo ($val["real_name"]); ?>,<?php echo ($val["jiedian"]); ?></td>
                                <td><?php echo ($val["time"]); ?></td>
                                <td><?php echo ($val["jiangli"]); ?></td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td><?php echo ($val["jiangli"]); ?></td>
                                <td>发奖完成</td>
                                <td></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>                
                    <table class="table" id="table2" style='display:none'>
                            <tr class="fir-tr">
                                <th>得奖单号</th>
                                <th>期数</th>
                                <th>结算时间</th>
                                <th>消费分利</th>
                                <th>扣综合管理费</th>
                                <th>积分</th>
                                <!--<th>实发奖金</th>-->
                                <th>审核状态</th>
                            </tr>
                            <?php if(is_array($ren)): $i = 0; $__LIST__ = $ren;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="sec-tr">
                                <td><?php echo ($val["name"]); ?>,<?php echo ($val["tel"]); ?></td>
                                <td><?php echo ($val["qixian"]); ?></td>
                                <td><?php echo ($val["fenlitime"]); ?></td>
                                <td><?php echo ($val["emoney"]); ?></td>
                                <td><?php echo ($val["guanlifei"]); ?></td>
                                <td><?php echo ($val["smoney"]); ?></td>
                                <!--<td></td>-->
                                <td>发奖完成</td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                    <?php echo ($show); ?>
                                        
      <table class="table" id="table3" style="display: none">
        <?php if(is_array($tongji_fafang)): $k = 0; $__LIST__ = $tongji_fafang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><tr style="background:#CCC" class="tr">
            <td>结算日期</td>
            <td></td>
            <td><?php echo ($val["created_date"]); ?></td>
            <td>奖励总额：<?php echo ($val[money]+$val[guanlifei]); ?></td>
            <td></td>
            <td class="mingxi" data-time="<?php echo ($val["created_date"]); ?>">查看明细</td> 
            
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>

<!--                    <table >
                            <tr class="fir-tr">
                                <th>序号</th>
                                <th>个人招商额(已去掉最高收益小组)</th>
                                <th>结算时间</th>
                                <th>营销顾问收益</th>
                          
                                <th>实发电子币</th>
                                <th>实发积分</th>
                                <th>扣综合管理费</th>
                                <th>审核状态</th>
                            </tr>
                       
                            <?php if(is_array($tongji_fafang)): $k = 0; $__LIST__ = $tongji_fafang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><tr class="sec-tr">
                                <td><?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></td>
                                <td><?php echo ($val["yeji"]); ?></td>
                                <td><?php echo ($val["created_date"]); ?></td>
                                <td><?php echo ($val["amount"]); ?></td>
                               
                                <td><?php echo ($val["emoney"]); ?></td>
                                <td><?php echo ($val["smoney"]); ?></td>
                                 <td><?php echo ($val["guanlifei"]); ?></td>
                                <td>                        
                                <?php switch($val["status"]): case "0": ?>未发放<?php break;?>
                                    <?php case "1": ?>已发放<?php break; endswitch;?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>-->
                             <!--<?php if($val["dengji"] < 9): ?>--> <!--<?php else: endif; ?>-->
                          
                    <!--</table>-->
                    <table class="table" id="table4" style="display: none">
                            <tr class="fir-tr">
                                <th>序号</th>
                                <th>月份</th>
                                <th>营业额</th>
                                <th>奖励比例</th>
                                <th>收益</th>
                                <th>结算时间</th>
                                <th>发放时间</th>
                                <th>状态</th>
                            </tr>
                            <?php if(is_array($flagshi)): $k = 0; $__LIST__ = $flagshi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$flag): $mod = ($k % 2 );++$k;?><tr class="sec-tr">
                                <td><?php echo (I('get.p'))?((I('get.p')-1)*12+$k):($k);?></td>
                                <td><?php echo ($flag["earing_month"]); ?></td>
                                <td><?php echo ($flag["volume"]); ?></td>
                                <td><?php echo ($flag["ratio"]); ?>%</td>
                                <td><?php echo ($flag[volume]*$flag[ratio]/100); ?></td>
                                <td><?php echo ($flag["created_time"]); ?></td>
                                <td><?php echo ($flag["reward_time"]); ?></td>
                                <td>                        
                                <?php switch($flag["status"]): case "1": ?>未发放<?php break;?>
                                    <?php case "2": ?>已发放<?php break; endswitch;?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>

    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script>
       
        $(function(){
            $("#tag1").click(function(){
                $(this).parent("li").attr("class","active");
                $(this).parent("li").siblings("li").removeClass("active");
                $("#table1").show();
                $("#table2").hide();
                $("#table4").hide();
                $("#table3").hide();
            })
            $("#tag2").click(function(){
                $(this).parent("li").attr("class","active");
                $(this).parent("li").siblings("li").removeClass("active");
                $("#table1").hide();
                $("#table2").show();
                $("#table4").hide();
                $("#table3").hide();
            })
            $("#tag3").click(function(){
                $(this).parent("li").attr("class","active");
                $(this).parent("li").siblings("li").removeClass("active");
                $("#table1").hide();
                $("#table2").hide();
                $("#table4").hide();
                $("#table3").show();
            })
            $("#tag4").click(function(){
                $(this).parent("li").attr("class","active");
                $(this).parent("li").siblings("li").removeClass("active");
                $("#table1").hide();
                $("#table2").hide();
                $("#table3").hide();
                $("#table4").show();
            })
        })
        
    </script>
    <script>
$(document).ready(function() {
 $(".mingxi").click(function(){
		var gg = $(this).attr("data-time");
//                alert(gg);return;
		var data ={
                    time:gg,
                };
            
	var mythis = $(this);
           
	$.ajax({
		url: "bnous_ajax",
		type: "post",
		data: JSON.stringify(data),
		contentType: "application/json; charset=UTF-8",
		success: function (res) {
//                    alert(res.length);
                        $(".biaozhu").remove();	
         		eval("obj="+res);
                        var item="";
                        var it='<tr class="biaozhu"><td>序号</td><td>本次发放金额</td><td>管理费</td><td>预计发放时间</td><td>期数</td> <td>状态</td> </tr>';
                        mythis.parent().parent().append(it);
                     
                         for(var i=0;i<obj.length;i++) {
                           var l=i+1;
                           item='<tr class="biaozhu"><td>'+l+'</td><td>'+obj[i].emoney+'</td> <td>'+'-'+obj[i].guanlifei+'</td><td>'+obj[i].fafang_time+'</td><td>'+obj[i].limit+'</td><td>'+obj[i].zhuangtai+'</td></tr>';
                           mythis.parent().parent().append(item);
//                             $"data-time") .append(item);
                        }
                    }   
		});
            });
});
</script>
<script>window.parent.scrollTo(0, 0);</script>
</body>
</html>