<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class GoodslogModel extends RelationModel{
	protected $_link=array(
		'goods' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'goods',
			'foreign_key'   => 'goods_id',
			'as_fields'  => 'news_title',
		),
	);

}
?>