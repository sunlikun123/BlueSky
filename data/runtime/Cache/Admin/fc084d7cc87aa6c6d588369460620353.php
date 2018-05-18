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
		<!--主题-->
		<div class="page-header">
			<h1>
				您当前操作
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					修改图书
				</small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal ajaxForm2" name="form0" method="post" action="<?php echo U('books_runedit');?>"  enctype="multipart/form-data">
					<input type="hidden" name="n_id" id="n_id" value="<?php echo ($news_list["n_id"]); ?>" />

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书所属分类： </label>
						<div class="col-sm-10">
							<select name="news_columnid"  class="col-sm-3 " required>
								<option value="">请选择所属分类</option>
								<?php if(is_array($menu)): foreach($menu as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if($v["id"] == $news_list['news_columnid']): ?>selected<?php endif; ?> style="margin-left:55px;"><?php echo ($v["lefthtml"]); echo ($v["title"]); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书名称：  </label>
						<div class="col-sm-10">
							<input type="text" name="news_title" id="news_title"  value="<?php echo ($news_list["news_title"]); ?>"   class="col-xs-10 col-sm-6" required/>
							<!--<input type="text" name="news_titleshort" id="news_titleshort"  value="<?php echo ($news_list["news_titleshort"]); ?>" placeholder="简短标题，建议6~12字数" class="col-xs-10 col-sm-4" style="margin-left:10px;" />-->
                                            <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle" id="resone"></span>
											</span>
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书属性：  </label>
						<div class="checkbox">
							<?php if(is_array($diyflag)): foreach($diyflag as $key=>$diyflag): ?><label id="news_flag_<?php echo ($diyflag["diyflag_value"]); ?>">
									<input <?php if(strstr($news_list['news_flag'],$diyflag['diyflag_value']) == true): ?>checked<?php endif; ?> class="ace ace-checkbox-2" name="news_flag[]" type="checkbox" id="news_flag_va<?php echo ($diyflag["diyflag_value"]); ?>" value="<?php echo ($diyflag["diyflag_value"]); ?>" />
									<span class="lbl"> <?php echo ($diyflag["diyflag_name"]); ?></span>
								</label><?php endforeach; endif; ?>
						</div>
					</div>
					<div class="space-4"></div>
					<div class="form-group" >
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书价格：  </label>
						<div class="col-sm-10">
                                                    <input type="text" name="news_cpprice" value="<?php echo ($news_list["news_cpprice"]); ?>" id="news_cpprice" placeholder="图书价格" class="col-xs-10 col-sm-6" />
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 作者：  </label>
						<div class="col-sm-10">
							<input type="text" name="news_auto" id="news_key"  value="<?php echo ($news_list["news_auto"]); ?>"  placeholder="" class="col-xs-10 col-sm-6" />
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 出版社：  </label>
						<div class="col-sm-10">
							<input type="text" name="news_source" id="news_source" value="<?php echo ($news_list["news_source"]); ?>" class="col-xs-10 col-sm-2" />
<!--							<label class="input_last">
								常用：
								<?php if(is_array($source)): $i = 0; $__LIST__ = $source;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$k): $mod = ($i % 2 );++$i;?><a class="btn btn-minier btn-yellow" href="javascript:;" onclick="return souadd('<?php echo ($k["source_name"]); ?>');" ><?php echo ($k["source_name"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
							</label>-->
						</div>
					</div>
					<div class="space-4"></div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 封面图片上传： </label>
						<div class="col-sm-10">
							<input type="hidden" name="checkpic" id="checkpic" value="<?php echo ($news_list["news_img"]); ?>" />
							<input type="hidden" name="oldcheckpic" id="oldcheckpic" value="<?php echo ($news_list["news_img"]); ?>" />
							<a href="javascript:;" class="file" title="点击选择所要上传的图片">
								<input type="file" name="pic_one[]" id="file0" multiple="multiple"/>
								选择上传文件
							</a>
							<span class="lbl">&nbsp;&nbsp;<img src="<?php if($news_list["news_img"] != ''): ?><?php echo ($news_list["news_img"]); else: ?>/public/img/no_img.jpg<?php endif; ?>" width="100" height="70" id="img0" ></span>&nbsp;&nbsp;<a href="javascript:;" onclick="return backpic('<?php if($news_list["news_img"] == ''): ?>/public/img/no_img.jpg<?php else: ?><?php echo ($news_list["news_img"]); endif; ?>');" title="还原修改前的图片" class="file">
							撤销修改
							</a>
											<span class="lbl">&nbsp;&nbsp;上传前先用PS处理成等比例图片后上传，默认比例100*70、600*420、800*560像素<br />
</span>
						</div>
					</div>
					<div class="space-4"></div>


					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书封面图集： </label>
						<div class="col-sm-10">
							<div class="radio" >
								<label>
									<input name="news_pic_type" <?php if($news_list['news_pic_type'] == 1): ?>checked<?php endif; ?> id="news_pic_list" checked type="radio" class="ace" value="1"/>
									<span class="lbl"> 无图模式</span>
								</label>
								<label>
									<input name="news_pic_type" <?php if($news_list['news_pic_type'] == 2): ?>checked<?php endif; ?> id="news_pic_qqlist" type="radio" class="ace" value="2"/>
									<span class="lbl"> 多图模式</span>
								</label>
								<?php if($news_list['news_pic_type'] == 2): ?><label>
										<span class="btn btn-minier btn-success"  data-toggle="modal" data-target="#myModal">查看已上传的图片</span>
									</label><?php endif; ?>
							</div>
						</div>
					</div>
					<div class="space-4"></div>
					<link href="/public/ppy/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
                    <script src="/public/ppy/js/fileinput.js" type="text/javascript"></script>
                    <script src="/public/ppy/js/fileinput_locale_zh.js" type="text/javascript"></script>
					<div class="form-group" id="pic_list" <?php if($news_list['news_pic_type'] == 1): ?>style="display:none"<?php endif; ?>>
					<div class="col-sm-10 col-sm-offset-2" style="padding-top:5px;">
						<input id="file-5" name="pic_all[]" type="file" class="file"  multiple data-preview-file-type="any" data-upload-url="#" data-preview-file-icon=""><br />
						<textarea name="news_pic_content" class="col-xs-12 col-sm-12" id="news_pic_content"  placeholder="多图对应文章说明，例如： 图片一说明 | 图片二说明 | 图片三说明    每个文字说明以 | 分割" ><?php echo ($news_list['news_pic_content']); ?></textarea>
					</div>
			</div>
			<div class="space-4"></div>
			<!--老多图字符串-->
			<input name="pic_oldlist" type="hidden" id="pic_oldlist" type="text" size="130" value="<?php echo ($news_list["news_pic_allurl"]); ?>" >
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否审核： </label>
				<div class="col-sm-10" style="padding-top:5px;">
					<input name='news_open' id='news_open' <?php if($news_list['news_open'] == 1): ?>checked<?php endif; ?>  value='1' class='ace ace-switch ace-switch-4 btn-flat' type='checkbox' />
					<span class="lbl">&nbsp;&nbsp;默认关闭</span>
				</div>
			</div>
			<div class="space-4"></div>

			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书简介： </label>
				<div class="col-sm-9">
					<input type="text" name="news_scontent" id="news_scontent" class="col-xs-10 col-sm-10"  maxlength="100" value="<?php echo ($news_list["news_scontent"]); ?>"  placeholder="输入文章简介"  />
					<label class="input_last">已限制在100个字以内</label>
				</div>
			</div>
			<div class="space-4"></div>

			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 图书其他内容 </label>
				<div class="col-sm-10">
					<script src="/public/ueditor/ueditor.config.js" type="text/javascript"></script>
					<script src="/public/ueditor/ueditor.all.js" type="text/javascript"></script>
					<textarea name="news_content" rows="100%" style="width:100%" id="myEditor"><?php echo ($news_list["news_content"]); ?></textarea>
					<script type="text/javascript">
						var editor = new UE.ui.Editor();
						editor.render("myEditor");
					</script>
				</div>
			</div>
			<div class="space-4"></div>

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="submit">
						<i class="ace-icon fa fa-check bigger-110"></i>
						保存
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						重置
					</button>
				</div>
			</div>
			</form>
		</div>
        <!-- 显示模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            操作已上传的多图
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">


                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <ul>
                                            <?php if(is_array($pic_list)): $i = 0; $__LIST__ = $pic_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="file-preview-frame" data-fileindex="0" id="id<?php echo ($i); ?>">
                                                    <img src="<?php echo ($v); ?>" class="file-preview-image" style="width:auto;height:160px;">
                                                    <div class="file-thumbnail-footer">
                                                        <div class="file-actions">
                                                            <div class="file-footer-buttons">
                                                                <a class="red" href="javascript:;" onclick="return delall(<?php echo ($i); ?>,'<?php echo ($v); ?>');" title="回收站">
                                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                </a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="space-4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            若想取消修改，请刷新当前页面
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            关闭
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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

	<script>
        $("#news_pic_list").click(function(){
            $("#pic_list").hide();
        });
        $("#news_pic_qqlist").click(function(){
            $("#pic_list").show();
        });
        if(!$("#news_flag_vaj").attr("checked")){
            $("#pptaddress").hide();
        }
        $("#news_flag_vaj").click(function(){
            $("#pptaddress").toggle(400);
        });
        if(!$("#news_flag_vacp").attr("checked")){
            $("#cpprice").hide();
        }
        $("#news_flag_vacp").click(function(){
            $("#cpprice").toggle(400);
        });
	</script>

<!-- 与此页相关的js -->
</body>
</html>