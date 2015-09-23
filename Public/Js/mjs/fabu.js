document.onkeydown=function() 
{ 
str=content.value.replace(/[^x00-xff]/g,"aa")
b.innerHTML="最少5个字,还可以输入"+(1000-str.length)+"字"
if(str.length+1>150) 
{ 
content.style.overflow="visible" 
} 
};


$(function(){ 
$("#second").hide(); //初始化的时候第二个下拉列表隐藏 
$("#first").change(function(){ //当第一个下拉列表变动内容时第二个下拉列表将会显示 
var parentId=$("#first").val(); 
if(null!= parentId && ""!=parentId){ 
$.getJSON("/index.php/member/publish/class2",{class1:parentId},function(myJSON){
var options=""; 
if(myJSON.length>0){ 
options+="<option value=''>=次分类=</option>"; 
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
if(document.myform.content.value.length<5)
	{
	    alert("信息详情最少5个字哦!");
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
var obj=document.getElementById("content");
obj.value=obj.value.replace(/\n/g,"<br>"); //回车换行

}