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

</head>
<body>

    <div class="container body-content">
<!--/3.2.0/index.php/Home/Index/withdrawals提现申请-->
        <div class="fanhuian"><a class="ui-button fleft" href="/3.2.0/index.php/Home/Index/withdrawals">提现申请</a></div>
        <table class="table">
            <tbody>
                <tr class="fir-tr">
                    <th>帐号</th>
                    <th>姓名</th>
                    <th>提取金额</th>
                    <th>扣手续费</th>
                    <th>实际提取金额</th>
                    <th>银行卡信息</th>
                    <th>提款时间</th>
                    <th>审核状态</th>
                    <th>审核备注</th>
                </tr>
            <?php if(is_array($tixian)): $i = 0; $__LIST__ = $tixian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr style="text-align: center">
                    <td><?php echo ($val["user"]); ?></td>
                    <td><?php echo ($val["real_name"]); ?></td>
                    <td><?php echo ($val["money"]); ?></td>
                    <td><?php echo ($val["shouxu"]); ?></td>
                    <td><?php echo ($val["shiji"]); ?></td>
                    <td><?php echo ($val["yinhangka"]); ?></td>
                    <td><?php echo ($val["time"]); ?></td>
                    <td class="tai"></td>
                    <input type="hidden" value="<?php echo ($val["zhuangtai"]); ?>" class="zhuang">
                    <td><?php echo ($val["beizhu"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination-container page_new">
            <div class="pagination-container"><ul class="pagination"><li class="disabled PagedList-skipToPrevious"><a rel="prev">«</a></li><li class="disabled PagedList-skipToNext"><a rel="next">»</a></li></ul></div>
        </div>


    </div>
    <script src="/3.2.0/Public/js/jquery-1.10.2.js"></script>
    <script>window.parent.scrollTo(0, 0);</script>
    <script>
        $(document).ready(function(){
            var zhuang = $(".zhuang");
            var tai = $(".tai");
            for(var i=0;i<zhuang.length;i++){
                if(zhuang.eq(i).val()==0){
                    tai.eq(i).text("待审核");
                }else if(zhuang.eq(i).val()==1){
                    tai.eq(i).text("通过审核");
                }
            }
        })
    </script>


</body>
</html>