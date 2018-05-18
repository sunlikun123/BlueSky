<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>消费记录</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/public/qiantai/css/moblie.css">
	<link rel="stylesheet" href="/public/qiantai/css/main.css">
</head>
<body>
	<!--头部-->
	<div class="header">
		<b>消费记录</b>
		<a class="toInformation" href="<?php echo U('notice');?>">
        <img src="/public/qiantai/images/xx.png" alt="">
</a>
	</div>
	<div class="recordMain">
		<?php if(is_array($loglist)): $i = 0; $__LIST__ = $loglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
			《<?php echo ($vo["news_title"]); ?>》&nbsp;&nbsp;
			<span><?php echo (date('Y-m-d h:i:s',$vo["borrow_time"])); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#FF9900;">0.5元</span>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="none"></div>
	<div class="bottomNav">
		<a href="<?php echo U('Book/index');?>">首页</a>
		<a href="<?php echo U('Book/hot');?>">热点</a>
		<a href="<?php echo U('Book/hotsell');?>">畅销</a>
		<a href="<?php echo U('Book/my');?>">我的</a>
		<div class="clear"></div>
	</div>
	<script src="/public/qiantai/js/jquery-2.2.1.min.js"></script>
	<script src="/public/qiantai/js/adaption.js"></script>
	<script src="/public/qiantai/js/main.js"></script>
</body>
</html>