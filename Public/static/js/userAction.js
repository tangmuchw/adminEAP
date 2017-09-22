$(function(){
	
	// 退出按钮设置
	$("#exit-btn").click(function(){
		$.ajax({
			type:"get",
			url:"/loginout",
			success:function(data){
				location.href = '/login';
			}
		});
	});

	// 设置当前登录用户的姓名和头像

	$.ajax({
		type:"get",
		url:"/user/selfSearch",
		success:function(data){
			$(".myName").html(data.UserName);
			$(".myFace").attr('src',data.Face);
		}

	});
	
	
});
