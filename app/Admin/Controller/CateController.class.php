<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Common\Controller\AuthController;
use Think\Db;
use Think\Auth;
use OT\Database;
use Org\Util\Stringnew;

/**
 * Description of CateController
 *
 * @author m
 */
class CateController  extends AuthController {
    
    public function cate_list(){
		$nav = new \Org\Util\Leftnav;
		$admin_rule=M('cate')->order('sort')->select();

		$arr = $nav::rule($admin_rule);
		$this->assign('admin_rule',$arr);//权限列表
		$this->display();
	}
	//权限添加
	public function admin_rule_runadd(){
		if(!IS_AJAX){
			$this->error('提交方式不正确',U('cate_list'),0);
		}else{
			$admin_rule=M('cate');
			$pid=$admin_rule->where(array('id'=>I('pid')))->field('level')->find();
			$level=$pid['level']+1;
			$sldata=array(
				'title'=>I('title'),
				'status'=>I('status'),
				'sort'=>I('sort'),
				'addtime'=>time(),
				'pid'=>I('pid'),
				'level'=>$level,
			);
			$admin_rule->add($sldata);
			clear_cache();
			$this->success('分类添加成功',U('cate_list'),1);
		}
	}

	public function admin_rule_state(){
		$id=I('x');
		$statusone=M('cate')->where(array('id'=>$id))->getField('status');//判断当前状态情况
		if($statusone==1){
			$statedata = array('status'=>0);
			$auth_group=M('cate')->where(array('id'=>$id))->setField($statedata);
			clear_cache();
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('status'=>1);
			$auth_group=M('cate')->where(array('id'=>$id))->setField($statedata);
			clear_cache();
			$this->success('状态开启',1,1);
		}

	}

	public function cate_order(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('cate_list'),0);
		}else{
			$auth_rule=M('cate');
			foreach ($_POST as $id => $sort){
				$auth_rule->where(array('id' => $id ))->setField('sort' , $sort);
			}
			clear_cache();
			$this->success('排序更新成功',U('cate_list'),1);
		}
	}

	public function cate_edit(){
		//全部规则
		$nav = new \Org\Util\Leftnav;
		$admin_rule_all=M('cate')->order('sort')->select();
		$arr = $nav::rule($admin_rule_all);
		$this->assign('cate',$arr);
		//待编辑规则
		$admin_rule=M('cate')->where(array('id'=>I('id')))->find();
		$this->assign('rule',$admin_rule);
		$this->display();
	}
	public function cate_runedit(){
		if(!IS_AJAX){
			$this->error('提交方式不正确',U('cate_list'),0);
		}else{
			$admin_rule=M('cate');
			$pid=$admin_rule->where(array('id'=>I('pid')))->field('level')->find();
			$level=$pid['level']+1;
			$sldata=array(
				'id'=>I('id',1,'intval'),
				'title'=>I('title'),
				'status'=>I('status'),
				'pid'=>I('pid',0,'intval'),
				'sort'=>I('sort'),
				'level'=>$level,
			);
			//dump($sldata);
			$rst=$admin_rule->save($sldata);
			if($rst!==false){
				clear_cache();
				$this->success('分类修改成功',U('cate_list'),1);
			}else{
				$this->error('分类修改失败',U('cate_list'),0);
			}
		}
	}

	public function cate_del(){
        //TODO 自动删除子权限
		$rst=M('cate')->where(array('id'=>I('id')))->delete();
        if($rst!==false){
			clear_cache();
            $this->success('分类删除成功',U('cate_list'),1);
        }else{
            $this->error('分类删除失败',U('cate_list'),0);
        }
	}
}
