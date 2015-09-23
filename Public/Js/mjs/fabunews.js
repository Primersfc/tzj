
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
