$(function(){
    //新增删除操作  动态创建tr表格
    var i = $(".tr").length;
    $("#add").click(function(){
            if($("#table").attr("data-val")=="on"){
            $("#table").append("<tr class='th tr'><td style='line-height: 150px;'>banner图"+(i+1)+"</td>\n\
            <td><img src='' style='margin:auto;width:100%;height:150px' class='img'></td>\n\
            <td style='line-height:150px;'><center>\n\
                <input type='button' value='预览' class='btn btn-primary up'>\n\
                </center></td></tr>");
            i++;
            $("#table").attr("data-val","off");
        }
    })
    $("#del").click(function(){
        if($("#table").attr("data-val")=="off"){
            if($("#table").find("tr").length>1){
               $("#table").find("tr:last").remove();
               i = $("#table").find("tr").length;
               $("#table").attr("data-val","on");
            }
        }
    })
    //图片上传路径更换
    function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { 
              url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) {
              url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) {
              url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
    }
    //上传图片
    $(".up").live("click",function(){
        var obj = document.getElementById('files') ; 
        obj.outerHTML=obj.outerHTML; 
        $("#files").click();
        var img = $(this).parent().parent().parent().find(".img");
        $("#files").change(function(){
            img.attr("src",getObjectURL(this.files[0]));
        })
    })
    //替换图片
    $(".huan").live("click",function(){
        var obj = document.getElementById('upt_files') ; 
        obj.outerHTML=obj.outerHTML; 
        $("#banner_id").val("");
        $("#upt_files").click();
        var img = $(this).parent().parent().parent().find(".img");
        var id = $(this).attr("data-id");
        $("#upt_files").change(function(){
            img.attr("src",getObjectURL(this.files[0]));
            $("#banner_id").val(id);
        })
    })
    //删除图片
    $(".del").live("click",function(){
        if(confirm('确定删除此图片吗？')){
            var id = $(this).attr("data-id");
            var frm = document.getElementById('form');
                frm.action='phone_banner_delss/id/'+id;
                frm.submit();
        }
    })
})