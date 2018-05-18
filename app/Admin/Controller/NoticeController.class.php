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

class NoticeController extends AuthController {
    protected function _initialize(){
		parent::_initialize();
        $sys=M('options')->where(array('option_name'=>'site_options'))->getField("option_value");
        $sys=json_decode($sys,true);
		$arr=list_file(APP_PATH.'Home/View/'.$sys['site_tpl'],'*.html');
		$tpls=array();
		foreach($arr as $v){
			$tpls[]=basename($v['filename'],'.html');
		}
		$this->tpls=$tpls;
    }
	//文章列表
	public function news_list(){
		$key=I('key');
            $map['title']= array('like',"%".$key."%");
            $rs=M('notice');
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
		$news=$rs->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('n_id desc')->select();
		
		$this->assign('keytype',$keytype);
		$this->assign('keyy',$key);
		$this->assign('sldate',$sldate);
		$this->assign('news',$news);
		$this->display();
	}

	//添加文章
	public function news_add(){
		$this->display();
	}
	//添加操作
	public function news_runadd(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('news_list'),0);
		}
		$news=M('notice');

		$sl_data=array(
			'title'=>I('title'),
			'content'=>htmlspecialchars_decode(I('content')),
			'create_at'=>time(),
		);

		$news->add($sl_data);
		$this->success('公告添加成功,返回列表页',U('news_list'),1);
	}

	public function news_edit(){
		$n_id = I('n_id');
		if (empty($n_id)){
			$this->error('参数错误',U('news_list'),0);
		}else{
			$news_list=M('notice')->where(array('n_id'=>I('n_id')))->find();
			$this->assign('news_list',$news_list);
			$this->display();
		}
	}
	public function news_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('news_list'),0);
		}
		$news=M('notice');
		$sl_data=array(
			'n_id'=>I('n_id'),
			'title'=>I('title'),
			'content'=>htmlspecialchars_decode(I('content')),
		);
		$rst=$news->save($sl_data);
		if($rst!==false){
			$this->success('公告修改成功,返回列表页',U('news_list'),1);
		}else{
			$this->error('公告修改失败',U('news_list'),0);
		}
	}

	public function news_del(){
		$p=I('p');
		$rst=M('notice')->where(array('n_id'=>I('n_id')))->delete();//删除
		if($rst){
			$this->success('删除公告成功！',U('news_list',array('p' => $p)),1);
		}else{
			$this -> error("删除公告失败！",U('news_list',array('p'=>$p)),0);
		}
	}
	

}