<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>热门推荐</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/public/qiantai/css/moblie.css">
	<link rel="stylesheet" href="/public/qiantai/css/main.css">
</head>
<body>
	<!--头部-->
	<div class="header">
		<b>热门推荐</b>
		<a class="toInformation" href="<?php echo U('notice');?>">
        <img src="/public/qiantai/images/xx.png" alt="">
</a>
	</div>
	<div class="mainBody">
		<?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="mainBodyLi">
			<a href="javascript:void(0)">
				<img src="<?php echo ($vo["news_img"]); ?>" alt="<?php echo ($vo["news_title"]); ?>">
				<div class="fl mainBodyLidiv">
					<p class="bookName"><?php echo (msubstr($vo["news_title"],0,8,'utf-8',true)); ?></p>
					<div class="bookDescription">
						<p>
							<span><?php echo ($vo["news_auto"]); ?></span>
							<span><?php echo ($vo["news_tag"]); ?></span>
							<span>可借:<?php echo ($vo["books_num"]); ?></span>
							<button data-id="<?php echo ($vo["n_id"]); ?>" <?php if($vo["books_num"] > 0): else: ?> disabled<?php endif; ?> >借阅</button>
						</p>
						<p><?php echo (msubstr($vo["news_content"],0,20,'utf-8',true)); ?></p>
					</div>
				</div>
				<div class="clear"></div>
			</a>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
		
	</div>
	
	<div class="none"></div>
	<div class="bottomNav">
		<a href="<?php echo U('Book/index');?>">首页</a>
		<a class="ce9" href="<?php echo U('Book/hot');?>">热点</a>
		<a href="<?php echo U('Book/hotsell');?>">畅销</a>
		<a href="<?php echo U('Book/my');?>">我的</a>
		<div class="clear"></div>
	</div>
	<script src="/public/qiantai/js/jquery-2.2.1.min.js"></script>
	<script src="/public/qiantai/js/adaption.js"></script>
	<script src="/public/qiantai/js/main.js"></script>
</body>
<script>
$("button").click(function(){
	var bookid = $(this).attr("data-id");
	
	$.ajax({
		url:"<?php echo U('Book/borrow');?>",
		data:{bookid:bookid},
		success:function(data){
			console.log(data);
			if(data.status)
				{
				    
				    alert('借阅成功');
				    location.reload() 
				}
                        else{
                            alert("借阅失败，请登录后再试");
                        }
		}
	})
})
</script>
</html>