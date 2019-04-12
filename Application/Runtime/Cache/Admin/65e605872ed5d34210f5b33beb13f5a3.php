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
                <li><a href="#">修改密码</a></li>
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
            </ul>
        </div>
    </div>
    
<div class="main-wrap">
    <div class="crumb-wrap">
        <div class="crumb-list">
            <i class="icon-font"></i><a href="index.html">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span>
        </div>
    </div>
    <div class="search-wrap">
        <div class="search-content">
            <form action="/index.php" method="get">
                <table class="search-tab">
                <input type="hidden" name="m" value="admin">
                <input type="hidden" name="c" value="user">
                <input type="hidden" name="a" value="index">
                <tr>
                    <th width="120">
                        选择性别:
                    </th>
                    <td>
                        <select name="sex" id="">
                            <option value="">全部</option>
                            <option value="m">男</option>
                            <option value="w">女</option>
                            <option value="x">保密</option>
                        </select>
                    </td>
                    <th width="70">
                        用户名:
                    </th>
                    <td>
                        <input class="common-text" placeholder="用户名" name="uname" value="" id="" type="text">
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
            <div class="result-title">
                <div class="result-list">
                    <a href="/index.php/admin/user/create"><i class="icon-font"></i>新增用户</a>
                    <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                    <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                <tr>
                    <th class="tc" width="5%">
                        <input class="allChoose" name="" type="checkbox">
                    </th>
                    <th>
                        排序
                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        用户名
                    </th>
                    <th>
                        头像
                    </th>
                    <th>
                        权限
                    </th>
                    <th>
                        性别
                    </th>
                    <th>
                        年龄
                    </th>
                    <th>
                        创建时间
                    </th>
                    <th>
                        操作
                    </th>
                </tr>
                <?php foreach($user as $k=>$v): ?>
                <tr>
                    <td class="tc">
                        <input name="id[]" value="59" type="checkbox">
                    </td>
                    <td>
                        <input name="ids[]" value="59" type="hidden">
                        <input class="common-input sort-input" name="ord[]" value="0" type="text">
                    </td>
                    <td>
                        <?=$v['uid']?>
                    </td>
                    <td>
                        <?=$v['uname']?>
                    </td>
                    <td>
                        <img src="/<?=$v['uface']?>" />
                    </td>
                    <td>
                        <?=$v['auth']?>
                    </td>
                    <td>
                        <?=$v['sex']?>
                    </td>
                    <td>
                        <?=$v['age']?>
                    </td>
                    <td>
                        <?=date('Y-m-d H:i:s', $v['created_at'])?>
                    </td>
                    <td>
                        <a class="link-update" href="/index.php/admin/user/edit/uid/<?=$v['uid']?>">修改</a>
                        <a class="link-del" href="/index.php/admin/user/del/uid/<?=$v['uid']?>">删除</a>
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