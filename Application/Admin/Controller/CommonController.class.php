<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		// 验证是否成功登录, 如果没有, 跳转到登录页面
		if (empty($_SESSION['flag'])) {
			$this->error('请先登录', '/index.php/admin/login/login', 1);
		}
	}
}