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
//ajax 登录判断
  //判断学生登录
	public function check_stu($stu_id)
	{
		$id = db('stu')
		  ->where("id = $stu_id")
		  ->find();
		if (!$id) return json('学号不存在');
		return json('Home/homeStu');
	}
  //判断管理成员登录-TA、仪器管理老师、任课老师
	public function check_admin($admin_id,$who)
	{
		switch ($who) {
			case 'lab_teacher':
			  $id = db('man')
			  ->where("id = $admin_id and typ =0")
			  ->find();
			  if (!$id) return json('学号不存在');
			  return json('Home/homeLabTeacher');
			case 'edu_teacher':
			  $id = db('man')
			  ->where("id = $admin_id and typ =1")
			  ->find();
			  if (!$id) return json('学号不存在');
			  return json('Home/homeEduTeacher');
			case 'ta':
				$id = db('man')
			  ->where("id = $admin_id and typ =2")
			  ->find();
			  if (!$id) return json('学号不存在');
			  return json('Home/homeTa');
		}
	}
}