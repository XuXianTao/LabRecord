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
		$stu = db('stu')
		  ->where('id',$stu_id)
		  ->find();
		if (!$stu) return json('学号不存在');
		session('user',$stu);
		return json('Home/homeStu');
	}
  //判断管理成员登录-TA、仪器管理老师、任课老师
	public function check_admin($admin_id,$who)
	{
		switch ($who) {
			case 'lab_teacher':
			  $id = db('teacher')
			  ->where("id = $admin_id and type =1")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
			  return json('Home/homeLabTeacher');
			case 'edu_teacher':
			  $id = db('teacher')
			  ->where("id = $admin_id and type =2")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
			  return json('Home/homeEduTeacher');
			case 'ta':
				$id = db('ta')
			  ->where("id = $admin_id")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
			  return json('Home/homeTa');
		}
	}
}