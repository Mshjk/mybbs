<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Upload;
use Think\Image;

class LinkController extends CommonController
{
	// 显示友情链接列表
	public function index()
	{
		// 获取友情链接列表
		$links 	  = M('bbs_link')->select();

		foreach ($links as $k=>$v) {
			$lpic = $v['lpic'];
			$links[$k]['lpic'] = getSm($lpic);
		}

		$this->assign('links', $links);
		$this->display();
	}

	// 显示友情链接添加页面
	public function create()
	{
		$this->display();
	}

	// 友情链接添加操作
	public function save()
	{
		$data = $_POST;

		// 必须所有选项都不为空
		foreach ($data as $v) {
			if (empty($v)) {
				$this->error('不能有空');
			}
		}
		// 上传logo
		$info = $this->doUp();

		// 拼接文件路径
		$this->filename = $info['lpic']['savepath'] . $info['lpic']['savename'];
		// 把文件名放入插入数据库的数据中
		$data['lpic']   = $this->filename;

		// 拼接缩略图名称
		$thumb_name     = getSm($this->filename);
		// 生成缩略图
		$this->doSm($thumb_name);

		// 添加到数据库, 返回受影响行
		$res = M('bbs_link')->add($data);

		if ($res) {
			$this->success('添加成功', '/index.php/admin/link/index');
		} else {
			$this->error('添加失败');
		}
	}

	// 删除链接
	public function del()
	{
		if (!isset($_GET['lid']) || empty($_GET['lid'])) {
			$this->error('没有传入id');
		}

		// 获取该链接信息
		$link = M('bbs_link')->find($_GET['lid']);
		// 删除该链接
		$res  = M('bbs_link')->delete($_GET['lid']);

		if ($res) {  // 删除成功
			// 删除图片
			unlink($link['lpic']);
			// 删除原缩放图
			$sm_yimg    = pathinfo($link['lpic']);
			$sm_yimg    = $sm_yimg['dirname'] . '/sm_' . $sm_yimg['filename'] . '.' . $sm_yimg['extension'];
			unlink($sm_yimg);
			$this->success('删除成功', '/index.php/admin/link/index', 1);
		} else {
			$this->error('删除失败');
		}
	}

	// 修改链接页面
	public function edit()
	{
		$link  = M('bbs_link');
		// 获取要修改的链接的信息
		$links = $link->find($_GET['lid']);
		// 获取原图片
		$yimg  = $links['lpic'];
		// 把图片地址换成缩放后的图片地址
		$links['lpic'] = getSm($links['lpic']);

		$this->assign('yimg',  $yimg);
		$this->assign('links', $links);
		$this->display();
	}

	// 修改操作
	public function update()
	{
		// 接收数据
		$data = $_POST;
		// 判断是否要删除原头像
		$del  = false;
		// 
		if (!empty($_FILES['lpic']['name'])) {
			$info = $this->doUp();
			if (!$info) {
				// 头像上传失败
				echo '<script>alert("新logo上传失败,将保持原logo")</script>';
			} else {
				// 拼接文件路径
				$this->filename = $info['lpic']['savepath'] . $info['lpic']['savename'];
				// 把文件名放入插入数据库的数据中
				$data['lpic'] = $this->filename;

				$del = true;
			}
		}

		// 判断信息是否有空
		foreach ($_POST as $k=>$v) {
			if (empty($v) && $k != 'yimg') {
				$this->error('信息不能为空');
			}
		}

		$lid = $_POST['lid'];

		// 返回影响行数
		$res = M('bbs_link')->where("lid=$lid")->save($data);

		if ($res) { // 信息更新成功
			if ($del) { // 头像成功上传
				// 删除原图像
				unlink($_POST['yimg']);
				// 删除原缩放图
				$sm_yimg    = pathinfo($_POST['yimg']);
				$sm_yimg    = $sm_yimg['dirname'] . '/sm_' . $sm_yimg['filename'] . '.' . $sm_yimg['extension'];
				unlink($sm_yimg);
				// 生成新缩略图
				// 拼接新缩略图名称
				$thumb_name = getSm($this->filename);
				
				// 生成缩略图
				$this->doSm($thumb_name);
			}
			$this->success('更新成功', '/index.php/admin/link/index');
		} else {
			$this->error('更新失败');
		}
	}

	// 生成缩略图
	private function doSm($thumb_name)
	{
		// 打开 $filename 文件, 进行处理
		$image = new Image(Image::IMAGE_GD, $this->filename);
		// 进行缩放处理, 生成新的缩略图文件
		$image->thumb(90, 90)->save($thumb_name);
	}

	// 上传文件
	private function doUp()
	{
		$config = [
			'maxSize'  => 3145728,
			'rootPath' => './',
			'savePath' => 'Public/Uploads/Link/',
			'saveName' => array('uniqid',''),
			'exts' 	   => array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'  => true,
			'subName'  => array('date','Ymd'),
		];
		$upload = new Upload($config);
		// 上传图片
		$info   = $upload->upload();
		if (!$info) {
			$this->error($upload->getError());
		}
		return $info;
	}
}