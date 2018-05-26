<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\facade\Session;

class Login extends Controller
{
	protected $present_course;
	// 周数更新
	public function initialize(){
		if(Session::has('user')){
			if (session('who')=='stu') $this->redirect('Home/HomeStu');
			else $this->redirect('Home/homeAdmin');
		}
	}
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
		//当前时间所有课程
		get_present_course($present_course_query);
		$this->present_course = $present_course_query->select();
		$counts = count($this->present_course);
		//整理成选择条件
		$condition = [];
		for ($i=0;$i<$counts;$i++) {
			array_push($condition,['course_id','=',$this->present_course[$i]['id']]);
		}
		if ($counts>1) array_push($condition,'or');
		//判断这个学生在当前时间是否有课程
		$stu = db('stu')
		  ->where('id',$stu_id)
		  ->where($condition)
		  ->find();
		if (!$stu) return json('学号不存在');
		session('user',$stu);
		session('who','stu');
		//获取登陆学生的签到状态
		$week = db('the_date')->find()['week'];
		$sign_stu = db('sign_stu')
		->where('id', session('user')['id'])
		->where('course_id', session('user')['course_id'])
		->where('week', $week);
		$success= '签到没问题';
		$hostip =  $_SERVER['REMOTE_ADDR'];
		$stat = $sign_stu->find()['stat'];
		if ($stat =='未签到') {
			//更新学生的登陆时间
			$sign_stu->update([
				'stat' => '已签到',
				'sign_in' => date('H:i:s'),
				'ip' => $hostip
			]);
			db('the_date')->update(['update_statu'=>true,'id'=>1]);
		} else if ($stat=='已签到') {
			$success = "已签到";
		} else if ($stat=='已补签') {
			$success = "已补签";
		}
		else $success = '签到有问题';
		return json($success);
	}
  //判断管理成员登录-TA、仪器管理老师、任课老师
	public function check_admin($admin_id,$who)
	{
		switch ($who) {
			// 仪器老师登陆 typ=0x01 or 0x11
			case 'lab_teacher':
			  $user = db('tea')
			  ->where("id = $admin_id and typ%2<>0")
			  ->find();
			  if (!$user) return json('学号不存在');
				session('user',$user);
				session('who',$who);
			  return json('LabTeacher');
			// 上课老师登陆 typ=0x10 or 0x11
			case 'edu_teacher':
			  $user = db('tea')
			  ->where("id = $admin_id and typ>=2")
			  ->find();
			  if (!$user) return json('学号不存在');
				session('user',$user);
				session('who',$who);
			  return json('EduTeacher');
			case 'com_teacher':
			  $user = db('tea')
			  ->where("id = $admin_id and typ=3")
			  ->find();
			  if (!$user) return json('学号不存在');
				session('user',$user);
				session('who',$who);
			  return json('ComTeacher');
			// 助理登陆
			case 'ta':
				$user = db('ta')
			  ->where("id = $admin_id")
			  ->find();
			  if (!$user) return json('学号不存在');
				session('user',$user);
				session('who',$who);
				//更新助理的登陆时间
				$week = db('the_date')->find()['week'];
				$data = [
				'id' => session('user')['id'],
				'sign_in' => date('Y-m-d H:i:s'),
				'week' => $week,
				'weekday' => date('N')
				];
				db('sign_ta')->insert($data);
				session('user.sign_in',$data['sign_in']);
			  return json('Ta');
			case 'admin':
			  if ($admin_id===ADMIN_ACCOUNT['id']) {
				  session('user',ADMIN_ACCOUNT);
					session('who',$who);
			  	return json('Admin');
			  } else return json('admin_account_error');
		}
	}
}
