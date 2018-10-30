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
$(document).ready(function(){
    var i =0;
    $("#shangchuan").toggle(function(){
        $("#fileImage").click();
        $("#fileImage").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $("#fileImage2").click();
        $("#fileImage2").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $("#fileImage3").click();
        $("#fileImage3").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $("#fileImage4").click();
        $("#fileImage4").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $("#fileImage5").click();
        $("#fileImage5").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $("#fileImage6").click();
        $("#fileImage6").change(function(){
            $("#preview > span").hide();
            $("#preview").append("<img class='sc' title='"+$(this).val()+"'>")
            $(".sc").eq(i).attr("src",getObjectURL(this.files[0]));
            $("#number").text(i+1);
            i++;
        })
    },function(){
        $(this).hide();
    })
})



