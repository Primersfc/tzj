$(function () {
    $(".qg_content p:odd").addClass("p03");  //隔行换色处，额数行增加样式P03

    //鼠标经过样式变化处
    $(".qg_content p").hover(
                function () {
                    $(this).addClass("p02");   //鼠标经过时增加样式P02
                },
                function () {
                    $(this).removeClass("p02"); //鼠标离开时移除样式P02
                }
            )

    //超链接无虚线框处
    $("a").focus(
                function () {
                    $(this).blur(); //得到焦点与失去焦点效果一致
                }
             )
})

//信息页聚光格子
$(document).ready(function(){
    $('.spotsidelist').mousemove(function(){
	$(this).find('.subclass').show();
	});
	$('.spotsidelist').mouseleave(function(){
	$(this).find('.subclass').hide();
	});
});



$(window).load(function(){
			var spotlight = {
				 // the opacity of the "transparent" images - change it if you like
				opacity : 0.3,


				
			};
			

			
			//when mouse over the list item...
			$('.spotlightWrapper2 ul li').hover(function(){
				
				//...find the image inside of it and add active class to it and change opacity to 1 (no transparency)
				
				
				//get the other list items and change the opacity of the images inside it to the one we have set in the spotlight array 
				$(this).siblings('li').find('img').animate({"opacity":"0.3"},100) ;
				$(this).find('img').addClass('active').animate({"opacity":"1"},100) ;
				//when mouse leave...
			}, function(){
				
				//... find the image inside of the list item we just left and remove the active class
				$(this).find('img').removeClass('active');
				
			});
			
			//when mouse leaves the unordered list...
			$('.spotlightWrapper2 ul').bind('mouseleave',function(){
				//find the images and change the opacity to 1 (fully visible)
				$(this).find('img').animate({"opacity":"1"},100) ;
			});
			

 	 	  var address;
 		   $(".pic-small img").mouseover(function(){
 	       $(".pic-small img").removeClass("cur");
	        $(this).addClass("cur");
	        address=$(this).attr("src");
	        $(".bigger").attr({ src : address });
  			  });
			
		});
		////信息页聚光格子over
//卡片列表图片渐变
$(function(){	
	
	$(".stickyImg a").hover(function(){
		$(this).find("img").animate({"opacity":"0.65"},200)
	},function(){
		$(this).find("img").animate({"opacity":"1"},150)
	});
})
//橱窗图片渐变
$(function(){	
	$(".xxpic a").hover(function(){
		$(this).find("img").animate({"opacity":"0.65"},200)
	},function(){
		$(this).find("img").animate({"opacity":"1"},150)
	});
})