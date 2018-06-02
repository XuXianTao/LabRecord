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
            'delId',
            'delNam',
            'delTim',
            'excp_desc',
            'stat',
            'delWay'])
        ->select();
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
