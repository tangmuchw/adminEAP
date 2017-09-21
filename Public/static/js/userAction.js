$(function(){
	
	$("#exit-btn").click(function(){
		$.ajax({
			type:"get",
			url:"/loginout",
		});
	});
	
	
});
