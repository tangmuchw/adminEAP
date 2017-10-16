$(function() {
	//				初始化datatables
	var searchParams = {};
	var tableRoleInfo = $('#roleInfo').DataTable({
		//						"processing": true,
		"serverSide": true,
		"scrollX": true,
		"autoWidth": true,
		"bLengthChange": false,
		"ajax": {
			"url": '/role/info',
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
				"data": "RoleName"
			}
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
	var btns = $("<div class='floatright'><input type='text' class='form-control' placeholder='请输入名称...' id='search-value'><div class='btn-group'><button type='button' class='btn btn-default' style='margin-left:5px' id='selectUser-btn'>查询</button><button type='button' class='btn btn-default' id='reset-datatable'>重置</button></div><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#addinfo' style='margin-left:5px'>新增</button><button type='button' class='btn btn-default'  data-toggle='modal' data-target='#update' id='role-update'>编辑</button><button type='button' class='btn btn-default' data-toggle='modal'  data-target='#delete' id='role-delete'>删除</button></div></div>");

	var a = $(" #roleInfo_wrapper .row").first().find(".col-sm-6").last();
	a.removeClass("col-sm-6");
	a.addClass("col-sm-12 left20");
	a.append(btns);

	//				新增角色信息

	$("#addinfo-sure").click(function() {
		var newRoleName = $("#addNewRoleName").val();
		var newID = $("#addNewID").val();
		$.ajax({
			type: "post",
			url: "/role/add",
			data: {
				"newRoleName": newRoleName,
				"newID": newID
			},
			success: function(data) {
				if(data.code == 0) {
					$(".modalTips").css("display", "block");
					$("#addTips-error").html(data.msg);

				} else {
					$(".modalTips").css("display", "block");
					$("#addTips-error").html(data.msg);
					tableRoleInfo.ajax.url('/role/info').load();

				}
			}
		});
	});
	//				判断左侧表格是否被选中
	var isSelect = false;
	leftSelectTips();

	var deleteRoleID; //得到要被删除的角色id
	$("#delete-sure").click(function() {
		$.ajax({
			type: "post",
			url: "/role/delete",
			data: {

				"roleID": deleteRoleID
			},
			success: function(data) {
				if(data.code == 0) {
					$("#usertorole-delete-error").html(data.msg);

				} else {
					$("#usertorole-delete-error").html(data.msg);
					tableRoleInfo.ajax.url('/role/info').load();

				}
				//							console.log("添加成功");
			},
			error: function(er) {
				$("#usertorole-delete-error").html('服务器错误');
			}

		});
	});

	//查询角色
	$("#selectUser-btn").on('click', function() {
		//					console.log(1);
		var searchValue = $("#search-value").val();
		searchParams.searchValue = searchValue;
		tableRoleInfo.ajax.url('/role/select').load();
		tableUsertoRole.ajax.url('/role/usertorole').load();
		isClick = false;
	});

	//编辑用户

	var roleInfoJson;

	function updateUser() {
		$('.update-info').css('display', 'block');
		$('.myModalTips').css('display', 'none');
		$("#update-rolename").val(roleInfoJson.RoleName);
		$("#update-roleID").val(roleInfoJson.ID);
		//					console.log(state);
		$("#update-sure").click(function() {
			var rolename = $("#update-rolename").val();
			var roleID = $("#update-roleID").val();
			$.ajax({
				type: "post",
				url: "/role/update",
				data: {
					rolename: rolename,
					roleID: roleID
				},
				success: function(data) {
					if(data.code == 1) {
						$(".modalTips").css("display", "block");
						$("#updateTips-error").html(data.msg);
						tableRoleInfo.ajax.url('/role/info').load();

					} else {
						$(".modalTips").css("display", "block");
						$("#updateTips-error").html(data.msg);
					}
					//							console.log("添加成功");
				}
			});

		});

	}

	//				重置按钮
	$("#reset-datatable").click(function() {
		tableRoleInfo.ajax.url('/role/info').load();
	})

	//				左边表格的行点击事件
	var rolename;
	$('#roleInfo tbody').on('click', 'tr', function(event) {
		if($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			isSelect = false;
		} else {
			tableRoleInfo.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			isSelect = true;

		}
		leftSelectTips();
		rolename = tableRoleInfo.row(this).data().RoleName;
		deleteRoleID = tableRoleInfo.row(this).data().ID;
		roleInfoJson = tableRoleInfo.row(this).data();
		updateUser();
		searchParams.roleID = roleInfoJson.ID;
		tableUsertoRole.ajax.url('/role/usertorole').load();
		$("#role-title").html(rolename);
		$("#delete-error").html('是否删除(角色为：' + rolename + ')的一行数据！');

	});

	function leftSelectTips() {
		//判断是否被选中
		if(!isSelect) {
			$("#delete-error").html('请选择左侧的一行数据进行删除!');
			$("#delete-sure").attr('disabled', 'disabled');
			//					设置update
			$(".update-info").css("display", "none");
			$("#update-sure").attr('disabled', 'disabled');
			$("#updateTips-error").html('请选择左侧一行数据进行编辑');
			$("#role-title").html('用户的角色信息');
			searchParams.roleID = '';
		} else {

			$("#delete-error").html("是否要删除(角色为：" + rolename + ")该行数据!");
			$("#delete-sure").removeAttr('disabled');

			$("#update-sure").removeAttr('disabled');
			$(".update-info").css("display", "block");

		}
	}
	//				tableUsertoRole.ajax.url('/role/usertorole').load();
	// 初始化tableUserToRole

	var tableUsertoRole = $('#usertorole').DataTable({
		//						"processing": true,
		"serverSide": true,
		"bLengthChange": false,
		"ajax": {
			"url": '/role/usertorole',
			"type": "get",
			"data": function(d) {
				if(searchParams) {
					$.extend(d, searchParams); //给d扩展参数
				}
			}
		},
		"ordering": false,
		"searching": false,
		"columns": [{
				"data": "ID"
			},
			{
				"data": "UserName"
			},
			{
				"data": "RoleName"
			}
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

	//添加按钮
	var btns = $("<div class='floatright'><input type='text' class='form-control' placeholder='请输入名称...' id='usertorole-value'><div class='btn-group'><button type='button' class='btn btn-default' style='margin-left:5px' id='usertorole-select'>查询</button><button type='button' class='btn btn-default' id='usertorole-reset'>重置</button></div><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal'  data-target='#usertoroe-updateTips' >编辑</button><button type='button' class='btn btn-default' data-toggle='modal'  data-target='#usertorole-deleteTips' >删除</button></div></div>");

	var b = $(" #usertorole_wrapper .row").first().find(".col-sm-6").last();
	b.removeClass("col-sm-6");
	b.addClass("col-sm-12 left20");
	b.append(btns);

	var isClick = false;
	var isCreate = false;
	var usertoroleDataJson;
	var deleteUserToRoleUserID; //得到要被删除的角色id

	//判断右侧表格是否点击
	rightClickTips();

	//用户对应的角色搜索
	$("#usertorole-select").click(function() {
		searchParams.searchUserName = $("#usertorole-value").val();
		tableUsertoRole.ajax.url('/role/usertorole/search').load();
		tableRoleInfo.ajax.url('/role/info').draw();
		tableRoleInfo.$('tr.selected').removeClass('selected');

	});

	//显示被搜索用户的角色信息
	$('#usertorole tbody').on('click', 'tr', function(event) {

		//					创建编辑的角色下拉列表
		if(!isCreate) {
			$.ajax({
				type: "get",
				url: "/role/fullInfo",
				success: function(data) {
					//							console.log(data[0].ID);
					//							console.log(data.length);
					var rolenameSelect = $("#rolename-select");
					var selects = $("<select name='usertorole-selects' class='form-control'  id='usertorole-selects'></select>")
					for(var i = 0; i < data.length; i++) {

						var options = $("<option value='" + data[i].ID + "'>" + data[i].RoleName + "</option>");
						selects.append(options);
					}
					rolenameSelect.append(selects);
					//								console.log(usertoroleDataJson);

				}
			});
			isCreate = true;
		}
		if($(this).hasClass('clicked')) {
			$(this).removeClass('clicked');
			isClick = false;
		} else {
			tableUsertoRole.$('tr.clicked').removeClass('clicked');
			$(this).addClass('clicked');
			isClick = true;
			usertoroleDataJson = tableUsertoRole.row(this).data();
			//						console.log(usertoroleDataJson);
			deleteUserToRoleUserID = usertoroleDataJson.ID
			//						填入编辑角色的信息
			$("#usertoroe-update-roleID").val(usertoroleDataJson.ID);
			$("#usertoroe-update-username").val(usertoroleDataJson.UserName);
		}
		rightClickTips();


	});

	function rightClickTips() {
		console.log(isClick);
		if(!isClick) {
			$(".myModalTips-right").css("display", "block");

			$("#role-title").removeClass('addRedColor');
			$("#role-title").html(rolename);
			//							右侧删除
			$("#usertorole-delete-error").html('请选择右侧一行数据进行删除!');
			$("#usertorole-delete-sure").attr('disabled', 'disabled');
			//					右侧编辑
			$(".usertorole-update-info").css("display", "none");
			$("#usertorole-update-sure").attr('disabled', 'disabled');

			$("#usertorole-updateTips-error").html('请选择右侧一行数据进行编辑!');

		} else {
			$("#usertorole-delete-error").html('是否要删除(姓名：' + usertoroleDataJson.UserName + ')该行数据');
			$(".usertorole-update-info").css("display", "block");
			$(".myModalTips-right").css("display", "none");
			
			$("#usertorole-update-sure").removeAttr('disabled');
			$("#usertorole-delete-sure").removeAttr('disabled');

		}

	}

	//				用户对应的角色重置
	$("#usertorole-reset").click(function() {

		tableUsertoRole.ajax.url('/role/usertorole').load();

	})

	//删除用户对用的角色判断是否点击
	//				console.log(isSelect);
	//				console.log(isClick);

	//删除用户对应角色
	$("#usertorole-delete-sure").click(function() {
		$.ajax({
			type: "post",
			url: "/role/usertorole/delete",
			data: {

				"UserID": deleteUserToRoleUserID
			},
			success: function(data) {
				if(data.code == 1) {
					$(".modalTips").css("display", "block");
					$("#usertorole-deleteTips-error").html(data.msg);
					tableUsertoRole.ajax.url('/role/usertorole').load();

				} else {
					$(".modalTips").css("display", "block");
					$("#usertorole-deleteTips-error").html(data.msg);

				}
				//							console.log("添加成功");
			},
			error: function(er) {
				$(".modalTips").css("display", "block");
				$("#deleteTips-error").html('服务器错误');
			}

		});

	});

	//				编辑用户对应角色
	$("#usertorole-update-sure").click(function() {
		var RoleID = $("#role-select").val();
		var UserID = usertoroleDataJson.ID;

		//					console.log(RoleId);
		//					console.log(UserId);
		$.ajax({
			type: "post",
			url: "/role/usertorole/add",
			data: {
				"UserID": UserID,
				"RoleID": RoleID
			},
			success: function(data) {
				if(data.code == 1) {
					$(".modalTips").css("display", "block");
					$("#usertorole-deleteTips-error").html(data.msg);
					tableUsertoRole.ajax.url('/role/usertorole').load();

				} else {
					$(".modalTips").css("display", "block");
					$("#usertorole-deleteTips-error").html(data.msg);

				}
				//							console.log("添加成功");
			},
			error: function(er) {
				$(".modalTips").css("display", "block");
				$("#deleteTips-error").html('服务器错误');
			}

		});
	});
});