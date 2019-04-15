<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends CommonController
{
    // 注册页
    public function signUp()
    {
        $this->getData();
        $this->display();
    }
    // 接收注册信息,保存到数据库
    public function register()
    {
        $data   = $_POST;
        // 选项不能有空
        foreach($data as $v) {
            if (empty($v)) {
                $this->error('不能有空');
            }
        }
        
        $user   = M('bbs_user');
        // 账户名是否重复
        $runame = $user->where("uname='{$data['uname']}'")->find();
        if ($runame) {
            // 用户名重复
            $this->error('账户已存在');
        }

        // 密码是否一致
        if ($data['upwd'] !== $data['reupwd']) {
            $this->error('两次密码不一致');
        }

        $data['upwd']       = password_hash($data['upwd'], PASSWORD_DEFAULT);
        $data['created_at'] = time();
        $data['auth']       = 3;
        $data['uface']      = 'Public/Uploads/User/no.jpg';
        $row = $user->add( $data );
        if ($row) {
         $this->success('注册成功!', '/');
        } else {
           $this->error('注册失败!');
        }
    } 
    // 登录操作
    public function dologin()
    {
        $uname = $_POST['uname'];
        $upwd  = $_POST['upwd'];
        $user  = M('bbs_user');
        $ures  = $user->where("uname='{$uname}'")->find();

        if ($ures && password_verify($upwd, $ures['upwd'])) {
            unset($ures['upwd']);
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
        $_SESSION['userInfo'] = NULL;
        $_SESSION['flag']     = false;
        $this->success('成功退出...', '/index.php/home/index/index', 1);
    }
}