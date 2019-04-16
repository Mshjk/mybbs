<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>这是一个神奇的网站</title>
<meta name="keywords" content="论坛,PHP">
<meta name="description" content="最大的社区网站">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<link rel="stylesheet" type="text/css" href="/Public/Home/css/style_1_common.css" /> 
  <link rel="stylesheet" type="text/css" href="/Public/Home/css/style_1_forum_viewthread.css" /> 
<link rel="stylesheet" type="text/css" href="/Public/Home/css/layout.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/css/css.css">
</head>
<body>
<!--网页顶部start-->
<div id="top">
	<div id="top_main">
		<span class="top_content_left">设为主页</span>
		<span class="top_content_left">收藏本站</span>
		<span class="top_content_right">切换到宽版</span>
	</div>
</div>
<!--网页顶部end--><!--网页主体部分start-->
<div id="main">
	<!--网页顶部广告部分start-->
	<div id="banner">
	</div>
	<!--网页顶部广告部分end-->
	<!--网页头部start-->
	<div id="header">
		<!--logo、登陆部分start-->
		<div id="logo_login" style="position: relative">
			<!--logo部分start-->
			<a href="/index.php/home"><div id="logo">
			</div></a>
			<!--logo部分end-->
			<!--登陆部分start-->
			<?php  if (isset($_SESSION['flag']) && $_SESSION['flag']) { ?>
			<div id="login" style="left:800px; top: 50px; position: absolute">
				<?php
 if ($_SESSION['userInfo']['auth'] < 3) { ?>
				<a href="/index.php/admin/index">进入后台 | </a>
				<?php } ?>
				
				<a href="/index.php/home/user/index"><?=$_SESSION['userInfo']['username']?>
				</a> | 
				<a href="/index.php/home/user/editPass">修改密码 | </a>
				<a href="/index.php/home/login/logout">退出登录</a>
			</div>
			<?php } else { ?>
			<form action="/index.php/home/login/dologin" method="post">
				<div id="login">
					<table>
					<tr>
						<td>
							<label>帐号</label>
						</td>
						<td>
							<input type="text" name="uname"/>
						</td>
					</tr>
					<tr>
						<td>
							<label>密码</label>
						</td>
						<td>
							<input type="password" name="upwd"/>
						</td>
						<td>
							<input type="submit" value="立即登录"/>
						</td>
						<td>
							<a href="/index.php/home/login/signup">立即注册</a>
						</td>
					</tr>
					</table>
				</div>
			</form>
			<?php } ?>
		</div>
		<!--logo、登陆部分end-->
		<!--菜单部分start-->
		<div id="menu">
			<ul>
				<?php foreach($parts as $part): ?>
				<li style="font-size: 13px"><a href="/index.php/home/index/index/pid/<?=$part['pid']?>"><?=$part['pname']?>
				</a></li>
				<li class="line"></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!--菜单部分end-->
		<!--搜索部分start-->
		<form action="/index.php/home/post/index" method="post">
			<div id="search">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="search_ico">
					</td>
					<td class="search_input">
						<input type="hidden" name="s" value="biaoji">
						<input type="text" name="title" x-webkit-speech speech placeholder="请输入搜索内容"/>
					</td>
					<td class="search_select">
						<a href="">帖子</a>
						<span class="select"></span>
					</td>
					<td class="search_btn">
						<input type="submit" value="搜索">
					</td>
					<td class="search_hot">
						<div>
							<strong>热搜:</strong>
							<a href="">交友</a>
							<a href="">教育</a>
							<a href="">幽默</a>
							<a href="">搞笑</a>
							<a href="">房产</a>
							<a href="">购物</a>
							<a href="">二手</a>
							<a href="">衣服</a>
							<a href="">鞋子</a>
							<a href="">帮助</a>
							<a href="">折扣</a>
							<a href="">电影</a>
						</div>
					</td>
				</tr>
				</table>
			</div>
		</form>
		<!--搜索部分end-->
		<!--小提示部分start-->
		<div id="tip">
			<!--路径部分start-->
			<div id="path">
				<a href="" class="index"></a>
				<em></em>
				<a href="" class="path_menu">论坛</a>
			</div>
			<!--路径部分end-->
			<!--统计部分start-->
			<div id="count">
				  今日活跃贴子: 
				<em><?=$newPost?></em>
				<span class="pipe">|</span>
				  贴子总数: 
				<em><?=$postAll?></em>
				<span class="pipe">|</span>
				  会员总数: 
				<em><?=$userAll?></em>
				<span class="pipe">|</span>
				  欢迎新会员: 
				<em><a href=""><?=$newUser?></a></em>
			</div>
			<!--统计部分end-->
		</div>
		<!--小提示部分end-->
	</div>
	<!--网页头部end-->
		<!--内容部分start-->
	<div class="content">			
		<form action="/index.php/home/user/update/uid/<?=$user['uid']?>" method="post" enctype="multipart/form-data">
			<table align="center" width="500" height="60">
				<tr>
					<td><label>帐户名(登录账号):</label></td>
					<td><input type="text" disabled value="<?=$user['uname']?>"></td>
				</tr>
				<tr>
					<td><label>用户名:</label></td>
					<td><input type="text" name="username" value="<?=$user['username']?>"></td>
				</tr>
				<tr>
					<td><label>年龄:</label></td>
					<td><input type="text" name="age" value="<?=$user['age']?>"></td>
				</tr>
				<tr>
					<td><label>性别:</label></td>
					<td>
						<select name="sex">
							<option value="w" <?php echo $user['sex']=='w' ? 'selected' : ''; ?>>女</option>
							<option value="m" <?php echo $user['sex']=='m' ? 'selected' : ''; ?>>男</option>
							<option value="x" <?php echo $user['sex']=='x' ? 'selected' : '' ;?>>保密</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>手机号:</label></td>
					<td><input type="text" name="tel" value="<?=$user['tel']?>"></td>
				</tr>
				<tr>
					<td><label>头像:</label></td>
					<td>
						<input type="file" name="uface">
						<input type="hidden" name="yimg" value="<?=$user['uface']?>" >
						<img src="/<?=getSm($user['uface'])?>">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="修改"></td>
				</tr>
			</table>
		</form>
			
	</div>
	<!--内容部分end-->
		<!--友情链接部分start-->
		<div id="friend_link">
			<!--友情链接标题部分start-->
			<div id="fri_title">
				<span>友情链接</span>
			</div>
			<!--友情链接标题部分end-->
			<!--友情链接内容部分start-->
			<?php  foreach($links as $link): $link['lpic'] = getSm($link['lpic']); ?>
			<div class="fri_content">
				<div class="fri_left">
					<a href="https://<?=$link['link']?>"><img width="50px" src="/<?=$link['lpic']?>" /></a>
				</div>
				<div class="fri_right">
					<p>
						<strong><?=$link['lname']?>
						</strong>
					</p>
					<p>
						<?=$link['lmsg']?>
					</p>
				</div>
			</div>
			<?php endforeach; ?>
			<!--友情链接内容部分end-->
		</div>
		<!--友情链接部分end-->
	</div>
	<!--内容部分end-->
</div>
<!--网页主体部分end--><!--尾部部分start-->
<div id="footer">
	<!--尾部左侧部分start-->
	<div id="footer_left">
		<p>
			Powered by <strong><a href="http://www.discuz.net" target="_blank">Discuz!</a></strong><em>X2.5</em>
		</p>
		<p class="xs0">
			© 2001-2012 <a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>
		</p>
	</div>
	<!--尾部左侧部分start-->
	<!--尾部右侧部分start-->
	<div id="footer_right">
		<p>
			<a href="http://www.discuz.net/archiver/">Archiver</a>
			<span class="pipe">|</span>
			<a href="">手机版</a>
			<span class="pipe">|</span>
			<strong>
			<a href="http://www.comsenz.com/" target="_blank">北京康盛新创科技有限责任公司</a>
			</strong>
		  ( 
			<a href="http://www.miitbeian.gov.cn/" target="_blank">京ICP证110024号|京网文[2011]0019-007号|北京公安备案:1101082242</a> )&nbsp;
			<a href="http://discuz.qq.com/service/security" target="_blank" title="防水墙保卫网站远离侵害">
		</p>
		<p class="xs0">
		  GMT+8, 2012-11-13 20:33
			<span id="debuginfo">
		  , Processed in 0.030692 second(s), 2 queries
		  , Gzip On, Memcached On.
			</span>
		</p>
	</div>
	<!--尾部右侧部分end-->
</div>
<!--尾部部分end-->
</body>
</html>