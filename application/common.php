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
//管理角色显示内容修订
define('TA', [
        'sign_stu'      => TRUE,
        'p_mechine'     => TRUE,
        's_mechine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => FALSE,
        'course'        => FALSE,
        'course_import' => FALSE,
        'ta_msg'        => TRUE,
        'sign_ta'       => FALSE,
        'teachers'      => FALSE
      ]);
define('EDU_TEACHER', [
        'sign_stu'      => TRUE,
        'p_mechine'     => FALSE,
        's_mechine'     => FALSE,
        'que'           => TRUE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => TRUE,
        'ta_msg'        => TRUE,
        'sign_ta'       => FALSE,
        'teachers'      => FALSE
      ]);
define('LAB_TEACHER', [
        'sign_stu'      => FALSE,
        'p_mechine'     => TRUE,
        's_mechine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => FALSE,
        'course'        => FALSE,
        'course_import' => FALSE,
        'ta_msg'        => FALSE,
        'sign_ta'       => TRUE,
        'teachers'      => FALSE
      ]);
define('COM_TEACHER', [
        'sign_stu'      => TRUE,
        'p_mechine'     => TRUE,
        's_mechine'     => TRUE,
        'que'           => TRUE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => TRUE,
        'ta_msg'        => TRUE,
        'sign_ta'       => TRUE,
        'teachers'      => FALSE
      ]);
define('ADMIN',[
        'sign_stu'      => FALSE,
        'p_mechine'     => TRUE,
        's_mechine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => FALSE,
        'ta_msg'        => TRUE,
        'sign_ta'       => TRUE,
        'teachers'      => TRUE
      ]);
define('ADMIN_ACCOUNT', [
        'id'            => 'admin',
        'typ'           => 4
        ]);
function get_present_course(&$param)
{
	//学生登录的时候--没有session，获取那个时间的课程
	$week = db('the_date')->find()['week'];
	$param = db('course')
		->where('sch_week_start','<=', $week)
		->where('sch_week_end','>=', $week)
		->where('sch_day', CN_WEEK[date('N')])
		->where('sch_time_start','<=',date("H:i:s"))
		->where('sch_time_end','>=',date("H:i:s"));
}
/*
 * @param int $sid 学生学号
 * @param int $cid 课程号
 * @param array &$grp 找到的第一个小组
 * @return int 找到的小组数
 */
function get_group($sid, $cid, &$grp)
{
    $grp_query = db('grp')->where('course_id', '=', $cid)
        ->where('stu1_id','=', $sid)
        ->whereOr('stu2_id','=', $sid)
        ->whereOr('stu3_id','=', $sid)
        ->whereOr('stu4_id','=', $sid);
    $grp = $grp_query->select();//查找学生有没有其对应的组队信息
    if(is_array($grp)) return count($grp);
    else return 0;
}
