/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-04-11 21:02:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yf_books
-- ----------------------------
DROP TABLE IF EXISTS `yf_books`;
CREATE TABLE `yf_books` (
  `n_id` int(36) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL COMMENT '图书标题',
  `news_columnid` int(11) NOT NULL COMMENT '所属分类ID',
  `news_columnviceid` int(11) DEFAULT NULL COMMENT '副栏目ID',
  `news_key` varchar(100) NOT NULL COMMENT '文章关键字',
  `news_tag` varchar(50) NOT NULL DEFAULT '' COMMENT '文章标签',
  `news_auto` varchar(255) NOT NULL COMMENT '图书作者',
  `news_source` varchar(20) NOT NULL DEFAULT '未知' COMMENT '来源',
  `news_content` longtext NOT NULL COMMENT '新闻内容',
  `news_scontent` varchar(200) NOT NULL DEFAULT '',
  `news_hits` int(11) NOT NULL DEFAULT '200' COMMENT '点击率',
  `news_like` int(11) unsigned DEFAULT '0' COMMENT '收藏数',
  `news_img` varchar(100) DEFAULT '' COMMENT '大图地址',
  `news_pic_type` tinyint(2) NOT NULL COMMENT '1=普通模式 2=腾讯模式',
  `news_pic_allurl` text COMMENT '多图路径',
  `news_pic_content` longtext COMMENT '多图对应文字说明',
  `news_time` int(11) NOT NULL,
  `news_modified` int(11) unsigned DEFAULT '0' COMMENT '修改时间',
  `news_flag` set('h','c','f','a','s','p','j','d','cp') NOT NULL DEFAULT '' COMMENT '文章属性',
  `news_zaddress` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `news_cpprice` double NOT NULL DEFAULT '0' COMMENT '产品价格',
  `news_back` int(2) NOT NULL DEFAULT '0' COMMENT '是否为回收站',
  `news_open` varchar(2) DEFAULT '0' COMMENT '0代表审核不通过 1代表审核通过',
  `news_lvtype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '旅游类型1=行程 2=攻略',
  `news_extra` text COMMENT '扩展字段，json',
  `books_price` decimal(10,2) DEFAULT NULL COMMENT '图书价格',
  `books_num` int(11) unsigned DEFAULT '0' COMMENT '库存',
  PRIMARY KEY (`n_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yf_books
-- ----------------------------
INSERT INTO `yf_books` VALUES ('1', '读者', '4', null, '', '', '读者', '读者出版社', '', '读者，就是读者', '200', '0', '/data/upload/2017-04-09/58e9df1fbc17e.jpg', '1', '', '', '1491722015', '0', 'h,c', '', '0', '0', '1', '0', null, null, '7');
INSERT INTO `yf_books` VALUES ('2', '', '0', null, '', '', '1', '', '', '', '200', '0', null, '0', null, '', '1491809309', '0', 'c', '', '0', '1', '', '0', null, null, null);
