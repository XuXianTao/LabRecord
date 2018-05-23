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
	public function import_stu() {
		//新建课程
		$data_course = [
			'name' => input('param.name'),
			'cla' => input('param.cla'),
			'tea_id' => session('user')['id'],
			'sch_time_start' => input('param.sch_time_start'),
			'sch_time_end' => input('param.sch_time_end'),
			'sch_year' => input('param.sch_year'),
			'sch_term' => input('param.sch_term'),
			'sch_day' => input('param.sch_day'),
			'sch_week_start' => input('param.sch_week')
		];
		$cid = db('course')->insertGetId($data_course);

		//读取学生excel
		$file = request()->file('excel_stu');
		$info = $file->move($this->uploads);
		$file_path = $this->uploads.'/'.$info->getSaveName();
		$file_path=str_replace('/','\\',$file_path);
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($file_path);
		$worksheet = $spreadsheet->getActiveSheet();
		$hightest_row = $worksheet->getHighestRow();
		$stu_data = $worksheet->rangeToArray(
			'A4:B'.$hightest_row,
			NULL,
			TRUE,
			TRUE,
			FALSE
		);
		$keys = array('id','name');
		foreach ($stu_data as $key=>$val) {
			$stu_data[$key]['course_id'] = $cid;
			foreach ($val as $k=>$v) {
				$stu_data[$key][$keys[$k]] = $v; //新建数据库对应键值
				unset($stu_data[$key][$k]);//删除原来数字key值
			}
		}
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		db('stu')->insertAll($stu_data);
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


		unlink(realpath($file_path));
		$this->redirect('Home/homeEduTeacher');

		// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		// if (!is_dir($this->output)) mkdir($this->output);
		// $writer->save($this->output.'/hellp.xlsx');
	}
	public function export_stu($course_id){
		$stu_data = db('stu')->where('course_id',$course_id)->column('id,name,sign_w1,sign_w2,sign_w3,sign_w4,sign_w5,sign_w6
		,sign_w7,sign_w8,sign_w9,sign_w10');
		if(empty($stu_data)){
			return '课程id错误，请重试';
		}
		$course = db('course')->where('id',$course_id)->find();
		$stu = array('id'=>0,'name'=>1,'sign_w1'=>2,'sign_w2'=>3,'sign_w3'=>4,'sign_w4'=>5,
		'sign_w5'=>6,'sign_w6'=>7,'sign_w7'=>8,'sign_w8'=>9,'sign_w9'=>10,'sign_w10'=>11);
		$i = 0;

		foreach($stu_data as $id => $stu_data_c){
			foreach($stu_data_c as $key => $val){
				$stu_data_c[$stu[$key]] = $val;
				unset($stu_data_c[$key]);
			}
			$stu_data[$i] = $stu_data_c;
			unset($stu_data[$id]);
			$i++;
		}
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$spreadsheet->getActiveSheet()
			->fromArray($stu_data,NULL,'A4')
			->setCellValue('A1',$course['sch_year']."年第".$course['sch_term']."学期".$course['name']."登记情况")
			->mergeCells('A1:L1')
			->setCellValue('A2','学号')
			->mergeCells('A2:A3')
			->setCellValue('B2','姓名')
			->mergeCells('B2:B3')
			->setCellValue('C2','考勤')
			->mergeCells('C2:L2')
			->setCellValue('C3','1')
			->setCellValue('D3','2')
			->setCellValue('E3','3')
			->setCellValue('F3','4')
			->setCellValue('G3','5')
			->setCellValue('H3','6')
			->setCellValue('I3','7')
			->setCellValue('J3','8')
			->setCellValue('K3','9')
			->setCellValue('L3','10');
		if (!is_dir($this->output)) mkdir($this->output);
		$path =$this->output.'/'.$course['sch_year']."年第".$course['sch_term']."学期".$course['name'].".xlsx";
		$writer->save($path);
		return $path;
	}
}