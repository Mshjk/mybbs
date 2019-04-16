<?php
namespace Home\Controller;

use Think\Controller;
use Think\Upload;
use Think\Image;

class UserController extends CommonController
{
	// 显示用户个人中心
	public function index()
	{
		// 如果没有登录, 则跳转到登录
		if (empty($_SESSION['flag'])) {
			$this->error('请先登录', '/');
		}

		$uid  = $_SESSION['userInfo']['uid'];
		// 获取用户信息
		$user = M('bbs_user')->find($uid);


		$this->assign('user', $user);
		$this->display();
	}

	// 修改个人信息
	public function update()
	{
		// 接收数据
		$data = $_POST;
		// 判断是否要删除原头像
		$del  = false;
		// 
		if (!empty($_FILES['uface']['name'])) {
			$info = $this->doUp();
			if (!$info) {
				// 头像上传失败
				echo '<script>alert("新头像上传失败,将保持原头像")</script>';
			} else {
				// 拼接文件路径
				$this->filename = $info['uface']['savepath'] . $info['uface']['savename'];
				// 把文件名放入插入数据库的数据中
				$data['uface'] = $this->filename;

				$del = true;
			}
		}

		// 判断信息是否有空
		foreach ($_POST as $k=>$v) {
			if (empty($v) && $k != 'yimg') {
				$this->error('信息不能为空');
			}
		}
		// 判断是否有传入id
		if (empty($_GET['uid']) && !isset($_GET['uid'])) {
			$this->error('未传入用户id');
		}

		$uid = $_GET['uid'];

		// 返回影响行数
		$res = M('bbs_user')->where("uid=$uid")->save($data);

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
			// 更新session的信息
			$user = M('bbs_user')->find($uid);
			$_SESSION['userInfo'] = $user;
			$this->success('更新成功', '/index.php/home/user/index');
		} else {
			$this->error('更新失败');
		}
	}


		// 显示修改密码-确认密码界面
	public function editPass()
	{
		$this->getData();
		if (!isset($_SESSION['flag']) || !$_SESSION['flag']) {
			$this->error('请先登录', '/index.php/home');
		}

		$this->display();
	}

	// 修改密码-确认原密码
	public function edit_pass()
	{
		if (!isset($_SESSION['flag']) || !$_SESSION['flag']) {
			$this->error('请先登录', '/index.php/home');
		}
		// 确认原密码是否正确
		$upwd  = $_POST['upwd'];
		$uid   = $_SESSION['userInfo']['uid'];

		$yupwd = M('bbs_user')->field('upwd')->find($uid);

		if (password_verify($upwd, $yupwd['upwd'])) {
			$this->success('密码正确', '/index.php/home/user/updatePass', 1);
		} else {
			$this->error('密码不对');
		}
	}

	// 修改密码界面
	public function updatePass()
	{
		$this->getData();
		
		$this->display();
	}

	// 修改密码
	public function update_pass()
	{
		// 密码不能为空
		if (empty($_POST['upwd']) || empty($_POST['reupwd'])) 
		{
			$this->error('密码不能为空');
		}

		if ($_POST['upwd'] != $_POST['reupwd']) {
			$this->error('两次密码输入不一致');
		}

		$uid 		  = $_SESSION['userInfo']['uid'];
		$data['uid']  = $uid;
		$data['upwd'] = password_hash($_POST['upwd'], PASSWORD_DEFAULT);

		$row 		  = M('bbs_user')->save($data);

		if ($row) {
			$this->success('密码修改成功', '/index.php/home');
		} else {
			$this->error('密码修改失败');
		}
	}


		// 生成缩略图
	private function doSm($thumb_name)
	{
		// 打开 $filename 文件, 进行处理
		$image = new Image(Image::IMAGE_GD, $this->filename);
		// 进行缩放处理, 生成新的缩略图文件
		$image->thumb(150, 150)->save($thumb_name);
	}

	// 上传文件
	private function doUp()
	{
		$config = [
			'maxSize'  => 3145728,
			'rootPath' => './',
			'savePath' => 'Public/Uploads/User/',
			'saveName' => array('uniqid',''),
			'exts' 	   => array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'  => true,
			'subName'  => array('date','Ymd'),
		];
		$upload = new Upload($config);
		// 上传图片
		$info   = $upload->upload();
		if (!$info) {
			// 上传失败
			$this->error($upload->getError());
		}
		return $info;
	}
}