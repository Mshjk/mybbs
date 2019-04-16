<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends CommonController
{
	// 发帖
	public function create()
	{
		// 如果没有登录, 则跳转到登录
		if (empty($_SESSION['flag'])) {
			$this->error('请先登录', '/');
		}

		// 如果接受到版块id
		$cid   = empty($_GET['cid']) ? 0 : $_GET['cid'];

		// 获取版块信息
		$cates = M('bbs_cate')->getField('cid, cname');

		// 获取版块信息
		$ocates		= M('bbs_cate')->select();
		// 获取分区信息
		$oparts		= M('bbs_part')->select();

		$this->getData();
		$this->assign('cid',   $cid);
		$this->assign('cates', $cates);
		$this->assign('ocates', $ocates);
		$this->assign('oparts', $oparts);
		$this->display();
	}

	// 保存贴子的信息
	public function save()
	{
		$data = $_POST;

		// 发帖人id
		$data['uid'] = $_SESSION['userInfo']['uid'];
		// 创建时间, 更新时间
		$data['updated_at'] = $data['created_at'] = time();

		$row = M('bbs_post')->add($data);

		if ($row) {
			$this->success('贴子发布成功', '/index.php/home/post/index');
		} else {
			$this->error('贴子发布失败');
		}
	}

	// 贴子列表
	public function index()
	{

		$where   			 = [];
		$wheres  			 = [];
		// 如果是点击某个版块进来的
		if (isset($_GET['cid'])) {
			$where['cid'] 	 = ['eq', $_GET['cid']];
		}

		// 如果有查询
		if (isset($_POST['s']) && !empty($_POST['title'])) {
			$where['title']  = ['like', "%{$_POST['title']}%"];
		}

		$post    			 = M('bbs_post');

		// 获取所有贴子的用户id
		$pUid    			 = $post->field('uid')->where($where)->select();

		// 将uid重新保存到一个数组中, 并去重复, 并用','拼接
		$uidList 			 = [];
		foreach($pUid as $k=>$v) {
			$uidList[] 		 = $v['uid'];
		}
		$uid     			 = implode(',', array_unique($uidList));

		$wheres['uid'] 		 = ['in', $uid];
		// 获取所有用户信息
		$users   			 = M('bbs_user')->where($wheres)->getField('uid, uname');

		$where['is_display'] = ['eq', 1];
		// 获取所有贴子信息, 并按照置顶, 加精, 最后修改时间排序
		$posts   			 = $post->where($where)->order("is_top desc, is_jing desc, updated_at desc")->select();

		// 获取数据
		$this->getData();
		$this->assign('posts', $posts);
		$this->assign('users', $users);
		$this->display();
		// 遍历显示
	}
}