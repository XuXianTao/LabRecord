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
        $result = db('excp_submit')->insert($data);
        db('the_date')->update(['update_statu2'=>true,'id'=>1]);
        if ($result) $this->redirect('/');
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
        ->join('stu', 'excp_submit.stu_id = stu.id and excp_submit.cid = stu.course_id')
        ->field([
            'excp_submit.id' => 'excp_id',
            'submit_tim',
            'stu_id',
            'nam',
            'cla',
            'num',
            'del_tim',
            'LEFT(excp_desc,10)' => 'excp_desc_info',
            'excp_desc',
            'stat',
            'del_way',
            'LEFT(del_way,10)' => 'del_way_info'])
        ->select();
        foreach($result as $key=>$val){
            if($val['del_way']==null){
                $result[$key]['del_way']='';
            }
        }
		return json($result);
    }
    public function del_excp(){
        //记录助理处理历史
        switch (input('param.oper')) {
            case '处理成功':
                db('sign_ta')
                ->where('id', session('user.id'))
                ->where('week',db('the_date')->find()['week'])
                ->where('weekday',date('N'))
                ->where('cla', session('user.cla'))
                ->where('sign_out',null)
                ->setInc('excp_suc');
                db('ta')
                ->where('id',session('user.id'))
                ->setInc('excp_suc');
                break;
            case '处理未成功':
                db('sign_ta')
                ->where('id',session('user.id'))
                ->where('week',db('the_date')->find()['week'])
                ->where('weekday',date('N'))
                ->where('cla', session('user.cla'))
                ->where('sign_out',null)
                ->setInc('excp_fail');
                db('ta')
                ->where('id',session('user.id'))
                ->setInc('excp_fail');
                break;
        }
        //更新故障反馈记录
        $id = input('param.id');
        $oper = input('param.oper');
        $des = input('param.des');
        $result = db('excp_submit')->where('id',$id)->find();
        $result['stat']=$oper;
        $result['del_tim'] = date('Y-m-d H:i:s');
        $result['del_way'] = $result['del_way'].$result['del_tim'].' '.' '.session('user')['nam'].'['.session('user')['id'].']:'.$oper.' 描述:'.$des.'<br>';
        $res = db('excp_submit')->where('id',$id)->update($result);

        return $res;
    }
    public function check_excp_update(){
        if (db('the_date')->find()['update_statu2'] == true) {
			db('the_date')->update(['update_statu2'=>false,'id'=>1]);
			return json('changed');
		}else {
			return json('excp-unchanged');
		}
    }
};
