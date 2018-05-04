<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
	public function loginStu()
	{
		return view();
	}

	public function loginAdmin()
	{
		return view();
	}

	public function check_stu()
	{
		return redirect('Home/homeStu');
	}

	public function check_admin(Request $request)
	{
		if ($request->has('ta','post')) {

			return redirect('Home/homeTa');
		}
		else if ($request->has('teacher','post')) {

			return redirect('Home/homeTeacher');
		}
		else {
			$this->error('错误操作','/admin',-1,1);
		}
	}
}