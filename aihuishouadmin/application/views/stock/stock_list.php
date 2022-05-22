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
					<form class="layui-form layui-col-space5" method="get" action="<?= RUN, '/stock/stock_list' ?>">
						<div class="layui-inline layui-show-xs-block">
							<select name="ctname" id="ctname">
								<option value="">请选择查询的分类</option>
								<?php foreach ($ctlist as $value): ?>
									<option value="<?=$value['ct_id']?>" <?php if($value['ct_id']==$ctid){echo 'selected';};?>><?=$value['ct_name']?></option>
								<?php endforeach; ?>
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
							<th style="width: 10%">商品品类</th>
							<th style="width: 10%">当前库存量</th>
							<th style="width: 10%">最新入库量</th>
							<th style="width: 10%">总出库量</th>
							<th style="width: 10%">剩余库存</th>
							<th style="width: 10%">处理记录</th>
							<th style="width: 10%">操作</th>
						</thead>
						<tbody>
						<?php if (isset($list) && !empty($list)) { ?>
							<?php foreach ($list as $num => $once): ?>
								<tr id="p<?= $once['id'] ?>" sid="<?= $once['id'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['ct_name'] ?></td>
									<td><?= $once['stocknum'] ?></td>
									<td><?= $once['stockaddnum'] ?></td>
									<td><?= $once['stockoutnum'] ?></td>
									<td><?= $once['stocknum']-$once['stockoutnum']  ?></td>
									<td><a href="#" onclick="xadmin.open('编辑','<?= RUN . '/stock/stockorder_list?id=' ?>'+<?= $once['ct_id'] ?>,900,700)">查看记录</td>
									<td class="td-manage">
										<button class="layui-btn layui-btn-normal"
												onclick="xadmin.open('编辑','<?= RUN . '/stock/stock_edit?id=' ?>'+<?= $once['id'] ?>,900,700)">
											<i class="layui-icon">&#xe642;</i>出库
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
</html>
