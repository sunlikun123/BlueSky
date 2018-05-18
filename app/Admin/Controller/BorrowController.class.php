<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AuthController;

class BorrowController extends AuthController {
    
    public function index() {
        $rs=D('Borrow');
        $count= $rs->where($map)->count();// 查询满足要求的总记录数
        $Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $this->assign('page',$show);
        $listRows=(intval(C('DB_PAGENUM'))>0)?C('DB_PAGENUM'):20;
        if($count>$listRows){
                $Page->setConfig('theme','<div class=pagination><ul> %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%</ul></div>');
        }
        $show= $Page->show();// 分页显示输出
        $this->assign('page_min',$show);
        $news=$rs->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('isback asc,id desc')->relation(true)->select();
        $this->assign('news',$news);
        $this->display();
    }
    
    public function back() {
        if (!IS_AJAX){
                $this->error('提交方式不正确',U('index'),0);
        }
        $id = I("id"); 
        $news=M('borrow');
        $data = array(
            'back_time'=>time(),
            'isback'=>1,
        );
        $rst = $news->where('id='.$id)->save($data);  //修改记录
        //修改图书库存 +1
        M('books')->where('n_id='.I('bookid'))->setInc('books_num'); 
        if($rst!==false){
                $this->success('返回成功,返回列表页',U('index'),1);
        }else{
                $this->error('返还失败',U('index'),0);
        }
    }
    
}