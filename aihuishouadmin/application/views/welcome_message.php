<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?= STA ?>/css/font.css">
	<link rel="stylesheet" href="<?= STA ?>/css/xadmin.css">
	<link type="text/css" href="<?= STA ?>/css/jquery-ui.css" rel="stylesheet"/>
	<script src="<?= STA ?>/lib/layui/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?= STA ?>/js/jquery.mini.js"></script>
	<script type="text/javascript" src="<?= STA ?>/js/xadmin.js"></script>
</head>
<body>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<blockquote class="layui-elem-quote">欢迎您登录爱回收后台管理系统
					</blockquote>
				</div>
			</div>
		</div>
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">提现审核统计</div>
				<div class="layui-card-body ">
					<ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
						<li class="layui-col-md6">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>提现申请待审核数量（单位：个）</h3>
								<p>
									<cite>100</cite></p>
							</a>
						</li>
						<li class="layui-col-md6">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>提现申请已审核数量（单位：个）</h3>
								<p>
									<cite>200</cite></p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">数据统计</div>
				<div class="layui-card-body ">
					<ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量1（单位：个）</h3>
								<p>
									<cite>456</cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量2（单位：个）</h3>
								<p>
									<cite>456</cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量3（单位：个）</h3>
								<p>
									<cite>432</cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量4（单位：个）</h3>
								<p>
									<cite>345</cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量5（单位：个）</h3>
								<p>
									<cite>321</cite></p>
							</a>
						</li>
						<li class="layui-col-md2">
							<a href="javascript:;" class="x-admin-backlog-body">
								<h3>项目数量6（单位：个）</h3>
								<p>
									<cite>123</cite></p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-header">开发团队</div>
				<div class="layui-card-body ">
					<table class="layui-table">
						<tbody>
						<tr>
							<th>开发者</th>
							<td>Gary(zhaoyue_gary@163.com)</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>
