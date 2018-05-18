<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>翰林轩书吧后台管理</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome必须的css -->
	<link rel="stylesheet" href="/public/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/public/font-awesome/css/font-awesome.min.css" />

	<!-- 此页插件css -->

	<!-- ace的css -->
	<link rel="stylesheet" href="/public/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<!-- IE版本小于9的ace的css -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="/public/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="/public/ace/css/ace-ie.css" />
	<![endif]-->

	<link rel="stylesheet" href="/public/yfcmf/yfcmf.css" />
	<!-- 此页相关css -->

	<!-- ace设置处理的css -->

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="/public/others/html5shiv.min.js"></script>
	<script src="/public/others/respond.min.js"></script>
	<![endif]-->
    <!-- 引入基本的js -->
    <script type="text/javascript">
        var admin_ueditor_handle = "<?php echo U('Sys/upload');?>";
        var admin_ueditor_lang ='zh-cn';
    </script>
    <!--[if !IE]> -->
    <script src="/public/others/jquery.min-2.2.1.js"></script>
    <!-- <![endif]-->
    <!-- 如果为IE,则引入jq1.12.1 -->
    <!--[if IE]>
    <script src="/public/others/jquery.min-1.12.1.js"></script>
    <![endif]-->

    <!-- 如果为触屏,则引入jquery.mobile -->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='/public/others/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/public/others/bootstrap.min.js"></script>
</head>

<body class="no-skin">
<!-- 导航栏开始 -->
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-container" id="navbar-container">
		<!-- 导航左侧按钮手机样式开始 -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button><!-- 导航左侧按钮手机样式结束 -->
		<button data-target="#sidebar2" data-toggle="collapse" type="button" class="pull-left navbar-toggle collapsed">
			<span class="sr-only">Toggle sidebar</span>
			<i class="ace-icon fa fa-dashboard white bigger-125"></i>
		</button>
		<!-- 导航左侧正常样式开始 -->
		<div class="navbar-header pull-left">
			<!-- logo -->
			<a href="<?php echo U('Index/index');?>" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					翰林轩书吧
				</small>
			</a>
		</div><!-- 导航左侧正常样式结束 -->

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<a href="<?php echo U('Home/index/index');?>" target="_blank">
						前台首页
					</a>
				</li>

				<li class="purple">
					<a data-info="确定要清理缓存吗？" class="confirm-rst-btn" href="<?php echo U('Sys/clear');?>">
						清除缓存
					</a>
				</li>

				<!-- 用户菜单开始 -->
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<?php if($_SESSION['admin_avatar'] != ''): ?><img class="nav-user-photo" src="/data/upload/avatar/<?php echo ($_SESSION['admin_avatar']); ?>" alt="<?php echo ($_SESSION['admin_username']); ?>" />
							<?php else: ?>
							<img class="nav-user-photo" src="/public/img/girl.jpg" alt="<?php echo ($_SESSION['admin_username']); ?>" /><?php endif; ?>
								<span class="user-info">
									<small>欢迎,</small>
									<?php echo ($_SESSION['admin_username']); ?>
								</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo U('Sys/profile');?>">
								<i class="ace-icon fa fa-user"></i>
								会员中心
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="<?php echo U('Login/logout');?>"  data-info="你确定要退出吗？" class="confirm-btn">
								<i class="ace-icon fa fa-power-off"></i>
								注销
							</a>
						</li>
					</ul>
				</li><!-- 用户菜单结束 -->
			</ul>
		</div><!-- 导航栏结束 -->
	</div><!-- 导航栏容器结束 -->
</div><!-- 导航栏结束 -->

<!-- 整个页面内容开始 -->
<div class="main-container" id="main-container">
	<!-- 菜单栏开始 -->
	<div id="sidebar" class="sidebar responsive sidebar-fixed">
	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<!--左侧顶端按钮-->
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="<?php echo U('News/news_list');?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>
			<a class="btn btn-info" href="<?php echo U('News/news_add');?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>
			<a class="btn btn-warning" href="<?php echo U('Member/member_list');?>" role="button" title="会员列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo U('Sys/sys');?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>
		<!--左侧顶端按钮（手机）-->
		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo U('News/news_list');?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo U('News/news_add');?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo U('Member/member_list');?>" role="button" title="会员列表"></a>
			<a class="btn btn-danger" href="<?php echo U('Sys/sys');?>" role="button" title="站点设置"></a>
		</div>
	</div>
	<!-- 菜单列表开始 -->
	<ul class="nav nav-list">
		<!--一级菜单遍历开始-->
		<?php if(is_array($menus)): foreach($menus as $key=>$v): if(!empty($v['_child'])): ?><li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>open<?php endif; ?>">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa <?php echo ($v["css"]); ?>"></i>
				<span class="menu-text"><?php echo ($v["title"]); ?></span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<ul class="submenu">
				<!--二级菜单遍历开始-->
				<?php if(is_array($v["_child"])): foreach($v["_child"] as $key=>$vv): if(!empty($vv['_child'])): ?><li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active open<?php endif; ?>">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo ($vv["title"]); ?>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!--三级菜单遍历开始-->
						<?php if(is_array($vv["_child"])): foreach($vv["_child"] as $key=>$vvv): ?><li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
							<a href="<?php echo U($vvv['name']);?>">
								<i class="menu-icon fa fa-caret-right"></i>
								<?php echo ($vvv["title"]); ?>
							</a>
							<b class="arrow"></b>
							</li><?php endforeach; endif; ?><!--三级菜单遍历结束-->
					</ul>
					</li>
					<?php else: ?>
					<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
					<a href="<?php echo U($vv['name']);?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo ($vv["title"]); ?>
					</a>
					<b class="arrow"></b>
					</li><?php endif; endforeach; endif; ?><!--二级菜单遍历结束-->
			</ul>
			</li>
			<?php else: ?>
			<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
			<a href="<?php echo U($v['name']);?>">
				<i class="menu-icon fa fa-caret-right"></i>
				<?php echo ($v["title"]); ?>
			</a>
			<b class="arrow"></b>
			</li><?php endif; endforeach; endif; ?><!--一级菜单遍历结束-->
	</ul><!-- 菜单列表结束 -->

	<!-- 菜单栏缩进开始 -->
	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div><!-- 菜单栏缩进结束 -->
</div>
	<!-- 菜单栏结束 -->

	<!-- 主要内容开始 -->
	<div class="main-content">
		<div class="main-content-inner">
			<!-- 右侧主要内容页顶部标题栏开始 -->
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse sidebar-fixed menu-min" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
	<div class="nav-wrap-up pos-rel">
		<div class="nav-wrap">
			<ul class="nav nav-list">
				<?php if($id_curr != ''): if(is_array($menus_child)): foreach($menus_child as $key=>$k): ?><li>
					<a href="<?php echo U(''.$k['name'].'');?>">
					<o class="font12 <?php if($id_curr == $k['id']): ?>rigbg<?php endif; ?>"><?php echo ($k["title"]); ?></o>
					</a>
					<b class="arrow"></b>
				</li><?php endforeach; endif; ?>
				<?php else: ?>
				<li>
					<a href="<?php echo U('Index/index');?>">
						<o class="font12">欢迎使用翰林轩书吧后台系统管理</o>
					</a>
					<b class="arrow"></b>
				</li><?php endif; ?>
			</ul>
		</div>
	</div><!-- /.nav-list -->
</div>
			<!-- 右侧主要内容页顶部标题栏结束 -->

			<!-- 右侧下主要内容开始 -->
			
	<div class="page-content">
		<div class="row">
			<div class="col-xs-12">
				<!-- 提示 -->
				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<i class="ace-icon fa fa-check green"></i>
					为了您更好的使用本系统，建议屏幕分辨率1280*768以上，并且安装chrome谷歌浏览器 ——— <a href="<?php echo U('Help/soft');?>">进入软件下载专区</a>
				</div>
				<div class="row">
					<div class="space-6"></div>
					<div class="col-sm-7 infobox-container">
						<div class="infobox infobox-green col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-folder"></i>
							</div>
							<div class="infobox-data">
								<span class="infobox-data-number"><?php echo ($tonews_count); ?></span>
								<div class="infobox-content">今日普通文章数</div>
							</div>
							<div class="stat <?php if($difday < 1): ?>stat-important<?php else: ?>stat-success<?php endif; ?>"><?php echo (round($difday,0)); ?>%</div>
						</div>
						<div class="infobox infobox-blue col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-user"></i>
							</div>
							<div class="infobox-data">
								<span class="infobox-data-number"><?php echo ($tomembers_count); ?></span>
								<div class="infobox-content">今日增加会员</div>
							</div>
							<div class="stat <?php if($difday_m < 1): ?>stat-important<?php else: ?>stat-success<?php endif; ?>"><?php echo (round($difday_m,0)); ?>%</div>
						</div>
						<div class="infobox infobox-pink col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-comment"></i>
							</div>
							<div class="infobox-data">
								<span class="infobox-data-number"><?php echo ($tocoms_count); ?></span>
								<div class="infobox-content">今日评论</div>
							</div>
							<div class="stat <?php if($difday_c < 1): ?>stat-important<?php else: ?>stat-success<?php endif; ?>"><?php echo (round($difday_c,0)); ?>%</div>
						</div>
						<div class="infobox infobox-orange infobox-dark col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-folder"></i>
							</div>

							<div class="infobox-data">
								<div class="infobox-content">总文章数</div>
								<a href="<?php echo U('News/news_list');?>"><div class="infobox-content"><?php echo ($news_count); ?></div></a>
							</div>
						</div>
						<div class="infobox infobox-green infobox-dark col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-users"></i>
							</div>
							<div class="infobox-data">
								<div class="infobox-content">总会员数</div>
								<a href="<?php echo U('Member/member_list');?>"><div class="infobox-content"><?php echo ($members_count); ?></div></a>
							</div>
						</div>
						<div class="infobox infobox-orange2 infobox-dark col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="infobox-icon">
								<i class="ace-icon fa fa-comment"></i>
							</div>
							<div class="infobox-data">
								<div class="infobox-content">总评论数</div>
								<a href="<?php echo U('Comment/comment_list');?>"><div class="infobox-content"><?php echo ($coms_count); ?></div></a>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="space-6"></div>
							</div>
						</div>
						<div class="widget-box sl-indextop10 text-left">
							<script src='https://git.oschina.net/rainfer/YFCMF/widget_preview'></script>
							<style>
								.pro_name a{color: #4183c4;}
								.osc_git_title{background-color: #d8e5f1;}
								.osc_git_box{background-color: #fafafa;}
								.osc_git_box{border-color: #ddd;}
								.osc_git_info{color: #666;}
								.osc_git_main a{color: #4183c4;}
							</style>
						</div>
						<div class="widget-box sl-indextop10 text-left">
							<div class="widget-header">
								<h5 class="widget-title"><span style="font-size:14px; font-family:Microsoft YaHei">框架&系统信息</span></h5>

							</div>
							<div class="widget-body">
								<div class="widget-main">
									<p class="alert alert-danger sl-line-height25">
										YFCMF版本：<?php echo (C("YFCMF_VERSION")); ?> &nbsp;
										<?php if(empty($ver_last)): ?><button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check"></i><?php echo ($ver_str); ?></button>
										<?php else: ?>
											<a href="<?php echo UU('Update/index');?>" title="在线更新"><button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-bolt bigger-110"></i><?php echo ($ver_str); ?></button></a><?php endif; ?>
										<br />
										框架版本：ThinkPHP<?php echo ($info["ThinkPHPTYE"]); ?>&nbsp;&nbsp;上传附件限制：<?php echo ($info["ONLOAD"]); ?><br />
										系统版本：<?php echo ($info["RUNTYPE"]); ?><br />
									</p>
								</div>
							</div>
						</div>
						<div class="widget-box sl-indextop10 text-left">
							<div class="widget-header">
								<h5 class="widget-title"><span style="font-size:14px; font-family:Microsoft YaHei">开发团队&贡献者</span></h5>
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<p class="alert alert-info sl-line-height25">
										YFCMF：<a href="http://www.rainfer.cn" target="_blank" alt="RainferCMF">www.rainfer.cn</a>
										<br />
										开发团队：Rainfer（<i class="ace-icon fa fa-qq"></i>:81818832）、Kenan2726（<i class="ace-icon fa fa-qq"></i>:86301216）<br />
									</p>
									<p class="alert alert-success">贡献者：
										<a>slackck</a>
									</p>
								</div>
							</div>
						</div>
					</div>

					<div class="vspace-12-sm"></div>

					<div class="col-sm-5">
						<!-- 安全检测开始 -->
						<div class="panel <?php if($system_safe): ?>panel-default<?php else: ?>panel-danger<?php endif; ?>">
						<div class="panel-heading">
							<i class="ace-icon fa fa-bolt"></i>
							<span class="icon-dashboard"></span> 系统安全检测
						</div>
						<div class="panel-body">
							<?php if($system_safe): ?><p class="text-success"><span class="glyphicon glyphicon-ok-sign"></span> 当前系统安全！</p><?php endif; ?>
							<?php if($weak_setting_db_password): ?><p class="text-danger"><span class="glyphicon glyphicon-info-sign"></span> 数据库连接密码为弱密码，安全起见，增强密码！</p><?php endif; ?>
							<?php if($weak_setting_admin_password): ?><p class="text-danger"><span class="glyphicon glyphicon-info-sign"></span> 检测到您的后台登录密码为弱密码！</p><?php endif; ?>
							<?php if($danger_mode_debug): ?><p class="text-warning"><span class="glyphicon glyphicon-info-sign"></span> 当前系统运行在调试模式，可能会影响运行性能及安全！</p><?php endif; ?>
							<?php if($system_pageshow): ?><p class="text-warning"><span class="glyphicon glyphicon-info-sign"></span>  当前系统已开SHOW_PAGE_TRACE</p><?php endif; ?>
							<?php if($weak_setting_admin_last_change_password): ?><p class="text-warning"><span class="glyphicon glyphicon-info-sign"></span>  您太久没有更换登陆密码了，请定期更换后台登陆密码！</p><?php endif; ?>
							<!--[if lte IE 8]>
							<p class="text-warning">
								<span class="glyphicon glyphicon-info-sign"></span> 浏览器版本过低！
							</p>
							<![endif]-->
						</div>
					</div>
					<!-- 安全检测结束 -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="ace-icon fa fa-wrench"></i>
							<span class="icon-desktop"></span> 日常维护
						</div>
						<table class="table">
							<tbody>
							<tr>
								<td colspan="2">
									<a href="<?php echo U('Sys/maintain',array('action'=>'download_log'));?>" target="_blank" class="btn btn-default maintain">下载日志</a>
									<a href="<?php echo U('Sys/maintain',array('action'=>'view_log'));?>" target="_blank" class="btn btn-default maintain">查看日志</a>
									<a href="<?php echo U('Sys/maintain',array('action'=>'clear_log'));?>" class="btn btn-default rst-url-btn maintain">清除日志</a>
									<?php if($debug): ?><a href="<?php echo U('Sys/maintain',array('action'=>'debug_off'));?>" class="btn btn-default rst-url-btn maintain">关闭调试</a>
										<?php else: ?>
										<a href="<?php echo U('Sys/maintain',array('action'=>'debug_on'));?>" class="btn btn-default rst-url-btn maintain">打开调试</a><?php endif; ?>
									<?php if($system_pageshow): ?><a href="<?php echo U('Sys/maintain',array('action'=>'trace_off'));?>" class="btn btn-default rst-url-btn maintain">关闭Trace</a>
										<?php else: ?>
										<a href="<?php echo U('Sys/maintain',array('action'=>'trace_on'));?>" class="btn btn-default rst-url-btn maintain">打开Trace</a><?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>日志大小 : <?php echo (format_bytes($log_size)); ?></td>
								<td>日志数 : <?php echo ($log_file_cnt); ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					<!-- 文章排行开始 -->
					<div class="widget-box widget-color-blue">
						<div class="widget-header">
							<h5 class="widget-title bigger lighter sl-font14">
								<i class="ace-icon fa fa-table"></i>
								<span style="font-size:14px; font-family:Microsoft YaHei">热门文章排行</span>
							</h5>
						</div>
						<div class="widget-body">
							<div class="widget-main no-padding">
								<table class="table table-striped table-bordered table-hover">
									<thead class="thin-border-bottom">
									<tr>
										<th width="68%">标题</th>
										<th width="17%"><em>点击数</em></th>
									</tr>
									</thead>
									<tbody>
									<?php $color=array("badge badge-pink","badge badge-yellow","badge badge-danger","badge badge-warning","badge badge-success","badge badge-inverse","badge badge-purple","badge badge-info","badge badge-grey","badge"); ?>
									<?php if(is_array($news_list)): foreach($news_list as $k=>$v): ?><tr>
											<td height="25"><span class="<?php echo ($color[$k]); ?>"><?php echo ($k+1); ?></span><a href="<?php echo U('Home/News/index',array('id'=>$v['n_id']));?>" target="_blank"><?php echo ($v["news_title"]); ?></a></td>
											<td><?php echo ($v["news_hits"]); ?></td>
										</tr><?php endforeach; endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- 文章排行结束 -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.col -->
	</div><!-- /.row -->
	</div>

			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder"><a href="http://www.rainfer.cn" target="_ablank">翰林轩书吧</a></span>
				后台管理系统 &copy; 2015-<?php echo date('Y');?>
			</span>
		</div>
	</div>
</div>

	<!-- 页脚结束 -->
	<!-- 返回顶端开始 -->
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
	<!-- 返回顶端结束 -->
</div><!-- 整个页面内结束 -->

<!-- ace的js,可以通过打包生成,避免引入文件数多 -->
<script src="/public/ace/js/ace.min.js"></script>
<!-- jquery.form、layer、yfcmf的js -->
<script src="/public/others/jquery.form.js"></script>
<script src="/public/others/maxlength.js"></script>
<script src="/public/layer/layer.js"></script>
<?php $t=time(); ?>
<script src="/public/yfcmf/yfcmf.js?<?php echo ($t); ?>"></script>
<!-- 此页相关插件js -->

<!-- 与此页相关的js -->
</body>
</html>