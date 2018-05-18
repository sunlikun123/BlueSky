$(function(){
	//列表点击查看详情
	$(".mainBodyLi").click(function(){
		$(this).find(".disNone").slideToggle();
		$(this).siblings().find(".disNone").slideUp();
	})
	//消息中心切换
	$(".messageBox li")	.click(function(){
		$(this).addClass("select").siblings().removeClass("select");
		var n = $(this).index();
		$(".infoBox").hide();
		$(".infoBox").eq(n).show();
	})
})