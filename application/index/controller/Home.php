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
		if ($this->the_date['weekday']!=date('N')) {
			db('the_date')->update(['weekday'=>date('N'),'id'=>1]);
		}
		//自动更新周数
		if (date('W')-$this->the_date['start_date']!=0){
			$this->the_date['week']+=date('W')-$this->the_date['start_date'];
			$this->the_date['start_date']=date('W');
			db('the_date')->update($this->the_date);
		}
		//每一次的请求都刷新week和day，使用GLOBALS不必assign
		$GLOBALS['week'] = $this->the_date['week'];
		$GLOBALS['day'] = $this->the_date['weekday'];
		//生成查询当前时间的课程信息的字符串
		get_present_course($this->present_course);
	}
// 主页显示
// 拥有队伍数
	public function homeStu()
	{
		if(session('who')=='stu'){
			$grp_stat = get_group(session('user.id'), session('user.course_id'), $grp);
			$excp_static = db('excp_static')->select();
			return view()->assign(['grp_stat'=>$grp_stat, 'excp_static'=>$excp_static]);
		} else $this->error('你不是学生');
	}
	public function homeAdmin()
	{
		if (session('?user')) {
			if (session('who')=='ta') {
				//更新TA的登陆课室
				$ta = db('sign_ta')
					->where('id',session('user.id'))
					->where('sign_in',session('user.sign_in'));
				if ($ta->find()['cla']==null){
					$ta->update(['cla' => input('param.cla')]);
					session('user.cla', input('param.cla'));
					//TA所在课室正在上的课
				}
				$p_course = $this->present_course->where('cla', input('param.cla'))->find();
			}
			else if (session('who')=='edu_teacher' || session('who')=='com_teacher') {
				//任课老师的课
				$p_course = $this->present_course->where('tea_id', session('user.id'))->find();
			}
			else if (session('who')=='admin' && $_SERVER['REMOTE_ADDR']!='127.0.0.1' && $_SERVER['REMOTE_ADDR']!='127.0.1.1') {
				$this->error('涉及最高管理操作，请到服务器上操作');
			}
			else $p_course = [];
		}
		return view()->assign(['course' => $p_course]);
	}

// 登出
	public function logout_stu()
	{
		//记录登出时间
		if(Session::has('user')){
			if(session('who')=='stu'){
				$grp_stat = get_group(session('user.id'), session('user.course_id'), $grp);
				if($grp_stat){
					foreach($grp as $key=>$val){
						if($key!='course_id'&&$key!='id'){
							if($val){
								$sign_stu = db('sign_stu')
										->where('id',$val)
										->where('course_id',session('user.course_id'))
										->where('week',$GLOBALS['week'])
										->update([
												'sign_out' => date('H:i:s'),
											]);
							}
						}
					}
				}
				session(null);
				return redirect('/');
			}
		}
	}
	public function logout_admin()
	{
		//TA 登出
		if (session('?user')&&session('who')=='ta') {
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
