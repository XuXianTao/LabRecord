<?php
namespace app\index\controller;

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet;

class Excel
{
	public function import_stu() {
		$file = request()->file('excel_stu');
		$info = $file->move('../uploads');
		echo $info;
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load('../uploads');
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('hellp.xlsx');
	}
}