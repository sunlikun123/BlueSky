<?php
//DB连接设置
if(!file_exists($file="data/conf/db.php")){
	$file= "data/conf/db.default.php";
}
$configs_db=include ($file);
//默认配置
$configs= array(
	'LOAD_EXT_CONFIG' => '',//扩展第三方登录配置文件
	'SHOW_PAGE_TRACE'=>false,
	'URL_CASE_INSENSITIVE'=>true,
	'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',//error错误提示页面
	//数据库
	'DB_FIELD_CACHE'=>false,
	'HTML_CACHE_ON'=>false,
	'DB_PAGENUM'=> 10,//后台每页显示条数
	'DB_PATH_NAME'=> 'backup',        //备份目录名称,主要是为了创建备份目录
	'DB_PATH'     => './data/backup/',     //数据库备份路径必须以 / 结尾；
	'DB_PART'     => '20971520',  //该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
	'DB_COMPRESS' => '1',         //压缩备份文件需要PHP环境支持gzopen,gzwrite函数        0:不压缩 1:启用压缩
	'DB_LEVEL'    => '9',         //压缩级别   1:普通   4:一般   9:最高
	'DB_CHARSET'=> 'utf8', // 数据库编码
	'DB_DEBUG' => DB_DEBUG ? true : false,
	//权限认证
	'AUTH_CONFIG' => array(
		'AUTH_ON' => true, //是否开启权限
		'AUTH_TYPE' => 1, //
		'AUTH_GROUP' => $configs_db['DB_PREFIX'].'auth_group', //用户组
		'AUTH_GROUP_ACCESS' => $configs_db['DB_PREFIX'].'auth_group_access', //用户组规则
		'AUTH_RULE' => $configs_db['DB_PREFIX'].'auth_rule', //规则中间表
		'AUTH_USER' => $configs_db['DB_PREFIX'].'admin'// 管理员表
	),
	//路径相关
	  'TMPL_PARSE_STRING' => 
	  array (
		'__UPLOAD__' => __ROOT__.'/data/upload/',
		'__PUBLIC__' => __ROOT__.'/public',
		'__DATA__' => __ROOT__.'/data/',
		'__AVATAR__' => __ROOT__.'/data/image/avatar/',
		'__STATIC_ROOT__' => __ROOT__,
	  ),
	  'UPLOAD_TEMP_DIR' => './data/runtime/Data/',
	  'UPLOAD_DIR' => './data/upload/',
);
$configs=array_merge($configs,$configs_db);
//动态设置
if(!file_exists($file="data/conf/config.php")){
	$file= "data/conf/config.default.php";
}
$configs=array_merge($configs,include ($file));
return  $configs;
