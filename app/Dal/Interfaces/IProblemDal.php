<?php

namespace App\Dal\Interfaces;

use App\Models\Problem as Problem;

interface IProblemDal {

    public function GetAllProblems();

    public function GetProblemById($id);

    public function GetAllProblemsForTopic($topicId);

    public function AddNewProblem($topicId, Problem $problem);

    public function DeleteProblem($problemId);

}