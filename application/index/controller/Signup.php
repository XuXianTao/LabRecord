<?php
namespace app\index\controller;

class Signup
{
	public function signupTa()
	{
		return view();
	}
	public function signupTeacher()
	{
		return view();
	}

	public function insert_ta()
	{
		$ta = [
			'id' => input('param.id'),
			'name' => input('param.name'),
			'sch_year' => input('param.sch_year'),
			'sch_term' => input('param.sch_term'),
			'sch_time' => input('param.sch_time')
		];
		db('ta')->insert($ta);
		return $ta;
	}
	public function insert_teacher()
	{
		$teacher = [
			'id' => input('param.id'),
			'name' => input('param.name'),
			'type' => input('param.type')
		];
		db('teacher')->insert($teacher);
		return $teacher;
	}
}