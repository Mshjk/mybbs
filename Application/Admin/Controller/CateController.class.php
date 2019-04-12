<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends CommonController
{
	// 显示添加版块页面
	public function create()
	{
		// 获取现在所有的分区
		$parts = M('bbs_part')->select();
		// 获取所有用户
		$users = M('bbs_user')->where('auth<=2')->select();

		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->display();
	}

	// 添加板块操作
	public function save()
	{
		$data = $_POST;

		$row = M('bbs_cate')->add($data);

		if ($row) {
			$this->success('添加成功', '/index.php/admin/cate');
		} else {
			$this->error('添加失败');
		}
	}

	// 查看某个分区下的版块
	public function show()
	{
		$pid = $_GET['pid'];

		$c = M('bbs_cate');
		// 查询版块内容
		$cates = $c->where("pid=$pid")->select();
		// 获取版块所属分区的id 以及版主的id
		$pid   = $c->Field('pid')->select();
		$uid   = $c->Field('uid')->select();
		
		// 去除版块的pid 和 uid的重复内容 并用,拼接起来
		$parr = [];
		$uarr = [];
		foreach($pid as $pv) {
			$parr[] = $pv['pid'];
		}
		foreach($uid as $uv) {
			$uarr[] = $uv['uid'];
		}
		$pid = implode(',', array_unique($parr));
		$uid = implode(',', array_unique($uarr));


		// 查询分区内容
		$parts = M('bbs_part')->where("pid in ($pid)")->getField('pid, pname');
		$users = M('bbs_user')->where("uid in ($uid)")->getField('uid, uname');

		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->assign('cates', $cates);
		$this->display();
	}

	// 查看版块
	public function index()
	{
		$c = M('bbs_cate');
		// 查询版块内容
		$cates = $c->select();
		// 获取版块所属分区的id 以及版主的id
		$pid   = $c->Field('pid')->select();
		$uid   = $c->Field('uid')->select();
		
		// 去除版块的pid 和 uid的重复内容 并用,拼接起来
		$parr = [];
		$uarr = [];
		foreach($pid as $pv) {
			$parr[] = $pv['pid'];
		}
		foreach($uid as $uv) {
			$uarr[] = $uv['uid'];
		}
		$pid = implode(',', array_unique($parr));
		$uid = implode(',', array_unique($uarr));


		// // 查询分区内容
		// $parts = M('bbs_part')->field('pid,pname')->select();
		// // 查询用户信息
		// $users = M('bbs_user')->field('uid, uname')->where('auth<=2')->select();

		// // 把名称作为值, id作为键
		// $parts = array_column($parts, 'pname', 'pid');
		// $users = array_column($users, 'uname', 'uid');

		// 这两行和前面几行一样效果
		$parts = M('bbs_part')->where("pid in ($pid)")->getField('pid, pname');
		$users = M('bbs_user')->where("uid in ($uid)")->getField('uid, uname');

		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->assign('cates', $cates);
		$this->display();
	}

	// 删除版块
	public function del()
	{
		if (!isset($_GET['cid']) || empty($_GET['cid'])) {
			$this->error('没有传入id');
		}
		$cid = $_GET['cid'];

		// 返回删除的记录数
		$res = M('bbs_cate')->delete($cid);

		if($res) {
			$this->success('删除成功', '/index.php/admin/cate/index');
		} else {
			$this->error('删除失败');
		}
	}

	// 显示修改版块页面
	public function edit()
	{
		$cid   = $_GET['cid'];
		$cate  = M('bbs_cate')->find($cid);

		$parts = M('bbs_part')->select();

		$users = M('bbs_user')->where('auth<=2')->select();

		$this->assign('cid',   $cid);
		$this->assign('users', $users);
		$this->assign('cate',  $cate);
		$this->assign('parts', $parts);
		$this->display();
	}

	// 修改板块操作
	public function update()
	{
		$data = $_POST;

		$row = M('bbs_cate')->save($data);

		if ($row) {
			$this->success('修改成功', '/index.php/admin/cate');
		} else {
			$this->error('修改失败');
		}
	}
}