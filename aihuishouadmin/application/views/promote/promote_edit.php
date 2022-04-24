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
					<span class="x-red">*</span>优惠卷名
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="name" name="name" lay-verify="name"
						   autocomplete="off" class="layui-input" value="<?=$name;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>开始时间
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input class="layui-input" placeholder="开始日期"
						   name="starttime" id="starttime" lay-verify="starttime" value="<?= date("Y-m-d",$starttime) ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>结束时间
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input class="layui-input" placeholder="开始日期"
						   name="endtime" id="endtime" lay-verify="endtime" value="<?= date("Y-m-d",$endtime) ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>优惠费用
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="price" name="price" lay-verify="price"
						   autocomplete="off" class="layui-input" value="<?=$price;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>地区设定
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<select name="area" id="area" lay-verify="area">
						<option value="">请选择</option>
						<option value="中山区" <?php echo $area == "中山区" ? 'selected' : '' ?>>中山区</option>
						<option value="西岗区" <?php echo $area == "西岗区" ? 'selected' : '' ?>>西岗区</option>
						<option value="沙河口区" <?php echo $area == "沙河口区" ? 'selected' : '' ?>>沙河口区</option>
						<option value="甘井子区" <?php echo $area == "甘井子区" ? 'selected' : '' ?>>甘井子区</option>
						<option value="高新园区" <?php echo $area == "高新园区" ? 'selected' : '' ?>>高新园区</option>
						<option value="旅顺口区" <?php echo $area == "旅顺口区" ? 'selected' : '' ?>>旅顺口区</option>
						<option value="开发区" <?php echo $area == "开发区" ? 'selected' : '' ?>>开发区</option>
						<option value="金州区" <?php echo $area == "金州区" ? 'selected' : '' ?>>金州区</option>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>状态
				</label>
				<div class="layui-input-inline" style="width: 500px;">
					<input type="radio" name="state" lay-skin="primary" title="正常"
						   value="0" <?php echo $state == 0 ? 'checked' : '' ?>>
					<input type="radio" name="state" lay-skin="primary" title="停止"
						   value="1" <?php echo $state == 1 ? 'checked' : '' ?>>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label" style="width: 30%;">
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<span class="x-red">※</span>请确认输入的数据是否正确。
				</div>
			</div>
			<input type="hidden" name="uid" id="uid" value="<?php echo $id; ?>">
			<input type="hidden" name="name1" id="name1" value="<?php echo $name ?>">
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
					name: function (value) {
						if ($('#name').val() == "") {
							return '请输入优惠卷名。';
						}
					},
					starttime: function (value) {
						if ($('#starttime').val() == "") {
							return '请输入开始时间。';
						}
					},
					endtime: function (value) {
						if ($('#endtime').val() == "") {
							return '请输入结束时间。';
						}
					},
					price: function (value) {
						if ($('#price').val() == "") {
							return '请输入优惠费用。';
						}
					},
					area: function (value) {
						if ($('#area').val() == "") {
							return '请选择优惠区域。';
						}
					},
				});

				$("#tab").validate({
					submitHandler: function (form) {
						$.ajax({
							cache: true,
							type: "POST",
							url: "<?= RUN . '/promote/promote_save_edit' ?>",
							data: $('#tab').serialize(),//
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

	layui.use(['laydate', 'form'],
			function() {
				var laydate = layui.laydate;
				//执行一个laydate实例
				laydate.render({
					elem: '#starttime' //指定元素
				});
				//执行一个laydate实例
				laydate.render({
					elem: '#endtime' //指定元素
				});
			});

</script>
</body>
</html>
