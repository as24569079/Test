<?php if (!defined('THINK_PATH')) exit();?>﻿<html>
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

</head>
<body>

    <div class="container body-content">

        <div class="fanhuian redbutton"><a class="ui-button fleft" href="/3.2.0/index.php/Home/Index/E_zz">转账</a></div>
        <table class="table">
            <tbody>
                <tr class="fir-tr">
                    <th>类型</th>
                    <th>转出人</th>
                    <th>转入人</th>
                    <th>转账时间</th>
                    <th>电子币</th>
                    <th>备注</th>
                </tr>
            <?php if(is_array($zhang)): $i = 0; $__LIST__ = $zhang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr style="text-align: center">
                    <td class="td1"></td>
                    <td><?php echo ($val["real_name"]); ?></td>
                    <td><?php echo ($val["TagertFullName"]); ?></td>
                    <input type="hidden" value="<?php echo ($val["moveType"]); ?>" class="type">
                    <td><?php echo ($val["time"]); ?></td>
                    <td class="td2"></td>
                    <input type="hidden" value="<?php echo ($val["Fn_Amount"]); ?>" class="qian">
                    <td><?php echo ($val["Fc_Remark"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination-container page_new">
            <div class="pagination-container"><ul class="pagination"><li class="disabled PagedList-skipToPrevious"><a rel="prev">«</a></li><li class="active"><a>1</a></li><li class="disabled PagedList-skipToNext"><a rel="next">»</a></li></ul></div>
        </div>
    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script>
        $(document).ready(function(){
            var td1 = $(".td1");
            var td2 = $(".td2");
            var td3 = $(".td3");
            var type = $(".type");
            var qian = $(".qian");
            for(var i=0;i<td1.length;i++){
                if(type.eq(i).val()=="emoney"){
                    td1.eq(i).html("转账;用户间转电子币");
                    td2.eq(i).html(qian.eq(i).val());
                }else if(type.eq(i).val()=="smoney"){
                    td1.eq(i).html("转账;用户间转积分");
                    td3.eq(i).html(qian.eq(i).val());
                }
            }
        })
    </script>
<script>window.parent.scrollTo(0, 0);</script>
</body>
</html>