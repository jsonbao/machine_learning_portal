<?php

namespace App\Dal\Interfaces;

use App\Models\LearningTopic as LearningTopic;

interface ILearningTopicDal {

    public function GetAllTopics();
    
    public function GetTopicById($id);
    
    public function AddNewTopic(LearningTopic $topic);
    
    public function AddSubjectsToTopic(LearningTopic $topic, $subjectIds);
    
    public function RemoveSubjectsFromTopic(LearningTopic $topic, $subjectIds);
    
    public function DeleteTopic($topicId);

}