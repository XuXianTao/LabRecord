<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Hook;
use think\facade\Session;

class Excp extends Controller
{
    //学生提交异常反馈进行异常登记
    public function excp_stu_submit() {
        //dump(input(''));
        $sid = session('user.id');
        $cid = session('user.course_id');
        $seat = db('ip')->where('ip',$_SERVER['REMOTE_ADDR'])->find();
        $cla = $seat['cla'];
        $num = $seat['num'];
        $excp_desc = "";
        if (array_key_exists('machine',input(''))) {
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
        }
        if (!empty(input('param.excp_desc')))
        $excp_desc .= "<b>描述：</b>". input('param.excp_desc');
        if (empty($excp_desc)) $this->error('空的故障反馈，无效');
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
    //获取当前课程的助理名单
    public function excp_stu_pta() {
        $pcla = db('course')->where('id', session('user.course_id'))->find();
        $pta = db('sign_ta')
        ->where('week', db('the_date')->find()['week'])
        ->where('weekday', date('N'))
        ->where('cla', $pcla['cla'])
        ->where('sign_out', null)
        ->join('ta', 'ta.id = sign_ta.id')
        ->select();
        return json($pta);
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
            'excp_desc',
            'stat',
            'del_way'])
        ->select();
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
        $result['del_way'] .= $result['del_tim'].' '.session('user')['id'].' '.session('user')['nam'].':'.$stat.' 描述:'.$des.'\n';

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
