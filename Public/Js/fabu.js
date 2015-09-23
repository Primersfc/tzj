
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('textarea[name="content"]', {
            resizeType: 1,
            uploadJson: '/index.php/member/upper/edituppic',
            fileManagerJson: '/editor/php/file_manager_json.php',
             afterChange : function() {
      K('.word_count2').html(this.count('text')); 
      var limitNum = 1000;
      var pattern = '还可以输入' + limitNum + '字'; 
      K('.word_surplus').html(pattern);
      if(this.count('text') > limitNum) {
       pattern = ('字数超过限制，请适当删除部分内容');
       var strValue = editor.text();
       strValue = strValue.substring(0,limitNum);
       editor.text(strValue);      
       } else {
       var result = limitNum - this.count('text'); 
       pattern = '还可以输入' +  result + '字'; 
       }
       K('.word_surplus').html(pattern);
      },

     
            items: [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'source']

        });
    });



var path='/App/Modules/Member/Tpl/default/Public';
var url='/index.php/member/publish';
var swfu;
window.onload = function () {
swfu = new SWFUpload({
upload_url: "/index.php/member/publish/uploadImg",
post_params: {"PHPSESSID": "p5ikkjkr2hnb2e1l7dglom3824"},
file_size_limit : "5 MB",
file_types : "*.jpeg;*.jpg;*.png;*.bmp",
file_types_description : "JPG Images",
file_upload_limit : "5",
//file_queue_error_handler : fileQueueError,数量超过五个提示待修改
file_dialog_complete_handler : fileDialogComplete,
upload_progress_handler : uploadProgress,
upload_error_handler : uploadError,
upload_success_handler : uploadSuccess,
upload_complete_handler : uploadComplete,
button_image_url : "/App/Modules/Member/Tpl/default/Public/images/upload.png",
button_placeholder_id : "spanButtonPlaceholder",
button_width: 113,
button_height: 33,
button_text : '',
button_text_style : '.spanButtonPlaceholder { font-family: Helvetica, Arial, sans-serif; font-size: 14pt;} ',
button_text_top_padding: 0,
button_text_left_padding: 0,
button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
button_cursor: SWFUpload.CURSOR.HAND,
flash_url : "/App/Modules/Member/Tpl/default/Public/swf/swfupload.swf",
custom_settings : {
upload_target : "divFileProgressContainer"
},
debug: false
});
};


$(function(){ 
$("#second").hide(); //初始化的时候第二个下拉列表隐藏 
$("#first").change(function(){ //当第一个下拉列表变动内容时第二个下拉列表将会显示 
var parentId=$("#first").val(); 
if(null!= parentId && ""!=parentId){ 
$.getJSON("/index.php/member/publish/class2",{class1:parentId},function(myJSON){
var options=""; 
if(myJSON.length>0){ 
options+="<option value=''>==请选择次分类==</option>"; 
for(var i=0;i<myJSON.length;i++){ 
options+="<option value="+myJSON[i].id+">"+myJSON[i].class2+"</option>"; 
} 
$("#area").html(options); 
$("#second").show(); 
} 
else if(myJSON.length<=0){ 
$("#second").hide(); 
} 
}); 
} 
else{ 
$("#second").hide(); 
}

});  
}); 

function CheckForm()
{
if(document.myform.class1.value=="")
	{
	    alert("请选择主分类!");
        document.myform.class1.focus();
        return false;
	}
if(document.myform.class2.value=="")
	{
	    alert("请选择次分类!!");
        document.myform.class2.focus();
        return false;
	}
if(document.myform.leixing.value.length<1)
	{
	    alert("请选择信息类别!");
        document.myform.leixing.focus();
	    return false;
	}
if(document.myform.diqu.value.length<1)
	{
	    alert("请选择校区!");
        document.myform.diqu.focus();
	    return false;
	}
if(document.myform.biaoti.value.length<3)
	{
	    alert("信息标题没有填写或内容太少!");
        document.myform.biaoti.focus();
        document.myform.biaoti.select();
	    return false;
	}
	if (document.myform.dianhua.value.length == 0 && document.myform.qq.value.length == 0) {
	    alert("电话QQ至少填一项！");
	    document.myform.dianhua.focus();
	    document.myform.dianhua.select();
	    return false;
	}

}