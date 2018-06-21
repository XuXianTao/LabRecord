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
define('MACHINE_STATIC',[
    '交流实验箱' => 'box_ac',
    '直流稳压电源' => 'dcpower',
    '台式万用表' => 'dmm',
    '功率表' => 'pm',
    '数字示波器' => 'oscp',
    '函数信号发生器' => 'fsg',
    '显示器' => 'display',
    '主机' => 'pc'
]);
define('MACHINE_NAME',[
    'box_ac' => '交流电路实验箱',
    'box_mode' => '模拟电路实验箱',
    'box_cir' => '电路基础实验箱',
    'dcpower' => '直流电源',
    'dmm' => '万用电表',
    'pm' => '功率因数表',
    'oscp' => '示波器',
    'fsg' => '函数发生器',
    'pc' => '主机',
    'display' => '显示器'
    ]);
define('MACHINE_ENGLISH_NAME',[
    '交流电路实验箱' => 'box_ac',
    '模拟电路实验箱' => 'box_mode',
    '电路基础实验箱' => 'box_cir',
    '直流电源' => 'dcpower',
    '万用电表' => 'dmm',
    '功率因数表' => 'pm',
    '示波器' => 'oscp',
    '函数发生器' => 'fsg',
    '主机' => 'pc',
    '显示器' => 'display'
    ]);
//管理角色显示内容修订
define('TA', [
        'sign_stu'      => TRUE,
        'p_machine'     => TRUE,
        's_machine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => FALSE,
        'course'        => FALSE,
        'course_import' => FALSE,
        'ta_msg'        => TRUE,
        'sign_ta'       => FALSE,
        'teachers'      => FALSE,
        'device_import' => FALSE,
        'excp_stats'    => FALSE
      ]);
define('EDU_TEACHER', [
        'sign_stu'      => TRUE,
        'p_machine'     => FALSE,
        's_machine'     => FALSE,
        'que'           => TRUE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => TRUE,
        'ta_msg'        => TRUE,
        'sign_ta'       => FALSE,
        'teachers'      => FALSE,
        'device_import' => FALSE,
        'excp_stats'    => FALSE
      ]);
define('LAB_TEACHER', [
        'sign_stu'      => FALSE,
        'p_machine'     => FALSE,
        's_machine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => FALSE,
        'course'        => FALSE,
        'course_import' => FALSE,
        'ta_msg'        => FALSE,
        'sign_ta'       => TRUE,
        'teachers'      => FALSE,
        'device_import' => TRUE,
        'excp_stats'    => TRUE
      ]);
define('COM_TEACHER', [
        'sign_stu'      => TRUE,
        'p_machine'     => TRUE,
        's_machine'     => TRUE,
        'que'           => TRUE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => TRUE,
        'ta_msg'        => TRUE,
        'sign_ta'       => TRUE,
        'teachers'      => FALSE,
        'device_import' => TRUE,
        'excp_stats'    => TRUE
      ]);
define('ADMIN',[
        'sign_stu'      => FALSE,
        'p_machine'     => FALSE,
        's_machine'     => TRUE,
        'que'           => FALSE,
        'que_publish'   => TRUE,
        'course'        => TRUE,
        'course_import' => FALSE,
        'ta_msg'        => TRUE,
        'sign_ta'       => TRUE,
        'teachers'      => TRUE,
        'device_import' => TRUE,
        'excp_stats'    => TRUE
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
    $grp = $grp_query->find();//查找学生有没有其对应的组队信息
    if($grp) return 1;
    else return 0;
}
