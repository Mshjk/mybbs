<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
    // 注册页
    public function signUp()
    {
        $this->display();
    }
    // 接收注册信息, 保存到数据库
    public function register()
    {
    }
    // 登录操作
    public function dologin()
    {
        $uname = $_POST['uname'];
        $upwd  = $_POST['upwd'];
        $user  = M('bbs_user');
        $ures  = $user->where("uname='{$uname}'")->find();

        if ($ures && password_verify($upwd, $ures['upwd'])) {
            $_SESSION['userInfo'] = $ures;
            $_SESSION['flag'] = true;
            $this->success('登录成功');
        } else {
            $this->error('账号或密码错误');
        }
    }
    // 退出登录
    public function logout()
    {
        $_SESSION['userinfo'] = NULL;
        $_SESSION['flag'] = false;
        $this->success('成功退出...', '/index.php/home/index/index', 1);
    }
}