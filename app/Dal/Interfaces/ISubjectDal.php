<?php

namespace App\Dal\Interfaces;

use App\Models\Subject as Subject;

interface ISubjectDal {

	public function GetAllSubjects();

	public function GetSubjectById($id);

	public function AddNewSubject(Subject $subject);

	public function AddTopicsToSubject(Subject $subject, $topicIds);

	public function RemoveTopicsFromSubject(Subject $subject, $topicIds);

	public function RemoveSubject($subjectId);	
}