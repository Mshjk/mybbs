<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;

class ReplyController extends CommonController
{
	// 添加回复
	public function create()
	{	
		if (!isset($_GET['pid'])) {
			$this->error('该贴子不存在');
		}
		$uid   		   	  = $posts['uid'];

		// 获取贴子id
		$pid   		   	  = $_GET['pid'];
		$post 		   	  = M('bbs_post');
		
		// 贴子的查看数+1
		$data 		   	  = [];
		$res		   	  = $post->where("pid=$pid")->setInc('view_cnt', 1);
		// 获取贴子数据
		$posts 		   	  = $post->find($pid);

		// 获取贴子的回复信息, 并分页
		$bbs_reply		  = M('bbs_reply');
		$count 			  = $bbs_reply->where("pid=$pid")->count();
		$page			  = new Page($count, 3);
		$show = $page->show();
		$replys			  = $bbs_reply->where("pid=$pid")->order("created_at asc")->limit($page->firstRow . ',' . $page->listRows)->select();

		// 获取用户的信息
		$users 		      = M('bbs_user')->select();
		$users			  = array_column($users, null, 'uid');

		// 楼号
		$p 				  = isset($_GET['p']) ? $_GET['p'] : 1;

		$this->getData();
		$this->assign('posts', $posts);
		$this->assign('replys', $replys);
		$this->assign('users', $users);
		$this->assign('show', $show);
		$this->assign('p', $p);
		$this->display();
	}

	// 保存回复内容
	public function save()
	{
		if (!$_SESSION['flag']) {
			$this->error('请先登录', '/', 1);
		}

		if (empty($_POST['rcontent'])) {
			$this->error('评论不能为空');
		}

		$data 				  	 = $_POST;
		$data['created_at']   	 = time();
		$data['uid']		 	 = $_SESSION['userInfo']['uid'];

		$row				  	 = M('bbs_reply')->add($data);

		if ($row) {
			$pid			  	 = $data['pid'];
			$bbs_post = M('bbs_post')->where("pid=$pid");
			// 更改贴子更新时间
			$time = time();
			$bbs_post->save(['updated_at'=>$time]);
			
			// 贴子回复数+1
			$bbs_post->setInc('rep_cnt', 1);			
			
			$this->success('添加回复成功');
		} else {
			$this->error('添加回复失败');
		}
	}
}