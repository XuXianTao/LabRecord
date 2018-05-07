<?php
namespace app\index\controller;

use think\Controller;

class Home
{
	protected $update_statu = false;
// 主页显示
	public function homeStu()
	{
		return view();
	}

	public function homeTa()
	{
		return view();
	}

	public function homeLabTeacher()
	{
		return view();
	}

  public function homeEduTeacher()
	{
		return view();
	}
// 登出
	public function logout_stu()
	{
		return redirect('/');
	}
	public function logout_admin()
	{
		return redirect('/admin');
	}

// 逻辑函数处理

	public function change_update()
	{
		$this->$update_statu = true;
	}
  //TA界面ajax判断是否刷新界面
	public function check_sql_update()
	{
		if ($this->update_statu) {
			$this->$update_statu = false;
			return json(true);
		}else {
			return json(false);
		}
	}
}