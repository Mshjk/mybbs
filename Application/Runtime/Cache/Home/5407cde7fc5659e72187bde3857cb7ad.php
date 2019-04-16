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
	<div id="wp" class="wp content">
		<!--留白-->
		<div id="pt" class="bm cl">
		</div>
		<!--包含发贴和回贴-->
		<div id="ct" class="wp cl">
			<!--发贴列表start-->
			<div id="postlist" class="pl bm">
				<table cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td class="pls ptm pbm">
						<div class="hm">
							<span class="xg1">查看:</span>
							<span class="xi1"><?=$posts['view_cnt']?>
							</span>
							<span class="pipe">|</span>
							<span class="xg1">回复:</span>
							<span class="xi1"><?=$posts['rep_cnt']?>
							</span>
						</div>
					</td>
					<td class="plc ptm pbn vwthd">
						<h1 class="ts"><a href="forum.php?mod=viewthread&amp;tid=6" id="thread_subject"><?=$posts['title']?>
						</a></h1>
						<span class="xg1"><a href="forum.php?mod=viewthread&amp;tid=6&amp;fromuid=1" onclick="return copyThreadUrl(this)" title="您的朋友访问此链接后，您将获得相应的积分奖励">[复制链接]</a></span>
					</td>
				</tr>
				</tbody>
				</table>
				<table cellspacing="0" cellpadding="0" class="ad">
				<tbody>
				<tr>
					<td class="pls">
					</td>
					<td class="plc">
					</td>
				</tr>
				</tbody>
				</table>
				<div id="post_16">
					<table id="pid16" summary="pid16" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
						<td class="pls" rowspan="2">
							<a name="lastpost"></a>
							<div class="pi">
								<div class="authi">
									<a href="home.php?mod=space&amp;uid=1" target="_blank" class="xw1"><?=$users[$posts['uid']]['uname']?>
									</a>
								</div>
							</div>
							<div>
								<div class="avatar" onmouseover="showauthor(this, 'userinfo16')">
									<a href="home.php?mod=space&amp;uid=1" target="_blank"><img src="/<?=getSm($users[$posts['uid']]['uface'])?>" /></a>
								</div>
								<div class="tns xg2">
									<table cellspacing="0" cellpadding="0">
									<tbody>
									<tr>
										<th>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=thread&amp;view=me&amp;from=space" class="xi2">4</a>
											</p>
											主题
										</th>
										<th>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=friend&amp;view=me" class="xi2">0</a>
											</p>
											好友
										</th>
										<td>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=profile" class="xi2">35</a>
											</p>
											积分
										</td>
									</tr>
									</tbody>
									</table>
								</div>
								<p>
									<em><a href="home.php?mod=spacecp&amp;ac=usergroup&amp;gid=1" target="_blank">管理员</a></em>
								</p>
							</div>
						</td>
						<td class="plc">
							<div class="pi">
								<strong><a href="forum.php?mod=viewthread&amp;tid=6&amp;fromuid=1">1楼</a></strong>
								<div class="pti">
									<div class="pdbt">
									</div>
									<div class="authi">
										<img class="authicn vm" id="authicon16" src="/Public/Home/images/common/online_admin.gif"/>
										<em id="authorposton16">发表于 <span title="2018-5-4 11:05:56"><?=date('Y-m-d H:i:s', $posts['created_at'])?>
										</span></em>
										<span class="pipe">|</span>
										<a href="forum.php?mod=viewthread&amp;tid=6&amp;extra=&amp;ordertype=1">倒序浏览</a>
										<span class="pipe">|</span>
									</div>
								</div>
							</div>
							<div class="pct">
								<style type="text/css">
									.pcb{margin-right:0}
								</style>
								<div class="pcb">
									<div class="t_fsz">
										<table cellspacing="0" cellpadding="0">
										<tbody>
										<tr>
											<td class="t_f" id="postmessage_16">
												<?=$posts['content']?>
											</td>
										</tr>
										</tbody>
										</table>
									</div>
									<div id="comment_16" class="cm">
									</div>
									<div id="post_rate_div_16">
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="plc plm">
						</td>
					</tr>
					<tr>
						<td class="pls">
						</td>
						<td class="plc" style="overflow:visible;">
						</td>
					</tr>
					<tr class="ad">
						<td class="pls">
						</td>
						<td class="plc">
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
			<!--发贴列表end-->


			<!--回复列表start-->
			<?php
 $i = 1; foreach($replys as $reply): ?>
			<div class="pl bm">
				<table cellspacing="0" cellpadding="0" class="ad">
				<tbody>
				<tr>
					<td class="pls">
					</td>
					<td class="plc">
					</td>
				</tr>
				</tbody>
				</table>
				<div id="post_16">
					<table id="pid16" summary="pid16" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
						<td class="pls" rowspan="2">
							<a name="lastpost"></a>
							<div class="pi">
								<div class="authi">
									<a href="home.php?mod=space&amp;uid=1" target="_blank" class="xw1"><?=$users[$reply['uid']]['uname']?></a>
								</div>
							</div>
							<div>
								<div class="avatar" onmouseover="showauthor(this, 'userinfo16')">
									<a href="home.php?mod=space&amp;uid=1" target="_blank"><img src="/<?=getSm($users[$reply['uid']]['uface'])?>"/></a>
								</div>
								<div class="tns xg2">
									<table cellspacing="0" cellpadding="0">
									<tbody>
									<tr>
										<th>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=thread&amp;view=me&amp;from=space" class="xi2">4</a>
											</p>
											主题
										</th>
										<th>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=friend&amp;view=me" class="xi2">0</a>
											</p>
											好友
										</th>
										<td>
											<p>
												<a href="home.php?mod=space&amp;uid=1&amp;do=profile" class="xi2">35</a>
											</p>
											积分
										</td>
									</tr>
									</tbody>
									</table>
								</div>
								<p>
									<em><a href="home.php?mod=spacecp&amp;ac=usergroup&amp;gid=1" target="_blank">管理员</a></em>
								</p>
							</div>
						</td>
						<td class="plc">
							<div class="pi">
								<strong><a href="forum.php?mod=viewthread&amp;tid=6&amp;fromuid=1">
									<?php
 echo (($p-1)*3+1) + $i; $i++; ?>楼
								</a></strong>
								<div class="pti">
									<div class="pdbt">
									</div>
									<div class="authi">
										<img class="authicn vm" id="authicon16" src="/Public/Home/images/common/online_admin.gif"/>
										<em id="authorposton16">发表于 <span title="2018-5-4 11:05:56"><?=date('Y-m-d H:i:s', $reply['created_at'])?></span></em>
										<span class="pipe">|</span>
										<a href="forum.php?mod=viewthread&amp;tid=6&amp;extra=&amp;ordertype=1">倒序浏览</a>
										<span class="pipe">|</span>
									</div>
								</div>
							</div>
							<div class="pct">
								<style type="text/css">
									.pcb{margin-right:0}
								</style>
								<div class="pcb">
									<div class="t_fsz">
										<table cellspacing="0" cellpadding="0">
										<tbody>
										<tr>
											<td class="t_f" id="postmessage_16">
												 <?=$reply['rcontent']?>
											</td>
										</tr>
										</tbody>
										</table>
									</div>
									<div id="comment_16" class="cm">
									</div>
									<div id="post_rate_div_16">
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="plc plm">
						</td>
					</tr>
					<tr>
						<td class="pls">
						</td>
						<td class="plc" style="overflow:visible;">
						</td>
					</tr>
					<tr class="ad">
						<td class="pls">
						</td>
						<td class="plc">
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
			<?php endforeach; ?>
			<style>
				.result-wrap{padding:10px 20px;}
				.list-page{padding:20px 0;text-align:center;}
				.list-page a {	margin: 0 5px;
								padding: 2px 7px;
								border: 1px solid #ccc;
								background: #f3f3f3;
				}
			</style>
			<div class="result-wrap">
	        	<form name="myform" id="myform" method="post">
        			<div class="result-content">
						<div class="list-page">
                    		<?=$show?>
            			</div>
			        </div>
			    </form>
			</div>
			<!--回复列表end-->


			<div class="xi2 mbm pbm bbs">
			</div>
			<!-- 评论框start -->
			<!--[diy=diyfastposttop]-->
			<div id="diyfastposttop" class="area">
			</div>
			<!--[/diy]-->
			<div id="f_pst" class="pl bm bmw">
				<form method="post" id="fastpostform" action="/index.php/home/reply/save">
					<input type="hidden" name="pid" value="<?=$posts['pid']?>">
					<table cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
						<td class="pls">
							<div class="avatar">
								<?php if ($_SESSION['flag']) { ?>
								<img src="/<?=getSm($_SESSION['userInfo']['uface'])?>" />
								<?php } else { ?>
								<img src="/Public/Home/images/common/tavatar.gif"/>
								<?php } ?>
							</div>
						</td>
						<td class="plc">
							<span id="fastpostreturn"></span>
							<div class="cl">
								<div id="fastsmiliesdiv" class="y">
									<div id="fastsmiliesdiv_data">
										<div id="fastsmilies">
										</div>
									</div>
								</div>
								<div class="hasfsl" id="fastposteditor">
									<div class="tedt mtn">
										<div class="bar">
											<span class="y"></span>
										</div>
										<div class="area">
											<textarea rows="6" cols="80" name="rcontent" id="fastpostmessage" tabindex="4" class="pt"></textarea>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" name="" id="posttime" value=""/>
							<div class="upfl hasfsl">
								<table cellpadding="0" cellspacing="0" border="0" id="attach_tblheader" style="display: none;">
								<tbody>
								<tr>
									<td>
										点击附件文件名添加到帖子内容中
									</td>
									<td class="atds">
										描述
									</td>
									<td class="attv">
										 阅读权限 <img src="/Public/Home/images/common/faq.gif" alt="Tip" class="vm" onmouseover="showTip(this)" tip="阅读权限按由高到低排列，高于或等于选中组的用户才可以阅读"/>
									</td>
									<td class="attpr">
										金钱
									</td>
									<td class="attc">
									</td>
								</tr>
								</tbody>
								</table>
								<div class="fieldset flash" id="attachlist">
								</div>
							</div>
							<p class="ptm pnpost">
								<button type="submit" name="" id="fastpostsubmit" class="pn pnc vm" value="replysubmit" tabindex="5"><strong>发表回复</strong></button>
							</p>
						</td>
					</tr>
					</tbody>
					</table>
				</form>
			</div>
		</div>
		<!-- 评论框end -->
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