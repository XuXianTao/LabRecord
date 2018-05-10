<?php
namespace app\index\controller;

use think\Controller;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet;

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
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
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
		db('stu')->insertAll($stu_data);
		unlink($file_path);
		$this->redirect('Home/homeEduTeacher');
	}
}