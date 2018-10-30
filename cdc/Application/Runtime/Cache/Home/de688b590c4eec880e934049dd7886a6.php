<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="/3.2.0/Public/css/j" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="/3.2.0/Public/css/mobilemain.css" type="text/css" rel="stylesheet">
    <link href="/3.2.0/Public/css/main.css" type="text/css" rel="stylesheet">
</head>
<style>
        .fena >div{
    text-align: center;height: 30px;
    line-height: 30px;
}
.fena >div> span{
    width: 50px;height: 30px;
    background: #fff;
    display: block;float:left;
    margin-right: 5px;text-align: center;
    line-height: 30px;
    border-radius: 3px;
    border:1px solid #ccc;
}
.fena >div> a{
    width: 50px;height: 30px;
    background: #fff;
    display: block;float:left;
    margin-right: 5px;text-align: center;
    line-height: 30px;
    border-radius: 3px;
    border:1px solid #ccc;
    text-decoration: none;
}
.fena >div> li{
    list-style: none;
    width: 200px;height: 30px;
    background: #fff;
    display: block;float:left;
    margin-right: 5px;text-align: center;
    line-height: 30px;
    border-radius: 3px;
    border:1px solid #ccc;
    text-decoration: none;
}
.fena >div> a:hover{
    text-decoration: none;
}
    </style>
<body>

    <div class="container body-content">


        <!--<p>编号: <input id="UserSubName" name="UserSubName" value="" type="text">  名称: <input id="Fc_Name" name="Fc_Name" value="" type="text"> &nbsp; &nbsp;<input id="query" value="筛选" class="ui-button" type="button"></p>-->
        <table class="table">
            <tbody>
                <tr class="fir-tr">
                    <th>是否有效</th>
                    <th>
                        编号
                    </th>
                    <th>
                        名称
                    </th>
                    <th>
                        合作资质
                    </th>
                    <th>
                        协议时间
                    </th>
                    <th>
                        生效时间
                    </th>
                    <th>
                        到期时间
                    </th>
                    <th>
                        奖金详情
                    </th>
                    <th>
                        团队管理
                    </th>
<!--                    <th>
                        详情
                    </th>-->
                </tr>
            <?php if(is_array($ding)): $i = 0; $__LIST__ = $ding;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr style="text-align: center" class="sec-tr">
                    <input type="hidden" class="zid" value="<?php echo ($val["crdentials_id"]); ?>">
                    <input type="hidden" class="you" value="<?php echo ($val["status"]); ?>">
                    <td class="youxiao" style="color:#00ff21"></td>
                    <td><?php echo ($val["bianhao"]); ?></td>
                    <td class="ping"><?php echo ($val["zizhanghu"]); ?></td>
                    <td><?php echo ($val["goods_id"]); ?></td>
                    <td class="time"><?php echo ($val["contract_date"]); ?></td>
                    <td class="time"><?php echo ($val["contract_date"]); ?></td>
                    <!--<td></td>-->
                    <td class="etime"><?php echo ($val["end_date"]); ?></td>
                    <td><a href="/3.2.0/index.php/Home/Index/jiangjinxiangqing">奖金详情</a></td>
                    <td><a href="/3.2.0/index.php/Home/Index/tuanduiliebiao/id/<?php echo ($val["crdentials_id"]); ?>">团队列表</a>&nbsp;&nbsp;<a href="/3.2.0/index.php/Home/Index/zhaoshange">团队奖励</a></td>
                    
	            
                    <!--<td><a href="/3.2.0/index.php/Home/Index/xiangqing" target="_blank">详情</a></td>-->
                    <!--<td><a>协议</a></td>-->
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="fena"><?php echo ($show); ?></div>
<!--        <div class="pagination-container page_new">
            <div class="pagination-container"><ul class="pagination"><li class="disabled PagedList-skipToPrevious"><a rel="prev">«</a></li><li class="disabled PagedList-skipToNext"><a rel="next">»</a></li></ul></div>
        </div>-->
    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script>window.parent.scrollTo(0,0);</script>
    <script type="text/javascript">
        $(document).ready(function(){
//            var ping = $(".ping");
//            for(var i=0;i<ping.length;i++){
//                ping.eq(i).append("-"+(i+1));
//            }
            var time = $(".time");
            var etime = $(".etime");
            var xiao = $(".youxiao");
            var you = $(".you")
            for(var i=0;i<xiao.length;i++){
//                if(time.eq(i).text()>=etime.eq(i).text()){
//                    xiao.eq(i).text("否");
//                }else{
//                    xiao.eq(i).text("是");
//                }
                if(you.eq(i).val()==1){
                    xiao.eq(i).text("是");
                }else{
                    xiao.eq(i).text("否");
                }
            }
        })
        
    </script>


</body>
</html>