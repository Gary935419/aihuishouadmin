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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/qishou/qishou_list' ?>">
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
				<button class="layui-btn layui-card-header" style="float: right;margin-top: -40px;margin-right: 20px;"
						onclick="xadmin.open('添加','<?= RUN . '/qishou/qishou_add' ?>',900,600)"><i
							class="layui-icon"></i>添加
				</button>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="width: 5%">序号</th>
							<th style="width: 10%">骑手账号</th>
							<th style="width: 10%">骑手姓名</th>
							<th style="width: 10%">联系电话</th>
							<th style="width: 40%">负责商家</th>
							<th style="width: 10%">当前状态</th>
							<th style="width: 15%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['qs_id'] ?>" sid="<?= $once['qs_id'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['qs_account'] ?></td>
									<td><?= $once['qs_name'] ?></td>
									<td><?= $once['qs_tel'] ?></td>
									<td><?= $once['qs_menames'] ?></td>
									<td><?php if ($once['qs_state'] == 0) { echo "使用中";}else{echo "停用";}?></td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/qishou/qishou_edit?id=' ?>'+<?= $once['qs_id'] ?>,900,700)">
											<i class="layui-icon">&#xe642;</i>编辑
										</button>
										<button class="layui-btn layui-btn-danger"
												onclick="qishou_delete('<?= $once['qs_id'] ?>')"><i class="layui-icon">&#xe640;</i>删除
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
						url: "<?= RUN . '/qishou/qishou_delete' ?>",
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
