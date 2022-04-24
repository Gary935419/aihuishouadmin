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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/orders/orders1_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="user_name" id="user_name" value="<?php echo $user_name1 ?>"
								   placeholder="骑手名" autocomplete="off" class="layui-input">
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
							<th style="width: 10%">下单用户名</th>
							<th style="width: 10%">用户手机号</th>
							<th style="width: 15%">下单货物</th>
							<th style="width: 10%">配送方式</th>
							<th style="width: 10%">下单时间</th>
							<th style="width: 10%">收货商家</th>
							<th style="width: 10%">回收费用</th>
							<th style="width: 10%">当前状态</th>
							<th style="width: 10%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['oid'] ?>" sid="<?= $once['oid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['uname'] ?></td>
									<td><?= $once['utel'] ?></td>
									<td><?= $once['goodsname'] ?></td>
									<td><?php echo $once['otype']==0 ? "自己送货":"上门取货" ?></td>
									<td><?= $once['delivery_time'] ?></td>
									<td><?= $once['muser'] ?></td>
									<td><?= $once['sum_price'] ?></td>
									<td>已完成</td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/orders/orders1_edit?id=' ?>'+<?= $once['oid'] ?>,900,700)">
											<i class="layui-icon">&#xe642;</i>查看
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
	function qishou_delete(id) {
		layer.confirm('您是否确认删除？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {"id": id},
						dataType: "json",
						url: "<?= RUN . '/orders/orders_delete' ?>",
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
</script>
</html>
