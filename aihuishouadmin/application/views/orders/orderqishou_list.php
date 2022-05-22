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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/orders/orderqishou_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<select name="qsid" id="qsid">
								<option value="0">选择查询司机</option>
								<?php foreach ($qishoulist as $value){ ?>
									<option value="<?=$value['qs_id'];?>" <?php if($qsid==$value['qs_id']){echo 'selected';}?>><?=$value['qs_name'];?></option>
								<? }?>
							</select>
						</div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="开始日期" value="<?php echo $start; ?>" name="start" id="start"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="截止日期" value="<?php echo $end; ?>" name="end" id="end"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<button class="layui-btn" lay-submit="" lay-filter="sreach">
								<i class="layui-icon">&#xe615;</i></button>
						</div>
					</form>
				</div>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="width: 5%">序号</th>
							<th style="width: 10%">商家名称</th>
							<th style="width: 10%">满仓提醒</th>
							<th style="width: 10%">订单状态</th>
							<th style="width: 10%">商家打分</th>
							<th style="width: 25%">备注</th>
							<th style="width: 10%">回收时间</th>
							<th style="width: 10%">查看详情</th>
							<th style="width: 10%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr>
									<td><?= $num + 1 ?></td>
									<td><?= $once['mename'] ?></td>
									<td>未满仓</td>
									<td><?PHP if($once['qstype']==0){echo "未入库";}elseif($once['qstype']==1){echo "申请入库";}elseif($once['qstype']==2){echo "以入库";}; ?></td>
									<td><?= $once['grade'] ?></td>
									<td><?= $once['remarks'] ?></td>
									<td><?= date('Y-m-d',$once['addtime']); ?></td>
									<td><a href="#" onclick="xadmin.open('编辑','<?= RUN . '/orders/orderqishou_edit?id=' ?>'+<?= $once['ordernumber'] ?>,900,700)">查看详情</td>
									<td>
										<?php if($once['qstype']==1){?>
										<button class="layui-btn layui-btn-danger"
												onclick="orderqishou_edit('<?= $once['ordernumber'] ?>')"><i class="layui-icon">&#xe640;</i>入库
										</button>
										<? }elseif($once['qstype']==0){echo '未申请入库';}elseif($once['qstype']==2){echo '入库完成';}?>
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
	layui.use(['laydate', 'form'],
			function() {
				var laydate = layui.laydate;
				//执行一个laydate实例
				laydate.render({
					elem: '#start' //指定元素
				});
				//执行一个laydate实例
				laydate.render({
					elem: '#end' //指定元素
				});
			});
</script>
<script>
	function orderqishou_edit(id) {
		layer.confirm('您是否确认入库？', {
					title: '温馨提示',
					btn: ['确认', '取消']
					// 按钮
				},
				function (index) {
					$.ajax({
						type: "post",
						data: {
							"id": id,
						},
						dataType: "json",
						url: "<?= RUN . '/orders/stcok_add' ?>",
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
