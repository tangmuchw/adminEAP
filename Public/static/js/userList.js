$(function() {
	//				初始化datatables
	var searchParams = {};
	var table = $('#example1').DataTable({
		//						"processing": true,
		"serverSide": true,
		"scrollX": true,
		"autoWidth": true,
		"ajax": {
			"url": '/user/info',
			"type": "get",
			"data": function(d) {
				if(searchParams) {
					$.extend(d, searchParams); //给d扩展参数
				}
			}
		},
		"ordering": false,
		"searching": false,
		//						"fnServerData": retrieveData,//分页回调函数
		"columns": [{
				"data": "ID"
			},
			{
				"data": "UserName"
			},
			{
				"data": "Email"
			},
			{
				"data": "Phone"
			},
			{
				"data": "Sex"
			},
			{
				"data": "Age"
			},
			{
				"data": "State"
			},
			{
				"data": "Address"
			}
			/*,{
				"data": 'btn'
			}*/
		],
		"language": {
			"sProcessing": "处理中...",
			"lengthMenu": "每页 _MENU_ 条记录",
			"zeroRecords": "没有找到记录",
			"info": "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
			"infoEmpty": "无记录",
			"infoFiltered": "(从 _MAX_ 条记录过滤)",
			"sUrl": "",
			"sEmptyTable": "表中数据为空",
			"sLoadingRecords": "载入中...",
			"sInfoThousands": ",",
			"search": "按姓名搜索:",
			"oPaginate": {
				"sFirst": "首页",
				"sPrevious": "上页",
				"sNext": "下页",
				"sLast": "末页"
			},
			"oAria": {
				"sSortAscending": ": 以升序排列此列",
				"sSortDescending": ": 以降序排列此列"
			}

		}
	});
	//					return table;
	//				}

	//添加按钮
	var btns = $("<input type='text' class='form-control' placeholder='按姓名搜索...' id='search-value'><div class='btn-group'><button type='button' class='btn btn-default' style='margin-left:5px' id='selectUser-btn'>查询</button><button type='button' class='btn btn-default' id='reset-datatable'>重置</button></div><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#addinfo' style='margin-left:5px'>新增</button><button type='button' class='btn btn-default'  data-toggle='modal' data-target='#update'>编辑</button><button type='button' class='btn btn-default' data-toggle='modal'  data-target='#delete'>删除</button></div>");

	var a = $("#example1_wrapper .row").first().find(".col-sm-6").last();
	a.append(btns);

	//				新增用户信息
	$("#addinfo-btn").click(function() {
		var newUsername = $("#addNewUserName").val();
		var newPwd = $("#addNewPassword").val();
		var newEmail = $("#addNewEmail").val();
		$.ajax({
			type: "post",
			url: "/user/add",
			data: {
				"newUserName": newUsername,
				"newPwd": newPwd,
				"newEmail": newEmail
			},
			success: function(data) {
				$(".myModalTips").css("display", "block");
				if(data.code == 0) {
					$("#addTips-error").html(data.msg);

				} else {
					$("#addTips-error").html(data.msg);
				}
				//							console.log("添加成功");
			},
			error: function(er) {
				$("#addTips-error").html('服务器错误');
			}

		});
	});

	var deleteUserEmail; //得到要被删除的邮箱
	$("#delete-sure").click(function() {
		$.ajax({
			type: "post",
			url: "/user/delete",
			data: {

				"email": deleteUserEmail
			},
			success: function(data) {
				if(data.code == 0) {
					setTimeout(function() {
						location.reload();
					}, 1000)

				} else {
					$("#delete-error").html(data.msg);
				}
				//							console.log("添加成功");
			},
			error: function(er) {
				$("#deleteTips-error").html('服务器错误');
			}

		});
	});

	//	console.log(table.data());
	//查询用户
	$("#selectUser-btn").on('click', function() {
		//					console.log(1);
		var searchValue = $("#search-value").val();
		searchParams.searchValue = searchValue;
		table.ajax.url('/user/select').load();
	});

	//编辑用户

	var userInfoJson;

	function updateUser() {
		$("#update-username").val(userInfoJson.UserName);
		$("#update-email").val(userInfoJson.Email);
		$("#update-phone").val(userInfoJson.Phone);
		$("#update-sex").val(userInfoJson.Sex);
		$("#update-age").val(userInfoJson.Age);
		$("#update-address").val(userInfoJson.Address);
		$("#update-state").val(userInfoJson.State);
		var email = userInfoJson.Email;
		//					console.log(state);
		$("#update-sure").click(function() {
			var state = $("#update-state").val();
			$.ajax({
				type: "post",
				url: "/user/update",
				data: {
					email: email,
					state: state
				},
				success: function(data) {
					$(".myModalTips").css("display", "block");
					if(data.code == 1) {
						$("#updateTips-error").html(data.msg);
						setTimeout(function() {
							location.reload();
						}, 1000)

					} else {
						$("#updateTips-error").html(data.msg);
					}
					//							console.log("添加成功");
				}
			});

		});

	}

	//				重置按钮
	$("#reset-datatable").click(function() {
		table.ajax.url('/user/info').load();
	})

	//判断当前表格的行是否选中行
	var isSelect = false;

	if(!isSelect) {
		$("#delete-error").html('请选择一行数据!');
		$("#delete-sure").attr('disabled', 'disabled');
		//					设置update
		$(".update-info").css("display", "none");
		$("#update-sure").attr('disabled', 'disabled');
		$("#updateTips-error").html('请选择一行数据');
	} else {

		$("#delete-error").html("是否要删除(姓名为：" + username + ")该行数据!");
		$("#delete-sure").removeAttr('disabled');
		$("#update-sure").removeAttr('disabled');
		$(".update-info").css("display", "block");
		$(".myModalTips").css("display", "none");

	}

	//				表格的行点击事件
	$('#example1 tbody').on('click', 'tr', function(event) {
		if($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			isSelect = false;
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			isSelect = true;

		}
		//					console.log(isSelect);
		//					console.log(table.row(this).data().ID);
		var username = table.row(this).data().UserName;
		deleteUserEmail = table.row(this).data().Email;
		userInfoJson = table.row(this).data();
		//					console.log(username);
		//					dataJson =  JSON.parse(table.row(this).data());
		//					console.log(dataJson);
		//					console.log(userInfoJson);
		//判断是否被选中
		if(!isSelect) {
			$("#delete-error").html('请选择一行数据!');
			$("#delete-sure").attr('disabled', 'disabled');
			//					设置update
			$(".update-info").css("display", "none");
			$("#update-sure").attr('disabled', 'disabled');

			$("#updateTips-error").html('请选择一行数据');
		} else {

			$("#delete-error").html("是否要删除(姓名为：" + username + ")该行数据!");
			$("#delete-sure").removeAttr('disabled');
			$("#update-sure").removeAttr('disabled');
			$(".update-info").css("display", "block");
			$(".myModalTips").css("display", "none");
			updateUser();

		}
	});

	//				给无效状态添加红色标记
	table.on('draw', function() {
		column6 = table.column(6).data();
		nodes = table.column(6).nodes().to$();
		//					table.column(6).addclass
		//					console.log(nodes[1]);
		//					nodes.toJQuery().addClass('addRedColor');

		for(var i = 0; i < column6.length; i++) {
			if(column6[i] == '无效') {
				nodes.eq(i).addClass('addRedColor');

			}

		}

	});
});