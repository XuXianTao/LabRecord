<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Signin extends Controller
{
	public function initialize() {
    }
    // 点击+号调用，判断人数是否超过最多人数，超过是false
    public function judge_grp($num){
        $course_id = session('user')['course_id'];
        $course = db('course')->where('id',$course_id)->find();
        if($num < $course['grp_mem_num']){
            return true;
        }else{
            return false;
        }
    }
    //判断组队是否正确
    public function check_grp_data(){
        $result = [];
        if(session('who')=='stu'){
            if(session('user')){
                $cid = session('user.course_id');
                $sid = session('user.id');
                $grp_src = [
                    'course_id' => $cid,
                    'stu1_id' => input('param.stu1_id'),
                    'stu2_id' => input('param.stu2_id'),
                    'stu3_id' => input('param.stu3_id'),
                    'stu4_id' => input('param.stu4_id')
                ];
                foreach($grp_src as $key=>$val){
                    if($val==''||$val == NULL){
                        unset($grp_src[$key]);
                    }else{
                        if($key!='course_id'){
                            $stu = db('stu')->where('course_id',$cid)
                                            ->where('id',$val)
                                            ->find();
                            array_push($result, $stu);
                            if(empty($stu)){
                                return 1;//成员信息有误
                            }
                            $stu_num = get_group($sid, $cid, $grp);
                            //查找学生有没有其对应的组队信息
                            if($stu_num!=0){
                                return 2;//有人重复组队
                            }
                        }
                    }
                }
            }else{
                return 3;//登录失效了
            }
        }else{
            return 3;//登录失效了
        }
        return json($result);//登陆没问题
    }
    // 建立组队信息
    public function cre_grp(){
        $grp_src = [
			'course_id' => session('user')['course_id'],
			'stu1_id' => input('param.grp_mem1'),
            'stu2_id' => input('param.grp_mem2'),
            'stu3_id' => input('param.grp_mem3'),
            'stu4_id' => input('param.grp_mem4')
        ];
        dump($grp_src);
        $cid = db('grp')->insert($grp_src);
        //return '组队成功！';
        $this->redirect('/');
    }
    public function sign_in_data(){
        if(session('who')=='stu'){
            if(session('user')){
                $grp_num = get_group(session('user.id'),session('user.course_id'),$grp);
                if($grp_num == 0){
                    return '无组队信息!';
                }
                foreach($grp as $key=>$mem){
                    if(preg_match("/^stu[1-4]_id$/",$key)  && $grp[$key]!=0){
                        $stu = db('stu')->where('course_id',session('user.course_id'))
                                        ->where('id',$mem)
                                        ->field('nam,id')
                                        ->find();
                        $grp[$key]=$stu;
                    }
                }
                return json($grp);
            }
        }
        return '登录已失效!';
    }
    public function sign_in(){
        $week = (db('the_date')->find())['week'];
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
    }
}
