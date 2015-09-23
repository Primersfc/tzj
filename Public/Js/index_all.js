

$(function() {
	// 频道页，内容页商品分类子类的显示与隐藏
	$('.all-goods .item').hover(function() {
		$(this).addClass('active').find('s').hide();
		$(this).find('.product-wrap').show();
	}, function() {
		$(this).removeClass('active').find('s').show();
		$(this).find('.product-wrap').hide();
	});
});
$(document).ready(function() {
	// 搜索输入不能为空
	$("a.search_btn").click(function() {
		var words = $("input.search_input").val();
		if (words) {
			document.Searchform.submit();
		} else {
			alert("搜索内容不能为空")
		}
	});
});
/* 其他页面隐藏menu */
window.onload = function() {
	// 分类菜单的显示隐藏

	var oDiv3 = document.getElementById('all-class');
	if (oDiv3 != null) {
		var oDiv4 = document.getElementById('all-goods');
		var timer2 = null;// 定义定时器变量
		// 鼠标移入div1或div2都把定时器关闭了，不让他消失
		oDiv3.onmouseover = oDiv4.onmouseover = function() {
			$("i#iarrow").attr("class", "glyphicon glyphicon-chevron-up");
			oDiv4.style.display = 'block';
			clearTimeout(timer2);
		}
		// 鼠标移出div1或div2都重新开定时器，让他延时消失
		oDiv3.onmouseout = oDiv4.onmouseout = function() {
			$("i#iarrow").attr("class", "glyphicon glyphicon-chevron-down");
			// 开定时器
			timer2 = setTimeout(function() {
				oDiv4.style.display = 'none';
			}, 300);
		}
	}
}

/* 首页幻灯片切换设置 */
$(document).ready(function() {
	$('.slider').cycle({
		fx : 'scrollHorz',
		timeout : 4000,
		cleartype : false, // disable cleartype corrections
		next : '.rightArrow2',
		prev : '.arrowLeft2',
		pager : '.pager2'
	});
	$('#slideText').cycle({
		fx : 'fade',
		timeout : 3999,
		cleartype : false, // disable cleartype corrections
		next : '.arrowLeft2',
		prev : '.rightArrow2',
		slideExpr : '.slide'
	});
	$('.small_PicBox').hover(function() {
		$(this).find('.boxHover').fadeIn();
		$(this).find('.boxHover span').animate({
			bottom : '0px'
		}, {
			queue : false
		});
	}, function() {
		$(this).find('.boxHover').fadeOut();
		$(this).find('.boxHover span').animate({
			bottom : '-36px'
		}, {
			queue : false
		});
	});
});

$(document).ready(function() {
	$('.sidelist').mousemove(function() {
		$(this).find('.i-list').show();
		$(this).find('.navlistk a').addClass('lanmuhover');
	});
	$('.sidelist').mouseleave(function() {
		$(this).find('.i-list').hide();
		$(this).find('.navlistk a').removeClass('lanmuhover');
	});
});

$(function() {
	$(".qg_content p:odd").addClass("p03"); // 隔行换色处，额数行增加样式P03

	// 鼠标经过样式变化处
	$(".qg_content p").hover(function() {
		$(this).addClass("p02"); // 鼠标经过时增加样式P02
	}, function() {
		$(this).removeClass("p02"); // 鼠标离开时移除样式P02
	})

	// 超链接无虚线框处
	$("a").focus(function() {
		$(this).blur(); // 得到焦点与失去焦点效果一致
	})
})

$(function() {

	// 执行瀑布流
	var $container = $('#picload');

	var loading = $("#loading").data("on", false);
	$(window)
			.scroll(
					function() {
						var nextrow = $("#nextrow").val(); // 下次加载从nextrow条开始
						if (loading.data("on"))
							return;
						if ($(document).scrollTop() > $(document).height()
								- $(window).height() - $('.footer').height()) {
							// 加载更多数据
							loading.data("on", true).fadeIn();
							$
									.get(
											"/index.php/Index/index/getxia",
											{
												"id" : $container.find(
														".item:last")
														.attr("id"),
												"nextrow" : nextrow
											},
											function(data) {
												if (data == 1) {
													$("#loading")
															.html(
																	'<span class="loadings">无更多信息</span>');
												} else {
													$("#nextrow")
															.val(
																	parseInt(nextrow) + 12); // 每次加载12条
													var html = "", item;
													if ($.isArray(data)) {
														for (i in data) {
															item = data[i];
															html += '<div id="'
																	+ item.article_id
																	+ '"  class="item"><div class="thumbnail">';
															html += '<div class="stickyImg"  ><a  href="index.php/Index/Article/index/articleid/'
																	+ item.article_id
																	+ '" ><img src="'
																	+ item.imgs
																	+ '"></a></div>';
															html += '<div class="caption"><div class="stickyContent"><h3 class="stickyTitle">['
																	+ item.leixing
																	+ ']<a href="index.php/Index/Article/index/articleid/'
																	+ item.article_id
																	+ '">'
																	+ item.biaoti
																	+ '</a></h3></div>';
															html += '<div style="height: 15px;"><div style="float:left;">'
																	+ item.diqu
																	+ '|'
																	+ item.fbsj
																	+ '</div><div style="float:right;"><a href="#" class=" l">'
																	+ item.name
																	+ '</a></div></div></div>';
															if (item.jiage != '') {
																html += '<span class="date">'
																		+ item.jiage
																		+ '元</span></div></div>';
															}
															html += '</div></div>';

														}
														var $newElems = $(html)
																.appendTo(
																		$container);
														loading.data("on",
																false);
													}
													loading.fadeOut();
												}
											}, 'json');
						}
					});
})


// 微信弹出框暂时无用
function showdiv() {
	document.getElementById("wxshow").style.display = "block";
}
function hidediv() {
	document.getElementById("wxshow").style.display = 'none';
}

/* 栏目move */
function wave_move() {
	if ($('#commend').hasClass("cur")) {
		$('#commend').mouseover(function() {
			$('#wave_w').animate({
				left : "32px"
			}, 300);
		});

		$('#new_pro').mouseover(function() {
			$('#wave_w').animate({
				left : "160px"
			}, 300);
		});

		$('#new_pro').mouseleave(function() {
			$('#wave_w').animate({
				left : "32px"
			}, 300);
		});
	}

}

$(function(){
	function navscroll(){
		$(window).scroll(function(){

				        //获取窗口的滚动条的垂直位置

				        var s = $(window).scrollTop();

				        //当窗口的滚动条的垂直位置大于页面的最小高度时，让返回顶部元素渐现，否则渐隐

				        if( s > 71){

				        	$(".header-wrap").addClass("narrow");
				        	 $(".search-tag").addClass("hidden");

				        }else{

				            $(".header-wrap").removeClass("narrow");
				            $(".search-tag").removeClass("hidden");
				        };

				    });
		};
	
	
	
	
	
	function gotoTop(min_height){

	    //预定义返回顶部的html代码，它的css样式默认为不显示

	    var gotoTop_html = '<div id="gotoTop">返回顶部</div>';

	    //将返回顶部的html代码插入页面上id为page的元素的末尾

	    $("body").append(gotoTop_html);

	    $("#gotoTop").click(//定义返回顶部点击向上滚动的动画

	        function(){ $('html,body').animate({scrollTop:0},700);

	    }).hover(//为返回顶部增加鼠标进入的反馈效果，用添加删除css类实现

	        function(){ $(this).addClass("hover");},

	        function(){ $(this).removeClass("hover");

	    });



	    //获取页面的最小高度，无传入值则默认为600像素

	    min_height ? min_height = min_height : min_height = 600;

	    //为窗口的scroll事件绑定处理函数

	    $(window).scroll(function(){

	        //获取窗口的滚动条的垂直位置

	        var s = $(window).scrollTop();

	        //当窗口的滚动条的垂直位置大于页面的最小高度时，让返回顶部元素渐现，否则渐隐

	        if( s > min_height){

	            $("#gotoTop").fadeIn(100);

	        }else{

	            $("#gotoTop").fadeOut(200);
	        };

	    });

	};
	gotoTop();
	navscroll();
})