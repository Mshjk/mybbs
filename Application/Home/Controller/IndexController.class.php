<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
	// 显示论坛首页
    public function index()
    {
    	$cate  = M('bbs_cate');
    	$user  = M('bbs_user');
        $link  = M('bbs_link');
    	// 获取版块信息
    	$parts = M('bbs_part')->select();
    	// 主页显示的分区的版块id
    	$pid   = isset($_GET['pid']) ? $_GET['pid'] : 1;
    	// 查询该版块下的分区
    	$cates = $cate->where("pid={$pid}")->select();
        // 获取所有的友情链接
        $links = $link->select();
    	if (!empty($cates)) {
	    	// 获取并去除版块的uid的重复内容 并用,拼接起来 作为查询条件
	    	$uid   = $cate->where("pid={$pid}")->Field('uid')->select();
	    	$uarr  = [];
			foreach($uid as $uv) {
				$uarr[] = $uv['uid'];
			}
			$uid   = implode(',', array_unique($uarr));
			// 查询版主id相对应的版主名称
			$users = $user->where("uid in ($uid)")->getField('uid, uname');
		}

		$this->assign('users', $users);
    	$this->assign('parts', $parts);
    	$this->assign('cates', $cates);
        $this->assign('links', $links);
        $this->display();
    }
}