<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
	// 显示登录页面
	public function login()
	{
		$this->display();
	}

	// 接收数据,验证
	public function dologin()
	{
		$uname 		= $_POST['uname'];
		$upwd  		= $_POST['upwd'];
		$code  		= $_POST['code']; // 填写的验证码

		$user  		= M('bbs_user')->where("uname='{$uname}'")->find();

		$verify     = new \Think\Verify();
		$check_code = $verify->check($code);

		// 判断验证码是否正确
		if(!$check_code) {
			$this->error('验证码错误');
		}


		if ($user && password_verify($upwd, $user['upwd'])) {
			// 保存当前登录成功的用户信息
			$_SESSION['userInfo'] = $user;
			// 是否登录
			$_SESSION['flag'] = true;
			
			$this->success('登录成功', '/index.php/admin/index', 1);
		} else {
			$this->error('账号或密码错误');
		}
	}

	// 退出登录
	public function logout()
	{
		$_SESSION['userInfo'] = NULL;
		$_SESSION['flag']	  = false;

		$this->success('成功退出...', '/index.php/admin/login/login');
	}

	// 获取验证码图片
	public function getCode()
	{
		$config = [
			'fontSize'  => 18,	  // 验证码字体大小
			'length'    => 4,	  // 验证码位数
			'useNoise'	=> false, // 是否使用验证码杂点
			'useCurve' => true, // 是否使用混淆曲线	
			'imageW'	=> 130,	  // 验证码图片宽度
			'imageH'	=> 50,	  // 验证码图片高度
		];
		$Verify	= new \Think\Verify($config); 
		$Verify->entry();
	}
}