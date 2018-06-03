<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Excp extends Controller
{
    public function excp_stu_submit() {
        //dump(input(''));
        $sid = session('user.id');
        $cid = session('user.course_id');
        $seat = db('ip')->where('ip',$_SERVER['REMOTE_ADDR'])->find();
        $cla = $seat['cla'];
        $num = $seat['num'];
        $excp_desc = "";
        foreach(input('')['machine'] as $machine=>$parts) {
            $excp_desc .= "<b>".$machine.":</b><br/>";
            foreach($parts as $part=>$color_arr) {
                $excp_desc .= $part."-";
                foreach($color_arr as $i=>$color) {
                    $excp_desc .= "[".$color."] ";
                }
                $excp_desc .= "<br/>";
            }
        }
        if (!empty(input('param.excp_desc')))
        $excp_desc .= "<b>描述：</b>". input('param.excp_desc');
        $data = [
            'stu_id'    => $sid,
            'cla'       => $cla,
            'cid'       => $cid,
            'week'      => db('the_date')->find()['week'],
            'num'       => $num,
            'submit_tim'=> date('Y-m-d H:i:s'),
            'excp_desc' => $excp_desc
        ];
        //dump($data);
        //echo $data['excp_desc'];
        /*
        * 还需要处理统计数据
        */
        if (db('excp_submit')->insert($data)) $this->redirect('/');
        else $this->error('故障提交失败，请联系维护');
    }
    public function excp_status(){
        $db = db('excp_submit');
        if (session('?user')&&session('who')=='ta') {
            $db = $db->where('excp_submit.cla',session('user')['cla']);
        }
        $result = $db
        ->where('excp_submit.stat = \'未处理\' or excp_submit.stat = \'处理未成功\' ')
        ->join('stu', 'excp_submit.stu_id = stu.id')
        ->field([
            'excp_submit.id' => 'excp_id',
            'submit_tim',
            'stu_id',
            'nam',
            'cla',
            'num',
            'del_id',
            'del_nam',
            'del_tim',
            'LEFT(excp_desc,10)' => 'excp_desc_info',
            'stat',
            'del_way''LEFT(del_way,10)' => 'del_way_info'])
        ->select();
        foreach($result as $key=>$val){
            if($val['del_id']==null){
                $result[$key]['del_id']='';
            }
            if($val['del_nam']==null){
                $result[$key]['del_nam']='';
            }
        }
		return json($result);
    }
    public function del_excp(){
        $id = input('param.id');
        $oper = input('param.oper');
        $des = input('param.des');
        $result = db('excp_submit')->where('id',$id)->find();
        $result['del_id'] = session('user')['id'];
        $result['del_nam'] = session('user')['nam'];
        $result['del_tim'] = 'now()';
        $result['del_way'] = $result['del_tim'].' '.session('user')['id'].' '.session('user')['nam'].':'.$stat.' 描述:'.$des.'\n'.$result['del_way'];

        $res = db('excp_submit')->where('id',$id)->update($result);

        return $res;
    }
    public function check_excp_update(){
        if (db('the_date')->find()['update_statu2'] == true) {
			db('the_date')->update(['update_statu2'=>false,'id'=>1]);
			return json('changed');
		}else {
			return json('unchanged');
		}
    }
};
