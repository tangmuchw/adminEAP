$(function() {
	$.ajax({
		type: 'get',
		url: '/base/myselfInfo',
		success: function(data) {
			console.log(data);
			$('#name').val(data.UserName);
			$('#email').val(data.Email);
			$('#phone').val(data.Phone);
			$('#age').val(data.Age);
//			console.log(data.Sex);
			$("input:radio[name='sex'][value='"+data.Sex+"']").attr('checked','checked');
			console.log(data.Address);
			var address = data.Address;
			console.log(address.substr(0,3));
			console.log(address.substr(4,3));
			console.log(address.substr(8,3));
			/*$('#provinceSelect').val(address.substr(0,3));
			$('#city').val(address.substr(4,3));
			$('#area').val('');
			$('#county').val(address.substr(8,3));*/
			
		}
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
	});

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
		$.ajax({
			type: 'get',
			url: '/base/myselfInfo',
			success: function(data) {
				console.log(data);
			},
			data: {
				img: roundedCanvas.toDataURL()
			}
		});
	});

	$('#upload_file').on('change', function() {
		readAsDataURL2();

	})

	//设置头像预览
	$uploadSure.on('click', function() {
		$('.preFace').attr('src', roundedCanvas.toDataURL());
		$("#upload_modal").modal('hide');

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
		console.log(file);
		if(!/image\/\w+/.test(file.type)) {
			alert("看清楚，这个需要图片！");
			return false;
		}
		var reader = new FileReader();
		//将文件以Data URL形式读入页面  
		reader.readAsDataURL(file);
		reader.onload = function(e) {
			console.log(e.target.result);
			var result = $(".cropper-canvas img");
			var result2 = $(".cropper-view-box img");

			//显示文件  
			result.attr('src', e.target.result);
			result2.attr('src', e.target.result);
		}
	}

});