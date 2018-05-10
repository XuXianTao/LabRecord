<?php
namespace app\index\controller;

use think\Controller;

class Table extends Controller
{
	protected $stu_list;
	protected $ta_list;
	protected $course_list;

	public function initialize()
	{
		$GLOBALS['day'] = date('N');
		//$tmp_stu=db('stu')->select();
		//$sign_stu=new SignStu;
		//$sign_stu->allowField(true)->save($tmp_stu);
		$this->stu_list=db('sign_stu');
		$this->ta_list=db('sign_ta');
		$this->course_list=db('course');
	}

	//学生表单
	public function table_stu() {
		return json($this->stu_list->select());
	}
	public function edit_stu($id, $opera) {
		$new_statu;
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = $this->stu_list->where('id',$id)
		  ->update(['statu' => $new_statu]);
		return json($this->stu_list);
	}

	//ta的表单
	public function table_ta() {
		return json($this->ta_list->select());
	}
	public function edit_ta($id, $opera) {
		$new_statu;
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = $this->ta_list->where('id',$id)
		  ->update(['statu' => $new_statu]);
		return json($this->stu_list);
	}

	//课程的表单
	public function table_course() {
		return json($this->course_list
			->field([
				'concat(sch_day,"<br/>",sch_time_start,"-",sch_time_end)' => 'sch_time',
				'course.id' => 'cid',
				'course.name' =>'cname',
				'cla',
				'sch_year',
				'sch_term',
				'tea_id',
			])
			->join('teacher',[
				'teacher.type' => '2',
				'teacher.id' => 'course.tea_id'
			])
			->select());
	}
	public function delete_course($id) {
		$this->course_list->delete($id);
		return 'success';
	}
}