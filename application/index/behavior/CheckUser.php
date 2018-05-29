<?php
namespace app\index\behavior;

use think\Controller;
use think\facade\Request;

class CheckUser extends Controller
{
	public function run($params) {
    //获取当前访问URL不含域名和参数
    $url = Request::baseUrl();
    $check_url1 = 'Home/homeStu';
    $check_url2 = 'Home/homeAdmin';
    $is_home = strpos($url, $check_url1) && strpos($url, $check_url2) ;
    if ($is_home && !session('?user'))
      $this->error('登录失效');
    else return ;
	}
}
