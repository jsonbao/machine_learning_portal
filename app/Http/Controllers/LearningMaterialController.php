<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Dal\LearningMaterialDal as LearningMaterialDal;
use App\Dal\LearningTopicDal as LearningTopicDal;

use App\Models\LearningMaterial as LearningMaterial;

use Response;

class LearningMaterialController extends Controller
{
    protected $learningMaterialDal;
    protected $learningTopicDal;

    public function __construct(LearningMaterialDal $learningMaterialDal, LearningTopicDal $learningTopicDal) {
        $this->learningMaterialDal = $learningMaterialDal;
        $this->learningTopicDal = $learningTopicDal;
    }

    public function GetAllLearningMaterials() {
    	 try {
            $allMaterials = $this->learningMaterialDal->GetAllLearningMaterials();

            if(count($allMaterials) == 0) {
                return Response::json([
                    'message' => 'No learning materials were found'
                ], 404); 
            }

            return Response::json([
                'materials' => $allMaterials,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetLearningMaterialById($id) {
    	try {
            $material = $this->learningMaterialDal->GetLearningMaterialById($id);

            if(count($material) == 0) {
                return Response::json([
                    'message' => 'Learning material with id ' . $id . ' not found'
                ], 404); 
            }

            return Response::json([
                'material' => $material,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

	public function GetAllLearningMaterialsForTopic($topicId) {
		try {
            $materials = $this->learningMaterialDal->GetAllLearningMaterialsForTopic($topicId);

            if(count($materials) == 0) {
                return Response::json([
                    'message' => 'Learning material with topic id ' . $topicId . ' not found'
                ], 404); 
            }

            return Response::json([
                'materials' => $materials,
            ], 200); 

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }

	}
	
	public function AddNewLearningMaterial(Request $request) {
		try {

            $requestData = $request->all();

            if(!isset($requestData['url']) || !isset($requestData['description']) || !isset($requestData['topicId'])) {
                return Response::json([
                    'message' => 'Invalid request, url, description or topicId not set.'
                ], 400); 
            }

            $topicId = $requestData['topicId'];

            $topic = $this->learningTopicDal->GetTopicById($topicId);

            if(count($topic) == 0) {
                return Response::json([
                    'message' => 'Topic with id ' . $topicId . ' not found'
                ], 400); 
            }

            $url = $requestData['url'];
            $description = $requestData['description'];

            $material = new LearningMaterial;

            $material->url = $url;
            $material->description = $description;

            $addedMaterial = $this->learningMaterialDal->AddNewLearningMaterial($topicId, $material);

            return Response::json([
                'message' => 'New learning material added.',
                'material' => $addedMaterial
            ], 200);

        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
	}
	
	public function DeleteLearningMaterial($id) {
		try {

            $material = $this->learningMaterialDal->GetLearningMaterialById($id);

            if(count($material) == 0) {
                return Response::json([
                    'message' => 'Learning material with id ' . $id . ' not found'
                ], 400);
            }

            $this->learningMaterialDal->DeleteLearningMaterial($id);

            return Response::json([
                'message' => 'Learning material deleted.'
            ], 200); 


        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ], 500);
        }
	}
}
