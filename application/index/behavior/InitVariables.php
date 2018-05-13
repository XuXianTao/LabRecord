<?php
namespace app\index\behavior;

class InitVariables
{
	public function run(&$param) {
		if (array_key_exists('type',session('user'))) {
			$param = db('course')
				->where('tea_id', session('user')['id'])
				->where('sch_week_start','<=',db('the_date')->find()['week'])
				->where('sch_day', CN_WEEK[date('N')])
				->whereTime('sch_time_start','<=',date("H:i:s"))
				->whereTime('sch_time_end','>=',date("H:i:s"))
				->find();
			}
		else {
			$param = db('course')
				->where('id', session('user')['course_id'])
				->where('sch_week_start','<=',db('the_date')->find()['week'])
				->where('sch_day', CN_WEEK[date('N')])
				->whereTime('sch_time_start','<=',date("H:i:s"))
				->whereTime('sch_time_end','>=',date("H:i:s"))
				->find();
		}
	}
}