<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
	public function getData()
	{

        $link  = M('bbs_link');
    	// 获取版块信息
    	$parts = M('bbs_part')->select();

        // 获取所有的友情链接
        $links = $link->select();

    	$this->assign('parts', $parts);

        $this->assign('links', $links);
	}
}