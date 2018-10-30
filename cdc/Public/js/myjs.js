/**
 * Created by liuwei on 2016/4/22.
 */
$(function(){
    /*#nav#*/
    $(".fr li").mouseover(function(){
        $(this).children().find("span").css({"transform":" rotate(180deg)","transition":"transform .2s"});
    }).mouseout(function(){
        $(this).children().find("span").css({"transform":" rotate(0deg)","transition":"transform .2s"});
    });

    /*#时钟#*/
    var n=0;m=0;q=0;
    function RotateIcon1(){
        n++;
        deg1=n*360;
         $(".jd-clock-s").css({"transform":"rotate("+deg1+"deg)","transition":"transform 15s linear"});
    }
    RotateIcon1();
   setInterval(RotateIcon1,15000);
    function RotateIcon2(){
        m++;
        deg1=m*360;
        $(".jd-clock-h").css({"transform":"rotate("+deg1+"deg)","transition":"transform 50s linear"});
    }
    RotateIcon2();
    setInterval(RotateIcon2,50000);
    function RotateIcon3(){
        q++;
        deg1=q*360;
        $(".jd-clock-m").css({"transform":"rotate("+deg1+"deg)","transition":"transform 25s linear"});

    }
    RotateIcon3();
    setInterval(RotateIcon3,25000)
});
/*切换图片*/
      $(function(){
			$(".lh li").mouseover(function(){
					$(".lh li").children().removeClass("img-hover");
					$(this).children().addClass("img-hover");
					var num=$(this).children().attr("src");
					$("#spec-n1").children().attr("src",num);
				})
	   })
   
    /*商品详情*/
        $(function(){
            $("#detail-tab-comm").click(function(){
                $("#parameter2").css("display","none");
                $("#parameter3").css("display","block");
                $("#detail-tab-intro").removeClass("curr");
                $("#detail-tab-comm").addClass("curr")
             });
             $("#detail-tab-intro").click(function(){
                $("#parameter2").css("display","block");
                $("#parameter3").css("display","none");
                $("#detail-tab-intro").addClass("curr");
                $("#detail-tab-comm").removeClass("curr")
              })  
         })  
         
        /*选择商品*/
        $(function(){
           $("#choose-suit .dd .item").click(function(){
             $(".item").removeClass("selected");
             $(this).addClass("selected"); 
           
           })
        })
          
    
        /*搜索框*/
  function SetUrl(url,key, value) {
  var uri=url.replace('#','');
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    uri= uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    uri=uri + separator + key + "=" + value;
  }
   window.location.href=uri;
 }
 
 function linkClick(){
      var search=encodeURI(document.getElementById("searchProduct").value);
      SetUrl('/PCmaster/products','searchtext',search+ "&searchmode=anyword");
     // window.location.href="/PCmaster/products?searchtext=" +search+ "&searchmode=anyword";
   }     
$(function(){
$('#search').keydown(function(e){
         if(e.keyCode==13){
            SetUrl('/PCmaster/products',"searchtext",  encodeURI($('#searchProduct').val()));
              return false;
           }
    });


 })       
        
        