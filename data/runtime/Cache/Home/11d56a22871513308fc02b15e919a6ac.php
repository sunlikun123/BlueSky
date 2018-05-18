<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>主页</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="/public/qiantai/css/moblie.css">
	<link rel="stylesheet" href="/public/qiantai/css/main.css">
</head>
<body>
	<!--头部-->
	<div class="header">
		<b>翰林轩书吧</b>
		<a class="toInformation" href="<?php echo U('notice');?>">
        <img src="/public/qiantai/images/xx.png" alt="">
</a>
	</div>
	<div class="search">
		<input class="searchInput" type="text" id="content" placeholder="请输入书名或作者名">
		<input class="searchBtn" type="button" id="so" value="搜索">
	</div>
        <div class="mainBody">
            <p class="recommend f1">书吧环境</p>
            <div class="clear"></div>
            <div class="imgBox">
                <img src="public/qiantai/images/1.jpg">
                <img src="public/qiantai/images/2.jpg">
                <img src="public/qiantai/images/3.jpg">
                <img src="public/qiantai/images/4.jpg">
            </div>
        </div>
        <div id="sliderSegmentedControl">
            <div class="mui-scroll clear">
                    <a class="mui-control-item <?php if($cateid == 0): ?>active<?php endif; ?>" data-id='0' href="<?php echo U(index);?>">
                            全部
                    </a>
                <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><a class="mui-control-item <?php echo $cateid==$c['id']?'active':''?>" data-id='<?php echo ($c["id"]); ?>' href="<?php echo U(index,array('id'=>$c['id']));?>">
                            <?php echo ($c["title"]); ?>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
    </div>
        <style>
            .clear:after{
                clear:both
            }
            #sliderSegmentedControl{
                width:100%;
                overflow-x: scroll;
                overflow-y: visible;
                height: 45px!important;
            }
            .mui-scroll{
                /*width:800px;*/
                min-width:720px;
                height:30px;
            }
            .mui-scroll a{
                display:block;
                float:left;
                width:120px;
                text-align: center;
                font-size: 22px;
                line-height: 30px;
            }
            .mui-scroll .active{
                color: red;
            }
            
        </style>
	<div class="mainBody">
            
		<p class="recommend fl">全部书籍</p>
		<!--<a class="loadMore fr" href="<?php echo U('Book/hot');?>">查看全部>></a>-->
		<div class="clear"></div>
		<?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="mainBodyLi">
			<a href="javascript:void(0)">
				<img src="<?php echo ($vo["news_img"]); ?>" alt="<?php echo ($vo["news_title"]); ?>">
				<div class="fl mainBodyLidiv">
					<p class="bookName" data-id="<?php echo ($vo["n_id"]); ?>"><?php echo (msubstr($vo["news_title"],0,8,'utf-8',true)); ?></p>
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
        <a class='more'>加载更多</a>
        <style>
            .more{
                display:block;
                width:100px;
                height:40px;
                border:1px solid #CCC;
                background:#FFF;
                font-size: 22px;
            }
        </style>
	<div class="none"></div>
    <div class="bottomNav">
        <a class="ce9" href="<?php echo U('Book/index');?>">首页</a>
        <a href="<?php echo U('Book/hot');?>">热点</a>
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
                            alert("借阅失败,请登录后再试");
                        }
		}
	})
})
$("#so").click(function(){
	var so = $("#content").val();
	window.location.href="/index.php?m=Home&c=Book&a=so&so="+so;
})
var p = 2;
$(".more").on('click',function(){
    cateid = $(".active").attr("data-id");
    $.ajax({
		url:"<?php echo U('Book/more');?>",
		data:{cateid:cateid,p:p},
		success:function(data){
                    if(data.length == 0){
                        alert("没有更多内容")
                    }else{
                        console.log(data);
                        str = '';
                        for (dat in data){
                            str+='<li class="mainBodyLi">';
                            str+='<a href="javascript:void(0)">';
                                str+='<img src="'+data[dat].news_img+'" alt="'+data[dat].news_title+'">';
			    str+='	<div class="fl mainBodyLidiv">';
                            str+='		<p class="bookName" data-id="'+data[dat].n_id+'">'+data[dat].news_title+'</p>';
                            str+='        <div class="bookDescription">';
				str+='		<p>';
				str+='			<span>'+data[dat].news_auto+'</span>';
				str+='			<span>'+data[dat].news_tag+'</span>';
				str+='			<span>可借:'+data[dat].books_num+'</span>';
				str+='			<button data-id="'+data[dat].n_id+'"';
                                if(data[dat].books_num ==0){
                                    str+='disabled>借阅</button>';
                                }else{
                                    str+='>借阅</button>'
                                }
				str+='		</p>';
				str+='		<p>'+data[dat].news_content+'</p>';
				str+='	</div>';
				str+='</div>';
				str+='<div class="clear"></div>';
			str+='</a></li>';
                        }
                        console.log(str);
                        $('div.mainBody').append(str);
                        p=p+1;
                    }
                    
			
		}
	});
})
</script>
</html>