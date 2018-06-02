<?php
namespace app\index\controller;

use think\Controller;

class Table extends Controller
{
	protected $p_course;
	public function initialize()
	{
		// 获取周数天数
		$GLOBALS['day'] = date('N');
		$GLOBALS['week'] = db('the_date')->find()['week'];

		// 获取当前时间的课程信息
		get_present_course($present_course_query);
		if (session('who')=='edu_teacher'||session('who')=='com_teacher')
			$this->p_course = $present_course_query->where('tea_id',session('user.id'))->find();
		elseif (session('who')=='ta')
			$this->p_course = $present_course_query->where('cla',session('user.cla'))->find() ;
	}

	//当前时间的学生表单
	public function table_stu() {
		$result = db('sign_stu')
		->where('sign_stu.course_id',$this->p_course['id'])
		->where('week', $GLOBALS['week'])
		->join('stu', 'sign_stu.id = stu.id and sign_stu.course_id = stu.course_id')
		->select();
		return json($result);
	}
	//修改当前学生表单的签到情况
	public function edit_stu($id, $opera) {
		$new_statu = 'null';
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = db('sign_stu')
		->where('id',$id)
		->where('course_id',$this->p_course['id'])
		->where('week',$GLOBALS['week'])
		->update(['stat' => $new_statu]);
		return json($stu);
	}

	//所有TA信息
	public function table_ta() {
		$result = db('ta')->select();
		return json($result);
	}
	//某个TA的详细登陆登出信息
	public function table_ta_detail($id) {
		$result = db('sign_ta')
		->where('id', $id)
		->select();
		return json($result);
	}

	//所有课程的表单
	public function table_course() {
		if (session('who')=='admin') {
			$result = db('course');
		}
		else {
			$result = db('course')->where('tea_id',session('user.id'));
		}
		return json(
			$result
			->join('tea','
				tea.id = course.tea_id and
				tea.typ >= 2'
				)
			->field([
				'concat("第",sch_week_start,"周-第",sch_week_end,"周 " "周",sch_day,"<br/>",sch_time_start,"-",sch_time_end)' => 'sch_time',
				'course.id' => 'cid',
				'course.nam' =>'cname',
				'cla',
				'sch_year',
				'sch_term',
				'sch_week_start',
				'sch_week_end',
				'sch_day',
				'sch_time_start',
				'sch_time_end',
				'grp_mem_num',
				'tea.nam' =>'tname',
				'tea.id' =>'tid',
			])
			->select());
	}
	//删除某个课程
	public function delete_course($id) {
		db('sign_stu')
		->where('course_id',$id)
		->delete();
		db('grp')
		->where('course_id',$id)
		->delete();
		db('stu')
		->where('course_id',$id)
		->delete();
		db('course')->delete($id);
		return 'success';
	}
	//修改某个课程
	public function change_course($cid, $detail) {
		db('course')->where('id',$cid)
		->update($detail);
		return json($detail);
	}
	//读取某课程对应所有学生
	public function table_stu_course($cid) {
		$result = db('stu')->where('course_id',$cid)->select();
		// 修改数组结构获取签到情况
		for ($i = 0; $i<count($result); $i++) {
			$sid = $result[$i]['id'];
			$sign = db('sign_stu')
			->where('course_id', $cid)
			->where('id', $sid)
			->select();
			for ($j = 0; $j<count($sign); $j++) {
				$result[$i]['sign_w'.$sign[$j]['week']] = $sign[$j]['stat'];
			}
		}
		return json($result);
	}

	//所有教师信息
	public function table_tea() {
		return json(db('tea')->select());
	}
	public function table_tea_course($cid) {
		return json(db('course')->where('tea_id',$cid)->select());
	}
}
