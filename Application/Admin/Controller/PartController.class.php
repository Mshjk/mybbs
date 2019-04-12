<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends CommonController
{
	// 添加分区页面
	public function create()
	{
		$this->display();
	}

	// 添加操作
	public function save()
	{
		// 确认数据不为空
		if (empty($_POST)) {
			$this->error('分区名称不能为空');
		}

		// 将数据添加进数据库
		$row = M('bbs_part')->add($_POST);

		// 判断是否添加成功
		if ($row) {
			$this->success('添加成功', '/index.php/admin/part/index');
		} else {
			$this->error('添加失败');
		}
	}

	// 查看分区列表
	public function index()
	{
		$parts = M('bbs_part')->select();

		$this->assign('parts', $parts);
		$this->display();
	}

	// 删除分区
	public function del()
	{
		if (!isset($_GET['pid']) || empty($_GET['pid'])) {
			$this->error('未传输id');
		}
		$pid = $_GET['pid'];
		// 如果该分区下有版块 不能删除
		$res = M('bbs_cate')->where("pid=$pid")->select();
		if ($res) {
			// 说明该分区下有版块
			$this->error('该分区下有版块, 不能删除');
		}
		$row = M('bbs_part')->delete($pid);

		// 判断结果
		if ($row) {
			$this->success('删除成功');
		} else {
			$this->success('删除失败');
		}
	}

	// 显示修改分区页面
	public function edit()
	{
		if(!isset($_GET['pid']) || empty($_GET['pid'])) {
			$this->error('未传输id');
		}

		$pid = $_GET['pid'];

		$pinfo = M('bbs_part')->find($pid);

		// 判断是否有这个分区
		if (!$pinfo) {
			$this->error('不存在该分区');
		}

		$this->assign('pinfo', $pinfo);
		$this->display();
	}

	// 修改分区操作
	public function update()
	{
		$data = $_POST;

		$row = M('bbs_part')->save($data);

		if ($row) {
			$this->success('修改成功', '/index.php/admin/part');
		} else {
			$this->error('修改失败');
		}
	}
}