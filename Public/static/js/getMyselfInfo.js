$(function() {
	$.ajax({
		type: 'get',
		url: '/base/getMyselfInfo',
		success: function(data) {
			//			console.log(data);
			$('#name').val(data.UserName);
			$('#email').val(data.Email);
			$('#phone').val(data.Phone);
			$('#age').val(data.Age);
			$(".sex[value='" + data.Sex + "']").attr('checked', 'checked');
			//			console.log(data.Address);
			$(".address").html(data.Address);

		}
	});
	
	//	设置修改地址的显示
	$('.updateAddress-icon').on("click", function() {
		$('.address-update').toggle();
	});

	var $image = $('#image');
	var $button = $('#cropper-button');
	var $result = $('#result');
	var $uploadSure = $('#upload-sure');
	var croppable = false;

	$image.cropper({
		aspectRatio: 1,
		viewMode: 1,
		ready: function() {
			croppable = true;
		}
	});;

	var croppedCanvas;
	var roundedCanvas;
	$button.on('click', function() {

		if(!croppable) {
			return;
		}

		// Crop
		croppedCanvas = $image.cropper('getCroppedCanvas');

		// Round
		roundedCanvas = getRoundedCanvas(croppedCanvas);

		// Show
		$result.html('<img src="' + roundedCanvas.toDataURL() + '">');
		//				console.log(roundedCanvas.toDataURL());

	});

	$('#upload_file').on('change', function() {
		readAsDataURL2();

	})

	//设置头像预览
	$uploadSure.on('click', function() {
		if(roundedCanvas.toDataURL()) {
			$('.preFace').attr('src', roundedCanvas.toDataURL());
		}

	});

	//	创建截图的圆形界面
	function getRoundedCanvas(sourceCanvas) {
		var canvas = document.createElement('canvas');
		var context = canvas.getContext('2d');
		var width = sourceCanvas.width;
		var height = sourceCanvas.height;

		canvas.width = width;
		canvas.height = height;
		context.beginPath();
		context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI);
		context.strokeStyle = 'rgba(0,0,0,0)';
		//			stroke() 方法会实际地绘制出通过 moveTo() 和 lineTo() 方法定义的路径
		context.stroke();
		context.clip();
		context.drawImage(sourceCanvas, 0, 0, width, height);

		return canvas;
	}

	//h5读取图片文件
	function readAsDataURL2() {
		//检验是否为图像文件  
		var file = document.getElementById("upload_file").files[0];
//		console.log(file);
		if(!/image\/\w+/.test(file.type)) {
			alert("看清楚，这个需要图片！");
			return false;
		}
		var reader = new FileReader();
		//将文件以Data URL形式读入页面  
		reader.readAsDataURL(file);
		reader.onload = function(e) {
			//			console.log(e.target.result);
			var result = $(".cropper-canvas img");
			var result2 = $(".cropper-view-box img");

			//显示文件  
			result.attr('src', e.target.result);
			result2.attr('src', e.target.result);
		}
	}

	//	验证有效性
	$('#user-form').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {
						message: '请输入姓名'
					}
				}
			},
			phone: {
				validators: {
					notEmpty: {
						message: '请输入电话'
					},
					stringLength: {
						min: 11,
						max: 11,
						message: '请输入11位手机号码'
					},
					regexp: {
						regexp: /^1[3|5|8]{1}[0-9]{9}$/,
						message: '请输入正确的手机号码'
					}
				}
			}

		}
	});

	//	修改个人资料提交按钮
	$("#myselfinfo-update-btn").on('click', function() {
		var name = $('#name').val();
		var phone = $('#phone').val();
		var age = $("#age option:selected").val();
		var address;
		var pro = $('#provinceSelect option:selected').val();
		var city = $('#city option:selected').val();
		var county = $('#county option:selected').val();
		var sex = $(".sex:checked").val();
		var face = $('.preFace').attr('src');
		if(pro == '请选择省') {
			address = $('.address').html();
		} else {
			address = pro + ' ' + city + ' ' + county;

		}
		//		console.log(name + phone + age + sex + address + face);
		var userForm = $('#user-form');
		userForm.data('bootstrapValidator').validate();
		//是否通过校验
		if(!userForm.data('bootstrapValidator').isValid()) {
			// 没有通过校验
			userForm.bootstrapValidator('validate');
			$('#myselfinfo-update_modal').modal();
			$(".update-my-error").html("请输入格式正确的信息");

		} else {
			// 通过校验
			$.ajax({
				type: 'post',
				url: '/base/setMyselfInfo',
				data: {
					name: name,
					phone: phone,
					age: age,
					sex: sex,
					address: address,
					face: face
				},
				success: function(data) {
					$('#myselfinfo-update_modal').modal();
					$(".update-my-error").html(data.msg);
					$('#update-my-sure').on('click', function() {
						$('#myselfinfo-update_modal').modal('hide');
						setTimeout(function() {
							location.reload();
						}, 1000);
					});

				}
			})
		}

	});

});