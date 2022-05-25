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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/orders/ordermerchants_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<select name="meid" id="meid">
								<option value="0">选择查询商家</option>
								<?php foreach ($merchantslist as $value){ ?>
								<option value="<?=$value['meid'];?>" <?php if($meid==$value['meid']){echo 'selected';}?>><?=$value['mename'];?></option>
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
							<th style="width: 10%">序号</th>
							<th style="width: 10%">下单时间</th>
							<th style="width: 10%">商品分类</th>
							<th style="width: 10%">当前状态</th>
							<th style="width: 10%">回收量</th>
							<th style="width: 10%">实际回收量</th>
							<th style="width: 10%">误差</th>
							<th style="width: 10%">误差比例</th>
							<th style="width: 10%">结算费用</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): 
							$wucha=$once['q_weight']-$once['m_weight'];
							$wcl=round($wucha/$once['m_weight']*100,2);
							?>
								<tr>
									<td><?= $num + 1 ?></td>
									<td><?= date('Y-m-d',$once['addtime']); ?></td>
									<td><?= $once['ct_name'] ?></td>
									<td><?php if($once['omtype']==0){echo '待回收';}else{echo '已回收';}; ?></td>
									<td><?= $once['m_weight'] ?></td>
									<td><?= $once['q_weight'] ?></td>
									<td><?= $wucha ?></td>
									<td><?= $wcl ?>%</td>

									<td><?= $once['q_weight']*$once['price'] ?></td>
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
</script>
</html>
