<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class ReplyController extends CommonController
{
	// 显示评论列表
	public function index()
	{
		// 查询条件
		$userWhere = [];
		$postWhere = [];
		$where 	   = [];
		if(isset($_GET['uname']) && !empty($_GET['uname'])) {
			$userWhere['uname'] = ['like', "%{$_GET['uname']}%"];
			$uname				= $_GET['uname'];
			// 查找该用户名相关的信息
			$userinfo			= M('bbs_user')->where($userWhere)->getField('uid, uname');
			$userinfo			= array_keys($userinfo);
			$userinfo			= implode(',', $userinfo);
			$where['uid']		= ['in', $userinfo];
		}
		if(isset($_GET['title']) && !empty($_GET['title'])) {
			$postWhere['title'] = ['like', "%{$_GET['title']}%"];
			// 查找该贴子相关信息
			$postinfo			= M('bbs_post')->where($postWhere)->getField('pid, title');
			$postinfo			= array_keys($postinfo);
			$postinfo			= implode(',', $postinfo);

			$where['pid'] 		= ['in', $postinfo];
		}


		$bbs_reply = M('bbs_reply');
		
		// 分页
		$count     = $bbs_reply->where($where)->count();
		$page      = new Page($count, 3);
		$show      = $page->show();

		$replys    = $bbs_reply->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();

		// 获取贴子信息
		$posts     = M('bbs_post')->where($postWhere)->getField('pid, title');
		// 获取用户信息
		$users	   = M('bbs_user')->where($userWhere)->getField('uid, uname');

		// var_dump($posts, $users, $replys);die;

		$this->assign('replys', $replys);
		$this->assign('posts', $posts);
		$this->assign('users', $users);
		$this->assign('show', $show);
		$this->display();
	}
}