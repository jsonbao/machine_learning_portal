<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Response;

use App\Dal\SubjectDal as SubjectDal;
use App\Dal\LearningTopicDal as LearningTopicDal;

use App\Models\Subject;

class SubjectController extends Controller
{
    
    protected $topicDal;
    protected $subjectDal;

    public function __construct(LearningTopicDal $topicDal, SubjectDal $subjectDal) {
        $this->topicDal = $topicDal;
        $this->subjectDal = $subjectDal;
    }

    public function GetAllSubjects() {
        try {
            $allSubjects = $this->subjectDal->GetAllSubjects();

            if(count($allSubjects) == 0) {
                return Response::json([
                    'message' => 'No topics were found'
                ], 404); 
            }

            return Response::json([
                'subjects' => $allSubjects,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetSubjectById($id) {
        try {
            $subject = $this->subjectDal->GetSubjectById($id);

           if($subject->count() == 0) {
                return Response::json([
                    'message' => 'Subject with id ' . $id . ' not found'
                ], 404); 
            }

            return Response::json([
                'subject' => $subject,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function AddNewSubject(Request $request) {
        try {
            $requestData = $request->all();

            if(!isset($requestData['name'])) {
                return Response::json([
                    'message' => 'Invalid request, name not set.'
                ], 400); 
            }

            $name = $requestData['name'];

            $subject = new Subject;

            $subject->name = $name;

            $addedSubject = $this->subjectDal->AddNewSubject($subject);

            if(isset($requestData['topicIds'])) {

                $topicIds = $requestData['topicIds'];

                //we have to check if all topicIds are valid.
                for ($i=0; $i < sizeof($topicIds) ; $i++) { 

                    $topic = $this->topicDal->GetTopicById($topicIds[$i]);

                    if($topic->count() == 0) {
                        return Response::json([
                            'message' => 'Invalid request, one or more topic ids are not valid.'
                        ], 400);
                    }     
                }
                
                $this->subjectDal->AddTopicsToSubject($addedSubject, $topicIds);
            }

            return Response::json([
                'message' => 'New subject added.',
                'subject' => $addedSubject
            ], 200);



        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function AddTopicsToSubject($subjectId, Request $request) {
        try {
            $requestData = $request->all();


            if(!isset($requestData['topicIds'])) {
                return Response::json([
                    'message' => 'Invalid request, topic ids not set.'
                ], 400); 
            }

            $topicIds = $requestData['topicIds'];
            
            $subject = $this->subjectDal->GetSubjectById($subjectId);

            //check if topic is valid
            if(count($subject) == 0) {
                return Response::json([
                        'message' => 'Invalid request, topic with id ' . $subjectId . ' not found'
                ], 400);
            }

            //we have to check if all subjectIds are valid.
            for ($i=0; $i < sizeof($topicIds) ; $i++) { 

                $topic = $this->topicDal->GetTopicById($topicIds[$i]);

                if($topic->count() == 0) {
                    return Response::json([
                        'message' => 'Invalid request, one or more topic ids are not valid.'
                    ], 400);
                }     
            }
            
            $this->subjectDal->AddTopicsToSubject(Subject::find($subjectId), $topicIds);
            
            return Response::json([
                'message' => 'Topics added.'
            ], 200);

            
            } catch (Exception $e) {
                return Response::json([
                    'message' => $e->getMessage()
                ], 500);
            }
    }

    public function RemoveTopicsFromSubject($subjectId, Request $request) {
        try {
            $requestData = $request->all();


            if(!isset($requestData['topicIds'])) {
                return Response::json([
                    'message' => 'Invalid request, topic ids not set.'
                ], 400); 
            }

            $topicIds = $requestData['topicIds'];
            
            $subject = $this->subjectDal->GetSubjectById($subjectId);

            //check if topic is valid
            if(count($subject) == 0) {
                return Response::json([
                        'message' => 'Invalid request, topic with id ' . $subjectId . ' not found'
                ], 400);
            }

            //we have to check if all subjectIds are valid.
            for ($i=0; $i < sizeof($topicIds) ; $i++) { 

                $topic = $this->topicDal->GetTopicById($topicIds[$i]);

                if($topic->count() == 0) {
                    return Response::json([
                        'message' => 'Invalid request, one or more topic ids are not valid.'
                    ], 400);
                }     
            }
            
            $this->subjectDal->RemoveTopicsFromSubject(Subject::find($subjectId), $topicIds);
            
            return Response::json([
                'message' => 'Topics removed.'
            ], 200);

            
            } catch (Exception $e) {
                return Response::json([
                    'message' => $e->getMessage()
                ], 500);
            }
    }

    public function DeleteSubject($id) {
    	try {

            $subject = $this->subjectDal->GetSubjectById($id);
            
            if(is_null($subject)) {
                return Response::json([
                    'message' => 'Invalid request, subject with id ' . $id . ' not found.' 
                ], 400); 
            }

            $this->subjectDal->DeleteSubject($id);

            return Response::json([
                'message' => 'Subject deleted.'
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
