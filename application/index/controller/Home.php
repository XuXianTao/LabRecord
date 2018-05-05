<?php
namespace app\index\controller;

use think\Controller;

class Home extends Controller
{
	public function homeStu()
	{
		return view();
	}

	public function homeTa()
	{
		return view();
	}

	public function homeTeacher()
	{
		return view();
	}

	public function logout_stu()
	{
		$this->redirect('/');
	}
	public function logout_admin()
	{
		$this->redirect('/admin');
	}
}