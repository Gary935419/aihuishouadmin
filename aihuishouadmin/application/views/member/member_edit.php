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
			<?php foreach ($list as $num => $once): ?>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 8%;">
					<span class="x-red">*</span>商品名：
				</label>
				<div class="layui-input-inline" style="width: 100px;">
					<input type="text" id="name" name="name" lay-verify="ltitle"
						   value="<?php echo $once['ct_name']; ?>" autocomplete="off" class="layui-input" disabled>
				</div>

				<label for="L_pass" class="layui-form-label" style="width: 8%%;">
					<span class="x-red">*</span>商品重量：
				</label>
				<div class="layui-input-inline" style="width: 80px;">
					<input type="text" id="name" name="name" lay-verify="ltitle"
						   value="<?php echo $once['weight']; ?>" autocomplete="off" class="layui-input">
				</div>

				<label for="L_pass" class="layui-form-label" style="width: 8%%;">
					<span class="x-red">*</span>商品单价：
				</label>
				<div class="layui-input-inline" style="width: 80px;">
					<input type="text" id="name" name="name" lay-verify="ltitle"
						   value="<?php echo $once['og_price']; ?>" autocomplete="off" class="layui-input">
				</div>

				<label for="L_pass" class="layui-form-label" style="width: 8%%;">
					<span class="x-red">*</span>实际费用：
				</label>
				<div class="layui-input-inline" style="width: 80px;">
					<input type="text" id="name" name="name" lay-verify="ltitle"
						   value="<?php echo $once['og_price']*$once['weight'] ?>" autocomplete="off" class="layui-input">
				</div>
			</div>
			<?php endforeach; ?>
            <div class="layui-form-item" style="padding-top: 300px">
                <label for="L_repass" class="layui-form-label" style="width: 30%;">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    修 改
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
				ltitle: function (value) {
					if ($('#ltitle').val() == "") {
						return '请输入标签名。';
					}
				},
            });

            $("#tab").validate({

                submitHandler: function (form) {
                    $.ajax({
                        cache: true,
                        type: "POST",
                        url: "<?= RUN . '/proclass/proclass2_save_edit' ?>",
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
