<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends CommonController
{
	public function create()
	{
		// 如果没有登录, 则跳转到登录
		if (empty($_SESSION['flag'])) {
			$this->error('请先登录', '/');
		}
		$this->getData();
		$this->display();
	}
}