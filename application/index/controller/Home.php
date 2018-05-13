<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;

class Home extends Controller
{
	protected $the_date;
	protected $present_course;
	protected $present_ta;
	protected $sign_ta;
// 周数更新
	public function initialize() {
		if (!session('?user')) $this->error('没登录');
		//更新周数天数
		$this->the_date= db('the_date')->find();
		//更新天数
		if ($this->the_date['day']!=date('N')) {
			db('the_date')->update(['day'=>date('N'),'id'=>1]);
		}
		//自动更新周数
		if (date('W')-$this->the_date['start_date']!=0){
			$this->the_date['week']+=date('W')-$this->the_date['start_date'];
			$this->the_date['start_date']=date('W');
			db('the_date')->update($this->the_date);
		}

		$GLOBALS['week'] = $this->the_date['week'];
		$GLOBALS['day'] = $this->the_date['day'];

		$result = get_present_course($this->present_course);
		if ($result!=='ta') {
			if ($result==0) {
				$GLOBALS['sweek']=1;
			} else {
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
		return view()->assign(['course' => $this->present_course]);
	}
// 登出
	public function logout_stu()
	{
		$stu = db('stu')
		->where('id',session('user')['id'])
		->where('course_id',$this->present_course['id']);
		$stu->update([
				'signout_w'.$GLOBALS['sweek'] => date('H:i:s'),
			]);
		session(null);
		return redirect('/');
	}
	public function logout_admin()
	{
		//TA 登出
		if (array_key_exists('duty_time',session('user'))) {
			$ta = db('sign_ta')
			->where('id',session('user.id'))
			->where('sign_in',session('user.sign_in'));
			$ta->update(['sign_out' => date('Y-m-d H:i:s')]);

			$data = $ta->find();
			//dump($data);
			$duty_time = strtotime($data['sign_out'])-strtotime($data['sign_in']);
			//dump($duty_time);
			$ta->update([
			  'duty_time' => $duty_time,
			]);
			db('ta')
			->where('id', session('user')['id'])
			->setInc('duty_time', $duty_time);
		}
		session(null);
		return redirect('/admin');
	}

// 逻辑函数处理
	// 更新周数
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