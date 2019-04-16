<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;

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
		$cid 		= empty($_GET['cid']) ? 0 : $_GET['cid'];
		// 获取版块信息
		$cates 		= M('bbs_cate')->getField('cid, cname');
		// 获取版块信息
		$ocates		= M('bbs_cate')->select();
		// 获取分区信息
		$oparts		= M('bbs_part')->select();

		$this->getData();
		$this->assign('cid',    $cid);
		$this->assign('cates',  $cates);
		$this->assign('ocates', $ocates);
		$this->assign('oparts', $oparts);
		$this->display();
	}

	// 保存贴子的信息
	public function save()
	{
		$data = $_POST;
		if (empty($_POST['title']) || empty($_POST['content'])) {
			$this->error('内容不能为空');
		}

		// 获取版块信息
		$cate 				 = M('bbs_cate')->find($_GET['cid']);

		// 版主发的贴子自动加精置顶
		if ($cate['uid'] == $_SESSION['userInfo']['uid']) {
			$data['is_top']  = 1;
			$data['is_jing'] = 1;
		}

		// 发帖人id
		$data['uid'] 		 = $_SESSION['userInfo']['uid'];
		// 创建时间, 更新时间
		$data['updated_at']  = $data['created_at'] = time();

		// 屏蔽敏感词汇
		$title				 = $data['title'];
		$content			 = $data['content'];
		$data['title']		 = $this->banWord($title);
		$data['content']	 = $this->banWord($content);

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
		// 贴子分页
		$count				 = $post->where($where)->count();
		$page 				 = new Page($count, 5);
		// 分页按钮
		$show  = $page->show();

		// 获取所有贴子信息, 并按照置顶, 加精, 最后修改时间排序
		$posts   			 = $post->where($where)->order("is_top desc, is_jing desc, updated_at desc")->limit($page->firstRow . ',' . $page->listRows)->select();

		// 版主有对贴子加精置顶的操作
		// 是否显示加精置顶按钮
		$cate  = M('bbs_cate')->find($_GET['cid']);
		$anniu = false;
		if ($cate['uid'] == $_SESSION['userInfo']['uid']) {
			$anniu = true;
		}

		// 获取数据
		$this->getData();
		$this->assign('posts', $posts);
		$this->assign('show',  $show);
		$this->assign('users', $users);
		$this->assign('anniu', $anniu);
		$this->display();
		// 遍历显示
	}

	// 版主置顶操作
	public function top()
	{
		$pid = $_GET['pid'];

		if ($_GET['method'] == 'jia') {
			$data['is_top'] = 1;	
		} else {
			$data['is_top'] = 0;			
		}
		$this->change($pid, $data);

		$this->success('修改成功');
	}


	// 版主加精操作
	public function jing()
	{
		$pid = $_GET['pid'];

		if ($_GET['method'] == 'jia') {
			$data['is_jing'] = 1;			
		} else {
			$data['is_jing'] = 0;	
		}
		$this->change($pid, $data);

		$this->success('修改成功');
	}

	// 操作修改post
	private function change($pid, $data)
	{
		return M('bbs_post')->where("pid=$pid")->save($data);
	}
}