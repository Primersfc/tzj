<?php
/**
 * 自定义文章模型类
 * @author  <[c@easycms.cc]>
 */
class ArticleModel extends RelationModel{
	
	protected $_link = array(
	            'Category'=>array(
                    'class_name'    =>'Category',
	            	'mapping_type'=>BELONGS_TO,
	                'foreign_key'=>'cid',
                    'mapping_name'=>'fenlei',
	             	'mapping_fields'=>'name',
               ),
			'member_user'=>array(
					'class_name'    =>'member_user',
					'mapping_type'=>BELONGS_TO,
					'foreign_key'=>'uid',
					'mapping_name'=>'user',
					'mapping_fields'=>'username,name',
			),
	);
	
	protected $_auto = array( 
		array("pubtime","time","1","function"),
	);
}
