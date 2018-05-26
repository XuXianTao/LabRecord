<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Signin extends Controller
{
	public function initialize() {
    }
    public function judge_grp($num){
        $course_id = session('user')['course_id'];
        $course = db('course')->where('id',$course_id)->find();
        if($num < $course['grp_mem_num']){
            return true;
        }else{
            return false;
        }
    }
    public function cre_grp(){
        $grp_src = [
			'course_id' => session('user')['course_id'],
			'stu1_id' => input('param.stu1_id'),
            'stu2_id' => input('param.stu2_id'),
            'stu3_id' => input('param.stu3_id'),
            'stu4_id' => input('param.stu4_id')
        ];
        foreach($grp_src as $key=>$val){
            if($val==''||$val == NULL){
                if($key!='course_id'){
                    if($key!='stu1_id'){
                        unset($grp_src[$key]);
                    }else{
                        return '组长信息不能为空!';
                    }
                }else{
                    return '学生登录失效!';
                }
            }else{
                if($key!='course_id'){
                    $stu = db('stu')->where('course_id',$course_id)
                                    ->where('id',$val)
                                    ->count();
                    if($stu==0){
                        return '成员信息有误!';
                    }
                    $stu = db('grp')->where('course_id','=',$course_id)
                    ->whereOr('stu1_id','=',$val)
                    ->whereOr('stu2_id','=',$val)
                    ->whereOr('stu3_id','=',$val)
                    ->whereOr('stu4_id','=',$val)
                    ->count();//查找学生有没有其对应的组队信息
                    if($stu!=0){
                        return '有人重复组队!';
                    }
                }
            }
        }
        $cid = db('grp')->insert($grp_src);
        return '组队成功！';
    }
    public function sign_in_data(){
        if(session('who')=='stu'){
            if(session('user')){
                $grp = db('grp')->where('course_id','=',session('user')['course_id'])
						->whereOr('stu1_id','=',session('user')['id'])
						->whereOr('stu2_id','=',session('user')['id'])
						->whereOr('stu3_id','=',session('user')['id'])
						->whereOr('stu4_id','=',session('user')['id'])
                        ->find();
            if($grp == NULL){
                return '无组队信息!';
            }
            return $grp;
            }
        }
        return '登录已失效!';
    }
    public function sign_in(){
        if(session('who')=='stu'){
            if(session('user')){
                $week = (db('the_date')>find())['week'];
                $success=[];
                for($i = 1;$i <= 4;$i++){
                    if(input('param.stu'.$i.'_id')){
                        $sign_stu = db('sign_stu')
                                        ->where('id', input('param.stu'.$i.'_id'))
                                        ->where('course_id', session('user')['course_id'])
                                        ->where('week', $week);
                        $success[$i]= '签到没问题';
                        $hostip =  $_SERVER['REMOTE_ADDR'];
                        $stat = $sign_stu->find()['stat'];
                        if ($stat =='未签到') {
                            //更新学生的登陆时间
                            $sign_stu->update([
                                'stat' => '已签到',
                                'sign_in' => date('H:i:s'),
                                'ip' => $hostip
                            ]);
                            db('the_date')->update(['update_statu'=>true,'id'=>1]);
                        } else if ($stat=='已签到') {
                            $success[$i] = "已签到";
                        } else if ($stat=='已补签') {
                            $success[$i] = "已补签";
                        }
                    }
                }
                return $success;
            }else{
                return '登录已失效!';
            }
        }else{
            return '登录已失效!';
        }
        
        
    }
}