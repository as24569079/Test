<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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

</head>
<body>

    <div class="container body-content">

        <div class="fanhuian"><a class="ui-button fleft" href="/3.2.0/index.php/Home/Index/tianjiayinhangka">添加银行卡</a></div>
        <table class="table">
            <tbody>
                <tr class="fir-tr">
                    <th>银行</th>
                    <th>开户行名称</th>
                    <th>卡号</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($ka)): $i = 0; $__LIST__ = $ka;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr style="text-align: center">
                    <td><?php echo ($val["y_name"]); ?></td>
                    <td><?php echo ($val["name"]); ?></td>
                    <td><?php echo ($val["card"]); ?></td>
                    <td><a href="/3.2.0/index.php/Home/Index/updateyinhangka/id/<?php echo ($val["y_id"]); ?>">修改</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination-container page_new">
            <div class="pagination-container"><ul class="pagination"><li class="disabled PagedList-skipToPrevious"><a rel="prev">«</a></li><li class="disabled PagedList-skipToNext"><a rel="next">»</a></li></ul></div>
        </div>


    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>

    <script src="/3.2.0/Public/js/bootstrap.js"></script>

    <script src="/3.2.0/Public/js/jquery-confirm.min.js"></script>

    <script src="/3.2.0/Public/js/jquery.validate.js"></script>
    <script src="/3.2.0/Public/js/jquery.validate.unobtrusive.js"></script>

    <script src="/3.2.0/Public/js/jquery.unobtrusive-ajax.js"></script>


    <script src="/3.2.0/Public/js/bootstrap-datetimepicker.js"></script>
    <script src="/3.2.0/Public/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <script>window.parent.scrollTo(0, 0);</script>



</body>
</html>