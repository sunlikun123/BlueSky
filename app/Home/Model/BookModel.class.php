<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class BookModel extends RelationModel{
    protected $_link=array(
        'borrow' => array(
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