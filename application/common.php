<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
define('CN_WEEK',['','一','二','三','四','五','六','日']);
function get_present_course(&$param, $who='')
{
	//学生登录的时候--没有session，获取那个时间的课程
	if ($who==='stu') {
		$param = db('course')
			->where('sch_week_start','<=',db('the_date')->find()['week'])
			->where('sch_day', CN_WEEK[date('N')])
			->where('sch_time_start','<=',date("H:i:s"))
			->where('sch_time_end','>=',date("H:i:s"))
			->select();
	}
	//老师登录进主页获取对应时间的课程
	else if (array_key_exists('type',session('user'))) {
		$param = db('course')
			->where('tea_id', session('user.id'))
			->where('sch_week_start','<=',db('the_date')->find()['week'])
			->where('sch_week_start','>',db('the_date')->find()['week']-10)
			->where('sch_day', CN_WEEK[date('N')])
			->where('sch_time_start','<=',date("H:i:s"))
			->where('sch_time_end','>=',date("H:i:s"))
			->find();
	}
	//学生登录进主页后获取对应时间的课程
	else if (array_key_exists('course_id', session('user'))){
		$param = db('course')
			->where('id', session('user')['course_id'])
			->where('sch_week_start','<=',db('the_date')->find()['week'])
			->where('sch_day', CN_WEEK[date('N')])
			->where('sch_time_start','<=',date("H:i:s"))
			->where('sch_time_end','>=',date("H:i:s"))
			->find();
	}
	//实验室助理进入主页
	else {
		$param = db('course')
			->where('sch_week_start','<=',db('the_date')->find()['week'])
			->where('sch_day', CN_WEEK[date('N')])
			->where('sch_time_start','<=',date("H:i:s"))
			->where('sch_time_end','>=',date("H:i:s"))
			->column('id');
		return 'ta';
	}
	if(is_array($param) || is_object($param)){
            return count($param);
        }else{
            return 0;
        }
}

