<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Excp extends Controller
{
    public function excp_status(){
        $db = db('excp_submit');
        if (session('?user')&&session('who')=='ta') {
            $db = $db->where('excp_submit.cla',session('user')['cla']);
        }
        $result = $db
        ->where('excp_submit.stat = \'未处理\' or excp_submit.stat = \'处理未成功\' ')
        ->join('stu', 'excp_submit.stu_id = stu.id')
        ->field('excp_submit.id,submit_tim,stu_id,nam,cla,num,delId,delNam,delTim,excp_desc,stat,delWay')
        ->select();
        foreach($result as $val){
            $val['delNam'] = $val['delId'].' '.$val['delNam'];
            unset($val['delId']);
        }
		return json($result);
    }
    public function edit_excp(){
        $id = input('param.id');
        $stat = input('param.opera');
        $des = input('param.des');
        switch ($stat) {
			case 'undeal': $stat = "处理不成功";break;
			case 'deal': $stat = "处理成功";break;
		}
        $result = db('excp_submit')->where('id',$id)->find();
        $result['delId'] = session('user')['id'];
        $result['delNam'] = session('user')['nam'];
        $result['delTim'] = 'now()';
        $result['delWay'] .= $result['deltim'].' '.session('user')['id'].' '.session('user')['nam'].':'.$stat.' 描述:'.$des.'\n';

        $res = db('excp_submit')->where('id',$id)->update($result);

        return $res;
    }
    public function check_excp_update(){
        if (db('the_date')->find()['update_statu'] == true) {
			db('the_date')->update(['update_statu'=>false,'id'=>1]);
			return json('changed');
		}else {
			return json('unchanged');
		}
    }
};
