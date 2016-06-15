<?php

namespace App\Dal;

use App\Dal\Interfaces\IProblemDal;

use App\Models\Problem as Problem;

use App\Models\LearningTopic as LearningTopic;

class ProblemDal implements IProblemDal {

    public function GetAllProblems() {
        return Problem::all();
    }

    public function GetProblemById($id) {
        return Problem::where('id', $id)->get();
    }

    public function GetAllProblemsForTopic($topicId) {
        return Problem::where('learning_topic_id', '$topicId')->get();
    }

    public function AddNewProblem($topicId, Problem $problem) {
        $topic = LearningTopic::find($topicId);

        return $topic->problems()->create([
            'year' => $problem->year,
            'text' => $problem->text,
            'image_url' => $problem->image_url
        ]);
    }

    public function DeleteProblem($problemId) {
        Problem::destroy($problemId);
    }

}
