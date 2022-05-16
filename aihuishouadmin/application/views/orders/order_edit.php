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
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th style="width: 10%">序号</th>
							<th style="width: 30%">商品名称</th>
							<th style="width: 10%">商品重量</th>
							<th style="width: 10%">回收单价</th>
							<th style="width: 10%">实际费用</th>
							<th style="width: 30%">回收商家</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (isset($list) && !empty($list)) { ?>
							<?php
							$moneys=0;
							foreach ($list as $num => $once):
								$moneys=$moneys+$once['og_price'];
								?>
								<tr id="p<?= $once['ogid'] ?>" sid="<?= $once['ogid'] ?>">
									<td><?= $num + 1 ?></td>
									<td><?= $once['ct_name'] ?></td>
									<td><?= $once['weight'] ?></td>
									<td><?= $once['ct_price'] ?></td>
									<td><?= $once['og_price'] ?></td>
									<td><?= $name; ?></td>
								</tr>
							<?php endforeach; ?>
							<tr>
								<td colspan="2">费用合计：</td>
								<td colspan="4"><?= $moneys; ?>元</td>
							</tr>
						<?php } else { ?>
							<tr>
								<td colspan="6" style="text-align: center;">暂无数据</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
