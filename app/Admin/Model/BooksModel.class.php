<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class BooksModel extends RelationModel{
	protected $_link=array(
		'cate' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'cate',
			'foreign_key'   => 'news_columnid',
			'as_fields'  => 'title',
		),
	);

}
?>