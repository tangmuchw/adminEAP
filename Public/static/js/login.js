$(function() {

	//				设置自动登录

	/*$.ajax({
					method: "post",
					url: "php/autologin.php",
					data: {
						remember: sessionStorage.getItem('remember')
					},
					success: function(data) {
						var rep = $.parseJSON(data);
						if(rep.code == 1) {
							$("#email").val(rep.msg);
							var pwd = sessionStorage.getItem(rep.msg);
//							console.log(pwd);
							$("#password").val(pwd);
							$('#tipsModal2').modal();
							$(".spinner").css("display", "block");
							setTimeout(function() {
								location.href = "home.html";
							}, 3000);
						}else{
							$("#tipsModal2").css("display","none");
							
						}

					}

				});*/

	/*var json = [{"email":"123@163.com","username":"\u80d6\u732b\u54aa","password":"123123"}]
	console.log(json[0].email)*/
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('#loginForm').bootstrapValidator({
		fields: {
			email: {
				validators: {
					notEmpty: {
						message: '请输入邮箱'
					},
					emailAddress: {
						message: '请输入格式正确的邮箱'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: '请输入密码'
					}
				}
			}

		}
	});

	// Validate the form manually
	$('#validateBtn').click(function() {
		var loginForm = $('#loginForm');
		loginForm.data('bootstrapValidator').validate();
		//是否通过校验
		if(!loginForm.data('bootstrapValidator').isValid()) {
			// 没有通过校验
			loginForm.bootstrapValidator('validate');

		} else {
			// 通过校验

			// console.log(loginForm.data('bootstrapValidator').isValid());
			var email = $("#email").val();
			var pwd = $("#password").val();
			var remember = $("#remember")[0].checked ? 1 : 0;
			//						console.log(remember);
			sessionStorage.setItem("remember", remember);

			$.ajax({
				type: "post",
				url: "/login",
				data: {
					email: email,
					pwd: pwd,
					remember: remember
				},
				success: function(data) {
					if(data.code == 1) {
						//									success
						$('#tipsModal').modal();
						$("#response-erro").html(data.msg);
						$(".spinner").css("display", "block");
						//保存密码
						sessionStorage.setItem("pwd", pwd);
						var home;
						home = data.index;
						setTimeout(function() {
							location.href = home;
						}, 2000);
					} else {
						$(".error-tips").css('display', 'block');
						$(".error-tips").html(data.msg);
					}

				},
				error: function(er) {
					var response = $.parseJSON(er);
					$("#response-erro").html(er.msg);
					$(".spinner").css("display", "none");
				}

			})

		}

	});

});