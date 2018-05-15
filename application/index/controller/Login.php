<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
	protected $present_courseid;
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
		//当前时间所有课程的id数组
		$counts=get_present_course($this->present_courseid,'stu');
		//整理成选择条件
		$condition = [];
		for ($i=0;$i<$counts;$i++) {
			array_push($condition,['course_id','=',$this->present_courseid[$i]['id']]);
		}
		if ($counts>1) array_push($condition,'or');
		//判断在当前时间的课程中是否有这个学生
		$stu = db('stu')
		  ->where('id',$stu_id)
		  ->where($condition)
		  ->find();
		if (!$stu) return json('学号不存在');
		session('user',$stu);
		//获取当前登陆周数对于学生课程来说是第几周
		$GLOBALS['sweek'] = db('the_date')->find()['week']-$this->present_courseid[0]['sch_week_start'] + 1;
		//获取登陆学生的签到状态
		$stu = db('stu')
		->where('id',session('user')['id'])
		->where('course_id',$this->present_courseid[0]['id']);
		$success= '签到没问题';
		if ($stu->find()['sign_w'.$GLOBALS['sweek']]=='未签到') {
			//更新学生的登陆时间
			$stu->update([
				'sign_w'.$GLOBALS['sweek'] => '已签到',
				'signin_w'.$GLOBALS['sweek'] => date('H:i:s'),
			]);
			db('the_date')->update(['update_statu'=>true,'id'=>1]);
		} else if ($stu->find()['sign_w'.$GLOBALS['sweek']]=='已签到') {
			$success = "已签到";
		} else $success = '签到有问题';
		return json($success);
	}
  //判断管理成员登录-TA、仪器管理老师、任课老师
	public function check_admin($admin_id,$who)
	{
		switch ($who) {
			// 仪器老师登陆
			case 'lab_teacher':
			  $id = db('teacher')
			  ->where("id = $admin_id and type =1")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
			  return json('Home/homeLabTeacher');
			// 上课老师登陆
			case 'edu_teacher':
			  $id = db('teacher')
			  ->where("id = $admin_id and type =2")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
			  return json('Home/homeEduTeacher');
			// 助理登陆
			case 'ta':
				$id = db('ta')
			  ->where("id = $admin_id")
			  ->find();
			  if (!$id) return json('学号不存在');
				session('user',$id);
				//更新助理的登陆时间
				$GLOBALS['week'] = db('the_date')->find()['week'];
				$data = [
				'id' => session('user')['id'],
				'name' => session('user')['name'],
				'sign_in' => date('Y-m-d H:i:s'),
				'week' => $GLOBALS['week'],
				'day' => date('N')
				];
				db('sign_ta')->insert($data);
				session('user.sign_in',$data['sign_in']);
			  return json('Home/homeTa');
		}
	}
}