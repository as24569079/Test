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
</head>
<body>
          
                    <table class="table" >
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
                    <div class="fena"><?php echo ($show); ?></div>
  
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
   
<script>window.parent.scrollTo(0, 0);</script>
</body>
</html>