$(function() {
    /*focus轮播图*/
    (function() {
        var icur = 0;
        var now = 0;
        var otimer = null;
        $('#focus .slider-panel').eq(0).css({
            'opacity': 1,
            'zIndex': 1
        });
        var timer = setInterval(function() {
            $('#focus .slider-next').click();
        }, 3000);
        //自动
        $('#focus .slider').mouseover(function() {
            $('#focus .slider-next').show();
            $('#focus .slider-prev').show();
            clearInterval(timer);
        }).mouseout(function() {
            $('#focus .slider-next').hide();
            $('#focus .slider-prev').hide();
            timer = setInterval(function() {
                $('#focus .slider-next').click();
            }, 3000);
        });
        //手动
        $('#focus .slider-prev').click(function() {
            now = icur - 1;
            if (now < 0) {
                now = 2;
            }
            clearInterval(otimer);
            fadein(now);
        });
        $('#focus .slider-next').click(function() {
            now = icur + 1;
            now %= 3;
            clearInterval(otimer);
            fadein(now);
        });
        $('#focus .slider-extra .slider-item').mouseover(function() {
            clearInterval(otimer);
            fadein($(this).index());
        });

        function fadein(inow) {
            if (icur == inow) {
                return;
            }
            otimer = setTimeout(function() {
                $('#focus .slider-panel').eq(icur).animate({
                    'opacity': 0,
                    'zIndex': 0
                }, 400, 'swing');
                $('#focus .slider-item').eq(icur).removeClass('slider-selected');
                icur = inow;
                $('#focus .slider-panel').eq(icur).animate({
                    'opacity': 1,
                    'zIndex': 1
                }, 400, 'swing');
                $('#focus .slider-item').eq(icur).addClass('slider-selected');
            }, 300);
        }
    })();


    /*clothes选项卡*/
    (function() {
        $(".tab .tab-item").mouseover(function(){
            $(this).addClass("tab-selected").siblings().removeClass("tab-selected");
            var i = $(this).index();
            var s=$(this).parent(".tab").parent(".mt").next(".mc").children(".Floor-right:eq("+i+")");
            s.addClass("Floor-right-show").show().siblings(".Floor-right").removeClass("Floor-right-show").hide();
           if(s.attr("loaded")!="1")
           {
           // console.log($(this).attr("idpath"));
            s.attr("loaded","1");          
            $.get('/ajax/getproduct',{idpath:$(this).attr("idpath")},function(data){
                 if(data!=null)
                   {               
                      s.append(data);
                   }              
             });       
           }
          
        });
    })();
});
