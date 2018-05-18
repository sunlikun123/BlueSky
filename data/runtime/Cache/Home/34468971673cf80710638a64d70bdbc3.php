<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/public/qiantai/css/moblie.css">
	<link rel="stylesheet" href="/public/qiantai/css/main.css">
</head>
<body>
	<!--头部-->
	<div class="header">
		<b>注册</b>
		<a class="toIndex" href="<?php echo U('Book/index');?>">
			首页
		</a>
	</div>
	<div class="loginMain">
		<li>
			<input class="loginInput loginCart" type="text" id="username" placeholder="请输入用户名">
		</li>
		<li>
			<input class="loginInput loginPass" type="password" id="pass" placeholder="请输入密码">
		</li>
		<li>
			<input class="loginBtn" type="button" id="loginBtn" value="注册">
		</li>
		<li>
			<input class="loginReg" type="button" value="已有账号点此登录">
		</li>
	</div>
	<script src="/public/qiantai/js/jquery-2.2.1.min.js"></script>
	<script src="/public/qiantai/js/adaption.js"></script>
	<script src="/public/qiantai/js/main.js"></script>
	
	<script>
	$(".loginReg").click(function(){
		window.location.href="<?php echo U('Book/login');?>"
	})
	$("#loginBtn").click(function(){
		var username = $("#username").val();
		var pass = $("#pass").val();
		var url = "<?php echo U('Book/reg');?>";
		
		$.ajax({url:url,data:{username:username,pass:pass},success:function(data){
			if(data.status)
				{
					alert("注册成功");
					window.location.href="<?php echo U('Book/login');?>";
				}
			else{
				alert("用户名被占用")
			}
			
		}
		})
	})
	</script>
</body>

</html>