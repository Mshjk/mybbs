<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController
{
    public function index()
    {
    	if ($_SESSION['userInfo']['auth'] > 2) {
    		$this->error('对不起, 你无权进入', '/');
    	}
        $this->display();
    }
}