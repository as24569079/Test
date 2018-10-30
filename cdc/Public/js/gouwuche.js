    function price1(){
        var change=0;
          $(".totalprice").each(function(){       
                change+= parseInt($(this).text());
              
     });
   
       $("#var").text('￥'+change);
       $(".allproducts").text($(".totalprice").length);
    }
    $(document).ready(function(){
        price1();
        
        $(".delete").click(function(){
               var result = confirm("您确认删除吗 ？");     
            if(result){
//                $(this).parent().parent().remove();
            var data={
                g_id:$(this).attr("data-id"),
            }
        $.ajax({
                type:"post",
                url:"gouwuched",
                dataType: "text",
                data:JSON.stringify(data),
                success:
                function(data){
//                    alert(data);
                    if(data == 1){
                               $(this).parent().parent().remove();
                        }else{
//                            alert("登录账户密码错误!");
                        }
                }
            })              
                
            }else{
                return;
            }
            price1();
        });
        
        
        
        $(".jia").click(function(){
            
            var total=0;
            var quantity = $(this).siblings(".quantity").val();    
            quantity = eval(parseInt(quantity) +1);
             $(this).siblings(".quantity").val(quantity);
            var price=$(this).parent().parent().parent().parent().find(".price").text();
            total=parseFloat(quantity*price);
            $(this).parent().parent().parent().parent().find(".totalprice").text(total);  
//            $(this).parent().parent().parent().parent().find(".totalprice").text("total");  
            price1();
            var g_id=$(this).parent().attr("data-g_id");
            alert(g_id);
            alert(quantity);
            
//            var quantity=quantity
            var data={
                g_id:g_id,
                quantity:quantity,
            } 
//            alert(JSON.stringify(data));return;
                    $.ajax({
                        type:"post",
                        url:"gouwuche_shop",
                        dataType: "text",
                        data:JSON.stringify(data),
                        success:
                        function(data){
        //                    alert(data);

                        }
                    })
               
//            alert(count);    
        });
        $(".jian").click(function(){
            
            var total=0;
            var quantity = $(this).siblings(".quantity").val();
            quantity= eval(parseInt(quantity) -1);
            if(quantity<1){
                return;
            }
            var price=$(this).parent().parent().parent().parent().find(".price").text();
             $(this).siblings(".quantity").val(quantity);
            total=parseFloat(quantity*price);
            $(this).parent().parent().parent().parent().find(".totalprice").text(total);  
            price1();
             var g_id=$(this).parent().attr("data-g_id");
            
//            var quantity=quantity
            var data={
                g_id:g_id,
                quantity:quantity,
            } 
//            alert(JSON.stringify(data));return;
                    $.ajax({
                        type:"post",
                        url:"gouwuche_shop",
                        dataType: "text",
                        data:JSON.stringify(data),
                        success:
                        function(data){
        //                    alert(data);

                        }
                    })
        });
//     LoginButton
     $("#LoginButton").click(function(){
            var data={
                name:$("#Login1_UserName").val(),
                password:$("#Login1_Password").val(),
            } 
            $.ajax({
                type:"post",
                url:"loginyes",
                dataType: "text",
                data:JSON.stringify(data),
                success:
                function(data){
//                    alert(data);
                    if(data == 1){
//                        if($("#sl").val()>=$("#zhi").val()){
                            var frm = document.getElementById('form');
                                frm.action='logincookie';
                                frm.submit();
                        }else{
                            alert("登录账户密码错误!");
                        }
                }
            })
        })

          $(".btn-primary").click(function(){
                $.ajax({
                    type:"post",
                    url:"loginajax",
                    dataType: "text",
                    data:null,
                    success:
                    function(data){
//                        alert(data);
                        if(data == 1){
                             $("#shop_login").fadeIn(1000);
                        }else if(data == 2){
                            document.location.href="liulan";
                      
                            
                        }
                    }
                })
                      
                     
    });
});   

