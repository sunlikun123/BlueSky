<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace Common\Controller;
use Think\Controller;
class CommonController extends Controller{
	protected function _initialize(){
		if (!file_exists('./data/install.lock')) {
            //不存在，则进入安装
            header('Location: ' . U('Install/index/index'));
            exit();
        }
	}
    //空操作
    public function _empty(){
        $this->error('此操作无效');
    }
}