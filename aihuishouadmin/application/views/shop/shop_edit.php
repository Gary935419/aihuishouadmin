<!DOCTYPE html>
<html class="x-admin-sm">

<head>
	<meta charset="UTF-8">
	<title>我的管理后台-爱回收</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport"
		  content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
	<link rel="stylesheet" href="<?= STA ?>/css/font.css">
	<link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
	<script type="text/javascript" src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/upload/jquery_form.js"></script>
</head>
<body>
<div class="layui-fluid" style="padding-top: 66px;">
	<div class="layui-row">
		<form method="post" class="layui-form" action="" name="basic_validate" id="tab">
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>商品分类
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="" name="" lay-verify="ctname"
						   autocomplete="off" value="<?php echo $ctname ?>" class="layui-input" disabled>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>当前数量
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="" name="" lay-verify="num"
						   autocomplete="off" value="<?php echo $stocknum ?>" class="layui-input" disabled>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>出库量
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="outnum" name="outnum" lay-verify="outnum"
						   autocomplete="off" value="" class="layui-input">
				</div>
			</div>
			<input type="hidden" name="uid" id="uid" value="<?php echo $id ?>">
			<input type="hidden" name="ctid" id="ctid" value="<?php echo $ctid ?>">
			<input type="hidden" name="ctname" id="ctname" value="<?php echo $ctname ?>">
			<input type="hidden" name="stocknum" id="stocknum" value="<?php echo $stocknum ?>">
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label" style="width: 30%;">
				</label>
				<button class="layui-btn" lay-filter="add" lay-submit="">
					确认提交
				</button>
			</div>
		</form>
	</div>
</div>
<script>
	layui.use(['form', 'layer'],
		function () {
			var form = layui.form,
				layer = layui.layer;
			//自定义验证规则
			form.verify({
				outnum: function (value) {
					if ($('#outnum').val() == "") {
						return '请输入出库量。';
					}
					if (isNaN($('#outnum').val())==true) {
						return '请输入数字。';
					}
				},
			});

			$("#tab").validate({
				submitHandler: function (form) {
					$.ajax({
						cache: true,
						type: "POST",
						url: "<?= RUN . '/stock/stock_save_edit' ?>",
						data: $('#tab').serialize(),
						async: false,
						error: function (request) {
							alert("error");
						},
						success: function (data) {
							var data = eval("(" + data + ")");
							if (data.success) {
								layer.msg(data.msg);
								setTimeout(function () {
									cancel();
								}, 2000);
							} else {
								layer.msg(data.msg);
							}
						}
					});
				}
			});
		});

	function cancel() {
		//关闭当前frame
		xadmin.close();
	}
</script>
</body>
</html>
