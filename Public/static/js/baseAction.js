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

	// 设置当前登录用户的姓名、头像和身份

	$.ajax({
		type:"get",
		url:"/base/selfSearch",
		success:function(data){
			$(".myName").html(data.UserName);
			$(".myFace").attr('src',data.Face);
			$(".cur-rolename").html("欢迎您！亲爱的用户，您的身份为："+data.RoleName);
		}

	});
	
	
});
