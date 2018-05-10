<?php
namespace app\index\controller;

use think\Controller;

class Table extends Controller
{
	protected $stu_sign_list;
	protected $ta_sign_list;
	protected $course_list;
	protected $stu_list;

	public function initialize()
	{
		$GLOBALS['day'] = date('N');
		//$tmp_stu=db('stu')->select();
		//$sign_stu=new SignStu;
		//$sign_stu->allowField(true)->save($tmp_stu);
		$this->stu_sign_list=db('sign_stu');
		$this->ta_sign_list=db('sign_ta');
		$this->course_list=db('course');
		$this->stu_list=db('stu');
	}

	//学生表单
	public function table_stu() {
		return json($this->stu_sign_list->select());
	}
	public function edit_stu($id, $opera) {
		$new_statu;
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = $this->stu_sign_list->where('id',$id)
		  ->update(['statu' => $new_statu]);
		return json($this->stu_sign_list);
	}

	//ta的表单
	public function table_ta() {
		return json($this->ta_sign_list->select());
	}
	public function edit_ta($id, $opera) {
		$new_statu;
		switch ($opera) {
			case 'append': $new_statu = "已补签";break;
			case 'leave': $new_statu = "已请假";break;
			case 'absence': $new_statu = "缺勤";break;
		}
		$stu = $this->ta_sign_list->where('id',$id)
		  ->update(['statu' => $new_statu]);
		return json($this->stu_sign_list);
	}

	//课程的表单
	public function table_course() {
		return json($this->course_list
			->join('teacher',[
				'teacher.type' => '2',
				'teacher.id' => 'course.tea_id',
			])
			->field([
				'concat("周",sch_day,"<br/>",sch_time_start,"-",sch_time_end)' => 'sch_time',
				'course.id' => 'cid',
				'course.name' =>'cname',
				'cla',
				'sch_year',
				'sch_term',
				'tea_id',
				'teacher.name' =>'tname'
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