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
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font"></i><a href="index.html">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">评论管理</span>
            </div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <table class="search-tab">
                    <input type="hidden" name="m" value="admin">
                    <input type="hidden" name="c" value="reply">
                    <input type="hidden" name="a" value="index">
                    <tr>
                        <th width="70">
                            发评人:
                        </th>
                        <td>
                            <input class="common-text" placeholder="用户名" name="uname" value="" id="" type="text">
                        </td>
                        <th width="70">
                        	贴子标题
                        </th>
                        	<td>
                            <input class="common-text" placeholder="贴子标题" name="title" value="" id="" type="text">
                        </td>
                        <td>
                            <input class="btn btn-primary btn2" name="" value="查询" type="submit">
                        </td>
                    </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                    <tr>
                        <th>
                            评论id
                        </th>
                        <th>
                            评论内容
                        </th>
                        <th>
                            发评人
                        </th>
                        <th>
                            评论贴子
                        </th>
                        <th>
                            发评时间
                        </th>
                        <th>
                        	操作
                        </th>
                    </tr>
                    <?php
 foreach($replys as $k=>$v): ?>
                    <tr>
                        <td>
                            <?=$v['rid']?>
                        </td>
                        <td>
                            <?=$v['rcontent']?>
                        </td>
                        <td>
							<?=$users[$v['uid']]?>
                        </td>
                        <td>
                            <?=$posts[$v['pid']]?>
                        </td>
                        <td>
                            <?=date('Y-m-d H:i:s', $v['created_at'])?>
                        </td>
                        <td>
                            <a class="link-del" href="/index.php/admin/reply/del/rid/<?=$v['rid']?>">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
                    <div class="list-page">
                        <?=$show?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--/main-->
</div>
</body>
</html>