<?php

namespace App\Dal;

use App\Dal\Interfaces\ISubjectDal;
use App\Models\Subject as Subject;

class SubjectDal implements ISubjectDal {

	public function GetAllSubjects() {
		return Subject::all();
	}

    public function GetSubjectById($id) {
        return Subject::where('id', $id)->get();
    }

	public function AddNewSubject(Subject $subject) {
		return Subject::create([
    		'name' => $subject->name
    	]);
	}

	public function AddTopicsToSubject(Subject $subject, $topicIds) {
		$subject->topics()->attach($topicIds);
	}

	public function RemoveTopicsFromSubject(Subject $subject, $topicIds) {
		$subject->topics()->detach($topicIds);
	}
	public function DeleteSubject($subjectId) {
		Subject::destroy($subjectId);
	}	



	
}
