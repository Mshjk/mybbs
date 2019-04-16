<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;
use Think\Upload;
use Think\Image;

class UserController extends CommonController
{
	private $filename;

	// 显示用户列表
	public function index()
	{
		// 查询条件
		$where = [];
		if(isset($_GET['sex']) && !empty($_GET['sex'])) {
			$where['sex'] = ['eq', "{$_GET['sex']}"];
		}
		if(isset($_GET['uname']) && !empty($_GET['uname'])) {
			$where['uname'] = ['like', "%{$_GET['uname']}%"];
		}

		$users = M('bbs_user');
		// 获取用户数量
		$count = $users->where($where)->count();

		// 实例化分页类
		$page = new Page($count, 5);
		// foreach($where as $k=>$v) {
		// 	$page->parameter[$k] = urldecode($v);
		// }
		// 分页按钮
		$show = $page->show();

		// 查询所有用户信息并且分页
		$user = $users->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

		foreach($user as $k=>$v) {
			switch($v['sex']) {
				case 'w':
					$user[$k]['sex'] = '女';
					break;
				case 'm':
					$user[$k]['sex'] = '男';
					break;
				case 'x':
					$user[$k]['sex'] = '保密';
					break;
			}

			switch($v['auth']) {
				case '1':
					$user[$k]['auth'] = '<font color="red" size="5">超级管理员</font>';
					break;
				case '2':
					$user[$k]['auth'] = '<font color="green" size="4">普通管理员</font>';
					break;
				case '3':
					$user[$k]['auth'] = '<font color="black" size="3">普通用户';
					break;
			}

			$user[$k]['uface'] = getSm($v['uface']);
		}

		// 传输数据到模板
		$this->assign('user', $user);
		$this->assign('show', $show);
		$this->display();
	}

	// 显示添加用户界面
	public function create()
	{
		$this->display();
	}

	// 添加用户操作
	public function save()
	{
		$data = $_POST;
		$data['created_at'] = time();

		// 必须所有选项都不为空
		foreach ($data as $v) {
			if (empty($v)) {
				$this->error('不能有空');
			}
		}

		// 确认两次密码输入一致
		if($data['upwd'] != $data['reupwd']) {
			$this->error('两次密码输入不一致');
		}

		// 确认重复命名
		$res = M('bbs_user')->where("uname='{$data['uname']}'")->find();
		if ($res) {
			$this->error("账号名已经存在");
		} 

		// 加密密码
		$data['upwd'] = password_hash($data['upwd'], PASSWORD_DEFAULT);

		// 用户上传了头像
		if (!empty($_FILES['uface']['name'])) {
			// 上传头像
			$info = $this->doUp();
			
			// 拼接文件路径
			$this->filename = $info['uface']['savepath'] . $info['uface']['savename'];
			// 把文件名放入插入数据库的数据中
			$data['uface']  = $this->filename;

			// 拼接缩略图名称
			$thumb_name     = getSm($this->filename);
			// 生成缩略图
			$this->doSm($thumb_name);
		} else {
			$data['uface'] = NO_PIC;
		}

		// 添加到数据库, 返回受影响行
		$res = M('bbs_user')->add($data);

		if ($res) {
			$this->success('添加成功', '/index.php/admin/user/index');
		} else {
			$this->error('添加失败');
		}
	}

	// 删除用户操作
	public function del()
	{
		if(!isset($_GET['uid']) || empty($_GET['uid'])) {
			$this->error('未传入用户id');
		}

		$uid = $_GET['uid'];

		$user = M('bbs_user');

		$userinfo = $user->find($uid);
		// 返回删除的记录数
		$res = $user->delete($uid);

		if($res) {
			unlink($userinfo['uface']);
			// 删除原缩放图
			$sm_yimg    = pathinfo($userinfo['uface']);
			$sm_yimg    = $sm_yimg['dirname'] . '/sm_' . $sm_yimg['filename'] . '.' . $sm_yimg['extension'];
			unlink($sm_yimg);
			$this->success('删除成功', '/index.php/admin/user/index');
		} else {
			$this->error('删除失败');
		}
	}

	// 显示修改用户信息页面
	public function edit()
	{
		if (!isset($_GET['uid']) || empty($_GET['uid'])) {
			$this->error('未传入用户id');
		}

		$uid  		   = $_GET['uid'];
		$user 		   = M('bbs_user')->find($uid);

		$yimg 		   = $user['uface'];
		$user['uface'] = getSm($user['uface']);

		// 传输数据到视图
		$this->assign('yimg', $yimg);
		$this->assign('user', $user);

		// 显示视图
		$this->display();
	}

	// 修改用户信息操作
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
			$this->success('更新成功', '/index.php/admin/user/index');
		} else {
			$this->error('更新失败');
		}
	}

	// 显示修改密码-确认密码界面
	public function editPass()
	{
		if (!isset($_SESSION['flag']) || !$_SESSION['flag']) {
			$this->error('请先登录', '/index.php/admin/login/login');
		}

		$this->display();
	}

	// 修改密码-确认原密码
	public function edit_pass()
	{
		if (!isset($_SESSION['flag']) || !$_SESSION['flag']) {
			$this->error('请先登录', '/index.php/admin/login/login');
		}
		// 确认原密码是否正确
		$upwd = $_POST['upwd'];
		$uid = $_SESSION['userInfo']['uid'];

		$yupwd = M('bbs_user')->field('upwd')->find($uid);

		if (password_verify($upwd, $yupwd['upwd'])) {
			$this->success('密码正确', '/index.php/admin/user/updatePass', 1);
		} else {
			$this->error('密码不对');
		}
	}

	// 修改密码界面
	public function updatePass()
	{
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
			$this->success('密码修改成功', '/index.php/admin');
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