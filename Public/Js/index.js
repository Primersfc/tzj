$(function(){
	//频道页，内容页商品分类子类的显示与隐藏
	$('.all-goods .item').hover(function(){
		$(this).addClass('active').find('s').hide();
		$(this).find('.product-wrap').show();
	},function(){
		$(this).removeClass('active').find('s').show();
		$(this).find('.product-wrap').hide();
	});
	});
	$(document).ready(function(){
	//搜索输入不能为空
  $("a.search_btn").click(function(){
var words=$("input.search_input").val();
  if(words){document.Searchform.submit();
  }
  else{
  alert("搜索内容不能为空")
  }


  });
});
/*其他页面隐藏menu*/
window.onload = function ()
        { 
//分类菜单的显示隐藏                                                                

            var oDiv3 = document.getElementById('all-class');
			if(oDiv3 != null)
			{
            var oDiv4 = document.getElementById('all-goods');
            var timer2 = null;//定义定时器变量
            //鼠标移入div1或div2都把定时器关闭了，不让他消失
            oDiv3.onmouseover = oDiv4.onmouseover = function ()
            {	$("i#iarrow").attr("class","glyphicon glyphicon-chevron-up");
                oDiv4.style.display = 'block';
                clearTimeout(timer2);
            }
            //鼠标移出div1或div2都重新开定时器，让他延时消失
            oDiv3.onmouseout = oDiv4.onmouseout = function ()
            {$("i#iarrow").attr("class","glyphicon glyphicon-chevron-down");
                //开定时器
                timer2 = setTimeout(function () { 
                    oDiv4.style.display = 'none'; },300);
            }
			}
		}

/*首页幻灯片切换设置*/
$(document).ready(function() {
	$('.slider').cycle({
		fx: 'scrollHorz',
		timeout: 4000,
		cleartype:  false, // disable cleartype corrections
		next: '.rightArrow2',
		prev: '.arrowLeft2',
		pager:  '.pager2'
	});
	$('#slideText').cycle({
		fx: 'fade',
		timeout: 3999,
		cleartype:  false, // disable cleartype corrections
		next: '.arrowLeft2',
		prev: '.rightArrow2',
		slideExpr: '.slide'
	});
	$('.small_PicBox').hover(function(){
		$(this).find('.boxHover').fadeIn();
		$(this).find('.boxHover span').animate({
			bottom: '0px'
		}, {queue:false});
	}, function(){
		$(this).find('.boxHover').fadeOut();
		$(this).find('.boxHover span').animate({
			bottom: '-36px'
		}, {queue:false});
	});
});
