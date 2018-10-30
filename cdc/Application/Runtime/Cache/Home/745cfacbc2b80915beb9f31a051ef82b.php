<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <script src="/3.2.0/Public/js/jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/3.2.0/Public/css/xiangqing.css">
        <link href="/3.2.0/Public/css/tongji.css" rel="stylesheet" />
        <style>
            table tr td {
                margin:0px;
            }
        </style>
    </head>
    
    <body>
    <table>
        
               
        <tr class="kb"></tr>
        <!--<tr><td class="time" colspan="6"></td></tr>-->
       
             <?php if(is_array($dd)): $k = 0; $__LIST__ = $dd;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k; if($val["order_no"] != ''): ?><tr style="margin:15px">
                         <td>订单号:<?php echo ($val["order_no"]); ?></td>
                         <td >时间:<?php echo ($val["time"]); ?></td>
                         <td >电子币:<?php echo ($val["emenoy"]); ?> 积分:<?php echo ($val["smenoy"]); ?></td>
                         <td >总计:<?php echo ($val["total_price"]); ?></td>
                         
                     </tr><?php endif; ?>
                 <?php if($val["item_name"] != ''): ?><tr > 
       
            <td>商品名字:<?php echo ($val["item_name"]); ?></td>
            <td>数量:<?php echo ($val["quantity"]); ?></td>
            <td>单价:
        <?php if($val["mall_id"] == 1): ?>积分:<?php echo ($val["gouwu"]); ?>
            <?php elseif($val["mall_id"] == 2 || $val["mall_id"] == 3): ?>
            电子币:<?php echo ($val["dianzi"]); ?>
            <?php elseif($val["mall_id"] == 4): ?>
             电子币:<?php echo ($val["dianzi"]); ?> +   积分:<?php echo ($val["gouwu"]); endif; ?></td>
        <?php if($val["kt"] != 2): if($val["tuihuo"] == ''): ?><td><input type='button' value="退货申请" class='tuihuos' data-id='<?php echo ($val["detail_id"]); ?>'></td>
                <?php elseif($val["tuihuo"] == 1): ?>
                <td>退货审核中</td>
                 <?php elseif($val["tuihuo"] == 2): ?>
                <td>退货申请已通过，请联系客服,电话:4006-116-226 寄回给商家</td>
                <?php elseif($val["tuihuo"] == 3): ?>
                <td>退货完成</td><?php endif; endif; ?>
        <?php if($val["tuihuo"] == 1 || $val["tuihuo"] == 2): ?><td><input type='button' value='取消退货' class='qxth' data-id='<?php echo ($val["detail_id"]); ?>'></td><?php endif; ?>
        </tr><?php endif; ?>
                 </div><?php endforeach; endif; else: echo "" ;endif; ?>
        
    </table>
        <div class="fena">
            <?php echo ($show); ?>
        </div>
    </body>
    <script>
        $(function(){
            $(".tuihuos").click(function(){
                 if(confirm('请联系客服，电话:4006-116-226')){
                     var id = $(this).attr("data-id");
                     window.location.href = "/3.2.0/index.php/Home/Index/dingdan_detail/id/"+id;
                 }
            })
            $(".qxth").click(function(){
                 if(confirm('确认取消退货？')){
                     var id = $(this).attr("data-id");
                     $.post("/3.2.0/index.php/Home/Index/qx_tuihuo",{id:id},function(data){
                   
                         if(data == 1){
                             alert("取消退货成功");
                             location.reload();
                         }else{
                             alert("系统忙，请稍后");
                         }
                     })
                 }
            })
        })
    </script>
</html>