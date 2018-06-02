<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Excp extends Controller
{
    public function excp_status(){
        $result = db('excp_submit')
		->where('excp_submit.cla',session('user')['cla'])
        ->join('stu', 'excp_submit.stu_id = stu.id')
        ->field('submit_tim,stu_id,nam,num,delId,delNam,delTim,excp_desc,stat')
        ->select();
        foreach($result as $val){
            $val['delNam'] = $val['delId'].' '.$val['delNam'];
            unset($val['delId']);
        }
		return json($result);
    }
    public function update_excp(){
        
    }
    public function check_excp_update(){

    }
};
