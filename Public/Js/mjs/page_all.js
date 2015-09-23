$(function(){   
    $("#loveit").click(function(){   
        var love = $(this);   
        var id = love.attr("rel"); //对应id   
        love.fadeOut(300); //渐隐效果   
        $.ajax({   
            type:"POST",   
            url:"/index.php/index/article/love",   
            data:"id="+id,   
            cache:false, //不缓存此页面   
            success:function(data){   
                love.html(data);   
                love.fadeIn(300); //渐显效果   
            }   
        });   
        return false;   
    }); 
});
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

$(function(){	
				
	    var form = $('.cmt-item:last');
	    //插入回复表单
	    $('.cmt-box').delegate('.reply-btn','click',function(event){
	        var parent = $(this).closest('.cmt-item');
	        //写入对应回复ID
	        form.find(':hidden[name=pid]').val($(this).attr('reply'));
	        var textarea = parent.append(form).find('textarea');
	        //对回复回复的处理
	        if($(this).attr('at-user') == 'true'){
				var uname = $(this).parent().find('.uname').text();
				textarea.text('回复 ' + uname + ' : ');
		    }else{
		    	textarea.text('');
			}
	        moveEnd(textarea.get(0));
	        event.stopPropagation();
	    })
	    $('.cmt-box').delegate('.cmt-item','click',function(event){
	        $(this).has('form').length && event.stopPropagation();
	    })
	    //点击评论框以外的地方，重置评论表单
	    $(document).click(function(){
		    if(form.find(':hidden[name=pid]').val() != 0){
		    	$('.reform').after($('.cmt-box').find('form'));
		        form.find(':hidden[name=pid]').val(0);
		        form.find('textarea').text('');
			}
	    })
	    //快捷键提交评论ok
	    $("#reviewForm").find('textarea').on("keydown", function(e){
	    	e.stopPropagation();
	    	if(e.ctrlKey && e.which ==13){
	    		$('#reviewForm').submit();
	    	}
	    });
	    //删除评论绑定事件
	    $('.cmt-box').delegate('.delete-review','click',function(event){
	    	var self = $(this);
		    var id = self.attr('review_id');
		    $.ThinkBox.confirm('确定删除吗？',
				{'cancel' : function(){this.hide();},
				 'ok' : function(){
					this.hide();
					$.post(
						'/review/deleteReview',
						{'id':id},
						function(data){
							if(data.status == 1){
								$.ThinkBox.success(data.info);
								setTimeout(function(){window.location.reload();}, 2000);
							}else{
								$.ThinkBox.error(data.info);
							}
						},
						'json'
					);
				 },
				 'drag' : true,
				 'modal' : true
				}
			 );
		    
		});
	})
	
//将光标移动到textarea末尾,保持pid不被click清除
	function moveEnd(obj){
		obj.focus(); 
	    var len = obj.value.length;
	    if (document.selection) {
	        var sel = obj.createTextRange(); 
	        sel.moveStart('character',len); 
	        sel.collapse(); 
	        sel.select(); 
	    } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
	        obj.selectionStart = obj.selectionEnd = len; 
	    } 
	}
	