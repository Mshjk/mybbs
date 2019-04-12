<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController
{
	// 显示论坛首页
    public function index()
    {
        $cate  = M('bbs_cate');
        $user  = M('bbs_user');
        $pid   = isset($_GET['pid']) ? $_GET['pid'] : 'all';
        $cwhere = '';
        // 判断是否传入pid
        if ($pid == 'all') {
            // 没有传入 则显示所有版块
            $cwhere = '';
        } else {
            // 传入了pid 则显示该版块下的分区
            $cwhere = "pid=$pid";
        }

        // 查询该版块下的分区
        $cates = $cate->where($cwhere)->select();

        if (!empty($cates)) {
            // 获取并去除版块的uid的重复内容 并用,拼接起来 作为查询条件
            $uid   = $cate->where($cwhere)->Field('uid')->select();
            $uarr  = [];
            foreach($uid as $uv) {
                $uarr[] = $uv['uid'];
            }
            $uid   = implode(',', array_unique($uarr));
            // 查询版主id相对应的版主名称
            $users = $user->where("uid in ($uid)")->getField('uid, uname');
        }
        // 获取单个版块的信息
        $opart = M('bbs_part')->find($pid);

        $this->getData();
        $this->assign('pid', $pid);
        $this->assign('users', $users);
        $this->assign('opart', $opart);
        $this->assign('cates', $cates);
        $this->display();
    }
}