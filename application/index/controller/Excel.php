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
		// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		// if (!is_dir($this->output)) mkdir($this->output);
		// $writer->save($this->output.'/hellp.xlsx');
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
		//dump($stu_data);
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);

		

		db('stu')->insertAll($stu_data);
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



		unlink(realpath($file_path));
		$this->redirect('Home/homeEduTeacher');
	}
}