<?php
/**
 评论视图模型
 */
class CommentViewModel extends ViewModel {
 public $viewFields = array( 
  'reply' => array('id','uid', 'article_id', 'pid', 'neirong', 'hfsj'),
  'member_user' => array('username', 'user_id','name', 'photo','qian','_on' => 'member_user.user_id=reply.uid', '_type' => "LEFT"),
  );
}
?>