<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
	public function getData()
	{

        $link     = M('bbs_link');
    	// 获取版块信息
    	$parts    = M('bbs_part')->select();

        // 获取所有的友情链接
        $links    = $link->select();

        // 获取总用户数量, 今日新用户数量
        $bbs_user = M('bbs_user');
        $userAll  = $bbs_user->count();

        // 获取时间戳
        $year     = date("Y");
        $month    = date("m");
        $day      = date("d");
        //当天开始时间戳
        $start    = mktime(0,0,0,$month,$day,$year);
        //当天结束时间戳
        $end      = mktime(23,59,59,$month,$day,$year);
        
        // 今日新用户条件
        $where['created_at'] = [['elt', $end], ['EGT', $start], 'AND'];
        $newUser  = $bbs_user->where($where)->count();

        // 获取贴子数量
        $bbs_post = M('bbs_post');
        $postAll  = $bbs_post->count();
        
        // 获取今日贴子数
        $wheres['updated_at'] = [['elt', $end], ['EGT', $start], 'AND'];
        $newPost  = $bbs_post->where($wheres)->count();
        
        $this->assign('userAll', $userAll);
        $this->assign('newUser', $newUser);
        $this->assign('postAll', $postAll);
        $this->assign('newPost', $newPost);
    	$this->assign('parts',   $parts);
        $this->assign('links',   $links);
	}


    // 屏蔽敏感词汇
    public function banWord($text)
    {
        $str     = file_get_contents("./Public/Include/banWord.txt");
        $pattern = '/\|(.*?)\|/';
        $res     = preg_match_all($pattern, $str, $arr);

        return str_replace($arr[1], '**', $text);
    }
}