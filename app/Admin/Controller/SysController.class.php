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
use Think\Db;
use Think\Auth;
use OT\Database;
use Org\Util\Stringnew;
class SysController extends AuthController {
	//站点设置显示
	public function sys(){
		$arr=list_file(APP_PATH.'Home/View/');
		$tpls=array();
		foreach($arr as $v){
			if($v['isDir'] && strtolower($v['filename']!='public')){
				$tpls[]=$v['filename'];
			}
		}
		$this->assign("templates",$tpls);
		$sys=M('options')->where(array('option_name'=>'site_options'))->getField("option_value");
		$sys=json_decode($sys,true);
		$this->assign('sys',$sys)->display();
	}
	//保存站点设置
	public function runsys(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('Sys/sys'),0);
		}else{
			$checkpic=I('checkpic');
			$oldcheckpic=I('oldcheckpic');
			$options=I('options');
			if ($checkpic!=$oldcheckpic){
				//获取图片上传后路径
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize   =     3145728 ;// 设置附件上传大小
				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->rootPath  =     C('UPLOAD_DIR'); // 设置附件上传根目录
				$upload->savePath  =     ''; // 设置附件上传（子）目录
				$upload->saveRule  =     'time';
				$info   =   $upload->upload();
				if($info) {
					$img_url=substr(C('UPLOAD_DIR'),1).$info[file0][savepath].$info[file0][savename];//如果上传成功则完成路径拼接
					//写入数据库
					$data['uptime']=time();
					$data['filesize']=$info[file0][size];
					$data['path']=$img_url;
					M('plug_files')->add($data);
				}else{
					$this->error($upload->getError(),U('Sys/sys'),0);//否则就是上传错误，显示错误原因
				}
				$options['site_logo']=$img_url;
			}else{
				//原有图片
				$options['site_logo']=I('oldcheckpicname');
			}
			$rst=M('options')->where(array('option_name'=>'site_options'))->setField('option_value',json_encode($options));
			if($rst!==false){
				F("site_options", $options);
				$this->success('站点设置保存成功',U('Sys/sys'),1);
			}else{
				$this->error('提交参数不正确',U('Sys/sys'),0);
			}
		}
	}
	//url设置显示
	public function urlsys(){
		$count=M('route')->count();
		$Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
		$show= $Page->show();// 分页显示输出
		$routes=M('route')->limit($Page->firstRow.','.$Page->listRows)->order('listorder')->select();
		$this->assign('page',$show);		
		$this->assign('routes',$routes);
		$this->display();
	}
	/*
     * 路由规则设置
	 * @author rainfer <81818832@qq.com>
     */
	public function runurlsys(){
		$url_model=I('url_model',0,'intval');
		$url_suffix=I('suffix');
		sys_config_setbykey('URL_MODEL',$url_model);
		sys_config_setbykey('URL_HTML_SUFFIX',$url_suffix);
		clear_cache();
		$this->success('URL基本设置成功',U('Sys/urlsys'),1);
	}
	/*
     * 添加路由规则操作
	 * @author rainfer <81818832@qq.com>
     */
	public function route_runadd(){
		$p=I('p',1,'intval');
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('Sys/urlsys',array('p'=>$p)),0);
		}else{
			M('route')->add(I('post.'));
			$p=I('p',1,'intval');
			F('routes',NULL);
			$this->success('路由规则添加成功',U('Sys/urlsys',array('p'=>$p)),1);
		}
	}
	/*
     * 路由规则修改返回值操作
	 * @author rainfer <81818832@qq.com>
     */
	public function route_edit(){
		$id=I('id');
		$route=M('route')->where(array('id'=>$id))->find();
		$sl_data['id']=$route['id'];
		$sl_data['full_url']=$route['full_url'];
		$sl_data['url']=$route['url'];
		$sl_data['r_status']=$route['status'];
		$sl_data['status']=1;
		$sl_data['listorder']=$route['listorder'];
		$this->ajaxReturn($sl_data,'json');
	}
	/*
     * 修改路由规则操作
	 * @author rainfer <81818832@qq.com>
     */
	public function route_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('Sys/urlsys'),0);
		}else{
			$p=I('p',1,'intval');
			$sl_data=array(
				'id'=>I('id'),
				'full_url'=>I('full_url'),
				'url'=>I('url'),
				'status'=>I('status'),
				'listorder'=>I('listorder'),
			);
			$rst=M('route')->save($sl_data);
            if($rst!==false){
				F('routes',NULL);
                $this->success('路由规则修改成功',U('Sys/urlsys',array('p'=>$p)),1);
            }else{
                $this->error('路由规则修改失败',U('Sys/urlsys',array('p'=>$p)),0);
            }
		}
	}
	/*
     * 修改路由规则状态
	 * @author rainfer <81818832@qq.com>
     */
	public function route_state(){
		$id=I('x');
		if (empty($id)){
			$this->error('规则ID不存在',U('urlsys'),0);
		}
		$status=M('route')->where(array('id'=>$id))->getField('status');//判断当前状态情况
		if($status==1){
			$statedata = array('status'=>0);
			M('route')->where(array('id'=>$id))->setField($statedata);
			F('routes',NULL);
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('status'=>1);
			M('route')->where(array('id'=>$id))->setField($statedata);
			F('routes',NULL);
			$this->success('状态开启',1,1);
		}

	}
	/*
     * 路由规则删除操作
	 * @author rainfer <81818832@qq.com>
     */
	public function route_del(){
		$rst=M('route')->where(array('id'=>I('id')))->delete();
        if($rst!==false){
			F('routes',NULL);
			$p=I('p',1,'intval');
            $this->success('路由规则删除成功',U('Sys/urlsys',array('p'=>$p)),1);
        }else{
            $this->error('路由规则删除失败',U('urlsys'),0);
        }
	}
	/*
     * 路由规则排序
	 * @author rainfer <81818832@qq.com>
     */
	public function route_order(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('urlsys'),0);
		}else{
			$route=M('route');
			foreach (I('post.') as $id => $listorder){
				$route->where(array('id' => $id ))->setField('listorder' , $listorder);
			}
			F('routes',NULL);
			$this->success('排序更新成功',U('urlsys'),1);
		}
	}
	//微信设置显示
	public function wesys(){
		$sys=M('options')->where(array('option_name'=>'weixin_options'))->find();
		if(empty($sys)){
			$data['option_name']='weixin_options';
			$data['option_value']='';
			$data['autoload']=1;
			M('options')->add($data);
		}else{
			$sys=json_decode($sys['option_value'],true);
		}
		$this->assign('sys',$sys)->display();
	}

	//保存微信设置
	public function runwesys(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('wesys'),0);
		}else{
			$rst=M('options')->where(array('option_name'=>'weixin_options'))->setField('option_value',json_encode(I('options')));
			if($rst!==false){
				$this->success('微信设置保存成功',U('wesys'),1);
			}else{
				$this->error('提交参数不正确',U('wesys'),0);
			}
		}
	}
	//第三方登录设置显示
	public function oauthsys(){
		$oauth_qq=sys_config_get('THINK_SDK_QQ');
		$oauth_sina=sys_config_get('THINK_SDK_SINA');
		$this->assign('oauth_qq',$oauth_qq);
		$this->assign('oauth_sina',$oauth_sina);
		$this->display();
	}
	//保存第三方登录设置
	public function runoauthsys(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('oauthsys'),0);
		}else{
			$host=get_host();
			$call_back = $host.__ROOT__.'/index.php?m=Home&c=oauth&a=callback&type=';
			$data = array(
				'THINK_SDK_QQ' => array(
						'APP_KEY'    => I('qq_appid'),
						'APP_SECRET' => I('qq_appkey'),
						'CALLBACK'   => $call_back . 'qq',
				),
				'THINK_SDK_SINA' => array(
						'APP_KEY'    => I('sina_appid'),
						'APP_SECRET' => I('sina_appkey'),
						'CALLBACK'   => $call_back . 'sina',
				),
			);
			$rst=sys_config_setbyarr($data);
			if($rst){
				clear_cache();
				$this->success('设置保存成功',U('oauthsys'),1);
			}else{
				$this->error('设置保存失败',U('oauthsys'),0);
			}
		}
	}
	//发送邮件设置
	public function emailsys(){
		$sys=M('options')->where(array('option_name'=>'email_options'))->find();
		if(empty($sys)){
			$data['option_name']='email_options';
			$data['option_value']='';
			$data['autoload']=1;
			M('options')->add($data);
		}
		$sys=json_decode($sys['option_value'],true);
		$this->assign('sys',$sys)->display();
	}

	//保存邮箱设置
	public function runemail(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('emailsys'),0);
		}else{
			$rst=M('options')->where(array('option_name'=>'email_options'))->setField('option_value',json_encode(I('options')));
			if($rst!==false){
				F("email_options",null);
				$this->success('邮箱设置保存成功',U('emailsys'),1);
			}else{
				$this->error('提交参数不正确',U('emailsys'),0);
			}
		}
	}

	//帐号激活设置
	public function activesys(){
		$sys=M('options')->where(array('option_name'=>'active_options'))->find();
		if(empty($sys)){
			$data['option_name']='active_options';
			$data['option_value']='';
			$data['autoload']=1;
			M('options')->add($data);
		}
		$sys=json_decode($sys['option_value'],true);
		$this->assign('sys',$sys)->display();
	}

	//保存帐号激活设置
	public function runactive(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('Sys/activesys'),0);
		}else{
			//htmlspecialchars_decode(
			$options=I('options');
			$options['email_tpl']=htmlspecialchars_decode($options['email_tpl']);
			$rst=M('options')->where(array('option_name'=>'active_options'))->setField('option_value',json_encode($options));
			if($rst!==false){
				F("active_options",null);
				$this->success('帐号激活设置保存成功',U('Sys/activesys'),1);
			}else{
				$this->error('提交参数不正确',U('Sys/activesys'),0);
			}
		}
	}

	/*
     * 文章来源列表
	 * @author rainfer <81818832@qq.com>
     */
	public function source_list(){
		$count= M('source')->count();
		$Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
		$show= $Page->show();// 分页显示输出
		$source=M('source')->limit($Page->firstRow.','.$Page->listRows)->order('source_order')->select();
		$this->assign('source',$source);
		$this->assign('page',$show);
		$this->display();
	}

	/*
     * 添加来源操作
	 * @author rainfer <81818832@qq.com>
     */
	public function source_runadd(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('source_list'),0);
		}else{
			M('source')->add(I('post.'));
			$this->success('来源添加成功',U('source_list'),1);
		}
	}

	/*
     * 来源删除操作
	 * @author rainfer <81818832@qq.com>
     */
	public function source_del(){
		$p=I('p');
		$rst=M('source')->where(array('source_id'=>I('source_id')))->delete();
        if($rst!==false){
            $this->success('来源删除成功',U('source_list',array('p' => $p)),1);
        }else{
            $this->error('来源删除失败',U('source_list',array('p' => $p)),0);
        }
	}

	/*
     * 来源修改返回值操作
	 * @author rainfer <81818832@qq.com>
     */
	public function source_edit(){
		$source_id=I('source_id');
		$source=M('source')->where(array('source_id'=>$source_id))->find();
		$sl_data['source_id']=$source['source_id'];
		$sl_data['source_name']=$source['source_name'];
		$sl_data['source_order']=$source['source_order'];
		$sl_data['status']=1;
		$this->ajaxReturn($sl_data,'json');
	}

	/*
     * 修改来源操作
	 * @author rainfer <81818832@qq.com>
     */
	public function source_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('source_list'),0);
		}else{
			$sl_data=array(
				'source_id'=>I('source_id'),
				'source_name'=>I('source_name'),
				'source_order'=>I('source_order'),
			);
			$rst=M('source')->save($sl_data);
            if($rst!==false){
                $this->success('来源修改成功',U('source_list'),1);
            }else{
                $this->error('来源修改失败',U('source_list'),0);
            }
		}
	}

	/*
     * 来源排序
	 * @author rainfer <81818832@qq.com>
     */
	public function source_order(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('source_list'),0);
		}else{
			$source=M('source');
			foreach (I('post.') as $source_id => $source_order){
				$source->where(array('source_id' => $source_id ))->setField('source_order' , $source_order);
			}
			$this->success('排序更新成功',U('source_list'),1);
		}
	}


    public function database($type = null){
        if(empty($type)){
            $type='export';
        }
        $title='';
        $list=array();
        switch ($type) {
            /* 数据还原 */
            case 'import':
                //列出备份文件列表
                $path = realpath(C('DB_PATH'));
                $flag = \FilesystemIterator::KEY_AS_FILENAME;
                $glob = new \FilesystemIterator($path,  $flag);

                $list = array();
                foreach ($glob as $name => $file) {
                    if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                        $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                        $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                        $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                        $part = $name[6];

                        if(isset($list["{$date} {$time}"])){
                            $info = $list["{$date} {$time}"];
                            $info['part'] = max($info['part'], $part);
                            $info['size'] = $info['size'] + $file->getSize();
                        } else {
                            $info['part'] = $part;
                            $info['size'] = $file->getSize();
                        }
                        $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                        $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                        $info['time']     = strtotime("{$date} {$time}");

                        $list["{$date} {$time}"] = $info;
                    }
                }
                $title = '数据还原';
                break;

            /* 数据备份 */
            case 'export':
                $Db    = Db::getInstance();
                $list  = $Db->query('SHOW TABLE STATUS FROM '.C('DB_NAME'));
                $list  = array_map('array_change_key_case', $list);
				//过滤非本项目前缀的表
 				foreach($list as $k=>$v){
					if(stripos($v['name'],strtolower(C('DB_PREFIX')))!==0){
						unset($list[$k]);
					}
				}
                $title = '数据备份';
                break;

            default:
                $this->error('参数错误！');
        }

        //渲染模板
        $this->assign('meta_title', $title);
        $this->assign('data_list', $list);
        $this->display($type);
    }

    public function import(){
        $path = realpath(C('DB_PATH'));
        $flag = \FilesystemIterator::KEY_AS_FILENAME;
        $glob = new \FilesystemIterator($path,$flag);

        $list = array();
        foreach ($glob as $name => $file) {
            if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if(isset($list["{$date} {$time}"])){
                    $info = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                } else {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }
                $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time']     = strtotime("{$date} {$time}");

                $list["{$date} {$time}"] = $info;
            }
        }
        //渲染模板
        $this->assign('data_list', $list);
        $this->display();
    }



    /**
     * 优化表
     * @param  String $tables 表名
     * @author rainfer <81818832@qq.com>
     */
    public function optimize($tables = null){
        if($tables) {
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");

                if($list){
                    $this->success("数据表优化完成！");
                } else {
                    $this->error("数据表优化出错请重试！");
                }
            } else {
                $list = $Db->query("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'优化完成！");
                } else {
                    $this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            $this->error("请指定要优化的表！");
        }
    }

    /**
     * 修复表
     * @param  String $tables 表名
     * @author rainfer <81818832@qq.com>
     */
    public function repair($tables = null){
        if($tables) {
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $Db->query("REPAIR TABLE `{$tables}`");

                if($list){
                    $this->success("数据表修复完成！");
                } else {
                    $this->error("数据表修复出错请重试！");
                }
            } else {
                $list = $Db->query("REPAIR TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'修复完成！",1,1);
                } else {
                    $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            $this->error("请指定要修复的表！");
        }
    }
    /**
     * 备份单表
     * @param  String $table 不含前缀表名
     * @author rainfer <81818832@qq.com>
     */
    public function exportsql($table = null){
        if($table){
            if(stripos($table,C('DB_PREFIX'))==0){
                //含前缀的表,去除表前缀
                $table=str_replace(C('DB_PREFIX'),"",$table);
            }
            if (!db_is_valid_table_name($table)) {
                $this->error("不存在表" . ' ' . $table);
            }
            force_download_content(date('Ymd') . '_' . C('DB_PREFIX') . $table . '.sql', db_get_insert_sqls($table));
        }else{
            $this->error('未指定需备份的表');
        }
    }
    /**
     * 删除备份文件
     * @param  Integer $time 备份时间
     * @author rainfer <81818832@qq.com>
     */
    public function del($time = 0){
        if($time){
            $name  = date('Ymd-His', $time) . '-*.sql*';
            $path  = realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR . $name;
            array_map("unlink", glob($path));
            if(count(glob($path))){
                $this->error('备份文件删除失败，请检查权限！',U('Sys/import'),0);
            } else {
                $this->success('备份文件删除成功！',U('Sys/import'),1);
            }
        } else {
            $this->error('参数错误！',U('Sys/import'),0);
        }
    }
    /**
     * 还原数据库
     * @author rainfer <81818832@qq.com>
     */
    public function restore($time = 0, $part = null, $start = null){
        //读取备份配置
        $config = array(
            'path'     => realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR,
            'part'     => C('DB_PART'),
            'compress' => C('DB_COMPRESS'),
            'level'    => C('DB_LEVEL'),
        );
        if(is_numeric($time) && is_null($part) && is_null($start)){ //初始化
            //获取备份文件信息
            $name  = date('Ymd-His', $time) . '-*.sql*';
            $path  = realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list  = array();
            foreach($files as $name){
                $basename = basename($name);
                $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            //检测文件正确性
            $last = end($list);
            if(count($list) === $last[0]){
                session('backup_list', $list); //缓存备份列表
                $this->restore(0,1,0);
            } else {
                $this->error('备份文件可能已经损坏，请检查！');
            }
        } elseif(is_numeric($part) && is_numeric($start)) {
            $list  = session('backup_list');
            $db = new Database($list[$part],$config);
            $start = $db->import($start);
            if(false === $start){
                $this->error('还原数据出错！');
            } elseif(0 === $start) { //下一卷
                if(isset($list[++$part])){
                    //$data = array('part' => $part, 'start' => 0);
                    $this->restore(0,$part,0);
                } else {
                    session('backup_list', null);
                    $this->success('还原完成！',U('Sys/import'),1);
                }
            } else {
                $data = array('part' => $part, 'start' => $start[0]);
                if($start[1]){
                    $this->restore(0,$part, $start[0]);
                } else {
                    $data['gz'] = 1;
                    $this->restore(0,$part, $start[0]);
                }
            }
        } else {
            $this->error('参数错误！');
        }
    }
    /**
     * 备份数据库
     * @param  String  $tables 表名
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     * @author rainfer <81818832@qq.com>
     */
    public function export($tables = null, $id = null, $start = null){
        if(IS_POST && !empty($tables) && is_array($tables)){ //初始化
            //读取备份配置
            $config = array(
                'path'     => realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR,
                'part'     => C('DB_PART'),
                'compress' => C('DB_COMPRESS'),
                'level'    => C('DB_LEVEL'),
            );
            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                $this->error('检测到有一个备份任务正在执行，请稍后再试！',0,0);
            } else {
                //创建锁文件
                file_put_contents($lock, NOW_TIME);
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！',0,0);
            session('backup_config', $config);

            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', NOW_TIME),
                'part' => 1,
            );
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new Database($file, $config);
            if(false !== $Database->create()){
                $tab = array('id' => 0, 'start' => 0);
                $this->success('初始化成功！', '', array('tables' => $tables, 'tab' => $tab));
            } else {
                $this->error('初始化失败，备份文件创建失败！',0,0);
            }
        } elseif (IS_GET && is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = session('backup_tables');
            //备份指定表
            $Database = new Database(session('backup_file'), session('backup_config'));
            $start  = $Database->backup($tables[$id], $start);
            if(false === $start){ //出错
                $this->error('备份出错！',0,0);
            } elseif (0 === $start) { //下一表
                if(isset($tables[++$id])){
                    $tab = array('id' => $id, 'start' => 0);
                    $this->success('备份完成！', '', array('tab' => $tab));
                } else { //备份完成，清空缓存
                    unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    $this->success('备份完成！',1,1);
                }
            } else {
                $tab  = array('id' => $id, 'start' => $start[0]);
                $rate = floor(100 * ($start[0] / $start[1]));
                $this->success("正在备份...({$rate}%)", '', array('tab' => $tab));
            }

        } else { //出错
            $this->error('参数错误！');
        }
    }


	public function admin_list(){
		$admin=M('admin');
		$val=I('val');
		$auth = new Auth();
		$this->assign('testval',$val);
        $map=array();
		if($val){
			$map['admin_username']= array('like',"%".$val."%");
		}

		$count= $admin->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

		foreach($map as $key=>$val) {
			$Page->parameter[$key]=urlencode($val);
		}
		$show= $Page->show();// 分页显示输出

		$admin_list=$admin->where($map)->order('admin_id')->limit($Page->firstRow.','.$Page->listRows)->select();

		foreach ($admin_list as $k=>$v){
			$group = $auth->getGroups($v['admin_id']);
			$admin_list[$k]['group'] = $group[0]['title'];
		}

		$this->assign('admin_list',$admin_list);
		$this->assign('page',$show);

		$this->display();
	}

	public function admin_add(){
		$auth_group=M('auth_group')->select();
		$this->assign('auth_group',$auth_group);
		$this->display();
	}

	public function admin_runadd(){
		$admin=M('admin');
		$admin_access=M('auth_group_access');
		$check_user=$admin->where(array('admin_username'=>I('admin_username')))->find();
		if ($check_user){
			$this->error('用户已存在，请重新输入用户名',U('admin_list'),0);
		}
		$admin_pwd_salt=Stringnew::randString(10);
		$sldata=array(
			'admin_username'=>I('admin_username'),
			'admin_pwd_salt' => $admin_pwd_salt,
			'admin_pwd'=>encrypt_password(I('admin_pwd'),$admin_pwd_salt),
			'admin_email'=>I('admin_email'),
			'admin_tel'=>I('admin_tel'),
			'admin_open'=>I('admin_open'),
			'admin_realname'=>I('admin_realname'),
			'admin_ip'=>get_client_ip(),
			'admin_addtime'=>time(),
            'admin_changepwd'=>time(),
		);
		$result=$admin->add($sldata);
		$accdata=array(
			'uid'=>$result,
			'group_id'=>I('group_id'),
		);
		$admin_access->add($accdata);
		$this->success('管理员添加成功',U('admin_list'),1);
	}

	public function admin_edit(){
		$auth_group=M('auth_group')->select();
		$admin_list=M('admin')->where(array('admin_id'=>I('admin_id')))->find();
		$auth_group_access=M('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->getField('group_id');
		$this->assign('admin_list',$admin_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		$this->display();
	}

	public function admin_runedit(){
		$admin_list=M('admin');
		$admin_pwd=I('admin_pwd');
		$group_id=I('group_id');
		$admindata['admin_id']=I('admin_id');
		if ($admin_pwd){
			$admin_pwd_salt=Stringnew::randString(10);
			$admindata['admin_pwd_salt']=$admin_pwd_salt;
			$admindata['admin_pwd']=encrypt_password(I('admin_pwd'),$admin_pwd_salt);
            $admindata['admin_changepwd']=time();
		}
		$admindata['admin_email']=I('admin_email');
		$admindata['admin_tel']=I('admin_tel');
		$admindata['admin_realname']=I('admin_realname');
		$admindata['admin_open']=I('admin_open',0,'intval');
		$admin_list->save($admindata);
        if($group_id){
			$rst=M('auth_group_access')->where(array('uid'=>I('admin_id')))->find();
			if($rst){
				//修改
				$rst=M('auth_group_access')->where(array('uid'=>I('admin_id')))->setField('group_id',$group_id);
			}else{
				//增加
				$data['uid']=I('admin_id');
				$data['group_id']=$group_id;
				$rst=M('auth_group_access')->add($data);
			}
        }
        if($rst!==false){
            $this->success('管理员修改成功',U('admin_list'),1);
        }else{
            $this->error('管理员修改失败',U('admin_list'),0);
        }
	}

	public function admin_del(){
		$admin_id=I('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',U('admin_list'),0);
		}
		M('admin')->where(array('admin_id'=>I('admin_id')))->delete();
		$rst=M('auth_group_access')->where(array('uid'=>I('admin_id')))->delete();
        if($rst!==false){
            $this->success('管理员删除成功',U('admin_list'),1);
        }else{
            $this->error('管理员删除失败',U('admin_list'),0);
        }
	}

	public function admin_state(){
		$id=I('x');
		if (empty($id)){
			$this->error('用户ID不存在',U('admin_list'),0);
		}
		$status=M('admin')->where(array('admin_id'=>$id))->getField('admin_open');//判断当前状态情况
		if($status==1){
			$statedata = array('admin_open'=>0);
			M('admin')->where(array('admin_id'=>$id))->setField($statedata);
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('admin_open'=>1);
			M('admin')->where(array('admin_id'=>$id))->setField($statedata);
			$this->success('状态开启',1,1);
		}

	}

	//用户组管理
	public function admin_group_list(){
		$auth_group=M('auth_group')->select();
		$this->assign('auth_group',$auth_group);
		$this->display();
	}
	//用户组管理
	public function admin_group_add(){
		$this->display();
	}
	public function admin_group_runadd(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('admin_group_list'),0);
		}else{
			$sldata=array(
				'title'=>I('title'),
				'status'=>I('status'),
				'addtime'=>time(),
			);
			M('auth_group')->add($sldata);
			$this->success('用户组添加成功',U('admin_group_list'),1);
		}
	}

	public function admin_group_del(){
		$rst=M('auth_group')->where(array('id'=>I('id')))->delete();
        if($rst!==false){
            $this->success('用户组删除成功',U('admin_group_list'),1);
        }else{
            $this->error('用户组删除失败',U('admin_group_list'),0);
        }
	}

	public function admin_group_edit(){
		$group=M('auth_group')->where(array('id'=>I('id')))->find();
		$this->assign('group',$group);
		$this->display();
	}

	public function admin_group_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('admin_group_list'),0);
		}else{
			$sldata=array(
				'id'=>I('id'),
				'title'=>I('title'),
				'status'=>I('status'),
			);
			M('auth_group')->save($sldata);
			$this->success('用户组修改成功',U('admin_group_list'),1);
		}
	}

	public function admin_group_state(){
		$id=I('x');
		$status=M('auth_group')->where(array('id'=>$id))->getField('status');//判断当前状态情况
		if($status==1){
			$statedata = array('status'=>0);
			$auth_group=M('auth_group')->where(array('id'=>$id))->setField($statedata);
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('status'=>1);
			$auth_group=M('auth_group')->where(array('id'=>$id))->setField($statedata);
			$this->success('状态开启',1,1);
		}
	}
    //四重权限配置
    public function admin_group_access(){
        $admin_group=M('auth_group')->where(array('id'=>I('id')))->find();
        $m = M('auth_rule');
        $data = $m->field('id,name,title')->where('pid=0')->select();
        foreach ($data as $k=>$v){
            $data[$k]['sub'] = $m->field('id,name,title')->where('pid='.$v['id'])->select();
            foreach ($data[$k]['sub'] as $kk=>$vv){
                $data[$k]['sub'][$kk]['sub'] = $m->field('id,name,title')->where('pid='.$vv['id'])->select();
                foreach ($data[$k]['sub'][$kk]['sub'] as $kkk=>$vvv){
                    $data[$k]['sub'][$kk]['sub'][$kkk]['sub'] = $m->field('id,name,title')->where('pid='.$vvv['id'])->select();
                }
            }
        }
        //p($data);die;
        $this->assign('admin_group',$admin_group);	// 顶级
        $this->assign('datab',$data);	// 顶级
        $this->display();
    }

    public function admin_group_runaccess(){
        $m = M('auth_group');
        $new_rules = I('new_rules');
        $imp_rules = implode(',', $new_rules).',';
        $sldata=array(
            'id'=>I('id'),
            'rules'=>$imp_rules,
        );
        if($m->save($sldata)!==false){
			clear_cache();
            $this->success('权限配置成功',U('admin_group_list'),1);
        }else{
            $this->error('权限配置失败',U('admin_group_list'),0);
        }
    }
	public function admin_rule_list(){
		$nav = new \Org\Util\Leftnav;
		$admin_rule=M('auth_rule')->order('sort')->select();
		$arr = $nav::rule($admin_rule);
		$this->assign('admin_rule',$arr);//权限列表
		$this->display();
	}
	//权限添加
	public function admin_rule_runadd(){
		if(!IS_AJAX){
			$this->error('提交方式不正确',U('admin_rule_list'),0);
		}else{
			$admin_rule=M('auth_rule');
			$pid=$admin_rule->where(array('id'=>I('pid')))->field('level')->find();
			$level=$pid['level']+1;
			//检测name是否有效
			if($level==1){
				//是否存在控制器
				$class = 'Admin\\Controller\\' . I('name') . 'Controller';
				if (!class_exists($class)) {
					$this->error('不存在 '.I('name').' 的控制器',U('admin_rule_list'),0);
                }
			}elseif($level==2){
				//不检测
			}else{
				//是否存在控制器/方法
				$arr=explode('/',I('name'));
				if(count($arr)==2){
					$class = 'Admin\\Controller\\' . $arr[0] . 'Controller';
					if (!class_exists($class)) {
						$this->error('不存在 '.$arr[0].' 的控制器',U('admin_rule_list'),0);
					}
					if (!method_exists($class, $arr[1])) {
						$this->error('控制器'.$arr[0].'不存在方法'.$arr[1],U('admin_rule_list'),0);
					}
				}else{
					$this->error('提交名称不规范',U('admin_rule_list'),0);
				}
			}
			$sldata=array(
				'name'=>I('name'),
				'title'=>I('title'),
				'status'=>I('status'),
				'sort'=>I('sort'),
				'addtime'=>time(),
				'pid'=>I('pid'),
				'css'=>I('css'),
				'level'=>$level,
			);
			$admin_rule->add($sldata);
			clear_cache();
			$this->success('权限添加成功',U('admin_rule_list'),1);
		}
	}

	public function admin_rule_state(){
		$id=I('x');
		$statusone=M('auth_rule')->where(array('id'=>$id))->getField('status');//判断当前状态情况
		if($statusone==1){
			$statedata = array('status'=>0);
			$auth_group=M('auth_rule')->where(array('id'=>$id))->setField($statedata);
			clear_cache();
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('status'=>1);
			$auth_group=M('auth_rule')->where(array('id'=>$id))->setField($statedata);
			clear_cache();
			$this->success('状态开启',1,1);
		}

	}

	public function admin_rule_order(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('admin_rule_list'),0);
		}else{
			$auth_rule=M('auth_rule');
			foreach ($_POST as $id => $sort){
				$auth_rule->where(array('id' => $id ))->setField('sort' , $sort);
			}
			clear_cache();
			$this->success('排序更新成功',U('admin_rule_list'),1);
		}
	}

	public function admin_rule_edit(){
		//全部规则
		$nav = new \Org\Util\Leftnav;
		$admin_rule_all=M('auth_rule')->order('sort')->select();
		$arr = $nav::rule($admin_rule_all);
		$this->assign('admin_rule',$arr);
		//待编辑规则
		$admin_rule=M('auth_rule')->where(array('id'=>I('id')))->find();
		$this->assign('rule',$admin_rule);
		$this->display();
	}
    public function admin_rule_copy(){
        //全部规则
        $nav = new \Org\Util\Leftnav;
        $admin_rule_all=M('auth_rule')->order('sort')->select();
        $arr = $nav::rule($admin_rule_all);
        $this->assign('admin_rule',$arr);
        //待编辑规则
        $admin_rule=M('auth_rule')->where(array('id'=>I('id')))->find();
        $this->assign('rule',$admin_rule);
        $this->display();
    }
	public function admin_rule_runedit(){
		if(!IS_AJAX){
			$this->error('提交方式不正确',U('admin_rule_list'),0);
		}else{
			$admin_rule=M('auth_rule');
			$pid=$admin_rule->where(array('id'=>I('pid')))->field('level')->find();
			$level=$pid['level']+1;
			$sldata=array(
				'id'=>I('id',1,'intval'),
				'name'=>I('name'),
				'title'=>I('title'),
				'status'=>I('status'),
				'pid'=>I('pid',0,'intval'),
				'css'=>I('css'),
				'sort'=>I('sort'),
				'level'=>$level,
			);
			//dump($sldata);
			$rst=$admin_rule->save($sldata);
			if($rst!==false){
				clear_cache();
				$this->success('权限修改成功',U('admin_rule_list'),1);
			}else{
				$this->error('权限修改失败',U('admin_rule_list'),0);
			}
		}
	}

	public function admin_rule_del(){
        //TODO 自动删除子权限
		$rst=M('auth_rule')->where(array('id'=>I('id')))->delete();
        if($rst!==false){
			clear_cache();
            $this->success('权限删除成功',U('admin_rule_list'),1);
        }else{
            $this->error('权限删除失败',U('admin_rule_list'),0);
        }
	}

	public function excel_import(){
		$this->display();
	}

	public function excel_export(){
        $Db    = Db::getInstance();
        $list  = $Db->query('SHOW TABLE STATUS FROM '.C('DB_NAME'));
        $list  = array_map('array_change_key_case', $list);
		//过滤非本项目前缀的表
		foreach($list as $k=>$v){
			if(stripos($v['name'],strtolower(C('DB_PREFIX')))!==0){
				unset($list[$k]);
			}
		}
        $this->assign('data_list', $list);
		$this->display();
	}

	/*
     * 表格导入
	 * @author rainfer <81818832@qq.com>
     */
	public function excel_runimport(){
		import("Org.Util.PHPExcel");
		$PHPExcel=new \PHPExcel();
		import("Org.Util.PHPExcel.Reader.Excel5");

		if (! empty ( $_FILES ['file_stu'] ['name'] )){
			$tmp_file = $_FILES ['file_stu'] ['tmp_name'];
			$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
			$file_type = $file_types [count ( $file_types ) - 1];
			/*判别是不是.xls文件，判别是不是excel文件*/
			if (strtolower ( $file_type ) != "xls"){
				$this->error ( '不是Excel文件，重新上传',U('excel_import'),0);
			}
			/*设置上传路径*/
			$savePath = './public/excel/';
			/*以时间来命名上传的文件*/
			$str = time ( 'Ymdhis' );
			$file_name = $str . "." . $file_type;

			if (! copy ( $tmp_file, $savePath . $file_name )){
				$this->error ('上传失败',U('excel_import'),0);
			}

			$res = $this->read ( $savePath . $file_name );
			if (!$res){
				$this->error ('数据处理失败',U('excel_import'),0);
			}
			//spl_autoload_register ( array ('Think', 'autoload' ) );
			foreach ( $res as $k => $v ){
				if ($k != 1){
					$data ['news_title'] = $v[1];
					$data ['news_titleshort'] = $v[2];
					$data ['news_columnid'] = $v[3];
					$data ['news_columnviceid'] = $v[4];
					$data ['news_key'] = $v[5];
					$data ['news_tag'] = $v[6];
					$data ['news_auto'] = $v[7];
					$data ['news_source'] = $v[8];
					$data ['news_content'] = $v[9];
					$data ['news_scontent'] = $v[10];
					$data ['news_hits'] = $v[11];
					$data ['news_img'] = $v[12];
					$data ['news_time'] = $v[13];
					$data ['news_flag'] = $v[14];
					$data ['news_zaddress'] = $v[15];
					$data ['news_back'] = $v[16];
					$data ['news_open'] = $v[17];
					$data ['news_lvtype'] = $v[18];

					$result = M ('news')->add ($data);
					if (!$result){
						$this->error ('导入数据库失败',U('excel_import'),0);
					}
				}
			}
			$this->success ('导入数据库成功',U('excel_import'),1);
		}
	}

	private function read($filename,$encode='utf-8'){
		$objReader = \PHPExcel_IOFactory::createReader(Excel5);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($filename);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		$excelData = array();
		for ($row = 1; $row <= $highestRow; $row++) {
			for ($col = 0; $col < $highestColumnIndex; $col++) {
				$excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			}
		}
		return $excelData;
	}

	/*
     * 数据导出功能
	 * @author rainfer <81818832@qq.com>
     */
	public function excel_runexport($table){
        export2excel($table);
	}

	public function clear(){
		clear_cache();
		$this->success ('清理缓存成功',1,1);
	}
    public function maintain()
    {
        $action=I('get.action');
		switch ($action) {
            case 'download_log' :
            case 'view_log':
                $logs = array();
                foreach (list_file(LOG_PATH) as $f) {
                    if ($f ['isDir']) {
                        foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                            if ($ff ['isFile']) {
                                $spliter = '==========================';
                                $logs [] = $spliter . '  ' . $f ['filename'] . '/' . $ff ['filename'] . '  ' . $spliter . "\n\n" . file_get_contents($ff ['pathname']);
                            }
                        }
                    }
                }
                if ('download_log' == $action) {
                    force_download_content('log_' . date('Ymd_His') . '.log', join("\n\n\n\n", $logs));
                } else {
                    echo '<pre>' . htmlspecialchars(join("\n\n\n\n", $logs)) . '</pre>';
                }
                break;
            case 'clear_log' :
                remove_dir(LOG_PATH);
                $this->success ('清除日志成功',U('Index/index'),1);
                break;
			case 'debug_on' :
				if (!file_exists($file = './data/conf/debug.lock')) {
					@file_put_contents($file, 'lock');
				}
				$this->success('已打开调试',U('Index/index'),1);
                break;
			case 'debug_off' :
				if (file_exists($file = './data/conf/debug.lock')) {
					@unlink($file);
				}
				$this->success('已关闭调试',U('Index/index'),1);
                break;
			case 'trace_on' :
				$data = array('SHOW_PAGE_TRACE'=>true);
				$res=sys_config_setbyarr($data);
				if($res === false){
					$this->error('打开Trace失败',U('Index/index'),0);
				}else{
					clear_cache();
					$this->success('已打开Trace',U('Index/index'),1);
				}
                break;
			case 'trace_off' :
				$data = array('SHOW_PAGE_TRACE'=>false);
				$res=sys_config_setbyarr($data);
				if($res === false){
					$this->error('关闭Trace失败',U('Index/index'),0);
				}else{
					clear_cache();
					$this->success('已关闭Trace',U('Index/index'),1);
				}
                break;
        }
    }
	public function profile(){
        $admin=array();
        if(session('aid')){
            $rs=M('admin');
            $join1 = "".C('DB_PREFIX').'auth_group_access as b on a.admin_id =b.uid';
            $join2= "".C('DB_PREFIX').'auth_group as c on b.group_id = c.id';
            $admin=$rs->alias("a")->join($join1)->join($join2)->where(array('a.admin_id'=>session('aid')))->find();
            $news_count=M('News')->where(array('news_auto'))->count();
            $admin['news_count']=$news_count;
        }
        $this->assign('admin', $admin);
		$this->display();
	}
    public function avatar(){
        $imgurl=I('post.imgurl');
        //去'/'
        $imgurl=str_replace('/','',$imgurl);
        $admin=M('admin')->where(array('admin_id'=>session('aid')))->find();
        $old_img=$admin['admin_avatar'];
        $data['admin_avatar']=$imgurl;
        $rst=M('admin')->where(array('admin_id'=>session('aid')))->save($data);
        if($rst!==false){
            session('admin_avatar',$imgurl);
			$url=substr(C('UPLOAD_DIR'),1).'avatar/'.$imgurl;
			//写入数据库
			$data['uptime']=time();
			$data['filesize']=filesize('./'.$url);
			$data['path']=$url;
			M('plug_files')->add($data);
			$this->success ('头像更新成功',U('profile'),1);
        }else{
            $this->error ('头像更新失败',U('profile'),0);
        }
    }
}