<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Home extends Controller
{
	protected $the_date;
	protected $present_course;
	protected $present_ta;
	protected $sign_ta;
// 周数更新
	public function initialize() {
		if (!session('?user')) $this->error('没登录');
		//获取天数周数
		$this->the_date= db('the_date')->find();
		//更新数据库天数
		if ($this->the_date['day']!=date('N')) {
			db('the_date')->update(['day'=>date('N'),'id'=>1]);
		}
		//自动更新周数
		if (date('W')-$this->the_date['start_date']!=0){
			$this->the_date['week']+=date('W')-$this->the_date['start_date'];
			$this->the_date['start_date']=date('W');
			db('the_date')->update($this->the_date);
		}
		//每一次的请求都刷新week和day，使用GLOBALS不必assign
		$GLOBALS['week'] = $this->the_date['week'];
		$GLOBALS['day'] = $this->the_date['day'];
		//获取当前时间的课程信息
		$result = get_present_course($this->present_course);
		//判断是否是助理登陆
		if ($result!=='ta') {
			if ($result==0) {
				//当前没有课程
				$GLOBALS['sweek']=1;
			} else {
				//当前课程->获取当前周数是该课程的第几周
				$GLOBALS['sweek'] = $GLOBALS['week']-$this->present_course['sch_week_start']+1;
			}
		}
	}
// 主页显示
	public function homeStu()
	{

		return view();
	}

	public function homeTa()
	{
		//更新TA的登陆课室
		$ta = db('sign_ta')
			->where('id',session('user.id'))
			->where('sign_in',session('user.sign_in'));
		if ($ta->find()['cla']==null)
			$ta->update(['cla' => input('param.cla')]);
		return view();
	}

	public function homeLabTeacher()
	{
		return view();
	}

  public function homeEduTeacher()
	{
		//前台当前时间的课程信息
		return view()->assign(['course' => $this->present_course]);
	}
// 登出
	public function logout_stu()
	{
		//dump(session('user'));
		//记录登出时间
		if(Session::has('user')){
			if(array_key_exists('course_id',session('user'))){
				$stu = db('stu')
				->where('id',session('user')['id'])
				->where('course_id',$this->present_course['id']);
				$stu->update([
						'signout_w'.$GLOBALS['sweek'] => date('H:i:s'),
					]);
				session(null);
				return redirect('/');
			}
		}
	}
	public function logout_admin()
	{
		//TA 登出
		if (array_key_exists('duty_time',session('user'))) {
			$ta = db('sign_ta')
			->where('id',session('user.id'))
			->where('sign_in',session('user.sign_in'));
			//记录助理登出时间
			$ta->update(['sign_out' => date('Y-m-d H:i:s')]);
			$data = $ta->find();
			//记录助理本次的值班时间
			$duty_time = strtotime($data['sign_out'])-strtotime($data['sign_in']);
			$ta->update([
			  'duty_time' => $duty_time,
			]);
			//增加助理的总值班时间
			db('ta')
			->where('id', session('user')['id'])
			->setInc('duty_time', $duty_time);
		}
		session(null);
		return redirect('/admin');
	}

// 逻辑函数处理
	// ajax更新周数
	public function change_week($week)
	{
		$this->the_date['week']=$week;
		$this->the_date['start_date']=date('W');
		db('the_date')->update($this->the_date);
		$GLOBALS['week'] = $this->the_date['week'];
	}
  //老师界面ajax判断是否是否有学生登录->刷新界面
	public function check_sql_update()
	{
		if (db('the_date')->find()['update_statu'] == true) {
			db('the_date')->update(['update_statu'=>false,'id'=>1]);
			return json('changed');
		}else {
			return json('unchanged');
		}
	}


}