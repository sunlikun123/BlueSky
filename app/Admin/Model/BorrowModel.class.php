<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class BorrowModel extends RelationModel{
	protected $_link=array(
		'books' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'books',
			'foreign_key'   => 'bookid',
			'as_fields'  => 'news_title',
		),
            'member_list' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'member_list',
			'foreign_key'   => 'userid',
			'as_fields'  => 'member_list_username',
		),
	);

}
?>