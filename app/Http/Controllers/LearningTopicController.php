<?php

namespace App\Http\Controllers;

use App\Models\LearningTopic as LearningTopic;
use App\Models\Subject as Subject;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Dal\LearningTopicDal as LearningTopicDal;
use App\Dal\SubjectDal as SubjectDal;

use Response;

class LearningTopicController extends Controller
{

    protected $learningTopicDal;
    protected $subjectDal;

    public function __construct(LearningTopicDal $learningTopicDal, SubjectDal $subjectDal) {
        $this->learningTopicDal = $learningTopicDal;
        $this->subjectDal = $subjectDal;
    }

    public function GetAllTopics() {
        try {
            $allTopics = $this->learningTopicDal->GetAllTopics();

            if(count($allTopics) == 0) {
                return Response::json([
                    'message' => 'No topics were found'
                ], 404); 
            }

            return Response::json([
                'topics' => $allTopics,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetTopicById($id) {
        try {
            $topic = $this->learningTopicDal->GetTopicById($id);

            if(count($topic) == 0) {
                return Response::json([
                    'message' => 'Topic with id ' . $id . ' not found'
                ], 404); 
            }

            return Response::json([
                'topic' => $topic,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    public function AddNewTopic(Request $request) {
        try {
            $requestData = $request->all();

            if(!isset($requestData['name']) || !isset($requestData['description'])) {
                return Response::json([
                    'message' => 'Invalid request, name and description not set.'
                ], 400); 
            }

            $name = $requestData['name'];
            $description = $requestData['description'];

            $topic = new LearningTopic;
            
            $topic->name = $name;
            $topic->description = $description;

            $addedTopic = $this->learningTopicDal->AddNewTopic($topic);

            if(isset($requestData['subjectIds'])) {

                $subjectIds = $requestData['subjectIds'];

                //we have to check if all subjectIds are valid.
                for ($i=0; $i < sizeof($subjectIds) ; $i++) { 

                    $subject = $this->subjectDal->GetSubjectById($subjectIds[$i]);

                    if($subject->count() == 0) {
                        return Response::json([
                            'message' => 'Invalid request, one or more subject ids are not valid.'
                        ], 400);
                    }     
                }
                
                $this->learningTopicDal->AddSubjectsToTopic($addedTopic, $subjectIds);
            }

            return Response::json([
                'message' => 'New topic added.',
                'topic' => $addedTopic
            ], 200);

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function AddSubjectsToTopic($topicId, Request $request) {
        try {
            $requestData = $request->all();


            if(!isset($requestData['subjectIds'])) {
                return Response::json([
                    'message' => 'Invalid request, subject ids not set.'
                ], 400); 
            }

            $subjectIds = $requestData['subjectIds'];
            $topic = $this->learningTopicDal->GetTopicById($topicId);

            //check if topic is valid
            if(count($topic) == 0) {
                return Response::json([
                        'message' => 'Invalid request, topic with id ' . $topicId . ' not found'
                ], 400);
            }

            //we have to check if all subjectIds are valid.
            for ($i=0; $i < sizeof($subjectIds) ; $i++) { 

                $subject = $this->subjectDal->GetSubjectById($subjectIds[$i]);

                if($subject->count() == 0) {
                    return Response::json([
                        'message' => 'Invalid request, one or more subject ids are not valid.'
                    ], 400);
                }     
            }
            
            $this->learningTopicDal->AddSubjectsToTopic(LearningTopic::find($topicId), $subjectIds);
            
            return Response::json([
                'message' => 'Subjects added.'
            ], 200);

            
            } catch (Exception $e) {
                return Response::json([
                    'message' => $e->getMessage()
                ], 500);
            }
    }

    public function RemoveSubjectsFromTopic($topicId, Request $request) {
        try {
            $requestData = $request->all();


            if(!isset($requestData['subjectIds'])) {
                return Response::json([
                    'message' => 'Invalid request, subject ids not set.'
                ], 400); 
            }

            $subjectIds = $requestData['subjectIds'];
            $topic = $this->learningTopicDal->GetTopicById($topicId);

            //check if topic is valid
            if(count($topic) == 0) {
                return Response::json([
                        'message' => 'Invalid request, topic with id ' . $topicId . ' not found'
                ], 400);
            }

            //we have to check if all subjectIds are valid.
            for ($i=0; $i < sizeof($subjectIds) ; $i++) { 

                $subject = $this->subjectDal->GetSubjectById($subjectIds[$i]);

                if($subject->count() == 0) {
                    return Response::json([
                        'message' => 'Invalid request, one or more subject ids are not valid.'
                    ], 400);
                }     
            }
            
            $this->learningTopicDal->RemoveSubjectsFromTopic(LearningTopic::find($topicId), $subjectIds);

            return Response::json([
                'message' => 'Subjects removed.'
            ], 200);

            
            } catch (Exception $e) {
                return Response::json([
                    'message' => $e->getMessage()
                ], 500);
            }
    }

    public function DeleteTopic($id) {
        try {

            $topic = $this->learningTopicDal->GetTopicById($id);

            if(count($topic) == 0) {
                return Response::json([
                    'message' => 'Invalid request, topic with id ' . $id . ' not found.' 
                ], 400); 
            }

            $this->learningTopicDal->DeleteTopic($id);

            return Response::json([
                'message' => 'Topic deleted.'
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
