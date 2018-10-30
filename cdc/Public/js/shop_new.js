$(function(){
    $("#add").click(function(){
        window.location.href='shop_new_add';
    })
    $(".del").click(function(){
        if(confirm('确定删除此新闻吗？')){
            var id = $(this).attr("data-id");
            $("#new_id").val(id);
            var frm = document.getElementById('form');
                frm.action='delshop_new'
                frm.submit();
        }else{
            $("#new_id").val("");
        }
    })
})