<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Dal\ProblemDal as ProblemDal;
use App\Dal\LearningTopicDal as LearningTopicDal;

use App\Models\Problem as Problem;

use Response;

use Storage;

class ProblemController extends Controller
{

    protected $problemDal;
    protected $topicDal;

    public function __construct(ProblemDal $problemDal, LearningTopicDal $topicDal) {
        $this->problemDal = $problemDal;
        $this->topicDal = $topicDal;
    }

    public function GetAllProblems() {
    	try {
            $allProblems = $this->problemDal->GetAllProblems();

            if(count($allProblems) == 0) {
                return Response::json([
                    'message' => 'No problems were found'
                ], 404); 
            }

            return Response::json([
                'problems' => $allProblems,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetProblemById($id) {
    	try {
            $problem = $this->problemDal->GetProblemById($id);

            if(count($problem) == 0) {
                return Response::json([
                    'message' => 'Problem with id ' . $id . ' not found'
                ], 404); 
            }

            return Response::json([
                'problem' => $problem,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function GetAllProblemsForTopic($topicId) {
    	try {
        	
        	$topic = $this->topicDal->GetTopicById($topicId);

        	if(count($topic) == 0) {
                return Response::json([
                    'message' => 'Topic with id ' . $topicId . ' not found'
                ], 400); 
            }

            $problems = $this->problemDal->GetAllProblemsForTopic($topicId);

            return Response::json([
                'problems' => $problems,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function AddNewProblem(Request $request) {
    	try {


			$requestData = $request->all();

			if(!isset($requestData['topicId']) || !isset($requestData['year']) || !isset($requestData['text']) ) {
                return Response::json([
                    'message' => 'Invalid request, some of the parameters are not set.'
                ], 400); 
            }

	        $topicId = $requestData['topicId'];

	    	$topic = $this->topicDal->GetTopicById($topicId);

	    	if(count($topic) == 0) {
	            return Response::json([
	                'message' => 'Topic with id ' . $topicId . ' not found'
	            ], 400); 
	        }

	        $problem = new Problem;

	        $problem->year = $requestData['year'];
	        $problem->text = $requestData['text'];

            $problem_image = $requestData['problem_image'];
            $destination = public_path() . '/uploads/images';
            $name = uniqid('img_');
            $problem_image->move($destination, $name);
            $image_url = $destination . '/' . $name;

	        $problem->image_url = $image_url;

	        $addedProblem = $this->problemDal->AddNewProblem($topicId, $problem);

	        return Response::json([
	            'message' => 'New subject added.',
	            'problem' => $addedProblem
	        ], 200);

    	} catch (Exception $e) {
    		return Response::json([
                'message' => $e->getMessage()
            ], 500);
    	}
    }

    public function DeleteProblem($problemId) {
    	try {
    		$problem = $this->problemDal->GetProblemById($problemId);

            if(count($problem) == 0) {
                return Response::json([
                    'message' => 'Problem with id ' . $problemId . ' not found'
                ], 400); 
            }

	        $this->problemDal->DeleteProblem($problemId);

	        return Response::json([
	            'message' => 'Problem deleted.'
	        ], 200); 

    	} catch (Exception $e) {
    		return Response::json([
                'message' => $e->getMessage()
            ], 500);
    	}
    }
}
