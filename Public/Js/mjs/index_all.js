

$(function(){
		
			
		
		
	    //执行瀑布流
	    var $container = $('#picload');

		var loading = $("#loading").data("on", false);
		$("#loading").click(function(){
			var nextrow=$("#nextrow").val();	//下次加载从nextrow条开始	
			if(loading.data("on")) return;
				//加载更多数据
				loading.data("on", true).fadeIn();
				$.get(
					"/index.php/Index/index/getxia", 
					{"id" : $container.find(".item:last").attr("id"),
						"nextrow":nextrow
					},
					function(data){
						if(data==1){
							$("#loading").html('<span class="loadings">无更多信息</span>');
						}else{
							$("#nextrow").val(parseInt(nextrow)+12);	//每次加载12条
							var html = "",item;
							if($.isArray(data)){
								for(i in data){
									item = data[i];
									html += '<div id="' + item.article_id + '"  class="item"><div class="thumbnail">';
									html += '<div class="stickyImg"  ><a class="img" href="index.php/Index/Article/index/articleid/' + item.article_id + '" ><img src="' + item.imgs + '"></a></div>';
									html += '<div class="caption"><div class="stickyContent"><h3 class="stickyTitle"><font style="color:#f40;">['+ item.leixing  +']</font><a href="index.php/Index/Article/index/articleid/' + item.article_id + '">' + item.biaoti + '</a></h3></div>';
									html += '<div style="height: 15px;"><div style="float:right;">' + item.diqu + '|' + item.fbsj  + '</div></div></div>';
									if(item.jiage != ''){
									html += '<span class="date">'+ item.jiage +'元</span></div></div>';
									}
									html += '</div></div>';
								}
								var $newElems = $(html).appendTo($container);
						        loading.data("on", false);
							}
						
						}
					}
				,'json'
				);
		});
	})


