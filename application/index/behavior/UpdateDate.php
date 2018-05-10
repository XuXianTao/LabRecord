<?php
namespace app\index\behavior;

class UpdateDate
{
	public function run($params) {
		$this->checkTime();
	}

	private function checkTime() {
		$GLOBALS['day'] = date('N');
	}
}