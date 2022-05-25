<!doctype html>
<html class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>我的管理后台-爱回收</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport"
		  content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="stylesheet" href="<?= STA ?>/css/font.css">
	<link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
	<script src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery.mini.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
</head>
<body>
<div class="x-nav">
          <span class="layui-breadcrumb">
            <a>
              <cite>订单管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/member/member_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="user_name" id="user_name" value="<?php echo $user_name1 ?>"
								   placeholder="用户名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-inline layui-show-xs-block">
							<select name="status" id="status">
								<option value="1">开通用户</option>
								<option value="2">禁用用户</option>
							</select>
						</div>
						<div class="layui-inline layui-show-xs-block">
							<button class="layui-btn" lay-submit="" lay-filter="sreach"><i
										class="layui-icon">&#xe615;</i></button>
						</div>
					</form>
				</div>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="width: 5%">序号</th>
							<th style="width: 9%">微信名</th>
							<th style="width: 9%">用户姓名</th>
							<th style="width: 9%">用户电话</th>
							<th style="width: 9%">个人钱包</th>
							<th style="width: 9%">注册时间</th>
							<th style="width: 9%">当前状态</th>
							<th style="width: 9%">开通上门取货</th>
							<th style="width: 9%">查看订单</th>
							<th style="width: 9%">查看地址</th>
							<th style="width: 15%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['mid'] ?>" sid="<?= $once['mid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['nickname'] ?></td>
									<td><?= $once['truename'] ?></td>
									<td><?= $once['mobile'] ?></td>
									<td><?= $once['wallet'] ?></td>
									<td><?php date("Y-m-d",$once['add_time']); ?></td>
									<td><?php echo $once['status']==1?"正常":"禁用" ?></td>
									<td><?php echo $once['getpro']==0?"关闭":"开通" ?></td>
									<td><a href="#" onclick="xadmin.open('地址','<?= RUN . '/member/userorder_list?id=' ?>'+<?= $once['mid'] ?>,1200,700)">查看订单</a></td>
									<td><a href="#" onclick="xadmin.open('地址','<?= RUN . '/member/address_list?id=' ?>'+<?= $once['mid'] ?>,1200,700)">查看地址</a></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="member_getpro('<?= $once['mid'] ?>','<?= $once['getpro'] ?>')"><i class="layui-icon">&#xe640;</i><?php echo $once['getpro']==0?"开通":"关闭" ?>
										</button>
										<button class="layui-btn layui-btn-danger"
												onclick="member_delete('<?= $once['mid'] ?>','<?= $once['status'] ?>')"><i class="layui-icon">&#xe640;</i><?php echo $once['status']==1?"禁用":"恢复" ?>
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php } else { ?>
							<tr>
								<td colspan="6" style="text-align: center;">暂无数据</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="layui-card-body ">
					<div class="page">
						<?= $pagehtml ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</body>
<script>
	layui.use(['form', 'layer'],
			function () {
				var form = layui.form,
						layer = layui.layer;
			});
</script>
<script>
	function member_delete(id,status) {
		layer.confirm('您是否确认禁用？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {
							"id": id,
							"status":status,
						},
						dataType: "json",
						url: "<?= RUN . '/member/member_delete' ?>",
						success: function (data) {
							if (data.success) {
								$("#p" + id).remove();
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 6,
											btn: ['确认']
										},
								);
							} else {
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 5,
											btn: ['确认']
										},
								);
							}
						},
					});
				});
	}

	function member_getpro(id,getpro) {
		layer.confirm('您是否修改上门回收状态？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {
							"id": id,
							"getpro":getpro,
						},
						dataType: "json",
						url: "<?= RUN . '/member/member_getpro' ?>",
						success: function (data) {
							if (data.success) {
								//$("#p" + id).remove();
								location.reload();
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 6,
											btn: ['确认']
										},
								);
							} else {
								layer.alert(data.msg, {
											title: '温馨提示',
											icon: 5,
											btn: ['确认']
										},
								);
							}
						},
					});
				});
	}
</script>
</html>
