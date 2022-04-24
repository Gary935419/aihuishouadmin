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
					<span class="x-red">*</span>账号
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="account" name="account" lay-verify="account"
						   autocomplete="off" class="layui-input" value="<?=$account;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>密码
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="password" id="password" name="password" lay-verify="password"
						   autocomplete="off" class="layui-input" >
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>骑手姓名
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="qsname" name="qsname" lay-verify="contactname"
						   autocomplete="off" class="layui-input" value="<?=$qsname;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>电话
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="qstel" name="qstel" lay-verify="metel"
						   autocomplete="off" class="layui-input" value="<?=$qstel;?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>负责商家
				</label>
				<div class="layui-input-inline" style="width: 500px;">
					<?php foreach ($menames as $num => $once): ?>
						<input type="checkbox" name="meids[]" lay-skin="primary" value="<?= $once['meid'];?>" title="<?= $once['mename'];?>"
								<?php if(in_array($once['meid'],$meids)){echo 'checked';}?>>


					<?php endforeach; ?>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>状态
				</label>
				<div class="layui-input-inline" style="width: 500px;">
					<input type="radio" name="state" lay-skin="primary" title="正常" value="0" <?php echo $state == 0 ? 'checked' : '' ?>>
					<input type="radio" name="state" lay-skin="primary" title="禁用" value="1" <?php echo $state == 1 ? 'checked' : '' ?>>
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
			<input type="hidden" name="pwsd" id="pwsd" value="<?php echo $password ?>">
			<input type="hidden" name="account1" id="account1" value="<?php echo $account ?>">
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
					user_name: function (value) {
						if ($('#account').val() == "") {
							return '请输入账号。';
						}
					},
					contactname: function (value) {
						if ($('#qsname').val() == "") {
							return '请输入骑手姓名。';
						}
					},
					metel: function (value) {
						if ($('#qstel').val() == "") {
							return '请输入联系人电话。';
						}
					},
				});

				$("#tab").validate({
					submitHandler: function (form) {
						$.ajax({
							cache: true,
							type: "POST",
							url: "<?= RUN . '/qishou/qishou_save_edit' ?>",
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
</script>
</body>
</html>
