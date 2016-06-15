<?php

namespace App\Dal;

use App\Dal\Interfaces\ILearningTopicDal;
use App\Models\LearningTopic as LearningTopic;

class LearningTopicDal implements ILearningTopicDal {

	public function GetAllTopics() {
		return LearningTopic::all();
	}

    public function GetTopicById($id) {
    	return LearningTopic::where('id', $id)->get();
    }

    public function AddNewTopic(LearningTopic $topic) {
    	return LearningTopic::create([
    		'name' => $topic->name,
    		'description' => $topic->description
    	]);
    }

    public function AddSubjectsToTopic(LearningTopic $topic, $subjectIds) {
        $topic->subjects()->attach($subjectIds);
    }

    public function RemoveSubjectsFromTopic(LearningTopic $topic, $subjectIds) {
        $topic->subjects()->detach($subjectIds);
    }

    public function DeleteTopic($topicId) {
    	LearningTopic::destroy($topicId);
    }
}
