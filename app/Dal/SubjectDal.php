<?php

namespace App\Dal;

use App\Dal\Interfaces\ISubjectDal;
use App\Models\Subject as Subject;

class SubjectDal implements ISubjectDal {

    public function GetSubjectById($id) {
        return Subject::where('id', $id)->get();
    }
	
}
