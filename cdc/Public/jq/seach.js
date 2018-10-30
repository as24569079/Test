$(function(){
    //点击导航
    $("#layout_jdKey").click(function(){
        if($(this).attr("data-val")=="on"){
            $("#m_common_header_shortcut").show();
            $(this).attr("data-val","off");
        }else{
            $("#m_common_header_shortcut").hide();
            $(this).attr("data-val","on");
        }
    })
    
    //钱数显示
    var emoney = $(".emoney");
    var smoney = $(".smoney");
    var bigprice = $(".big-price");
    for(var i=0;i<emoney.length;i++){
        if(emoney.eq(i).val()==0){
            bigprice.eq(i).html(smoney.eq(i).val());
        }else if(smoney.eq(i).val()==0){
            bigprice.eq(i).html(emoney.eq(i).val());
        }
    }
    
    //无搜索结果
    var li = $(".normal-list");
    if(li.length==0){
        $("#searchlist44").hide();
        $("#searchlist48").removeClass("displayNone");
    }
    
    //回车时间
    var last;
    $("#layout_newkeyword").keyup(function(event){
        last = event.timeStamp;
        if(last-event.timeStamp==0){
            if(event.which==13){
                var value = $.trim($(this).val());
                var frm = document.getElementById('layout_searchForm');
                    frm.action='seach/val/'+value;
                    frm.submit();
            }
        }
    })
})