<?php

namespace App\Dal\Interfaces;

use App\Models\Subject as Subject;

interface ISubjectDal {

	public function GetSubjectById($id);

}