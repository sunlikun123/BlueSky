<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Verify;
use Home\Controller\HomebaseController;
use Org\Util\Stringnew;
class BookController extends HomebaseController {
	public function index(){
            $cateid = I('id');
            if($cateid !=''){
                
                $where['news_columnid'] = $cateid;
            }else{
                $cateid = 0;
            }
            $book = M("books");
            $cate = M('cate')->where("level=2")->select();
            $where['news_back'] = 0;
            $count= $book->where($where)->count();// 查询满足要求的总记录数
            $Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
            $list=$book->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('n_id desc')->select();
//	    $list = M('books')->where($where)->limit(5)->select();
        $this->assign('cateid',$cateid);
	    $this->assign('hot',$list);
            $this->assign('cate',$cate);
            $this->display('index');
	}
        //加载更多
        public function more(){
            $cateid = I('id');
            if($cateid !=0){
                $where['news_columnid'] = $cateid;
            }
            $book = M("books");
            $p = I("p");
            $firstRow = ($p-1)*C('DB_PAGENUM');
            $where['news_back'] = 0;
            $count= $book->where($where)->count();// 查询满足要求的总记录数
            $Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
            $list=$book->where($where)->limit($firstRow.','.$Page->listRows)->order('n_id desc')->select();
            $this->ajaxReturn($list);
	}



        public function notice() {
            $list = M("notice")->order('n_id desc')->select();
            $this->assign('list',$list);
            $this->display();
        }
        public function noticedetail() {
            $id = I('id');
            if(!$id){
                $this->redirect('notice');
            }
            $list = M("notice")->where(array('n_id'=>$id))->find();
            $this->assign('list',$list);
            $this->display();
        }
        
	public function so()
	{
	    $input = I('so');
            $map['news_back'] = 0;  //w未删除的
	    $where['news_auto'] = array('like','%'.$input.'%');
	    $where['news_title'] =array('like','%'.$input.'%');
	    $where['_logic'] = 'or'; 
            
	    $map['_complex'] = $where;
	    $list = M('books')->where($map)->select();
//            var_dump(M()->getlastsql());
	    $this->assign('hot',$list);
//            dump($list);
	    $this->display();
	}
	public function hot()   //热门
	{
	    $where['news_back'] = 0;
	    $list = M('books')->where($where)->order("news_hits desc")->select();
	    $this->assign('hot',$list);
	    $this->display();
	}
	public function hotsell()  // 推荐
	{
	     //推荐，根据后台管理员是否设置推荐字段来进行设置

            $where['news_back'] = 0;
            $where['news_flag'] = array('like','%c%');
	    $booklist = M('books')->where($where)->order("n_id desc")->select();
	    
	    $this->assign('sell',$booklist);
	    $this->display();
	}
	/*
	 * 登录
	 */
	public function login()
	{
	     
	    $this->display();
	}
	/*
	 * 注册
	 */
	public function register()
	{
	    $this->display();
	}
	public function reg()
	{
	    $username = I('username');
	    $pass = I("pass");
	    $is = M("member_list")->where(array('member_list_username'=>$username))->find();
	    if ($is)
	    {
	        $data['status'] = false;
	        $this->ajaxReturn($data);
	    }
	    else
	    {
                $member_list_salt=Stringnew::randString(10);
	        $v['member_list_username'] = $username;
                $v['member_list_salt'] = $member_list_salt;
	        $v['member_list_pwd'] = encrypt_password($pass,$member_list_salt);
	        $v['member_list_addtime'] = time();
	        $add = M('member_list')->add($v);
	        if ($add)
	        {
	            $data['status'] = true;
	            $this->ajaxReturn($data);
	        }
	    }
	    
	   
	}
	/*
	 * 登录验证
	 */
	public function lg()
	{
	    $username = I('username');
	    $pass = I("pass");
	    $where['member_list_username'] = $username;
            $member=M("member_list")->where($where)->find();
	    $where['member_list_pwd'] = encrypt_password($pass,$member['member_list_salt']);
	    $is = M("member_list")->where($where)->getfield('member_list_id');
	    if (empty($is))
	    {
	        $data['status'] = false;
	        $this->ajaxReturn($data);
	    }
	    else
	    {
	        
	        session('user_id',$is);
            $data['status'] = true;
            $this->ajaxReturn($data);
	        
	    }
	     
	
	}
	/*
	 * 个人中心
	 */
	public function my()
	{
	    $this->check_login();
	    $id = session('user_id');
	    $member = M('member_list')->where(array('member_list_id'=>$id))->find();
	    $limit = M('member_group')->select();
	    foreach ($limit as $k=>$v)
	    {
	        if ($member['score'] <= $v['member_group_toplimit'])
	        {
	            $group_name = $v['member_group_name'];
	            break;
	        }
	            
	    }
	    $this->assign('nickname',$member['member_list_nickname']);
	    $this->assign('score',$member['score']);
	    $this->assign('headpic',$member['member_list_headpic']);
	    $this->assign('group',$group_name);
	    $this->display();
	}
	/*
	 * 退出登录
	 */
	public function logout()
	{
	   session('user_id',null);
	   $this->redirect('Book/login');
	}
    public function check_login(){
        $sid = session('user_id');
        //判断用户是否登陆
        if(!isset($sid ) ) {
            redirect(U('Book/login'));
        }

    }
    /*
     * 修改资料
     */
    public function edit()
    {
        
        $this->display();
    }
    /*
     * 保存修改资料
     */
    public function saveedit()
    {
        $sex = I('sex');
        $nickname = I('nickname');
        $upload = new \Think\Upload();// 实例化上传类 
        $upload->maxSize = 3145728 ;// 设置附件上传大小 
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './uploads/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录 // 上传文件
        $info = $upload->upload(); 
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError()); 
        }else{// 上传成功 获取上传文件信息
              $imgurl = '/uploads/'.$info['file']['savepath'].$info['file']['savename']; 
              $data['member_list_headpic'] = $imgurl;
              $data['member_list_nickname'] = $nickname;
              switch ($sex)
              {
                  case '男':
                      $data['member_list_sex'] = 1;
                      break;
                  case '女':
                      $data['member_list_sex'] = 2;
                      break;
                  default:
                      $data['member_list_sex'] = 3;
                      break;
              }
              M('member_list')->where(array('member_list_id'=>session('user_id')))->save($data);
              
        }
        $this->redirect('Book/my');
    }
    /*
     * 借阅记录
     */
    public function log(){
        $this->check_login();
        $borrowlist =  M('borrow')->where(array('userid'=>session('user_id')))->join('as a LEFT JOIN __BOOKS__ as b ON a.bookid = b.n_id')->select();
        $this->assign('loglist',$borrowlist);
        $this->display();
    }
    /*
     * 借阅
     */
    public function borrow()
    {
        $this->check_login();
        $bookid = I('bookid');
        $data['userid'] = session('user_id');
//        if(empty(session('user_id'))){
//            $result['status'] = 'nologin';
//            $this->ajaxReturn($result);
//            return FALSE;
//        }
        $data['bookid'] = $bookid;
        $data['borrow_time'] = time();
        $id = $borrowlist =  M('borrow')->add($data);
        if ($id)
        {
            $result['status'] = true;
            //更新库存
            $book_num = M('books')->where(array('n_id'=>$bookid))->getfield('books_num');
            //订阅次数+1
            $book_num = M('books')->where(array('n_id'=>$bookid))->setInc('news_hits');
            if($book_num=0){   //库存不足
                $data['status'] = false;
                $this->ajaxReturn($result);
                return FALSE;
            }
            M('books')->where(array('n_id'=>$bookid))->setDec('books_num');

            //更新积分   每次借阅都加1积分
            $score = M('member_list')->where(array('member_list_id'=>session('user_id')))->setInc('score');
            $this->ajaxReturn($result);
        }
        else 
        {
            $data['status'] = false;
            $this->ajaxReturn($result);
        }
    }
	public function visit(){
		$id=I("get.id");
		$users_model=M("member_list");
		$user=$users_model->where(array("member_list_id"=>$id))->find();
		if(empty($user)){
			$this->error("查无此人！",0,0);
		}
		$this->assign($user);
		$this->display("User:index");
    }
	public function verify_msg()
    {
		ob_end_clean();
		$verify = new Verify (array(
            'fontSize' => 20,
            'imageH' => 40,
            'imageW' => 150,
            'length' => 4,
            'useCurve' => false,
        ));
        $verify->entry('msg');
    }
	public function addmsg(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',0,0);
		}else{
			$verify =new Verify ();
			if (!$verify->check(I('verify'), 'msg')) {
				$this->error('验证码错误',0,0);
			}
			$data=array(
				'plug_sug_name'=>I('plug_sug_name'),
				'plug_sug_email'=>I('plug_sug_email'),
				'plug_sug_content'=>I('plug_sug_content'),
				'plug_sug_addtime'=>time(),
				'plug_sug_open'=>0,
				'plug_sug_ip'=>get_client_ip(0,true),
			);
			$rst=M('plug_sug')->data($data)->add();
			if($rst!==false){
				$this->success("留言成功",1,1);
			}else{
				$this->error('留言失败',0,0);
			}
		}
	}
}