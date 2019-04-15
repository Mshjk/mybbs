<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class PostController extends CommonController
{
	// 显示贴子列表
	public function index()
	{
		// 查询条件
		$where = [];
		if(isset($_GET['cid']) && !empty($_GET['cid'])) {
			$where['cid'] = ['eq', "{$_GET['cid']}"];
		}
		if(isset($_GET['uname']) && !empty($_GET['uname'])) {
			$userWhere['uname'] = ['like', "%{$_GET['uname']}%"];
			$uname			= $_GET['uname'];
			// 查找该用户名相关的信息
			$userinfo		= M('bbs_user')->where($userWhere)->getField('uid, uname');
			$userinfo		= array_keys($userinfo);
			$userinfo		= implode(',', $userinfo);
			$where['uid']	= ['in', $userinfo];
		}
		if(isset($_GET['title']) && !empty($_GET['title'])) {
			$where['title'] = ['like', "%{$_GET['title']}%"];
		}


		$bbs_post	= M('bbs_post');
		
		// 分页
		$count = $bbs_post->where($where)->count();
		$page = new Page($count, 3);
		$show = $page->show();
		
		// 获取贴子信息
		$posts		= $bbs_post->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

		// 获取所有发帖人的id
		$uids		= $bbs_post->where($where)->getField('pid, uid');
		// 去除重复, 并用',' 拼接
		$uids		= implode(',', array_unique($uids));
		// 获取发帖人信息
		$whe['uid'] = ['in', "$uids"];
		$users		= M('bbs_user')->where($whe)->getField('uid, uname');
		// 获取版块信息
		$cates		= M('bbs_cate')->select();
		// 获取分区信息
		$parts		= M('bbs_part')->select();

		$this->assign('posts', $posts);
		$this->assign('cates', $cates);
		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->assign('show',  $show);
		$this->display();
	}

	// 删除帖
	public function del()
	{
		if (!isset($_GET['pid']) || empty($_GET['pid'])) {
			$this->error('该贴子不存在');
		}

		$pid = $_GET['pid'];
		$row = M('bbs_post')->delete($pid);
		if ($row) {
			// 删除该贴子下的评论
			M('bbs_reply')->where("pid=$pid")->delete();
			$this->success('贴子删除成功');
		} else {
			$this->error('贴子删除失败');
		}
	}

	// 贴子加精
	public function addJing()
	{
		$pid 			 = $_GET['pid'];
		$data['is_jing'] = 1;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

	// 贴子取消加精
	public function rmJing()
	{
		$pid 			 = $_GET['pid'];
		$data['is_jing'] = 0;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

	// 贴子置顶
	public function setTop()
	{
		$pid 			 = $_GET['pid'];
		$data['is_top']  = 1;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

	// 贴子取消置顶
	public function rmTop()
	{
		$pid 			 = $_GET['pid'];
		$data['is_top']  = 0;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

	// 不显示贴子
	public function no_display()
	{
		$pid			 	= $_GET['pid'];
		$data['is_display'] = 0;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

	// 显示贴子
	public function post_display()
	{
		$pid			 	= $_GET['pid'];
		$data['is_display'] = 1;
		M('bbs_post')->where("pid=$pid")->save($data);
		header('location: /index.php/admin/post');
	}

}