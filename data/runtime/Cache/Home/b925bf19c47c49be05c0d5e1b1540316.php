<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>个人中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/public/qiantai/css/moblie.css">
	<link rel="stylesheet" href="/public/qiantai/css/main.css">
</head>
<body>
	<!--头部-->
	<div class="header">
		<b>个人中心</b>
		<a class="toInformation" href="<?php echo U('notice');?>">
        <img src="/public/qiantai/images/xx.png" alt="">
</a>
	</div>
	<div class="centerBox">
		<li class="tx">
			<img class="centerImg fl" src="<?php echo ($headpic); ?>" alt="">
			<p class="fl"><?php echo ($nickname); ?></p>
			<div class="clear"></div>
		</li>
		<li>我的等级:<span style="color:#FF9900;"><?php echo ($group); ?></span></li>
		<li>我的积分 :<span style="color:#FF9900;"><?php echo ($score); ?></span></li>
		<li><a href="<?php echo U('Book/log');?>">消费记录</a></li>
		<li><a href="<?php echo U('Book/edit');?>">修改资料</a></li>
		<li>
			<a class="exit" href="<?php echo U('Book/logout');?>" >退出登录</a>
		</li>
	</div>
	<div class="none"></div>
	<div class="bottomNav">
		<a href="<?php echo U('Book/index');?>">首页</a>
		<a href="<?php echo U('Book/hot');?>">热点</a>
		<a href="<?php echo U('Book/hotsell');?>">畅销</a>
		<a class="ce9" href="<?php echo U('Book/my');?>">我的</a>
		<div class="clear"></div>
	</div>
	<script src="/public/qiantai/js/jquery-2.2.1.min.js"></script>
	<script src="/public/qiantai/js/adaption.js"></script>
	<script src="/public/qiantai/js/main.js"></script>
</body>
<script type="text/javascript">
  $(".header").
</script>
</html>