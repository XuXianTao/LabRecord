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
	public function change_course($cid,$detail) {
		db('course')->where('id',$cid)
		->update($detail);
		db('grp')->where('course_id',$cid)->delete();
		$stu_data = db('stu')->where('course_id')->select();
		db('sign_stu')->where('course_id',$cid)->where('week <'.$detail['sch_week_start'].' or week >'.$detail['sch_week_end'])->delete();
		$sign_stu_data = [];
		$sign_i = 0;
		for($week = $detail['sch_week_start'];$week <= $detail['sch_week_end'];$week++){
			$mem = db('sign_stu')->where('week',$week)->where('course_id',$cid)->find();
			if($mem!=null){
				foreach($stu_data as $key=>$val){
					$sign_stu_data[$sign_i]['id'] = $val['id'];
					$sign_stu_data[$sign_i]['course_id'] = $cid;
					$sign_stu_data[$sign_i]['week'] = $week;
					$sign_i++;
				}
			}
		}
		db('sign_stu')->insertAll($sign_stu_data);
		unset($sign_stu_data);
		if($detail['grp_mem_num']==1){
			foreach ($stu_data as $key=>$val) {
				$stu_data[$key]['stu1_id'] = $stu_data[$key]['id'];
				unset($stu_data[$key]['nam']);
				unset($stu_data[$key]['id']);
			}
			db('grp')->insertAll($stu_data);
		}
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

	//学生查询自己提交的异常情况
	public function table_excp_stu() {
		$result = db('excp_submit')
		->where('cid', session('user.course_id'))
		->where('week',db('the_date')->find()['week'])
		->field(['*',
			'LEFT(excp_desc,10)' => 'excp_desc_info',
			'LEFT(del_way,10)' => 'del_way_info'
		])
		->select();
		return json($result);
	}
	//学生端异常处理-修改处理状态
	public function excp_deal() {
		//记录助理处理历史
		$pcla = db('course')->where('id', session('user.course_id'))->find();
		switch (input('param.statu')) {
			case '处理成功':
				db('sign_ta')
				->where('id',input('param.taid'))
				->where('week',db('the_date')->find()['week'])
				->where('weekday',date('N'))
				->where('cla', $pcla['cla'])
				->where('sign_out',null)
				->setInc('excp_suc');
				db('ta')
				->where('id',input('param.taid'))
				->setInc('excp_suc');
				break;
			case '处理未成功':
				db('sign_ta')
				->where('id',input('param.taid'))
				->where('week',db('the_date')->find()['week'])
				->where('weekday',date('N'))
				->where('cla', $pcla['cla'])
				->where('sign_out',null)
				->setInc('excp_fail');
				db('ta')
				->where('id',input('param.taid'))
				->setInc('excp_fail');
				break;
		}

		//修改处理状态
		$del_nam = db('ta')->where('id',input('param.taid'))->find()['nam'];
		$row_desc = db('excp_submit')
		->where('id',input('param.id'))
		->find()['del_way'];
		$del_desc = $row_desc.date('Y-m-d H:i:s')." ".$del_nam."[".input('param.taid')."] ".input('param.statu')." ".input('param.desc')."<br/>";
		db('excp_submit')
		->where('id',input('param.id'))
		->update([
			'del_tim' => date('Y-m-d H:i:s'),
			'stat' => input('param.statu'),
			'del_way' => $del_desc
		]);
		//记录更新，让助理界面刷新
		db('the_date')->update(['update_statu2'=>true,'id'=>1]);
		return ;
	}
	//管理员异常处理-示波器
	public function table_oscp() {
		return json(db('dev_osc')->select());
	}
}
