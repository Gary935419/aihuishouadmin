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
              <cite>商家管理</cite></a>
          </span>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/merchants/withdrawal_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<input type="text" name="user_name" id="user_name" value="<?php echo $user_name1 ?>"
								   placeholder="商家名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-inline layui-show-xs-block">
							<select name="vid" id="vid">
								<option <?php echo $vid == 0 ? 'selected' : '' ?> value="0">申请中</option>
								<option <?php echo $vid == 1 ? 'selected' : '' ?> value="1">已处理</option>
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
							<th style="width: 10%">申请时间</th>
							<th style="width: 20%">商家名称</th>
							<th style="width: 10%">提现金额</th>
							<th style="width: 10%">打款银行</th>
							<th style="width: 10%">银行卡号</th>
							<th style="width: 10%">账号名</th>
							<th style="width: 10%">当前状态</th>
							<th style="width: 10%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['wid'] ?>" sid="<?= $once['wid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['addtime'] ?></td>
									<td><?= $once['mename'] ?></td>
									<td><?= $once['money'] ?></td>
									<td><?= $once['bankname'] ?></td>
									<td><?= $once['bankcard'] ?></td>
									<td><?= $once['username'] ?></td>
									<td><?php if ($once['state'] == 0) { echo "申请中";}else{echo "已处理";}?></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-danger"
												onclick="withdrawal_delete('<?= $once['wid'] ?>','<?= $once['state'] ?>')"><i class="layui-icon"></i>提现处理
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
	function withdrawal_delete(id,state) {

		layer.confirm('您是否确认打款完成？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {
							"id": id,
							"state": state,
						},
						dataType: "json",
						url: "<?= RUN . '/merchants/withdrawal_delete' ?>",
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
