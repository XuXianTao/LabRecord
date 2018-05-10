<?php
namespace app\index\controller;

use think\Controller;

define('CN_WEEK',['','一','二','三','四','五','六','七']);

class Home extends Controller
{
//监控判断ta界面是否需要更新
	protected $update_statu = false;
	protected $the_date;
// 周数更新
	public function initialize() {
		$this->the_date= db('the_date')->select()[0];
		$GLOBALS['week'] = $this->the_date['week'];
		$GLOBALS['day'] = $this->the_date['day'];
		if (date('W')-$this->the_date['start_date']!=0){
			$this->the_date['week']+=date('W')-$this->the_date['start_date'];
			$this->the_date['start_date']=date('W');
			db('the_date')->update($this->the_date);
		}
	}
// 主页显示
	public function homeStu()
	{
		if (!session('?user')) $this->error('没登录玩啥呢','/');
		return view();
	}

	public function homeTa()
	{
		if (!session('?user')) $this->error('没登录玩啥呢','/admin');
		return view();
	}

	public function homeLabTeacher()
	{
		if (!session('?user')) $this->error('没登录','/admin');
		return view();
	}

  public function homeEduTeacher()
	{
		if (!session('?user')) $this->error('没登录','/admin');
		return view();
	}
// 登出
	public function logout_stu()
	{
		session(null);
		return redirect('/');
	}
	public function logout_admin()
	{
		session(null);
		return redirect('/admin');
	}

// 逻辑函数处理

	public function change_week($week)
	{
		$this->the_date['week']=$week;
		$this->the_date['start_date']=date('W');
		db('the_date')->update($this->the_date);
		$GLOBALS['week'] = $this->the_date['week'];
	}
  //TA界面ajax判断是否刷新界面
	public function check_sql_update()
	{
		if ($this->update_statu) {
			$this->update_statu = false;
			return json(true);
		}else {
			return json(false);
		}
	}


}