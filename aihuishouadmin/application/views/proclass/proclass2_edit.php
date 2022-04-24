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
					<span class="x-red">*</span>所属一级分类：
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<select name="coid" id="coid" lay-verify="rid">
						<?php foreach ($class1 as $num => $once): ?>
							<option value="<?=$once['co_id'];?>" <?php if($coid==$once['co_id']){echo 'selected';}?>><?=$once['co_name'];?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>二级分类名：
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="name" name="name" lay-verify="ltitle"
						   value="<?php echo $name ?>" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>分类状态：
				</label>
				<div class="layui-input-inline layui-show-xs-block">
					<div style="width: 300px" class="layui-input-inline layui-show-xs-block">
						<select name="state" id="state" lay-verify="rid">
							<option value="1" <?php if($state==1){echo 'selected';}?>>热门</option>
							<option value="2" <?php if($state==2){echo 'selected';}?>>已开通</option>
							<option value="3" <?php if($state==3){echo 'selected';}?>>暂未开通</option>
						</select>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>图标：
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="pic" name="pic" lay-verify="ltitle"
						   value="<?php echo $pic; ?>" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="L_pass" class="layui-form-label" style="width: 30%;">
					<span class="x-red">*</span>回收费用（公斤）：
				</label>
				<div class="layui-input-inline" style="width: 300px;">
					<input type="text" id="price" name="price" lay-verify="ltitle"
						   value="<?php echo $price; ?>" autocomplete="off" class="layui-input">
				</div>
			</div>
            <input type="hidden" name="uid" id="uid" value="<?php echo $id ?>">
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
