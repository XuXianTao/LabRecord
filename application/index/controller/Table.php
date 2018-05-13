<?php
namespace app\index\controller;

use think\Controller;

class Table extends Controller
{
	protected $ta_sign_list;
	protected $course_list;
	protected $stu_list;
	protected $present_course;
	public function initialize()
	{
		$GLOBALS['day'] = date('N');
		$GLOBALS['week'] = db('the_date')->find()['week'];

		$this->ta_sign_list=db('sign_ta');
		$this->course_list=db('course');
		$this->stu_list=db('stu');
		$result = get_present_course($this->present_course);
		if ($result!='ta')
			$GLOBALS['sweek'] = $GLOBALS['week']-$this->present_course['sch_week_start']+1;
	}

	//学生表单
	public function table_stu() {
		$result = $this->stu_list
		->where('course_id',$this->present_course['id'])
		->select();
		return json($result);
	}
	public function edit_stu($id, $opera) {
		$new_statu = 'null';
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = $this->stu_list
		->where('id',$id)
		->where('course_id',$this->present_course['id'])
		->update(['sign_w'.$GLOBALS['sweek'] => $new_statu]);
		return json($stu);
	}

	//ta的表单
	public function table_ta() {
		$result = db('ta')->select();
		return json($result);
	}
	public function table_ta_detail($id) {
		$result = db('sign_ta')
		->where('id', $id)
		->select();
		return json($result);
	}

	//课程的表单
	public function table_course() {
		return json(db('course')
			->join('teacher','
				teacher.id = course.tea_id and
				teacher.type = 2'
				)
			->field([
				'concat("第",sch_week_start,"周开始 周",sch_day,"<br/>",sch_time_start,"-",sch_time_end)' => 'sch_time',
				'course.id' => 'cid',
				'course.name' =>'cname',
				'cla',
				'sch_year',
				'sch_term',
				'tea_id',
				'sch_week_start',
				'teacher.name' =>'tname',
				'teacher.id' =>'tid'
			])
			->select());
	}
	public function delete_course($id) {
		$this->stu_list
		->where('course_id',$id)
		->delete();
		$this->course_list->delete($id);
		return 'success';
	}

	//读取某课程对应所有学生
	public function table_stu_course($cid) {
		return json($this->stu_list
		->where('course_id',$cid)
		->select());
	}
}