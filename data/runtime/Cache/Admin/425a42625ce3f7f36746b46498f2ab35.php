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
		<link rel="stylesheet" type="text/css" media="all" href="/public/sldate/daterangepicker-bs3.css" />
		<form name="admin_list_sea" class="form-search form-horizontal" method="post" action="<?php echo U('goods_list');?>">
			<div class="row maintop">
				<div class="col-xs-12 col-sm-4">
<!--					<select name="keytype">
						<option value="news_title" <?php if(($keytype == 'news_title') or ($keytype == '')): ?>selected<?php endif; ?>>按标题</option>
						<option value="news_auto" <?php if($keytype == 'news_auto'): ?>selected<?php endif; ?>>按作者</option>
					</select>
					<select name="diyflag">
						<option value="">按属性</option>
						<?php if(is_array($diyflag)): foreach($diyflag as $key=>$v): ?><option value="<?php echo ($v["diyflag_value"]); ?>" <?php if($diyflag_check == $v['diyflag_value']): ?>selected<?php endif; ?>><?php echo ($v["diyflag_name"]); ?>(<?php echo ($v["diyflag_value"]); ?>)</option><?php endforeach; endif; ?>
					</select>-->
					<select name="opentype_check">
						<option value="">状态</option>
						<option value="1" <?php if($opentype_check == '1'): ?>selected="selected"<?php endif; ?>>上架中</option>
						<option value="0" <?php if($opentype_check == '0'): ?>selected="selected"<?php endif; ?> >下架</option>
					</select>
				</div>

				<div class="col-xs-12 col-sm-3 hidden-xs btn-sespan">
					<div class="input-group">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
										</span>
						<input type="text"  name="reservation" id="reservation" class="sl-date" value="<?php echo ($sldate); ?>" placeholder="点击选择日期范围"/>
					</div>
				</div>


				<div class="col-xs-12 col-sm-3 btn-sespan">
					<div class="input-group">
									<span class="input-group-addon">
										<i class="ace-icon fa fa-check"></i>
									</span>
						<input type="text" name="key" id="key" class="form-control search-query admin_sea" value="<?php echo ($keyy); ?>" placeholder="输入需查询的关键字" />
									<span class="input-group-btn">
										<button type="submit" class="btn btn-xs btm-input btn-purple">
											<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
											搜索
										</button>
									</span>
					</div>
				</div>

				<div class="input-group-btn">
					<a href="<?php echo U('goods_list');?>">
						<button type="button" class="btn btn-xs all-btn btn-purple">
							<span class="ace-icon fa fa-globe icon-on-right bigger-110"></span>
							显示全部
						</button>
					</a>
				</div>


			</div>
		</form>



		<div class="row">
			<div class="col-xs-12">
				<div>
					<form id="alldel" name="alldel" method="post" action="<?php echo U('news_alldel');?>" >
						<input name="p" id="p" value="<?php echo I('p',1);?>" type="hidden" />
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dynamic-table">
								<thead>
								<tr>
									<th class="hidden-xs center">
										<label class="pos-rel">
											<input type="checkbox" class="ace"  id='chkAll' onclick='CheckAll(this.form)' value="全选"/>
											<span class="lbl"></span>															</label>											</th>
									<th class="hidden-xs">ID</th>
									<th>图书</th>
									<th class="hidden-sm hidden-xs">所属栏目</th>
<!--									<th class="hidden-sm hidden-xs">文章属性</th>-->
									<th class="hidden-xs">库存</th>
									<th class="hidden-xs">审核</th>
									<th class="hidden-xs">发布时间</th>
									<th style="border-right:#CCC solid 1px;">操作</th>
								</tr>
								</thead>

								<tbody>

								<?php if(is_array($news)): foreach($news as $key=>$v): ?><tr>
										<td class="hidden-xs" align="center">
											<label class="pos-rel">
												<input name='n_id[]' id="navid" class="ace"  type='checkbox' value='<?php echo ($v["n_id"]); ?>'>
												<span class="lbl"></span>
											</label>
										</td>
										<td class="hidden-xs" align="center"><?php echo ($v["n_id"]); ?></td>
										<td><a href="" target="_blank" title="<?php echo ($v["news_title"]); ?>"><?php echo (subtext($v["news_title"],25)); ?></a>【<?php echo ($v['news_auto']); ?>】</td>
										<td class="hidden-sm hidden-xs"><?php echo ($v["title"]); ?></td>
<!--										<td class="hidden-sm hidden-xs">
											<?php if(strstr($v['news_flag'],'h') == true): ?><span style="color:#03C">头</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'c') == true): ?><span style="color:#060">荐</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'f') == true): ?><span style="color:#09F">幻</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'a') == true): ?><span style="color:#63C">特</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'s') == true): ?><span style="color:#C0C">滚</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'p') == true): ?><span style="color:#960">图</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'j') == true): ?><span style="color:#C00">跳</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'d') == true): ?><span style="color:#630">原</span><?php endif; ?>
											<?php if(strstr($v['news_flag'],'cp') == true): ?><span style="color:#438eb9">产</span><?php endif; ?>
										</td>-->
										<td class="hidden-xs"><?php echo ($v["books_num"]); ?></td>
										<td class="hidden-xs">
											<?php if($v['news_open'] == 1): ?><a class="red up-btn" href="<?php echo U('news_state');?>" data-id="<?php echo ($v["n_id"]); ?>" title="已审">
													<div id="zt<?php echo ($v["n_id"]); ?>"><button class="btn btn-minier btn-yellow">上架中</button></div>
												</a>
												<?php else: ?>
												<a class="red up-btn" href="<?php echo U('news_state');?>" data-id="<?php echo ($v["n_id"]); ?>" title="未审">
													<div id="zt<?php echo ($v["n_id"]); ?>"><button class="btn btn-minier btn-danger">下架</button></div>
												</a><?php endif; ?>
										</td>
										<td class="hidden-xs"><?php echo (date('Y-m-d',$v["news_time"])); ?></td>
										<td>
											<div class="hidden-sm hidden-xs action-buttons">
												<a class="green" href="<?php echo U('goods_edit',array('n_id'=>$v['n_id']));?>" title="修改">
													<i class="ace-icon fa fa-pencil bigger-130"></i>
												</a>
												<a class="red confirm-rst-url-btn" data-info="你确定要删除到回收站吗？" href="<?php echo U('goods_del',array('n_id'=>$v['n_id'],'p'=>I('p',1)));?>" title="回收站">
													<i class="ace-icon fa fa-trash-o bigger-130"></i>
												</a>
                                                                                                <a class="blue" href="<?php echo U('goods_add_kucun',array('n_id'=>$v['n_id']));?>" title="增加库存">
                                                                                                    <i class="ace-icon fa fa-plus-circle bigger-130"></i>										
                                                                                                </a>
                                                                                                <a class="blue" href="<?php echo U('goods_reduce_kucun',array('n_id'=>$v['n_id']));?>" title="卖出商品">
                                                                                                    <i class="ace-icon fa fa-flag bigger-130"></i>										
                                                                                                </a>
											</div>
											<div class="hidden-md hidden-lg">
												<div class="inline position-relative">
													<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
													</button>
													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														<li>
															<a href="<?php echo U('books_edit',array('n_id'=>$v['n_id']));?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="修改">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
															</a>
														</li>

														<li>
															<a href="<?php echo U('books_del',array('n_id'=>$v['n_id'],'p'=>I('p',1)));?>" data-info="你确定要删除到回收站吗？" class="tooltip-error confirm-rst-url-btn" data-rel="tooltip" title="" data-original-title="回收站">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</td>
									</tr><?php endforeach; endif; ?>
								<tr>
								
									<td colspan="8" align="right" class="hidden-xs"><?php echo ($page); ?></td>
									<td colspan="8" align="right" class="hidden-lg hidden-md hidden-sm"><?php echo ($page_min); ?></td>
								</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!-- /.page-content -->

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

	<script type="text/javascript" src="/public/sldate/moment.js"></script>
	<script type="text/javascript" src="/public/sldate/daterangepicker.js"></script>
    <script type="text/javascript">
        $('#reservation').daterangepicker(null, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    </script>

<!-- 与此页相关的js -->
</body>
</html>