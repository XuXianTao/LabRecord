<?php
namespace app\index\controller;

use think\Controller;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet;

define('DS', '/');
class Excel extends Controller
{
    protected $output = '../output';
	protected $uploads = '../uploads';
	public function check_data(){
		$flag = db('course')->where('sch_year','=',input('param.sch_year'))
					->where('sch_term','=',input('param.sch_term'))
					->where('sch_day','=',input('param.sch_day'))
					->where('cla','=',input('param.cla'))
					->where('sch_time_start <= '.input('param.sch_time_end').' and sch_time_end >= '.input('param.sch_time_start'))
					->where('sch_week_start <= '.input('param.sch_week_end').' and sch_week_end >= '.input('param.sch_week_start'))
					->count();
		dump($flag);
		return json($flag);
	}	
	public function import_stu() {
		//新建课程
		$data_course = [
			'nam' => input('param.name'),
			'cla' => input('param.cla'),
			'tea_id' => session('user')['id'],
			'sch_time_start' => input('param.sch_time_start'),
			'sch_time_end' => input('param.sch_time_end'),
			'sch_year' => input('param.sch_year'),
			'sch_term' => input('param.sch_term'),
			'sch_day' => input('param.sch_day'),
			'sch_week_start' => input('param.sch_week_start'),
			'sch_week_end' => input('param.sch_week_end'),
			'grp_mem_num' => input('param.grp_mem_num'),
		];
		dump($data_course);
		$cid = db('course')->insertGetId($data_course);

		//读取学生excel
		$file = request()->file('excel_stu');
		$info = $file->move($this->uploads);
		$file_name = $info->getSaveName();
		for($i=0;$i<strlen($file_name);$i++){
			if($file_name[$i]=='.'){
				break;
			}
		}
		$file_type = substr($file_name,$i+1);
		$file_type = ucfirst($file_type);
		dump($file_type);
		$file_path = $this->uploads.'/'.$file_name;
		$file_path=str_replace('\\','/',$file_path);
		dump($file_path);
		$new_namespace = '\\PhpOffice\\PhpSpreadsheet\\Reader\\'.$file_type.'';
		$reader = new $new_namespace;
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($file_path);
		$worksheet = $spreadsheet->getActiveSheet();
		$hightest_row = $worksheet->getHighestRow();
		$higntest_col = $worksheet->getHighestColumn();
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($higntest_col);
		dump($higntest_col);
		$row_t=0;
		$col_t=0;
		for ($row = 1; $row <= $hightest_row; ++$row) {
			for($col = 1; $col <= $highestColumnIndex; ++$col) {
				$col_t = $col;
				if( $worksheet->getCellByColumnAndRow($col, $row)->getValue()=='学号'){
					dump('in');
					while($worksheet->getCellByColumnAndRow($col, $row+1)->getValue()==NULL){
						++$row;
					}
					$row_t = $row;
					break;
					
				}
			}
			if($col_t==$col){
				break;
			}
		}
		$col_t_s=\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_t);
		$row_t++;
		$col_t++;
		dump($col_t_s.$row_t);
		$col_t_1 =\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_t);
		$stu_data = $worksheet->rangeToArray(
			$col_t_s.$row_t.':'.($col_t_1).$hightest_row,
			NULL,
			TRUE,
			TRUE,
			FALSE
		);//根据姓名和学号后面跟着我们要的数据和它们紧邻在一起，直接拿这两列的数据
		dump($stu_data);
		$keys = array('id','nam');
		foreach ($stu_data as $key=>$val) {
			$stu_data[$key]['course_id'] = $cid;
			if($val[0]==NULL||$val[1]==NULL||!is_string($val[0])||!is_string($val[1])){
				unset($stu_data[$key]);
			}else{
				if(strlen($val[0])!=8){
					unset($stu_data[$key]);
				}else{
					foreach ($val as $k=>$v) {
						$stu_data[$key][$keys[$k]] = $v; //新建数据库对应键值
						unset($stu_data[$key][$k]);//删除原来数字key值
					}
				}
			}
		}
		dump($stu_data);
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		
		db('stu')->insertAll($stu_data);


		//加入对应要签到的条目
		$sign_stu_data = [];
		$sign_i = 0;
		for($week = input('param.sch_week_start');$week <= input('param.sch_week_end');$week++){
			foreach($stu_data as $key=>$val){
				$sign_stu_data[$sign_i]['id'] = $val['id'];
				$sign_stu_data[$sign_i]['course_id'] = $cid;
				$sign_stu_data[$sign_i]['week'] = $week;
				$sign_i++;
			}
		}
		db('sign_stu')->insertAll($sign_stu_data);
		unset($sign_stu_data);


///////////////////////////////////////////这一段不加就会unlink出错，我也不知道为什么
		dump($file_path);
		dump($perms = fileperms($file_path));
		if (($perms & 0xC000) == 0xC000) {
		    // Socket
		    $info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
		    // Symbolic Link
		    $info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
		    // Regular
		    $info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
		    // Block special
		    $info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
		    // Directory
		    $info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
		    // Character special
		    $info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
		    // FIFO pipe
		    $info = 'p';
		} else {
		    // Unknown
		    $info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
		            (($perms & 0x0800) ? 's' : 'x' ) :
		            (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
		            (($perms & 0x0400) ? 's' : 'x' ) :
		            (($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
		            (($perms & 0x0200) ? 't' : 'x' ) :
		            (($perms & 0x0200) ? 'T' : '-'));
		echo $info;
///////////////////////////////////////////

		if(input('param.grp_mem_num')==1){
			foreach ($stu_data as $key=>$val) {
				$stu_data[$key]['stu1_id'] = $stu_data[$key]['id'];
				unset($stu_data[$key]['nam']);
				unset($stu_data[$key]['id']);
			}
			db('grp')->insertAll($stu_data);
		}

		unlink(realpath($file_path));
		$this->redirect('Home/homeAdmin');

		// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		// if (!is_dir($this->output)) mkdir($this->output);
		// $writer->save($this->output.'/hellp.xlsx');
	}
	public function export_stu($course_id){
		$course = db('course')->where('id',$course_id)->find();
		if(empty($course)){
			return '课程id错误，请重试';
		}
		//查找课程对应的学生的签到信息，包括id，姓名，哪一周
		$stu = db('sign_stu')
		->join('stu','stu.id=sign_stu.id')
		->where('sign_stu.course_id',$course_id)
		->field('sign_stu.id,stat,week,stu.nam')
		->order(['sign_stu.id','week'])
		->select();
		
		$stu_m = [];
		foreach($stu as $stu_i){
			$stu_m[$stu_i['id']][0]=$stu_i['id'];
			$stu_m[$stu_i['id']][1]=$stu_i['nam'];
			$stu_m[$stu_i['id']][$stu_i['week']-$course['sch_week_start']+2]=$stu_i['stat'];
		}
		//统计一个学生的签到情况
		$stu_data = [];

		$i=0;
		$max_index = 0;
		foreach($stu_m as $stu_){
			$stu_data[$i] = $stu_;
			if($max_index<count($stu_)){
				$max_index = count($stu_);
			}
			$i++;
		}
		//整理成以数字为基准的数组,并记录最大的数组宽度
		unset($stu_m);
		dump($max_index);

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$worksheet = $spreadsheet->getActiveSheet();
		//获取excel表的宽度
		$max_index_s = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($max_index);

		$worksheet
			->fromArray($stu_data,NULL,'A4')
			->setCellValue('A1',$course['sch_year']."年第".$course['sch_term']."学期".$course['nam']."登记情况")
			->mergeCells("A1:$max_index_s".'1')
			->setCellValue('A2','学号')
			->mergeCells('A2:A3')
			->setCellValue('B2','姓名')
			->mergeCells('B2:B3')
			->setCellValue('C2','考勤')
			->mergeCells("C2:$max_index_s".'2');
		
		//
		for($i = 2;$i<$max_index;$i++){
			$index_s = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i+1);
			dump($index_s);
			$worksheet->setCellValue($index_s.'3',$course['sch_week_start']+$i-2);
		}

		if (!is_dir($this->output)) mkdir($this->output);
		$path =$this->output.'/'.$course['sch_year']."年第".$course['sch_term']."学期".$course['nam'].".xlsx";
		$writer->save($path);

		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);

		return $path;
	}
}