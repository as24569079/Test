var $item='<div class="item" data-id="11">';
	$item+='<div class="itemimg"><img src="wei5.PNG"></div>';
	$item+='<div class="iteminfo">';
	$item+='<div class="upinfo">  黄瓜 </div>';
	$item+='<div class="downinfo">';
	$item+='<div class="subitem">';
	$item+='<span class="left" >单价：</span>';
	$item+='<span class="right price">2</span>';
	$item+='<span>元</span>';
	$item+='</div>';
	$item+='<div class="subitem">';
	$item+='<span  class="left" >数量：</span>';
	$item+='<span class="right txt-orange quantity">1</span>';
	$item+='</div>';
	$item+='<div class="subitem">';
	$item+='<span class="left" >小计：</span>';
	$item+='<span class="right txt-orange count">2</span>';
	$item+='<span>元</span>';
	$item+='</div>';
	$item+='</div>';
	$item+='</div>';
	$item+='<div class="itemopt">';
	$item+='<span class="add bg-black">+</span>';
	$item+='<span class="reduce bg-black">-</span>';
	$item+=' <span class="delete bg-red">×</span>';
	$item+='</div>';
	$item+='</div>';

function CountTotal()
{
	var totalquantity=0;
	var totalfee=0;	
	 $(".downinfo").each(function(){
         totalquantity+=$(this).find(".quantity").text()*1;
		 totalfee+=$(this).find(".count").text()*1;
  });
  	$(".itemCount").text($(".downinfo").length);
    $(".quantityCount").text(totalquantity);
	$(".total").text(totalfee);
	
  
 // alert(totalquantity);
}

$(document).ready(function() {
		CountTotal();	
		
 }).on('click', '.add', function () {
			 var count=0;
			 var quantity=$(this).parent().parent().find(".quantity").text()*1;
//                         if(parseInt(quantity)>=parseInt($(".Stock").text())){
//                             alert("1!!!");
//                         }else{
			 quantity= quantity*1 + 1*1;
			 $(this).parent().parent().find(".quantity").text(quantity);
			 var emoney_price=$(this).parent().parent().find(".emoney_price").text()*1;
			 var smoney_price=$(this).parent().parent().find(".smoney_price").text()*1;
                         if(emoney_price*1>0){
                             count=quantity*1*emoney_price*1;
                             count = count.toFixed(2);
                             var emoney_heji = $(".emoney_heji").val()*1;
                             emoney_heji += emoney_price*1;
                             emoney_heji = emoney_heji.toFixed(2);
                             $(".emoney_heji").val(emoney_heji*1);
                             $(".emoney_total").text(emoney_heji);
                         }
                         if(smoney_price*1>0){
                             count=quantity*smoney_price;
                             count = count.toFixed(2);
                             var smoney_heji = $(".smoney_heji").val()*1;
                             smoney_heji += smoney_price*1;
                             smoney_heji = smoney_heji.toFixed(2);
                             $(".smoney_heji").val(smoney_heji);
                             $(".smoney_total").text($(".smoney_heji").val());
                         }
			
//			alert(count);
			$(this).parent().parent().find(".count").text(count);
			CountTotal();
                    
 }).on('click', '.reduce', function () {	
			//alert('this is add');
			 var count=0;
			 var quantity=$(this).parent().parent().find(".quantity").text(); 
			 quantity= eval(quantity*1 -1);
			 if(quantity<=0)
			 {
				 var result=confirm("再减就没有了啊？");
				 if(result)
				 {
				 
                                    var emoney_price=$(this).parent().parent().find(".emoney_price").text();
                                    var smoney_price=$(this).parent().parent().find(".smoney_price").text();
                                    if(emoney_price*1>0){
                                        count=quantity*emoney_price;
                                        count = count.toFixed(2);
                                        var emoney_heji = $(".emoney_heji").val()*1;
                                        emoney_heji -= emoney_price*1;
                                        emoney_heji = emoney_heji.toFixed(2);
                                        $(".emoney_heji").val(emoney_heji);
                                        $(".emoney_total").text(emoney_heji);
                                    }
                                    if(smoney_price*1>0){
                                        count=quantity*smoney_price;
                                        count = count.toFixed(2);
                                        var smoney_heji = $(".smoney_heji").val()*1;
                                        smoney_heji -= smoney_price*1;
                                        smoney_heji = smoney_heji.toFixed(2);
                                        $(".smoney_heji").val(smoney_heji);
                                        $(".smoney_total").text(smoney_heji);
                                    }
                                    $(this).parent().parent().remove();
				 }
				 CountTotal();
				 return;
			 }
			 $(this).parent().parent().find(".quantity").text(quantity);
			 var emoney_price=$(this).parent().parent().find(".emoney_price").text();
			 var smoney_price=$(this).parent().parent().find(".smoney_price").text();
			if(emoney_price*1>0){
                             count=quantity*emoney_price;
                             count = count.toFixed(2);
                             var emoney_heji = $(".emoney_heji").val()*1;
                             emoney_heji -= emoney_price*1;
                             emoney_heji = emoney_heji.toFixed(2);
                             $(".emoney_heji").val(emoney_heji);
                             $(".emoney_total").text(emoney_heji);
                         }
                         if(smoney_price*1>0){
                             count=quantity*smoney_price;
                             count = count.toFixed(2);
                             var smoney_heji = $(".smoney_heji").val()*1;
                             smoney_heji -= smoney_price*1;
                             smoney_heji = smoney_heji.toFixed(2);
                             $(".smoney_heji").val(smoney_heji);
                             $(".smoney_total").text(smoney_heji);
                         }
			$(this).parent().parent().find(".count").text(count);
			CountTotal();
 }).on('click', '.delete', function () {	
     	  var result=confirm("您确认删除吗 ？");
          var count=0;
          var quantity=$(this).parent().parent().find(".quantity").text(); 
			 if(result)
			 {
                                var emoney_price=$(this).parent().parent().find(".emoney_price").text();
                                var smoney_price=$(this).parent().parent().find(".smoney_price").text();
                                if(emoney_price*1>0){
                                    count=quantity*emoney_price;
                                    count = count.toFixed(2);
                                    var emoney_heji = $(".emoney_heji").val()*1;
                                    emoney_heji -= count*1;
                                    emoney_heji = emoney_heji.toFixed(2);
                                    $(".emoney_heji").val(emoney_heji);
                                    $(".emoney_total").text(emoney_heji);
                                }
                                if(smoney_price*1>0){
                                    count=quantity*smoney_price;
                                    count = count.toFixed(2);
                                    var smoney_heji = $(".smoney_heji").val()*1;
                                    smoney_heji -= count*1;
                                    smoney_heji = smoney_heji.toFixed(2);
                                    $(".smoney_heji").val(smoney_heji);
                                    $(".smoney_total").text(smoney_heji);
                                }
				$(this).parent().parent().remove();		
				CountTotal();
			 }
}).on('change', '#itemname', function () {		
	      //itemname表示商品名称或者条形码值	  
		var itemname=$(this).val();
                $(this).val('');
		//alert(itemname);
		//var args={itemname:itemname};
		//编写ajax程序到后台查询该商品，如果该商品存在则添加到页面中。
			var _itemid,_itemname,_price,_count;	
			//以下代码在AJAX中响应后执行
			/*---------------------------------start------------------------------*/
			
			/*---------------------------------End------------------------------*/
		emoney=0,smoney=0;	
		var data={
                    itemname:itemname,
                }				
		$.ajax({
		url: "shouyin_ajax",
		type: "post",
		data: JSON.stringify(data),
		contentType: "application/json; charset=UTF-8",
		success: function (res) {
         		eval("obj="+res);
//				obj.ed;
				//处理数据,把后台打回来的值重新复制到#item变量中		
//				$item.find("")
//				 $(".itemlist").append($item);
//                                  $(this).val('');
                                  
//                        _itemid=111;
//			_itemname='这里是测试商品';
//			_price=12.5;
			_price=obj.eMoney*1+obj.sMoney*1;
                        var jiagege = _price.toFixed(2);
			_count=_price.toFixed(2);
                        var emoney = $(".emoney_heji").val()*1;
                        var smoney = $(".smoney_heji").val()*1;
                        emoney += obj.eMoney*1;
                        smoney += obj.sMoney*1;
                        emoney = emoney.toFixed(2);
                        smoney = smoney.toFixed(2);
                        $(".emoney_heji").val(emoney);
                        $(".smoney_heji").val(smoney);
			$item='<div class="item" data-id="'+obj.item_id+'">';
			$item+='<div class="itemimg"><img src="'+obj.img_url+'"></div>';
			$item+='<div class="iteminfo">';
			$item+='<div class="upinfo">'+obj.item_name+' </div>';
			$item+='<div class="downinfo">';
			$item+='<div class="subitem">';
			$item+='<span class="left">电子币：</span>';
			$item+='<span class="right emoney_price">'+obj.eMoney+'</span>';
			$item+='<span>元</span>';
			$item+='</div>';
			$item+='<div class="subitem">';
			$item+='<span class="left" >积分：</span>';
			$item+='<span class="right smoney_price">'+obj.sMoney+'</span>';
			$item+='<span></span>';
			$item+='</div>';
			$item+='<div class="subitem">';
			$item+='<span  class="left" >数量：</span>';
			$item+='<span class="right txt-orange quantity">1</span>';
			$item+='</div>';
			$item+='<div class="subitem">';
			$item+='<span class="left" >小计：</span>';
			$item+='<span class="right txt-orange count">'+_count+'</span>';
			$item+='<span>元</span>';
			$item+='</div>';
			$item+='</div>';
			$item+='</div>';
			$item+='<div class="itemopt">';
			$item+='<span class="add bg-black">+</span>';
			$item+='<span  class="reduce bg-black">-</span>';
			$item+=' <span class="delete bg-red">×</span>';
			$item+='</div>';
			$item+='</div>';	
                        $(".itemlist").append($item);
                        $(this).val(''); 
                 
                        $(".sp_qian").text(obj.category_name);
//                        $(".price").text(_price);
                        $(".Specifications").text(obj.unit_name);
                        $(".Stock").text(obj.number);
                        var jiagege_z = emoney*1+smoney*1;
                        jiagege_z = jiagege_z.toFixed(2);
                        $(".total").text(jiagege_z);
                        $(".emoney_total").text(emoney);
                        $(".smoney_total").text(smoney);
//                        $(".account").text(obj.eMoney*1+obj.sMoney*1);
                         CountTotal();	
		}
                 
 })
 

    $(".jiezhang").click(function () {
         var item_id='';
            $(".item").each(function(){       
                    item_id+= $(this).attr("data-id")+",";
                
         });   
     
          var quantity='';
          $(".quantity").each(function(){       
                    quantity+= $(this).text()+",";
                

         });   
         var data={
             item_id:item_id,
             quantity:quantity,
         };
         
         $.ajax({
		url: "shouyin_cookie",
		type: "post",
		data: JSON.stringify(data),
		contentType: "application/json; charset=UTF-8",
		success: function (res) {
                      if(res==1){
                          window.location.href="shouyin_user";
                      }
                }
            })
    }); 	 	
     
});
