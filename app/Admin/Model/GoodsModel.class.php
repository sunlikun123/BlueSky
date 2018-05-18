<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class GoodsModel extends RelationModel{
	protected $_link=array(
		'goods_cate' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'goods_cate',
			'foreign_key'   => 'news_columnid',
			'as_fields'  => 'title',
		),
	);

}
?>