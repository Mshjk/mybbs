<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>后台管理</title>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/> -->
<script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="index.html">首页</a></li>
                <li><a href="http://www.mycodes.net/" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="#"><?=$_SESSION['userInfo']['uname']?>
                </a></li>
                <li><a href="/index.php/admin/user/editPass">修改密码</a></li>
                <li><a href="/index.php/admin/login/logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                <a href="#"><i class="icon-font">&#xe003;</i>用户管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/user/create"><i class="icon-font">&#xe008;</i>添加用户</a></li>
                    <li><a href="/index.php/admin/user/index"><i class="icon-font">&#xe005;</i>查看用户</a></li>
                </ul>
                </li>
                <li>
                <a href="#"><i class="icon-font">&#xe018;</i>分区管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/part/create"><i class="icon-font">&#xe017;</i>添加分区</a></li>
                    <li><a href="/index.php/admin/part/index"><i class="icon-font">&#xe037;</i>查看分区</a></li>
                </ul>
                </li>
                <li>
                <a href="#"><i class="icon-font">&#xe018;</i>板块管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/cate/create"><i class="icon-font">&#xe017;</i>添加板块</a></li>
                    <li><a href="/index.php/admin/cate/index"><i class="icon-font">&#xe037;</i>查看板块</a></li>
                </ul>
                </li>
                <li>
                <a href="#"><i class="icon-font">&#xe018;</i>链接管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/link/create"><i class="icon-font">&#xe017;</i>添加友情链接</a></li>
                    <li><a href="/index.php/admin/link/index"><i class="icon-font">&#xe037;</i>查看友情链接</a></li>
                </ul>
                </li>
                <li>
                <a href="#"><i class="icon-font">&#xe018;</i>贴子管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/post/index"><i class="icon-font">&#xe037;</i>查看贴子</a></li>
                </ul>
                </li>
                <li>
                <a href="#"><i class="icon-font">&#xe018;</i>评论管理</a>
                <ul class="sub-menu">
                    <li><a href="/index.php/admin/reply/index"><i class="icon-font">&#xe037;</i>查看评论</a></li>
                </ul>
                </li>
                <li>
            </ul>
        </div>
    </div>
    
	<div class="main-wrap">
	    <div class="result-wrap">
			<form action="/index.php/admin/user/edit_pass" method="post">
				<label for="upwd">确认原密码</label>
				<input type="password" name="upwd" id="upwd">
				<input type="submit" value="确认">
			</form> 
		</div>
	</div>

    <!--/main-->
</div>
</body>
</html>