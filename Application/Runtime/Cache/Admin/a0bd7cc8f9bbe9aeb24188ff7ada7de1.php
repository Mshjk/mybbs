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
                <li><a href="#"><?=$_SESSION['userInfo']['uname']?></a></li>
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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php/admin">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php/admin/cate/index">版块管理</a><span class="crumb-step">&gt;</span><span>修改版块</span></div>
        </div>
		<div class="result-wrap">
            <div class="result-content">
                <form action="/index.php/admin/cate/update" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody>
                        	<input type="hidden" name="cid" value="<?=$cid?>">
                        	<tr>
                            	<th width="120"><i class="require-red">*</i>权限：</th>
	                            <td>
	                                <select name="pid" id="catid" class="required">
	                                	<?php foreach($parts as $part): ?>
	                                    <option value="<?=$part['pid']?>" <?php if($cate['pid'] == $part['pid']) { echo 'selected'; } ?>><?=$part['pname']?></option>
	                                    <?php endforeach; ?>
	                                </select>
	                            </td>
                        	</tr>
                        	<tr>
                            	<th width="120"><i class="require-red">*</i>版块名称：</th>
                            	<td>
                                    <input class="common-text required" id="title" name="cname" size="50" value="<?=$cate['cname']?>" type="text">
                                </td>
                            </tr>
                            <tr>
                            	<th width="120"><i class="require-red">*</i>指定版主：</th>
	                            <td>
	                                <select name="uid" id="catid" class="required">
	                                	<?php foreach($users as $user): ?>
	                                    <option value="<?=$user['uid']?>" <?php if($cate['uid'] == $user['uid']) { echo 'selected'; } ?>><?=$user['uname']?></option>
	                                    <?php endforeach; ?>
	                                </select>
	                            </td>
                        	</tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                    </table>
                </form>
            </div>
   		</div>
   	</div>

    <!--/main-->
</div>
</body>
</html>