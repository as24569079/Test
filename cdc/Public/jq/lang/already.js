$(function(){   
    //通用头js
    $("#m_common_header_jdkey").click(function(){
        if($(this).attr("data-val")=="off"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","on");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","off");
        }
    })
        //动态查询订单、创建订单
        $.post("already_ajax",function(res){
            eval("var obj = "+res);
            for(var i=0;i<$(".mar9").length;i++){
                alert(obj[i]);
                for(var a=0;a<obj[i].length;a++){
                var html = '';
                    html += ' <div class="mc">';
                    html += ' <a sign="orderDetail" otc="false" popself="false" href2="">';
                    html += '<div class="imc-con bdb-1px">';
                    html += '  <div class="imc-one">';
                    html += '  <div class="imco-l">';
                    html += ' <div class="imco-l-img-box">';
                    html += ' <div class="imco-l-img">';
                    html += '  <img src="'+obj[i][a]["img_url"]+'">';
                    html += '   </div>';
                    html += '   </div>';
                    html += '   </div>';
                    html += ' <div class="imco-r-content">';
                    html += ' <div class="imco-r">';
                    html += obj[i][a]["item_name"];
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</a>';
                    html += ' </div>';
                    $(".fuck").eq(i).append(html);
                  }
        }
    },"text")
})